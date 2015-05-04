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

	public function add_cart_item()
	{
	
		if(!$this->session->userdata($cart_items[$this->input->post['id']]))
	 		{
			$this->session->set_userdata($cart_items[$this->input->post['id']], $this->input->post['quantity']);
			}
		else
			{
			$this->session->set_userdata($cart_items[$this->input->post['id']],
			 $this->session->userdata($cart_items[$this->input->post['id']]) + $this->input->post['quantity']);
			}
		
		foreach($this->session->userdata($cart_items) as $cart_item => $quantity)
			{
				$total_quantity += $quantity;
			}
		

		$this->session->set_userdata("total_quantity", $total_quantity);
 /// 1. update session["cart"]   [{"product"=>"1","qty"=>"3"},...] with post[id] and post[qty]
		

// 2. get products.id products.name and products.price from DB for all id's in cart => "cart_inventory"

		// $cart_inventory = array(
			
		// 	"id" => $id;
		// 	"product"=> $data['name'],
		// 	"price" => $data['price'],
		// 	"quantity" => $quantity;
		// 	"sub_total" => $data['price'] * $quantity;


		// 	"total_quantity" => //add all quantities
		// 	"total_price" =>	//add all sub_total
		// 	)		

		// $this->Purchase->get_product_by_id($id)
	
		var_dump($this->session->userdata());
		die();
	}

	public function view_cart()
	{
		$this->load->view('/purchases/checkout', $data);
	}

	public function validate_billing()
	{

	}
}

