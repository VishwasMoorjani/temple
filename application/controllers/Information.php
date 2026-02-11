<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Information extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Community_model');
        $this->load->library('pagination');
        $this->load->helper('text');
    }

    public function temples()
    {
        $config = $this->_pagination_config('information/temples', $this->db->where('status', 1)->where('is_deleted', 0)->count_all_results('com_temples'));
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['temples'] = $this->Community_model->get_temples($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Temples Directory';
        
        $this->load->view('front/information/temples', $data);
    }

    public function maharaj()
    {
        $count = $this->db->where('status', 1)->count_all_results('com_maharaj_mataji');
        $config = $this->_pagination_config('information/maharaj', $count);
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['maharaj'] = $this->Community_model->get_maharaj($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Maharaj & Mataji';

        $this->load->view('front/information/maharaj', $data);
    }

    public function dharmshalas()
    {
        $config = $this->_pagination_config('information/dharmshalas', $this->db->where('status', 1)->where('is_deleted', 0)->count_all_results('com_dharmshalas'));
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['dharmshalas'] = $this->Community_model->get_dharmshalas($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Dharmshala Directory';

        $this->load->view('front/information/dharmshalas', $data);
    }

    public function jobs()
    {
        $config = $this->_pagination_config('information/jobs', $this->db->where('status', 1)->where('is_deleted', 0)->where('expiry_date >=', date('Y-m-d'))->count_all_results('com_jobs'));
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['jobs'] = $this->Community_model->get_jobs($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'Community Jobs';

        $this->load->view('front/information/jobs', $data);
    }

    private function _pagination_config($base_url_suffix, $total_rows)
    {
        $base = base_url($base_url_suffix);
        if (substr($base, -1) !== '/') $base .= '/';

        return [
            'base_url'    => $base,
            'total_rows'  => $total_rows,
            'per_page'    => 12,
            'uri_segment' => 3,
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
