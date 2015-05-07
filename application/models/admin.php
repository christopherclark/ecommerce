<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require "assets/vendor/autoload.php";
		use Aws\S3\S3Client;
		use Aws\S3\Exception\S3Exception;

class  Admin extends CI_Model {

	public function validate_login($email, $password)
	{
		$query = "SELECT id FROM admins WHERE email = ? AND password = ?";
		$values = array($email, $password);
		return $this->db->query($query, $values)->row_array();
	}

	public function get_all_orders_count()
	{
		$query = "SELECT COUNT(orders.id) AS count FROM orders JOIN billings ON orders.billing_id = billings.id";
		return $this->db->query($query)->row_array();	
	}

	public function get_all_orders($page_no)
	{
		$query = "SELECT orders.id AS id, billing_first, billing_last, orders.created_at AS created_at, billing_address, billing_city, billing_state, billing_zip, total_price, status  FROM orders JOIN billings ON orders.billing_id = billings.id LIMIT ?, 8";
		return $this->db->query($query, $page_no)->result_array();
	}

	public function update_order_status($post)
	{	
		$id = $post['id'];
		$order_status = $post['status'];
		$query = "UPDATE orders SET status = ? WHERE id = ?";
		return $this->db->query($query, array($order_status, $id));
	}

	public function get_order_status_count($post)
	{
		$query = "SELECT COUNT(orders.id) AS count FROM orders JOIN billings ON orders.billing_id = billings.id WHERE orders.status = ?";
		return $this->db->query($query, $post['statuses'])->row_array();
	}

	public function filter_by_status_count($post)
	{
		$query = "SELECT COUNT(orders.id) AS count FROM orders JOIN billings ON orders.billing_id = billings.id WHERE orders.status = ?";
		return $this->db->query($query, array($post['statuses']))->row_array();
	}

	public function filter_by_status($post)
	{
		$query = "SELECT orders.id AS id, billing_first, billing_last, orders.created_at AS created_at, billing_address, billing_city, billing_state, billing_zip, total_price, status  FROM orders JOIN billings ON orders.billing_id = billings.id WHERE orders.status = ? LIMIT ?, 8";
		$page_no = intval($post['page_no'])*8;
		$values = array($post['statuses'], $page_no);
		return $this->db->query($query, $values)->result_array();
	}

	public function search_orders_all_count($post)
	{
		$query = "SELECT COUNT(orders.id) AS count FROM orders JOIN billings ON orders.billing_id = billings.id WHERE (orders.id = ? OR billing_first = ? OR billing_last = ?)";
		$values = array($post['search'], $post['search'], $post['search']);
		return $this->db->query($query, $values)->row_array();
	}

	public function search_orders_all($post)
	{
		$page_no = intval($post['page_no']);
		$query = "SELECT orders.id AS id, billing_first, billing_last, orders.created_at AS created_at, billing_address, billing_city, billing_state, billing_zip, total_price, status  FROM orders JOIN billings ON orders.billing_id = billings.id WHERE (orders.id = ? OR billing_first = ? OR billing_last = ?) LIMIT ?, 8";
		$values = array($post['search'], $post['search'], $post['search'], $page_no);
		return $this->db->query($query, $values)->result_array();
	}

	public function search_orders_count($post)
	{
		$query = "SELECT COUNT(orders.id) AS count FROM orders JOIN billings ON orders.billing_id = billings.id WHERE orders.status = ? AND (orders.id = ? OR billing_first = ? OR billing_last = ?)";
		$values = array($post['statuses'], $post['search'], $post['search'], $post['search']);
		return $this->db->query($query, $values)->row_array();
	}

	public function search_orders($post)
	{
		$page_no = intval($post['page_no']);
		$query = "SELECT orders.id AS id, billing_first, billing_last, orders.created_at AS created_at, billing_address, billing_city, billing_state, billing_zip, total_price, status  FROM orders JOIN billings ON orders.billing_id = billings.id WHERE orders.status = ? AND (orders.id = ? OR billing_first = ? OR billing_last = ?) LIMIT ?, 8";
		$values = array($post['statuses'], $post['search'], $post['search'], $post['search'], $page_no);
		return $this->db->query($query, $values)->result_array();
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

	public function get_all_products()
	{
		$query = "SELECT * FROM products";
		return $this->db->query($query)->result_array();
	}

	public function edit_product($post)
	{
		$name= $post['name'];
		$description= $post['description'];
		$id = $post['id'];
		$query = "UPDATE products SET name = ?, description = ?, updated_at = NOW() WHERE id = ?";
		return $this->db->query($query, array($name, $description, $id));
	}

	public function upload_photo($file)
	{
	
		$s3 = S3Client::factory();
		try {
		    $s3->putObject(array(
		        'Bucket' => 'horseshoes',
		        'Key'    => $file['name'],
		        'Body'   => fopen($file['tmp_name'], 'r'),
		        'ACL'    => 'public-read',
		    ));
		} catch (S3Exception $e) {
		    echo "There was an error uploading the file.\n";
		}
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