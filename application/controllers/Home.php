<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->Global = $this->Global_model->getdata();
		$data['modules'] = $this->db->get('modules')->result();
		foreach($data['modules'] as $module)
		{
			$this->Global[$module->table_name] = $this->db->get($module->table_name)->result();
		}
	}

	public function index()
	{
		$this->load->view('front/index', $this->Global);
	}
	
	public function about()
	{
		$this->Global['page'] = $this->Global_model->getpage("about")[0];
		$this->load->view('front/about', $this->Global);
	}
	public function achievements()
	{
		$this->load->view('front/achievements', $this->Global);
	}
	
	public function services()
	{
		$this->load->view('front/services', $this->Global);
	}
	
	public function service($slug)
	{
		$this->Global['service'] = $this->db->get_where('services', array('slug' => $slug))->row();
		if(!$this->Global['service']) show_404();
		else
		$this->load->view('front/service-detail', $this->Global);
	}
	
	public function policy($slug)
	{
		$this->Global['policy'] = $this->db->get_where('policies', array('slug' => $slug))->row();
		if(!$this->Global['policy']) show_404();
		else
		$this->load->view('front/policy', $this->Global);
	}
	
	public function blogs()
	{
		$this->load->view('front/blogs', $this->Global);
	}
	
	public function blog($slug)
	{
		$this->Global['blog'] = $this->db->get_where('blogs', array('slug' => $slug))->row();
		if(!$this->Global['blog']) show_404();
		else
		$this->load->view('front/blog-detail', $this->Global);
	}
	
	public function gallery()
	{
		$this->load->view('front/gallery', $this->Global);
	}
	
	public function contact()
	{
		$this->load->view('front/contact', $this->Global);
	}
	public function thanks()
	{
		$this->load->view('front/thanks', $this->Global);
	}

	public function form()
	{
		$module = $this->db->get_where('modules', ['table_name' => 'form'])->row();
		if (!$module) show_404();

		$fields = json_decode($module->fields);
		$data = [];

		foreach ($fields as $f) {
			$value = trim(strip_tags($this->input->post($f->name)));
			if ($f->type == 'file' && !empty($_FILES[$f->name]['name'])) {
				$path = './assets/front/images/';
				@mkdir($path, 0777, true);
				$filename = time().'_'.basename($_FILES[$f->name]['name']);
				move_uploaded_file($_FILES[$f->name]['tmp_name'], $path.$filename);
				$data[$f->name] = $filename;
			} else {
				$data[$f->name] = $value;
			}
		}

		$data['status'] = 1;
		$this->db->insert($module->table_name, $data);

		redirect('thanks');
	}



}
