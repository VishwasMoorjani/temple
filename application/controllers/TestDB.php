<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestDB extends CI_Controller {
    public function index() {
        $fields = $this->db->list_fields('com_members');
        foreach ($fields as $field) {
            echo $field . "<br>";
        }
        echo "<hr>";
        $row = $this->db->get('com_members', 1)->row();
        echo "<pre>";
        print_r($row);
        echo "</pre>";
    }
}
