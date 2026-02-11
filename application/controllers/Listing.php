<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Listing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Community_model');
        $this->load->library('pagination');
        $this->load->helper('text');
    }

    // --- Members Directory ---
    public function members($offset = 0)
    {
        $search = $this->input->get('q');
        $filter_role = $this->input->get('type'); // 'executive' or 'lifetime' or 'patron'

        // Count Query
        $this->db->where('is_deleted', 0);
        $this->db->where('status', 1);
        if($search) {
            $this->db->group_start();
            $this->db->like('first_name', $search);
            $this->db->or_like('last_name', $search);
            $this->db->or_like('city', $search);
            $this->db->or_like('gotra', $search);
            $this->db->group_end();
        }
        if($filter_role) {
            // Assuming role column exists or using some logic. 
            // For now, if role column is missing, we might need to rely on membership_no pattern or add column.
            // Keeping it simple for clone: searching/filtering basic.
             $this->db->like('membership_type', $filter_role);
        }
        $total_rows = $this->db->count_all_results('com_members');

        // Pagination
        $config = $this->_pagination_config('members', $total_rows);
        $config['reuse_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $page = $offset;

        // Fetch Data
        $this->db->select('id, first_name, last_name, membership_no, phone, email, city, gotra, profile_pic, designation, membership_type, status');
        $this->db->where('is_deleted', 0);
        $this->db->where('status', 1);
        if($search) {
            $this->db->group_start();
            $this->db->like('first_name', $search);
            $this->db->or_like('last_name', $search);
            $this->db->or_like('city', $search);
            $this->db->or_like('gotra', $search);
            $this->db->group_end();
        }
        if($filter_role) {
             $this->db->like('membership_type', $filter_role);
        }
        $this->db->limit($config['per_page'], $page);
        $this->db->order_by('first_name', 'ASC');
        $data['members'] = $this->db->get('com_members')->result();

        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Member Directory';
        $data['search_q'] = $search;

        $this->load->view('front/directory/members', $data);
    }


    public function member_profile($id)
    {
        $member = $this->Community_model->get_member_with_family($id);
        if(!$member || $member->status == 0) show_404();

        // Check visibility rules (e.g. only members can see contact info)
        $data['can_view_contact'] = $this->session->userdata('isMemberLoggedIn');
        $data['member'] = $member;
        $data['page_title'] = $member->first_name . ' ' . $member->last_name;

        $this->load->view('front/directory/member_profile', $data);
    }

    // --- Business Directory (Yellow Pages) ---
    public function business($offset = 0)
    {
        $this->load->helper('text');
        $search = $this->input->get('q');
        $cat = $this->input->get('cat');

        $this->db->where('is_deleted', 0);
        $this->db->where('status', 'approved');
        if($search) {
             $this->db->group_start();
             $this->db->like('business_name', $search);
             $this->db->group_end();
        }
        if($cat) $this->db->where('category_id', $cat);
        $total_rows = $this->db->count_all_results('com_business_listings');

        $config = $this->_pagination_config('business', $total_rows);
        $config['reuse_query_string'] = TRUE;
        $this->pagination->initialize($config);
        $page = $offset;

        $data['businesses'] = $this->Community_model->get_business_listings($config['per_page'], $page, $cat);
        $data['categories'] = $this->Community_model->get_business_categories();
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Business Listings (Yellow Pages)';
        $data['search_q'] = $search;

        $this->load->view('front/directory/business', $data);
    }

    private function _pagination_config($segment, $total_rows)
    {
        // Ensure base_url has trailing slash for (:num) routes
        $base = base_url($segment);
        if (substr($base, -1) !== '/') $base .= '/';

        return [
            'base_url'    => $base,
            'total_rows'  => $total_rows,
            'per_page'    => 12, // Grid 3x4
            'uri_segment' => 2, // Relative to members/ link
            'use_page_numbers' => FALSE,
            'full_tag_open'   => '<ul class="pagination justify-content-center">',
            'full_tag_close'  => '</ul>',
            'first_link'      => 'First',
            'last_link'       => 'Last',
            'first_tag_open'  => '<li class="page-item"><span class="page-link">',
            'first_tag_close' => '</span></li>',
            'prev_link'       => '&laquo',
            'prev_tag_open'   => '<li class="page-item"><span class="page-link">',
            'prev_tag_close'  => '</span></li>',
            'next_link'       => '&raquo',
            'next_tag_open'   => '<li class="page-item"><span class="page-link">',
            'next_tag_close'  => '</span></li>',
            'last_tag_open'   => '<li class="page-item"><span class="page-link">',
            'last_tag_close'  => '</span></li>',
            'cur_tag_open'    => '<li class="page-item active"><span class="page-link">',
            'cur_tag_close'   => '</span></li>',
            'num_tag_open'    => '<li class="page-item"><span class="page-link">',
            'num_tag_close'   => '</span></li>',
        ];
    }
}
