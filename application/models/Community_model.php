<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Community_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // --- Members ---
    public function get_members($limit = 10, $offset = 0)
    {
        $this->db->where('is_deleted', 0);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('com_members', $limit, $offset)->result();
    }

    public function get_member($id)
    {
        return $this->db->get_where('com_members', ['id' => $id, 'is_deleted' => 0])->row();
    }

    public function get_member_with_family($id)
    {
        $member = $this->get_member($id);
        if($member) {
            $member->family = $this->db->get_where('com_family_members', ['member_id' => $id, 'is_deleted' => 0])->result();
        }
        return $member;
    }

    public function count_members()
    {
        $this->db->where('is_deleted', 0);
        return $this->db->count_all_results('com_members');
    }

    public function create_member($data)
    {
        // Safe defaults
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('com_members', $data);
        return $this->db->insert_id();
    }

    public function update_member($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        return $this->db->update('com_members', $data);
    }

    public function delete_member($id) // Soft Delete
    {
        $data = [
            'is_deleted' => 1,
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $this->session->userdata('admin_id') // Assuming admin session
        ];
        $this->db->where('id', $id);
        return $this->db->update('com_members', $data);
    }

    // --- Family Members ---
    public function add_family_member($data)
    {
        $this->db->insert('com_family_members', $data);
        return $this->db->insert_id();
    }

    public function delete_family_member($id) // Soft Delete
    {
        $this->db->where('id', $id);
        return $this->db->update('com_family_members', ['is_deleted' => 1]);
    }


    // --- Categories ---
    public function get_categories()
    {
        $this->db->where('is_deleted', 0);
        return $this->db->get('com_categories')->result();
    }

    public function get_business_categories()
    {
        return $this->db->where('is_deleted', 0)->get('com_business_categories')->result();
    }

    public function create_category($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('com_categories', $data);
        return $this->db->insert_id();
    }

    // --- Posts ---
    public function get_posts($limit = 10, $offset = 0, $filters = [])
    {
        $this->db->select('com_posts.*, com_members.first_name, com_members.last_name');
        $this->db->from('com_posts');
        $this->db->join('com_members', 'com_members.id = com_posts.member_id', 'left');
        $this->db->where('com_posts.is_deleted', 0);

        if (!empty($filters['status'])) {
            $this->db->where('com_posts.status', $filters['status']);
        }
        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(com_posts.created_at) >=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(com_posts.created_at) <=', $filters['end_date']);
        }

        $this->db->order_by('com_posts.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function count_posts($filters = [])
    {
        $this->db->where('is_deleted', 0);
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['start_date'])) {
            $this->db->where('DATE(created_at) >=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $this->db->where('DATE(created_at) <=', $filters['end_date']);
        }
        return $this->db->count_all_results('com_posts');
    }

    public function update_post_status($id, $status)
    {
        $data = ['status' => $status];
        if($status == 'approved') {
            $data['approved_by'] = $this->session->userdata('admin_id');
            $data['approved_at'] = date('Y-m-d H:i:s');
        } elseif($status == 'rejected') {
            $data['rejected_by'] = $this->session->userdata('admin_id');
            $data['rejected_at'] = date('Y-m-d H:i:s');
        }

        $this->db->where('id', $id);
        return $this->db->update('com_posts', $data);
    }

    // --- Stats ---
    public function get_stats()
    {
        // Members
        $this->db->where('is_deleted', 0);
        $members = $this->db->count_all_results('com_members');

        // Business
        $this->db->where('is_deleted', 0);
        $business = $this->db->count_all_results('com_business_listings');

        // Donations
        $this->db->where('is_deleted', 0);
        $donations = $this->db->count_all_results('com_donations');
        
        // Applications
        $this->db->where('is_deleted', 0);
        $applications = $this->db->count_all_results('com_applications');

        return [
            'total_members' => $members,
            'total_business' => $business,
            'total_donations' => $donations,
            'total_applications' => $applications
        ];
    }
    // --- Sliders ---
    public function get_sliders()
    {
        $this->db->where('status', 1);
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('com_sliders')->result();
    }

    // --- Events / Programs ---
    public function get_upcoming_events($limit = 3)
    {
        $this->db->where('event_date >=', date('Y-m-d'));
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        $this->db->order_by('event_date', 'ASC');
        $this->db->limit($limit);
        return $this->db->get('com_events')->result();
    }

    public function get_recent_events($limit = 6)
    {
        $this->db->where('event_date <', date('Y-m-d'));
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        $this->db->order_by('event_date', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('com_events')->result();
    }

    // --- News ---
    public function get_news($limit = 5)
    {
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        $this->db->order_by('publish_date', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('com_news')->result();
    }

    // --- Directories ---
    public function get_temples($limit = 10, $offset = 0)
    {
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        return $this->db->get('com_temples', $limit, $offset)->result();
    }

    public function get_dharmshalas($limit = 10, $offset = 0)
    {
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        return $this->db->get('com_dharmshalas', $limit, $offset)->result();
    }

    public function get_jobs($limit = 10, $offset = 0)
    {
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        $this->db->where('expiry_date >=', date('Y-m-d'));
        return $this->db->get('com_jobs', $limit, $offset)->result();
    }

    public function get_business_listings($limit = 10, $offset = 0, $category = null)
    {
        $this->db->select('b.*, c.name as category_name');
        $this->db->from('com_business_listings b');
        $this->db->join('com_business_categories c', 'b.category_id = c.id', 'left');
        
        if ($category) {
            $this->db->where('b.category_id', $category);
        }
        $this->db->where('b.status', 'approved');
        $this->db->where('b.is_deleted', 0);
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function get_maharaj($limit = 10, $offset = 0)
    {
        $this->db->where('status', 1);
        return $this->db->get('com_maharaj_mataji', $limit, $offset)->result();
    }

    // --- CMS Pages ---
    public function get_page($slug)
    {
        return $this->db->get_where('com_pages', ['slug' => $slug, 'status' => 1])->row();
    }
}

