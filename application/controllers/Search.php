<?php 
class Search extends CI_Controller{

	function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('minify');
        $this->load->library('paypal');
        $this->load->model('crud_model');
        $this->load->model('email_model');
        $this->crud_model->ip_data();
    }
	public function index(){
        
		redirect(base_url(), 'refresh');
	}

	// adding the function that perform the search results on the db and return the results
 
	public function results(){
		$horse_id =  $this->input->post('horse_id');
		if(empty($horse_id)){
		redirect(base_url(), 'refresh');	
		}
		$horse_res_arr = $this->db->get_where('product',array('horse_code'=>$horse_id))->result_array();
	
		
		if(count($horse_res_arr)<=0)
		{
			
			$horse_res_arr = $this->db->query("SELECT * FROM product WHERE title LIKE '%".$horse_id."%' AND status !='under_approved' AND status !='reject'")->result_array();
		}
        
		// // $db_query = "SELECT * FROM `product` WHERE `horse_code` = 5006";
		// // $horse_res_arr = $this->db->query($db_query);
  //       echo "<pre>";
  //       print_r($horse_res_arr);
  //       echo "</pre>";
  //       die('here');
		$page_data['user_login'] = $this->session->userdata('user_login');
		$page_data['horse_details'] = $horse_res_arr;
        $page_data['page_name']     = "search";
        $page_data['page_title']    = translate('search');
        $this->load->view('front/index', $page_data);
	}
}
?>