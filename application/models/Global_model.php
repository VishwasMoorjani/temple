<?php 
#[\AllowDynamicProperties]
class Global_model extends CI_Model {

    public function getdata(){
        $this->load->database();
        $query = $this->db->query("Select * from global");
        $info = $query->result_array();
        foreach ($info as $row) {
            $data[$row['name']] = $row['value'];
        }
        return $data;
    }
    
    public function editsettings($name, $value){
        $this->db->set('value',$value);
        $this->db->where('name', $name);
        $this->db->update('global');
    }

    public function send_mail($data)
    {
        $this->load->library('email');
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = admin_host;
        $config['smtp_crypto'] = 'ssl';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = admin_username;
        $config['smtp_pass']    = admin_password;
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not    

        $this->email->initialize($config);
        $this->email->from(admin_username, admin_name);
        $this->email->to($data['toemail']);
        $this->email->subject($data['subject']);
        $this->email->message($data['message']);
        
        if (isset($data['attachment']) && !empty($data['attachment'])) {
            $this->email->attach($data['attachment']);
        }

        if (!$this->email->send()) {
        return $this->email->print_debugger();
        } else {
        redirect('home/thanks');
        }
    }

    public function getpage($link){
        $this->load->database();
        $query = $this->db->query("Select * from pages where slug=\"$link\"");
        return $query->result();
    }
}
