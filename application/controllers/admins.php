<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Admins extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin');
	}

	public function index()
	{
		$this->load->view('/admins/login');
	}

	public function validate_login()
	{
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required|md5');

        if($this->form_validation->run()) 
        {
        	$admin_id = $this->Admin->validate_login(set_value('email'), set_value('password'));
        	if(!$admin_id) 
        	{
        	$this->session->set_flashdata('login_errors', "Incorrect email/password combination");
        	redirect('/admins');
        	}
        	else
        	{
        		$this->session->set_userdata($admin_id);
        		$this->get_all_orders();
        	}
        }
        else
        {
        	$this->session->set_flashdata('login_errors', validation_errors());
        	redirect('/admins');
        }
	}

	public function logoff()
	{
		$this->session->sess_destroy();
		redirect('/admins');
	}

	public function get_all_orders()
	{
		if(empty($this->session->userdata('admin_id')))
		{
			redirect('/admins');
		}
		else
		{
			$data['orders'] = $this->Admin->get_all_orders();
			$this->load->view('/admins/all_orders', $data);
		}
	}

	public function update_order_status()
	{
		$this->Admin->update_order_status($id);
	}

	public function get_all_products()
	{
		if(empty($this->session->userdata('admin_id')))
		{
			redirect('/admins');
		}
		else
		{
			$data['products'] = $this->Admin->get_all_products();
			$this->load->view('/admins/inventory', $data);
		}
	}

	public function get_order_by_id($id)
	{
		if(empty($this->session->userdata('admin_id')))
		{
			redirect('/admins');
		}
		else
		{
			$data['order'] = $this->Admin->get_order_by_id($id);
			$data['products'] = $this->Admin->get_order_products($id);
			$this->load->view('/admins/view_order', $data);
		}
	}

	public function get_product_by_id($id)
	{
		if(empty($this->session->userdata('admin_id')))
		{
			redirect('/admins');
		}
		else
		{
			$data['product'] = $this->Admin->get_product_by_id($id);
			$data['categories'] = $this->Admin->get_categories();
			$this->load->view('/admins/edit_product', $data);
		}
	}

	public function edit_product()
	{
		$this->Admin->edit_product($this->input->post());
		$this->load->view('/admins/inventory');
	}

	public function delete_product()
	{
		$this->Admin->delete_product($this->input->post());
	}

	public function add_product()
	{
		$this->Admin->add_product($this->input->post());
	}
}