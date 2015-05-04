<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Purchases extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Purchase');
	}

	public function index()
	{
		$data['products'] = $this->Purchase->get_all_products();
		$data['categories'] = $this->Purchase->get_all_categories();
		$this->load->view('/purchases/all_products', $data);
	}

	public function get_products_by_category()
	{
		$data['page_no'] = $this->Purchase->count($this->input->post());
		$data['products'] = $this->Purchase->get_products_by_category($this->input->post());
		$this->load->view('/purchases/all_products', $data);
	}

	public function get_product_by_id($id)
	{
		$data['product'] = $this->Purchase->get_product_by_id($id);
		$this->load->view('/purchases/view_product', $data);
	}

	public function add_to_cart()
	{

	}

	public function view_cart()
	{
		$this->load->view('/purchases/checkout');
	}

	public function validate_billing()
	{

	}
}

