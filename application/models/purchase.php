<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Purchase extends CI_Model {

	public function get_all_products()
	{

		$query = "SELECT * FROM products";
		return $this->db->query($query)->result_array();
	}
	public function count($post)
	{

	}

	public function get_products_by_category($post)
	{	
		$query= "SELECT products.name, products.price FROM products
			LEFT JOIN product_categories ON products.id = product_categories.product_id
			 LEFT JOIN categories ON product_categories.category_id = categories.id
			 WHERE categories.id = ?";
		return $this->db->query($query, $post)->result_array();
	}

	public function get_all_categories()
	{

		$query = "SELECT * FROM categories";
		return $this->db->query($query)->result_array();
	}

	public function get_product_by_id($id)
	{
		$query = "SELECT * FROM products WHERE id  = ?";
		return $this->db->query($query, $id)->row_array();
	}

	// public function new_order($post)
	// {
	// 	$query = "INSERT INTO billings (shipping_first, shipping_last,
	// 	 	shipping_address, shipping_city, shipping_state, shipping_zip,
	// 	 	billing_first, billing_last, billing_city, billing_zip, card,
	// 	 	security, expiration, created_at, updated_at)
	// 		VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, NOW(), NOW())";
	// 	return $this->db->query($query, $post)-> /*get billings.id */ ;

	// 	$query = "INSERT INTO orders (billing_id, total_price, status, created_at, updated_at)
	// 	 		VALUES (?, ?, ?, NOW(), NOW())";
	// 	return $this->db->query($query, array();

	// 	$query = "INSERT INTO product_orders (order_id, product_id) VALUES (?,?)";
	// 	return $this->db->query($query, array());

	// 	$query = "UPDATE products SET in_stock = ?, quantity_sold = ?, updated_at = NOW() WHERE id = ?";
	// 	return $this->db->query($query, array());

	// }

}