<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MemberAuth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Community_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function login()
    {
        if ($this->session->userdata('isMemberLoggedIn')) {
            redirect('my-profile');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['page_title'] = 'Member Login';
            $this->load->view('front/auth/login', $data);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $member = $this->db->get_where('com_members', ['email' => $email, 'is_deleted' => 0])->row();

            if ($member) {
                if ($password === $member->password) {
                    if ($member->status == 1) {
                        $session_data = [
                            'member_id' => $member->id,
                            'member_name' => $member->first_name . ' ' . $member->last_name,
                            'member_email' => $member->email,
                            'isMemberLoggedIn' => TRUE
                        ];
                        $this->session->set_userdata($session_data);
                        redirect('my-profile');
                    } else {
                        $this->session->set_flashdata('error', 'Your account is inactive or banned.');
                        redirect('login');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Invalid password.');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('error', 'Email not found.');
                redirect('login');
            }
        }
    }

    public function register()
    {
        if ($this->session->userdata('isMemberLoggedIn')) {
            redirect('my-profile');
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[com_members.email]');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $data['page_title'] = 'Member Registration';
            $this->load->view('front/auth/register', $data);
        } else {
            $data = [
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'email'      => $this->input->post('email'),
                'phone'      => $this->input->post('phone'),
                'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'status'     => 1 // Auto-active for now, or 0 for pending
            ];

            if ($this->Community_model->create_member($data)) {
                $this->session->set_flashdata('success', 'Registration successful! Please login.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                redirect('register');
            }
        }
    }

    public function dashboard()
    {
        if (!$this->session->userdata('isMemberLoggedIn')) {
            redirect('login');
        }

        $member_id = $this->session->userdata('member_id');
        $data['member'] = $this->Community_model->get_member_with_family($member_id);

        // Count applications & donations for sidebar badges
        $this->db->where(['member_id' => $member_id, 'is_deleted' => 0]);
        $data['application_count'] = $this->db->count_all_results('com_applications');

        $this->db->where(['member_id' => $member_id, 'is_deleted' => 0]);
        $data['donation_count'] = $this->db->count_all_results('com_donations');
        
        $data['page_title'] = 'My Profile';
        $this->load->view('front/auth/dashboard', $data);
    }

    public function my_applications()
    {
        if (!$this->session->userdata('isMemberLoggedIn')) {
            redirect('login');
        }

        $member_id = $this->session->userdata('member_id');
        $data['member'] = $this->Community_model->get_member($member_id);

        $this->db->where(['member_id' => $member_id, 'is_deleted' => 0]);
        $this->db->order_by('created_at', 'DESC');
        $data['applications'] = $this->db->get('com_applications')->result();

        // Count for sidebar badges
        $data['application_count'] = count($data['applications']);
        $this->db->where(['member_id' => $member_id, 'is_deleted' => 0]);
        $data['donation_count'] = $this->db->count_all_results('com_donations');

        $data['page_title'] = 'My Applications';
        $this->load->view('front/auth/my_applications', $data);
    }

    public function donation_history()
    {
        if (!$this->session->userdata('isMemberLoggedIn')) {
            redirect('login');
        }

        $member_id = $this->session->userdata('member_id');
        $data['member'] = $this->Community_model->get_member($member_id);

        $this->db->select('com_donations.*, com_donation_causes.name as cause_name');
        $this->db->from('com_donations');
        $this->db->join('com_donation_causes', 'com_donation_causes.id = com_donations.cause_id', 'left');
        $this->db->where(['com_donations.member_id' => $member_id, 'com_donations.is_deleted' => 0]);
        $this->db->order_by('com_donations.created_at', 'DESC');
        $data['donations'] = $this->db->get()->result();

        // Count for sidebar badges
        $data['donation_count'] = count($data['donations']);
        $this->db->where(['member_id' => $member_id, 'is_deleted' => 0]);
        $data['application_count'] = $this->db->count_all_results('com_applications');

        $data['page_title'] = 'Donation History';
        $this->load->view('front/auth/donation_history', $data);
    }

    public function request_update()
    {
        if (!$this->session->userdata('isMemberLoggedIn')) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Please login first.']));
            return;
        }

        $member_id = $this->session->userdata('member_id');
        $member = $this->Community_model->get_member($member_id);
        $message = $this->input->post('message');
        $update_type = $this->input->post('update_type');

        if (empty($message)) {
            $this->session->set_flashdata('error', 'Please describe what you want to update.');
            redirect('my-profile');
            return;
        }

        $data = [
            'name'       => $member->first_name . ' ' . $member->last_name,
            'email'      => $member->email,
            'phone'      => $member->phone,
            'subject'    => 'Profile Update Request: ' . ucfirst($update_type ?? 'General'),
            'message'    => $message,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('com_inquiries', $data);

        $this->session->set_flashdata('success', 'Your update request has been submitted! Our team will review and update your profile shortly.');
        redirect('my-profile');
    }

    public function edit_profile()
    {
        if (!$this->session->userdata('isMemberLoggedIn')) {
            redirect('login');
        }

        $member_id = $this->session->userdata('member_id');
        
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('gotra', 'Gotra', 'trim');
        $this->form_validation->set_rules('dob', 'Date of Birth', 'trim');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');
        $this->form_validation->set_rules('city', 'City', 'trim');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim');

        if ($this->form_validation->run() == FALSE) {
            $data['member'] = $this->Community_model->get_member($member_id);
            
            // Count for sidebar badges
            $this->db->where(['member_id' => $member_id, 'is_deleted' => 0]);
            $data['application_count'] = $this->db->count_all_results('com_applications');
            $this->db->where(['member_id' => $member_id, 'is_deleted' => 0]);
            $data['donation_count'] = $this->db->count_all_results('com_donations');

            $data['page_title'] = 'Edit Profile';
            $this->load->view('front/auth/edit_profile', $data);
        } else {
            $data = [
                'first_name'     => $this->input->post('first_name'),
                'last_name'      => $this->input->post('last_name'),
                'phone'          => $this->input->post('phone'),
                'gotra'          => $this->input->post('gotra'),
                'dob'            => $this->input->post('dob') ? $this->input->post('dob') : null,
                'marital_status' => $this->input->post('marital_status'),
                'spouse_name'    => $this->input->post('spouse_name'),
                'address'        => $this->input->post('address'),
                'city'           => $this->input->post('city'),
                'pincode'        => $this->input->post('pincode')
            ];

            // Handle Profile Pic Upload
            if (!empty($_FILES['profile_pic']['name'])) {
                $config['upload_path']   = './assets/uploads/members/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = 2048; // 2MB
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('profile_pic')) {
                    $upload_data = $this->upload->data();
                    $data['profile_pic'] = $upload_data['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('edit-profile');
                    return;
                }
            }

            if ($this->Community_model->update_member($member_id, $data)) {
                $this->session->set_flashdata('success', 'Profile updated successfully!');
                redirect('my-profile');
            } else {
                $this->session->set_flashdata('error', 'Failed to update profile.');
                redirect('edit-profile');
            }
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('isMemberLoggedIn');
        $this->session->unset_userdata('member_id');
        $this->session->sess_destroy();
        redirect('login');
    }
}
