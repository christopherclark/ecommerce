<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class  Purchase extends CI_Model {

	public function get_all_products()
	{
		$query = ("SELECT * FROM products");
		return $this->db->query($query)->result_array();
	}
	public function count($post)
	{

	}

	public function get_products_by_category($post)
	{
		
	}

	public function get_all_categories()
	{
		$query = ("SELECT * FROM categories");
		return $this->db->query($query)->result_array();
	}

	public function get_product_by_id($id)
	{
		$query = ("SELECT * FROM products WHERE id  = ?");
		return $this->db->query($query, $id)->row_array();
	}

}