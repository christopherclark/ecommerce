<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Admins extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin');

		/////
		$this->load->helper(array('form', 'url'));
		////
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
        		$this->session->set_userdata('admin_id',$admin_id['id']);
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
			$this->load->view('/admins/all_orders');
		}
	}

	public function get_order_status()
	{
		$data['page_no'] = 0;
		$data['statuses'] = 'show all';
		$data['count'] = $this->Admin->get_all_orders_count();
		$data['orders'] = $this->Admin->get_all_orders($data['page_no']);
		$this->load->view('/admins/partials/status_form',$data);
	}

	public function update_order_status()
	{
		$page_no = intval($this->input->post('page_no'));
		$data['statuses'] = $this->input->post('statuses');
		$this->Admin->update_order_status($this->input->post());
		if($data['statuses']=='show all') 
		{
			$data['count'] = $this->Admin->get_all_orders_count();
			$data['orders'] = $this->Admin->get_all_orders($page_no);
			$this->load->view('/admins/partials/status_form',$data);
		}
		else
		{
			$this->filter_by_status();
		}
	}

	public function filter_by_status()
	{
		$page_no = intval($this->input->post('page_no')) * 8;
		$data['statuses'] = $this->input->post('statuses');
		if($data['statuses']=='show all') 
		{
			$data['count'] = $this->Admin->get_all_orders_count();
			$data['orders'] = $this->Admin->get_all_orders($page_no);
			$this->load->view('/admins/partials/status_form',$data);
		}
		else
		{
			$data['count'] = $this->Admin->filter_by_status_count($this->input->post());
			$data['orders'] = $this->Admin->filter_by_status($this->input->post());
			$this->load->view('/admins/partials/status_form',$data);
		}
	}

	public function search_orders()
	{
		$data['page_no'] = $this->input->post('page_no');
		$data['statuses'] = $this->input->post('statuses');
		if($data['statuses']=='show all')
		{
			$data['count'] = $this->Admin->search_orders_all_count($this->input->post());
			$data['orders'] = $this->Admin->search_orders_all($this->input->post());
		}
		else
		{
			$data['count'] = $this->Admin->search_orders_count($this->input->post());
			$data['orders'] = $this->Admin->search_orders($this->input->post());
		}
		$data['search'] = $this->input->post('search');
		$this->load->view('/admins/partials/status_form',$data);
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
			$data['photos'] = $this->Admin->get_main_photos();
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
			$data['categories'] = $this->Admin->get_categories($id);
			$data['photos'] = $this->Admin->get_product_photos($id);
			$this->load->view('/admins/edit_product', $data);
		}
	}

	public function edit_product()
	{
		// $config['upload_path'] = './uploads/';
		// $config['allowed_types'] = 'gif|jpg|png';
		// $config['max_size']	= '100';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';
		// $this->load->library('upload', $config);


		// if ( !$this->upload->do_upload())
		// {
		// 	$error = array('error' => $this->upload->display_errors());

		// 	// $this->load->view('upload_form', $error);
		// 	var_dump($error);
		// }
		// else
		// {
		// 	$data = array('upload_data' => $this->upload->data());
		// 	var_dump($this->input->post());
		// 	var_dump($data);
		// 	// $this->load->view('upload_success', $data);
		// }
		if (isset($_FILES['name'])) { $this->Admin->upload_photo($_FILES['userfile'], $this->input->post()); }
		if (isset($_POST['category'])) {$this->Admin->add_category($this->input->post());}
		$this->Admin->edit_product($this->input->post());
		$this->Admin->update_main_photo($this->input->post());
		$data['products'] = $this->Admin->get_all_products();
		$data['photos'] = $this->Admin->get_main_photos();
		$this->load->view('/admins/inventory', $data);
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