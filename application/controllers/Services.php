<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Community_model');
    }

    public function donate()
    {
        $data['page_title'] = 'Make a Donation';
        $this->load->view('front/services/donate', $data);
    }

    public function apply($type = 'medical')
    {
        $allowed = ['medical', 'education', 'pension'];
        if (!in_array($type, $allowed)) show_404();

        $titles = [
            'medical'   => 'Medical Assistance',
            'education' => 'Education / Scholarship',
            'pension'   => 'Pension / Donation Support'
        ];

        $data['type'] = $type;
        $data['page_title'] = $titles[$type];

        // Check if user is logged in
        $data['is_logged_in'] = $this->session->userdata('isMemberLoggedIn');

        $this->load->view('front/services/apply', $data);
    }
}
