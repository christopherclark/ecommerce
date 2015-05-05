<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Purchases extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Purchase');
	}

	public function index()
	{	
		// $this->session->sess_destroy();

		// 1. GET CATEGORY COUNTS
		$data['category_counts'] = $this->Purchase->get_category_counts();

		// 2. GET THE SELECTED RECORDS
		$data['category_id'] = 0;
		$data['page_no'] = 1;
		$data['products'] = $this->Purchase->get_all_products();

		// 3. LOAD THE VIEW
		$this->load->view('/purchases/all_products', $data);
	}

	public function view_all_products_by_page()
	{
		// 1. GET CATEGORY COUNTS
		$data['category_counts'] = $this->Purchase->get_category_counts();

		// 2. GET THE SELECTED RECORDS
		$data['category_id'] = 0;
		$data['page_no'] = $this->input->post('page_no');
		$data['products'] = $this->Purchase->get_all_products();

		// 3. LOAD THE VIEW
		$this->load->view('/purchases/all_products', $data);
	}

	public function view_product_category_by_page()
	{
		// 1. GET CATEGORY COUNTS
		$data['category_counts'] = $this->Purchase->get_category_counts();

		// 2. GET THE SELECTED RECORDS
		$data['category_id'] = $this->input->post('category_id');
		$data['page_no'] = $this->input->post('page_no');
		$data['products'] = $this->Purchase->get_products_by_category($this->input->post('category_id'));

		// 3. LOAD THE VIEW		
		$this->load->view('/purchases/all_products', $data);
	}

	public function get_product_by_id($id)
	{	
		$data['id'] = $id;
		$data['product'] = $this->Purchase->get_product_by_id($id);
		// echo "get_product_by_id(".$id.")<br>";
		// var_dump($data);
		// die();
		$this->load->view('/purchases/view_product', $data);
	}

	public function add_to_cart()
	{		
		$this->session->set_flashdata("success_message", "Item has been added to cart");
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
		$id = $this->input->post('id');
		$data['id'] = $id;
		$data['product'] = $this->Purchase->get_product_by_id($id);

		redirect('/products/show/'.$id, $data);
	}

	public function view_cart()
	{	
		var_dump($this->session->userdata('total_quantity'));
		$data['products']= $this->Purchase->load_cart();
		$this->load->view('/purchases/checkout', $data);
	}

	public function delete_item_from_cart($id)
	{	
		$cart = $this->session->userdata('cart_items');
		$cart[$id] = 0;
		$this->session->set_userdata('cart_items', $cart);
		
		$total_quantity = 0;
		foreach($this->session->userdata('cart_items') as $cart_item => $quantity){
				$total_quantity += $quantity;
			}
		$this->session->set_userdata("total_quantity", $total_quantity);

		$data['products']= $this->Purchase->load_cart();
		$this->load->view('/purchases/checkout', $data);
	}


	public function validate_billing()
	{

	}
}

