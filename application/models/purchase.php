<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Purchase extends CI_Model {

	public function get_all_products($sort_by)
	{
		if($sort_by == "Price") {
			$sort_by_str = " ORDER BY products.price ASC";
		}
		else if ($sort_by == "Most Popular") {
			$sort_by_str = " ORDER BY products.quantity_sold DESC";
		}
		else {
			$sort_by_str = "";
		}

		$query = "SELECT * FROM products".$sort_by_str;
		
		return $this->db->query($query)->result_array();
	}

	public function count($post)
	{

	}

	public function get_category_name($category_id)
	{
		if ($category_id == 0) {
			return "All Products";
		}
		else {
			$query = "SELECT categories.name FROM categories WHERE categories.id = ?";
			return $this->db->query($query, array($category_id))->row_array();	
		}
	}

	public function get_products_by_category($category_id, $sort_by)
	{	
		if($sort_by == "Price") {
			$sort_by_str = " ORDER BY products.price ASC";
		}
		else if ($sort_by == "Most Popular") {
			$sort_by_str = " ORDER BY products.quantity_sold DESC";
		}
		else {
			$sort_by_str = "";
		}
		$query= "SELECT products.name, products.price, products.quantity_sold FROM products
			LEFT JOIN product_categories ON products.id = product_categories.product_id
			 LEFT JOIN categories ON product_categories.category_id = categories.id
			 WHERE categories.id = ?".$sort_by_str;

		return $this->db->query($query, array($category_id))->result_array();
	}

	public function get_all_categories()
	{
		$query = "SELECT * FROM categories";

		return $this->db->query($query)->result_array();
	}

	public function get_category_counts()
	{
		$query= "SELECT categories.id as category_id, categories.name as category_name, COUNT(category_id) as category_count FROM products
			LEFT JOIN product_categories ON products.id = product_categories.product_id
			 LEFT JOIN categories ON product_categories.category_id = categories.id
             GROUP BY category_id";

		return $this->db->query($query)->result_array();
	}

	public function get_product_by_id($id)
	{
		$query = "SELECT * FROM products WHERE id  = ?";

		return $this->db->query($query, $id)->row_array();
	}

	public function get_products_by_name($name)
	{
		$query = "SELECT * FROM products WHERE products.name LIKE '%".$name."%'";
		return $this->db->query($query)->result_array();
	}

	public function load_cart()
	{
		$cart_items = $this->session->userdata('cart_items');
		if(empty($cart_items)){ return; }
		$query = "SELECT products.id, products.name, products.price FROM products WHERE ";
		$first = true;
		foreach($cart_items as $product_id => $quantity){ 
			if (!$first) {
				$query .= "OR ";
			}
			else {
				$first = false;
			}
			$query .= "(products.id = ".$product_id.") ";
		}
		return $this->db->query($query)->result_array();
	}

	public function new_billings($post)
	{
		$query = "INSERT INTO billings (shipping_first, shipping_last,
		 	shipping_address, shipping_city, shipping_state, shipping_zip,
		 	billing_first, billing_last, billing_address, billing_city, billing_state, billing_zip, card,
		 	security, expiration_month, expiration_year, created_at, updated_at)
			VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NOW(), NOW())";
		$this->db->query($query, $this->input->post());
		return $this->db->insert_id();
	}

	public function new_orders($id, $price)
	{
		$query = "INSERT INTO orders (billing_id, total_price, status, created_at, updated_at)
		 		VALUES (?, ?, 'Order in process', NOW(), NOW())";

		$this->db->query($query, array($id, $price));
		return $this->db->insert_id();
	}

	public function new_order_products($id)
	{	
		$cart_items = $this->session->userdata('cart_items');
		if(empty($cart_items)){ return;}
		$query = "INSERT INTO order_products (product_id, quantity, order_id) VALUES (?,?,?)";
		$first = true;
		foreach($cart_items as $product_id => $quantity){ 
			if($quantity == 0){ continue;}
			if (!$first) {
			}
			else {
				$first = false;
			}
			$this->db->query($query, array($product_id, $quantity, $id));
		}
	redirect('/purchases/products');
	}

	public function new_products()
	{	
		$cart_items = $this->session->userdata('cart_items');
		foreach($cart_items as $product_id => $quantity){ 
		$query = "UPDATE products SET in_stock = in_stock - ?, quantity_sold = quantity_sold + ?, updated_at = NOW() WHERE ";		
		$first = true;
		
			if (!$first) {
				$query .= "OR ";
			}
			else {
				$first = false;
			}
			$query .= "(products.id = ".$product_id.") ";
		$this->db->query($query, array($quantity, $quantity));
		}
		redirect('/purchases/order_complete');
	}	
}