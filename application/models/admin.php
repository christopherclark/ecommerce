<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Admin extends CI_Model {

	public function get_all_orders()
	{
		$query = "SELECT * FROM orders";
		return $this->db->query($query)->result_array;
	}

	public function get_order_by_id($id)
	{
		$query = "SELECT * FROM orders WHERE id =?";
		return $this->db->query($query, $id)->row_array;
	}

	public function update_order_status($post)
	{	
		$id = $post['id'];
		$order_status = $post['order_status'];
		$query = "UPDATE orders SET order_status = ? WHERE id = ?";
		return $this->db->query($query, array($order_status, $id);
	}

	public function get_all_products()
	{
		$query = "SELECT * FROM products";
		return $this->db->query($query)->result_array;
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
			$name, $description, $price, $in_stock, $id);
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
    		 	$name, $description, $price, $in_stock);
	}

}