<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $Global = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Global_model');
        $this->Global = $this->Global_model->getdata();

        if (!$this->session->userdata('isAdminLoggedIn')) {
            redirect('auth/login');
        }
    }
}
