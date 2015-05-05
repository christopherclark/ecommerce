<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Admin extends CI_Model {

	public function validate_login($email, $password)
	{
		$query = "SELECT id FROM admins WHERE email = ? AND password = ?";
		$values = array($email, $password);
		return $this->db->query($query, $values)->row_array();
	}

	public function get_all_orders()
	{
		$query = ("SELECT orders.id AS id, billing_first, billing_last, orders.created_at AS created_at, billing_address, billing_city, billing_state, billing_zip, total_price, status  FROM orders JOIN billings ON orders.billing_id = billings.id");
		return $this->db->query($query)->result_array();
	}

	public function get_order_by_id($id)
	{
		$query = "SELECT *, orders.id AS order_id FROM orders JOIN billings on orders.billing_id = billings.id WHERE orders.id =?";
		return $this->db->query($query, $id)->row_array();
	}

	public function get_order_products($id)
	{
		$query = "SELECT * FROM orders JOIN order_products ON orders.id = order_products.order_id JOIN products ON order_products.product_id = products.id WHERE orders.id = ?";
		return $this->db->query($query, $id)->result_array();
	}

	public function get_product_by_id($id)
	{
		$query = "SELECT * FROM products WHERE id = ?";
		return $this->db->query($query, $id)->row_array();
	}

	public function get_categories()
	{
		$query = "SELECT * FROM categories";
		return $this->db->query($query)->result_array();
	}

	public function update_order_status($post)
	{	
		$id = $post['id'];
		$order_status = $post['order_status'];
		$query = "UPDATE orders SET order_status = ? WHERE id = ?";
		return $this->db->query($query, array($order_status, $id));
	}

	public function get_all_products()
	{
		$query = "SELECT * FROM products";
		return $this->db->query($query)->result_array();
	}

	public function edit_product($post)
	{
		$name= $post['name'];
		$description= $post['description'];
		$price= $post['price'];
		$in_stock= $post['in_stock'];
		$id = $post['id'];
		$query = "UPDATE products SET name = ?, description = ?, price = ?,
		 in_stock = ?, updated_at = NOW() WHERE id = ?";
		return $this->db->query($query, array(
			$name, $description, $price, $in_stock, $id));
	}

	public function delete_product($id)
	{
		$query = "DELETE FROM products where id = ?";
    	return $this->db->query($query, $id);
	}

	public function add_product($post)
	{
		$name= $post['name'];
		$description= $post['description'];
		$price= $post['price'];
		$in_stock= $post['in_stock'];
		$query = "INSERT INTO products (name, description,
		 price, in_stock, quantity_sold, created_at, updated_at)
			 VALUES (?, ?, ?, ?, 0,  NOW(), NOW())";
    		 return $this->db->query($query, array (
    		 	$name, $description, $price, $in_stock));
	}

}