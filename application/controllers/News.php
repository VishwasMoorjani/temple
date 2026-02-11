<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Community_model');
        $this->load->library('pagination');
    }

    public function index()
    {
        $config = [
            'base_url'    => base_url('news'),
            'total_rows'  => $this->db->where('status', 1)->where('is_deleted', 0)->count_all_results('com_news'),
            'per_page'    => 10,
            'uri_segment' => 2,
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

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        $this->db->order_by('publish_date', 'DESC');
        $this->db->limit($config['per_page'], $page);
        $data['news'] = $this->db->get('com_news')->result();
        
        $data['pagination'] = $this->pagination->create_links();
        $data['page_title'] = 'News & Announcements';

        $this->load->view('front/news/list', $data);
    }

    public function detail($slug)
    {
        $news = $this->db->get_where('com_news', ['slug' => $slug, 'status' => 1])->row();
        if (!$news) show_404();

        $data['news'] = $news;
        $data['page_title'] = $news->title;
        $this->load->view('front/news/detail', $data);
    }
}
