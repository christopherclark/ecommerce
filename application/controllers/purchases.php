<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Purchases extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Purchase');
	}

	public function get_category_name($category_id) 
	{
		if ($category_id == -1) {
			return "Search Results";
		}
		else if ($category_id == 0) {
			return "All Products";
		}
		else {
			$data = $this->Purchase->get_category_name($category_id);
			return $data['name'];
		}
	}

	public function index()
	{	

		// $this->session->sess_destroy();

		// 0. GET CATEGORY COUNTS
		$data['category_counts'] = $this->Purchase->get_category_counts();

		// 1. SET THE DEFAULT SORT MODE
		$data['sort_by'] = "Price";

		// 2. GET THE SELECTED RECORDS
		$data['category_id'] = 0;
		$data['category_name'] = "All Products";
		$data['page_no'] = 1;
		$data['products'] = $this->Purchase->get_all_products($data['page_no'],$data['sort_by']);

		// 3. LOAD THE VIEW
		$this->load->view('/purchases/all_products', $data);
	}

	public function view_all_products_by_page()
	{
		echo "WHY AM I HERE IN view_all_products_by_page? I SHOULDN'T BE HERE!<br>";
		die();

		// 0. GET CATEGORY COUNTS
		$data['category_counts'] = $this->Purchase->get_category_counts();

		// 1. GET THE SORT MODE
		$data['sort_by'] = $this->input->post('sort_by');

		// 2. GET THE SELECTED RECORDS
		$data['category_id'] = 0;
		$data['category_name'] = "All Products";
		$data['page_no'] = $this->input->post('page_no');
		$data['products'] = $this->Purchase->get_all_products($data['sort_by']);

		// 3. LOAD THE VIEW
		$this->load->view('/purchases/all_products', $data);
	}

	public function view_product_category_by_page()
	{
		// 0. GET CATEGORY COUNTS
		$data['category_counts'] = $this->Purchase->get_category_counts();

		// 1. GET THE SORT MODE
		$data['sort_by'] = $this->input->post('sort_by');

		// 2. GET THE SELECTED RECORDS
		$data['search_str'] = $this->input->post('search_str');
		$data['category_id'] = $this->input->post('category_id');
		$data['category_name'] = $this->get_category_name($data['category_id']);
		$data['page_no'] = $this->input->post('page_no');
		if ($data['category_id'] == 0) {
			$data['products'] = $this->Purchase->get_all_products($data['page_no'],$data['sort_by']);
		}
		else{
			$data['products'] = $this->Purchase->get_products_by_category($this->input->post('category_id'),$data['page_no'],$data['sort_by']);
		}
// echo "CATEGORY FILTER<br>";
// var_dump($data);
// die();
		// 3. LOAD THE VIEW		
		$this->load->view('/purchases/all_products', $data);
	}

	public function get_product_by_id($id)
	{	
		$data['id'] = $id;
		$data['product'] = $this->Purchase->get_product_by_id($id);
		$this->load->view('/purchases/view_product', $data);
	}

	public function get_products_by_name()
	{	
		// 0A. GET CATEGORY COUNTS
		$data['category_counts'] = $this->Purchase->get_category_counts();

		// 0B. GET SEARCH COUNTS
		$data['search_str'] = $this->input->post('search_str');
		$result = $this->Purchase->get_search_counts($this->input->post('search_str'));
		$data['search_count'] = $result['search_count'];

		// 1. GET THE SORT MODE
		$data['sort_by'] = $this->input->post('sort_by');

		// 2. GET THE SELECTED RECORDS
		$data['category_id'] = $this->input->post('category_id');
		if ($data['category_id'] == 0) {
			echo "WHY AM I HERE IN get_products_by_name? I SHOULDN'T BE HERE!<br>";
			die();
			$data['category_name'] = "All Products";
		}
		else {
			$data['category_name'] = $this->get_category_name($data['category_id']);
		}
		$data['page_no'] = $this->input->post('page_no');
		$data['products'] = $this->Purchase->get_products_by_name($this->input->post('search_str'),$data['page_no'],$data['sort_by']);

		// 3. LOAD THE VIEW		
		$this->load->view('/purchases/all_products', $data);
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
		$this->load->library("form_validation");
		$data['products']= $this->Purchase->load_cart();
		$this->load->view('/purchases/checkout', $data);
	}

	public function delete_item_from_cart($id)
	{	
		$this->load->library("form_validation");

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
		$this->load->helper(array('form', 'url'));
		$this->load->library("form_validation");
		$this->form_validation->set_rules("ship_first_name", "First Name", "required");
		$this->form_validation->set_rules("ship_last_name", "Last Name", "required");
		$this->form_validation->set_rules("ship_address", "Address", "required");
		$this->form_validation->set_rules("ship_city", "City", "required");
		$this->form_validation->set_rules("ship_state", "State", "required");
		$this->form_validation->set_rules("ship_zipcode", "Zip Code", "required");
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if($this->form_validation->run() == FALSE)
		{
		$data['products']= $this->Purchase->load_cart();
		$this->load->view('/purchases/checkout', $data);
		}
		else
		{ 
			// var_dump($this->session->userdata('cart_items'));
			// var_dump($this->input->post());
			// echo "no errors";
			// die();

		$billing_id = $this->Purchase->new_billings($this->input->post());
		$id=$billing_id;
		
		$price = $this->session->userdata('price');	
	
		$order_id = $this->Purchase->new_orders($id, $price);
		$id=$order_id;
		
		$this->Purchase->new_order_products($id);
		}
	}
	public function products()
	{
		$this->Purchase->new_products();
	}

	public function order_complete()
	{
		$this->session->unset_userdata('cart_items');
		$this->session->set_userdata("total_quantity", 0);
		$this->load->view('/purchases/thank_you');
	}

	public function sort_by()
	{
		// 0A. GET CATEGORY COUNTS
		$data['category_counts'] = $this->Purchase->get_category_counts();

		// 0B. GET SEARCH COUNTS
		$data['search_str'] = $this->input->post('search_str');
		$result = $this->Purchase->get_search_counts($this->input->post('search_str'));
		$data['search_count'] = $result['search_count'];

		// 1. GET THE SORT MODE
		$data['sort_by'] = $this->input->post('sort_by');

		// 2. GET THE SELECTED RECORDS
		$data['search_str'] = $this->input->post('search_str');
		$data['category_id'] = $this->input->post('category_id');
		$data['page_no'] = $this->input->post('page_no');
		$data['category_name'] = $this->get_category_name($data['category_id']);
		if ($data['category_id'] == -1) {
			$data['products'] = $this->Purchase->get_products_by_name($data['search_str'],$data['page_no'],$data['sort_by']);
		}
		else if ($data['category_id'] == 0) {
			$data['products'] = $this->Purchase->get_all_products($data['page_no'],$data['sort_by']);
		} else {
			$data['products'] = $this->Purchase->get_products_by_category($data['category_id'],$data['page_no'],$data['sort_by']);
		}

		// 3. LOAD THE VIEW
		$this->load->view('/purchases/all_products', $data);
	}

	public function selfie($id)
	{
		redirect('purchases/self_join');
	}

}


