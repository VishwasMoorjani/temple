<?php defined('BASEPATH') or exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Admin_model extends CI_Model
{
    function __construct()
    {
        // Set table name 
        $this->table = 'admin';
    }

    /* 
     * Fetch user data from the database 
     * @param array filter data based on the passed parameters 
     */
    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from($this->table);

        if (array_key_exists("conditions", $params)) {
            foreach ($params['conditions'] as $key => $val) {
                $this->db->where($key, $val);
            }
        }

        if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
            $result = $this->db->count_all_results();
        } else {
            if (array_key_exists("id", $params) || $params['returnType'] == 'single') {
                if (!empty($params['id'])) {
                    $this->db->where('id', $params['id']);
                }
                $query = $this->db->get();
                $result = $query->row_array();
            } else {
                $this->db->order_by('id', 'desc');
                if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                    $this->db->limit($params['limit'], $params['start']);
                } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                    $this->db->limit($params['limit']);
                }

                $query = $this->db->get();
                $result = ($query->num_rows() > 0) ? $query->result_array() : FALSE;
            }
        }

        // Return fetched data 
        return $result;
    }

    public function ForgotPassword($email)
    {
        $this->db->select('email');
        $this->db->from('admin');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function addcategory($data){
        $this->db->insert('category', $data);
        redirect('admin/categories');
    }

    public function editcategory($data){  
        $this->db->where('link', $data['link']);
        $this->db->update('category', $data);
        return 1;
    }


    function getreviews($field = NULL, $value = NULL)
    {
        $this->load->database();
        if ($field != NULL && $value != NULL) {
            $this->db->where('status', 1);
            $this->db->order_by('date_added','desc');
            $this->db->where($field, $value);
        }
        $query = $this->db->get('reviews');
        return $query->result_array();
    }

    function addreview($data)
    {
        $this->db->insert('reviews',$data);
        redirect('admin/reviews');
    }
    
    function editreview($post_id, $data)
    {
        $this->db->where('id',$post_id);
        $this->db->update('reviews',$data);
        redirect(base_url('admin/reviews'));
    }
}
