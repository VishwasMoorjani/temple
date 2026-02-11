<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url', 'form']);
        // Load the safe wrapper, not the raw third-party class
        $this->load->library('hashids_lib');
        $this->Global = $this->Global_model->getdata();
    }

    public function index()
    {
        redirect('admin/dashboard');
    }


    public function dashboard()
    {
        $this->load->view('admin/dashboard', $this->Global);
    }

    public function modules() {
        $data['modules'] = $this->db->get('modules')->result();
        $this->load->view('admin/modules', $data);
    }

    public function add_module() {
        $data['modules'] = $this->db->get('modules')->result();
        $this->load->view('admin/add_module', $data);
    }

    public function save_module() {
        $module_name = $this->input->post('module_name');
        $table_name  = $this->input->post('table_name');
        $fields_json = $this->input->post('fields_json');

        $data = [
            'name'       => $module_name,
            'table_name' => $table_name,
            'fields'     => $fields_json
        ];

        $this->db->insert('modules', $data);
        $id = $this->db->insert_id();

        // Generate hash and store
        $hash = $this->hashids_lib->encode($id);
        $this->db->update('modules', ['hash' => $hash], ['id' => $id]);

        $this->_create_table_if_not_exists($table_name, json_decode($fields_json));
        redirect('admin/modules');
    }

    public function edit_module($hash) {
        $id = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $id])->row();
        if (!$module) show_404();

        $modules = $this->db->get('modules')->result();
        $module->fields = $module->fields ? $module->fields : '[]';

        $this->load->view('admin/edit_module', compact('module', 'modules'));
    }

    public function update_module($hash) {
        $id = $this->_decode($hash);
        $name = $this->input->post('module_name');
        $table = $this->input->post('table_name');
        $fields_json = $this->input->post('fields_json');

        $data = [
            'name'        => $name,
            'table_name'  => $table,
            'fields'      => $fields_json
        ];

        $this->db->where('id', $id)->update('modules', $data);
        $this->_sync_table_structure($table, json_decode($fields_json));

        redirect('admin/modules');
    }

    public function delete_module($hash) {
        $id = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $id])->row();
        if (!$module) show_404();

        if ($this->db->table_exists($module->table_name)) {
            $this->db->query("DROP TABLE IF EXISTS `{$module->table_name}`");
        }

        $this->db->delete('modules', ['id' => $id]);
        redirect('admin/modules');
    }

    public function fix_hashes()
    {
        $modules = $this->db->get('modules')->result();
        foreach ($modules as $m) {
            if (empty($m->hash)) {
                $hash = $this->hashids_lib->encode($m->id);
                $this->db->update('modules', ['hash' => $hash], ['id' => $m->id]);
            }
        }
        echo "Hashes generated successfully.";
    }

    public function test_hash()
    {
        echo $this->hashids_lib->encode(1);
    }

    // public function module($hash) {
    //     $id = $this->_decode($hash);
    //     $module = $this->db->get_where('modules', ['id' => $id])->row();
    //     if (!$module) show_404();

    //     $fields = json_decode($module->fields);
    //     $records = $this->db->order_by('id', 'ASC')->get($module->table_name)->result();

    //     $data = compact('module', 'fields', 'records');
    //     $this->load->view('admin/module_dynamic', $data);
    // }
    
    public function module($hash)
    {
        $id     = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $id])->row();
        if (!$module) show_404();
    
        $fields  = json_decode($module->fields);
        $records = $this->db->order_by('id','ASC')->get($module->table_name)->result();
    
        $names = array_map(function($f){
            return $f->name;
        }, $fields);

        $special = ['image'];
        $view = (count($names) === 1 && empty(array_diff($special, $names)))
                ? 'admin/module_gallery'
                : 'admin/module_dynamic';
    
        $this->load->view($view, compact('module','fields','records'));
    }
    
    public function dragDropUploadGallery($table = '')
    {
        if (empty($_FILES['file']['name'])) return;
    
        $config['upload_path']   = FCPATH . 'assets/front/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp|svg';
    
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
    
        if ($this->upload->do_upload('file')) {
    
            // resize
            $file = $this->upload->data();
            $resize = [
                'image_library'  => 'gd2',
                'source_image'   => $file['full_path'],
                'maintain_ratio' => true,
                'height'         => 1100,
                'new_image'      => $file['full_path'],
            ];
            $this->load->library('image_lib', $resize);
            $this->image_lib->resize();
    
            // insert into dynamic module table
            $insert = [
                'image'      => $file['file_name'],
                'created_at' => date('Y-m-d H:i:s'),
            ];
    
            $this->db->insert($table, $insert);
        }
    }
    
    public function removegalleryimages($table, $id, $image)
    {
        if (!isset($_SESSION['isAdminLoggedIn'])) {
            redirect('admin/login');
        }
    
        $path = FCPATH . 'assets/front/images/' . $image;
        if (file_exists($path)) {
            unlink($path);
        }
    
        $this->db->where('id', $id)->delete($table);
    
        redirect($_SERVER['HTTP_REFERER']);
    }





    public function add_record($hash) {
        $id = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $id])->row();
        $fields = json_decode($module->fields);
        $data = compact('module', 'fields');
        $this->load->view('admin/module_record_add', $data);
    }

    public function save_record($hash) {
        $id = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $id])->row();
        $fields = json_decode($module->fields);

        $data = [];
        foreach ($fields as $f) {
            if ($f->type == 'file' && !empty($_FILES[$f->name]['name'])) {
                $path = './assets/front/images/';
                @mkdir($path, 0777, true);
                $filename = time().'_'.$_FILES[$f->name]['name'];
                move_uploaded_file($_FILES[$f->name]['tmp_name'], $path.$filename);
                $data[$f->name] = $filename;
            } else {
                $data[$f->name] = $this->input->post($f->name);
            }
        }

        $data['status'] = 1;
        $this->db->insert($module->table_name, $data);
        redirect('admin/module/'.$hash);
    }

    public function edit_record($hash, $id) {
        $mid = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $mid])->row();
        if (!$module) show_404();

        $fields = json_decode($module->fields);
        $record = $this->db->get_where($module->table_name, ['id' => $id])->row();

        $data = compact('module', 'fields', 'record');
        $this->load->view('admin/module_record_edit', $data);
    }

    public function update_record($hash, $id) {
        $mid = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $mid])->row();
        if (!$module) show_404();

        $fields = json_decode($module->fields);
        $table = $module->table_name;
        $existing = $this->db->get_where($table, ['id' => $id])->row_array();

        $data = $_POST; // directly get all form data
        unset($data["submit"]);

        foreach ($fields as $f) {
            if ($f->type == 'file') {
                if (!empty($_FILES[$f->name]['name'])) {
                    // upload new file
                    $path = './assets/front/images/';
                    @mkdir($path, 0777, true);
                    $filename = time().'_'.$_FILES[$f->name]['name'];
                    move_uploaded_file($_FILES[$f->name]['tmp_name'], $path.$filename);

                    // remove old file if exists
                    if (!empty($existing[$f->name])) {
                        $old = $path.$existing[$f->name];
                        if (file_exists($old)) @unlink($old);
                    }

                    $data[$f->name] = $filename;
                } else {
                    // don't modify this field if no new upload
                    unset($data[$f->name]);
                }
            }
        }

        $this->db->update($table, $data, ['id' => $id]);
        redirect('admin/module/'.$hash);
    }


    public function delete_record($hash, $id) {
        $mid = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $mid])->row();
        $this->db->delete($module->table_name, ['id' => $id]);
        redirect('admin/module/'.$hash);
    }

    public function activate_record($hash, $id) {
        $mid = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $mid])->row();
        $this->db->update($module->table_name, ['status' => 1], ['id' => $id]);
        redirect('admin/module/'.$hash);
    }

    public function deactivate_record($hash, $id) {
        $mid = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $mid])->row();
        $this->db->update($module->table_name, ['status' => 0], ['id' => $id]);
        redirect('admin/module/'.$hash);
    }

    public function remove_file($hash, $id, $field)
    {
        $mid = $this->_decode($hash);
        $module = $this->db->get_where('modules', ['id' => $mid])->row();
        if (!$module) show_404();

        $record = $this->db->get_where($module->table_name, ['id' => $id])->row_array();
        if (!empty($record[$field])) {
            $path = './assets/front/images/' . $record[$field];
            if (file_exists($path)) @unlink($path);
            $this->db->query("UPDATE {$module->table_name} SET `$field` = NULL WHERE id = $id");
        }

        echo "done";
    }




    private function _sync_table_structure($table, $fields) {
        if (!$this->db->table_exists($table)) return;
        $existing = $this->db->list_fields($table);
        foreach ($fields as $f) {
            if (!in_array($f->name, $existing)) {
                $this->db->query("ALTER TABLE `$table` ADD `{$f->name}` TEXT");
            }
        }
    }

    private function _create_table_if_not_exists($table, $fields) {
        if ($this->db->table_exists($table)) return;

        $table = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($table));
        $sql = "CREATE TABLE `$table` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `status` TINYINT(1) NOT NULL DEFAULT 1,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP";

        foreach ($fields as $f) {
            switch ($f->type) {
                case 'number':
                    $type = 'DECIMAL(10,2)';
                    break;
        
                case 'file':
                    $type = 'VARCHAR(255)';
                    break;
        
                case 'relation':
                    $type = 'INT';
                    break;
        
                default:
                    $type = 'TEXT';
            }
        
            $sql .= ", `{$f->name}` $type";
        }

        $sql .= ")";
        $this->db->query($sql);
    }

    private function _decode($hash) {
        return $this->hashids_lib->decode($hash) ?: 0;
    }

    public function globalsettings()
	{
		$this->load->view('admin/globalsettings', $this->Global);
	}

	public function editsettings()
	{
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $value = $_POST['value'];
            $this->Global_model->editsettings($name, $value);
        }
        redirect('admin/globalsettings');
	}

	public function change_password()
	{
		$this->load->view('admin/change-password');
	}
    
}
