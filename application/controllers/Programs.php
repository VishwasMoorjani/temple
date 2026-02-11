<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Programs extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Community_model');
    }

    public function upcoming()
    {
        $data['events'] = $this->Community_model->get_upcoming_events(20); // Limit 20
        $data['page_title'] = 'Upcoming Programs';
        $data['type'] = 'upcoming';
        $this->load->view('front/programs/list', $data);
    }

    public function recent()
    {
        $data['events'] = $this->Community_model->get_recent_events(20);
        $data['page_title'] = 'Recent Programs';
        $data['type'] = 'recent';
        $this->load->view('front/programs/list', $data);
    }

    public function detail($slug)
    {
        $event = $this->db->get_where('com_events', ['slug' => $slug, 'status' => 1])->row();
        if (!$event) show_404();

        $data['event'] = $event;
        $data['page_title'] = $event->title;
        $this->load->view('front/programs/detail', $data);
    }
}
