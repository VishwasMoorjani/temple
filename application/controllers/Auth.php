<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Admin_model');
        $this->load->model('Global_model');
        $this->Global = $this->Global_model->getdata();
    }

    public function index()
    {
        if ($this->session->userdata('isAdminLoggedIn')) {
            redirect('admin/dashboard');
        }
        redirect('auth/login');
    }

    public function login()
    {
        
        if ($this->session->userdata('isAdminLoggedIn')) {
            redirect('admin/dashboard');
        }
        
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run()) {
                $con = [
                    'returnType' => 'single',
                    'conditions' => [
                        'email'    => $this->input->post('email', true),
                        'password' => sha1($this->input->post('password', true)),
                    ]
                ];

                $checkLogin = $this->Admin_model->getRows($con);
                if ($checkLogin) {
                    $this->session->set_userdata([
                        'isAdminLoggedIn' => TRUE,
                        'userId' => $checkLogin['id']
                    ]);
                    redirect('admin/dashboard');
                } else {
                    $this->session->set_flashdata('error_msg', 'Wrong email or password.');
                }
            } else {
                $this->session->set_flashdata('error_msg', 'Please fill all required fields.');
            }
        }

        $this->load->view('admin/sign-in', $this->Global);
    }

    public function logout()
    {
        $this->session->unset_userdata(['isAdminLoggedIn', 'userId']);
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    public function forgot_password()
    {
        if ($this->input->method() === 'post') {
            $email = $this->input->post('email', true);
            $findemail = $this->Admin_model->ForgotPassword($email);
            if ($findemail) {
                $this->Admin_model->sendpassword($findemail);
            } else {
                $this->session->set_flashdata('error_msg', 'Email not found.');
                redirect('auth/login');
            }
        }
        $this->load->view('admin/forgot', $this->Global);
    }
}
