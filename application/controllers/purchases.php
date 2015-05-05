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
		$data['id'] = $id;
		$data['product'] = $this->Purchase->get_product_by_id($id);
		$this->load->view('/purchases/view_product', $data);
	}
	public function add_to_cart()
	{	
		// $this->session->sess_destroy();
		if(empty($this->session->userdata('cart_items'))){
	 		$cart_items = array($this->input->post('id') => $this->input->post('quantity'));
			$this->session->set_userdata('cart_items', $cart_items);
			}
		else{
				$cart_items=$this->session->userdata('cart_items');
				$found = false;
				foreach($cart_items as $cart_item => $quantity){
					if($cart_item == $this->input->post('id')){
						$cart_items[$cart_item] += $this->input->post('quantity');
						$found=true;
						$this->session->set_userdata('cart_items',$cart_items);
					}
				}
				if ($found == false){
					$cart_items = $this->session->userdata('cart_items');
					$cart_items[$this->input->post('id')]=$this->input->post('quantity');
					$this->session->set_userdata('cart_items', $cart_items);
				}
			}
		$total_quantity = 0;
		foreach($this->session->userdata('cart_items') as $cart_item => $quantity){
				$total_quantity += $quantity;
			}
		$this->session->set_userdata("total_quantity", $total_quantity);

		$this->session->set_flashdata("success_message", "Item has been added to cart");

		$id = $this->input->post('id');
		$data['id'] = $id;
		$data['product'] = $this->Purchase->get_product_by_id($id);
		$this->load->view('/purchases/view_product', $data);

		// var_dump($this->session->all_userdata());
		// die();
	}

	public function view_cart()
	{
		$data['products']= $this->Purchase->load_cart();
		// var_dump($this->session->userdata('cart_items'));

		$this->load->view('/purchases/checkout', $data);
	}

	public function validate_billing()
	{

	}
}

