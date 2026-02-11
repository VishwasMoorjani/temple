<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Community extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Community_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function index()
    {
        redirect('admin/community/dashboard');
    }

    public function dashboard()
    {
        $data['stats'] = $this->Community_model->get_stats();
        $this->Global['page_title'] = 'Community Dashboard';
        $this->load->view('admin/community/dashboard', array_merge($this->Global, $data));
    }

    // --- Members Management ---
    // --- Members Management ---
    public function members()
    {
        $config = [
            'base_url'    => base_url('admin/community/members'),
            'total_rows'  => $this->Community_model->count_members(),
            'per_page'    => 10,
            'uri_segment' => 4,
            'full_tag_open'   => '<ul class="pagination">',
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

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        $data['members'] = $this->Community_model->get_members($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $this->Global['page_title'] = 'Manage Community Members';
        
        $this->load->view('admin/community/members_list', array_merge($this->Global, $data));
    }

    public function add_member()
    {
        $this->Global['page_title'] = 'Add New Member';
        $this->load->view('admin/community/member_form', $this->Global);
    }

    public function save_member()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[com_members.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $this->add_member();
        } else {
            $data = [
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'email'      => $this->input->post('email'),
                'phone'      => $this->input->post('phone'),
                'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'dob'        => $this->input->post('dob'),
                'gotra'      => $this->input->post('gotra'),
                'marital_status' => $this->input->post('marital_status'),
                'spouse_name' => $this->input->post('spouse_name'),
                'address'    => $this->input->post('address'),
                'city'       => $this->input->post('city'),
                'pincode'    => $this->input->post('pincode'),
                'status'     => $this->input->post('status')
            ];

            if ($this->Community_model->create_member($data)) {
                $this->session->set_flashdata('success', 'Member added successfully.');
                redirect('admin/community/members');
            } else {
                $this->session->set_flashdata('error', 'Failed to add member.');
                redirect('admin/community/add_member');
            }
        }
    }

    public function edit_member($id)
    {
        $data['member'] = $this->Community_model->get_member_with_family($id);
        if (!$data['member']) show_404();

        $this->Global['page_title'] = 'Edit Member';
        $this->load->view('admin/community/member_form', array_merge($this->Global, $data));
    }

    public function update_member($id)
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_member($id);
        } else {
            $data = [
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'email'      => $this->input->post('email'),
                'phone'      => $this->input->post('phone'),
                'dob'        => $this->input->post('dob'),
                'gotra'      => $this->input->post('gotra'),
                'marital_status' => $this->input->post('marital_status'),
                'spouse_name' => $this->input->post('spouse_name'),
                'address'    => $this->input->post('address'),
                'city'       => $this->input->post('city'),
                'pincode'    => $this->input->post('pincode'),
                'status'     => $this->input->post('status')
            ];

            if ($this->input->post('password')) {
                $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $this->Community_model->update_member($id, $data);
            $this->session->set_flashdata('success', 'Member updated successfully.');
            redirect('admin/community/edit_member/'.$id);
        }
    }

    public function delete_member($id)
    {
        $this->Community_model->delete_member($id);
        $this->session->set_flashdata('success', 'Member deleted successfully.');
        redirect('admin/community/members');
    }

    public function add_family_member($member_id)
    {
        $data = [
            'member_id' => $member_id,
            'name'      => $this->input->post('name'),
            'relation'  => $this->input->post('relation'),
            'dob'       => $this->input->post('dob')
        ];
        $this->Community_model->add_family_member($data);
        $this->session->set_flashdata('success', 'Family member added.');
        redirect('admin/community/edit_member/'.$member_id);
    }

    public function delete_family_member($id, $member_id)
    {
        $this->Community_model->delete_family_member($id);
        $this->session->set_flashdata('success', 'Family member removed.');
        redirect('admin/community/edit_member/'.$member_id);
    }

    // --- Categories Management ---
    public function categories()
    {
        $data['categories'] = $this->Community_model->get_categories();
        $this->Global['page_title'] = 'Manage Categories';
        $this->load->view('admin/community/categories_list', array_merge($this->Global, $data));
    }

    public function add_category()
    {
        $this->Global['page_title'] = 'Add Category';
        $this->load->view('admin/community/category_form', $this->Global);
    }

    public function save_category()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('slug', 'Slug', 'required|trim|is_unique[com_categories.slug]');

        if ($this->form_validation->run() == FALSE) {
            $this->add_category();
        } else {
            $data = [
                'name'   => $this->input->post('name'),
                'slug'   => url_title($this->input->post('slug'), '-', TRUE), // Ensure slug format
                'icon'   => $this->input->post('icon'),
                'status' => $this->input->post('status')
            ];

            $this->Community_model->create_category($data);
            $this->session->set_flashdata('success', 'Category added successfully.');
            redirect('admin/community/categories');
        }
    }

    public function delete_category($id)
    {
        $this->db->delete('com_categories', ['id' => $id]);
        $this->session->set_flashdata('success', 'Category deleted successfully.');
        redirect('admin/community/categories');
    }

    // --- Posts Management ---
    public function posts($status = 'all')
    {
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        $base_url = base_url('admin/community/posts/'.$status);
        // Append query strings for pagination links
        if ($start_date || $end_date) {
            $base_url .= '?start_date='.$start_date.'&end_date='.$end_date;
        }

        $config = [
            'base_url'    => $base_url,
            'per_page'    => 10,
            'uri_segment' => 5,
            'full_tag_open'   => '<ul class="pagination">',
            'full_tag_close'  => '</ul>',
            'first_link'      => 'First',
            'last_link'       => 'Last',
            'first_tag_open'  => 'li class="page-item"><span class="page-link">',
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
            // Fix for query strings in pagination logic (CI3 standard pagination doesn't handle query strings well by default without config)
            'reuse_query_string' => TRUE 
        ];

        
        $filters = ($status == 'all') ? [] : ['status' => $status];
        if($start_date) $filters['start_date'] = $start_date;
        if($end_date) $filters['end_date'] = $end_date;

        $config['total_rows'] = $this->Community_model->count_posts($filters);

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        
        $data['posts'] = $this->Community_model->get_posts($config['per_page'], $page, $filters);
        $data['pagination'] = $this->pagination->create_links();
        $data['current_status'] = $status;
        
        $this->Global['page_title'] = 'Manage Community Posts';
        $this->load->view('admin/community/posts_list', array_merge($this->Global, $data));
    }

    public function approve_post($id)
    {
        $this->Community_model->update_post_status($id, 'approved');
        $this->session->set_flashdata('success', 'Post approved successfully.');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function reject_post($id)
    {
        $this->Community_model->update_post_status($id, 'rejected');
        $this->session->set_flashdata('success', 'Post rejected.');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function view_post($id)
    {
        // Simple view, can be expanded
        $posts = $this->db->select('com_posts.*, com_members.first_name, com_members.last_name, com_categories.name as category_name')
        ->from('com_posts')
        ->join('com_members', 'com_members.id = com_posts.member_id', 'left')
        ->join('com_categories', 'com_categories.id = com_posts.category_id', 'left')
        ->where('com_posts.id', $id)
        ->get()->result(); // get_posts returns array of objects

        if (empty($posts)) show_404();
        $data['post'] = $posts[0];
        
        $this->Global['page_title'] = 'View Post';
        $this->load->view('admin/community/post_view', array_merge($this->Global, $data));
    }
}

