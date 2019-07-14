<?php 
class Newsletter extends CI_Controller{
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
	//added the index if any access direct from the url 
	public function index(){
		redirect(base_url(), 'refresh');
	}
	// added the function to add email to newsletter list start here //
	public function add($email=''){		
		$id = $this->input->post('email_id');
		$message = array();
		if($email =='email_id' && $id == ''){
			// if the email id is empty the return false
		$message['sts'] = 'error';
		$message['message'] = 'Email id is not to be empty';
		}else{
		// check if the email id already exists or not
		$selId = $this->db->get_where('newsletter', array('email_id' => $id));		
		if($selId->num_rows() > 0){
			$message['sts'] = 'error';
			$message['message'] = 'Email Id is already is list';
		}else{
	    $data = array('email_id'=>$id);
	    $test = $this->db->insert('newsletter', $data);		
		if($test == 1){
		$message['sts'] = 'success';	
		$message['message'] = 'Added to newsletter list successfully';
		}else{
		$message['sts'] = 'error';	
		$message['message'] = 'db Query error,Please try again';	
		}
		}
		}
		echo json_encode($message);
	}
	// added the function to add email to newsletter list ends here //
}

?>