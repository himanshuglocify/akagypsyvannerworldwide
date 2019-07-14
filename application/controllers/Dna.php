<?php 
class Dna extends CI_Controller{
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
      } // end of the constructor function 
      public function index(){
          $page_data['page_name']     = "dna";
            $page_data['page_title']    = translate('dna');
            $this->load->view('front/index', $page_data);
      } // end of the index function

    public function dnaterm(){
        $formData = $this->session->userdata('formData');
        $id = $this->session->userdata('formDataId');
        //if exit then show the page else redirect to the homepage
        if(is_array($formData) && !empty($id)){
        $page_data['page_name']     = "dnaterm";
        $page_data['page_title']    = translate('dna_terms_and_conditions');
        $this->load->view('front/index', $page_data);
        }else{
         redirect(base_url(), 'refresh');
        }
        
    } // end of the dna term function here

    public function DnaTermSubmit(){
      // getting the flashdata that is set on the db insert on the dna_submit
        $formData = $this->session->userdata('formData');
        $id = $this->session->userdata('formDataId');
        //if exit then show the page else redirect to the homepage
        if(is_array($formData) && !empty($id)){
        // calling the function that is reponsible for the payment of dna
         $this->dna_payment($formData,$id);
        }else{
         redirect(base_url(), 'refresh');
        }
    }

    public function dna_submit(){
    if($this->input->post()){
    $post_data = array_values($this->input->post());
    // array fields that are into the db
    $tb_fields = array('title','name','address','postcode','telephone','mobile','email','registered_name','breed','test_required','kc_isds_registration_num','microchip_tattoo_num','sex','sex_dob','sire_reg_name','sire_reg_num','dam_reg_name','dam_reg_num','created_date');

    $data = array();
    // number of items into post array
    $counter  = count($post_data);
    // loop all the array elements 
    for($i =0; $i <=$counter-1; $i++){
      $tb_fields_dta = $tb_fields[$i];
      $post_d = $post_data[$i];      
      if($tb_fields_dta == 'created_date'){
        $data[$tb_fields_dta] = date("Ymd");
      }else{
        $data[$tb_fields_dta] = $post_d;
      }        
    }
    // insert the data into the db     
    $res = $this->db->insert('dna', $data);
    //if all well redirected to next page here   
    if($res){
    $id = $this->db->insert_id();
    $this->session->set_userdata('formData',$data);
    $this->session->set_userdata('formDataId',$id);
    $url = base_url().'index.php/dna/dnaterm';
        redirect($url, 'refresh');
    }
    } // end of the if condition here 
    } // end  of the function here 

// function that is responsible for the payment of the dna module start here //
    public function dna_payment($formData,$id){
      $postdata = 'dna';      
      if(is_array($formData)){
      $vat = 0;
      $paypal_email = $this->crud_model->get_type_name_by_id('business_settings', '1', 'value');
      /****TRANSFERRING USER TO PAYPAL TERMINAL****/
        $this->paypal->add_field('rm', 2);
        $this->paypal->add_field('no_note', 0);
        $this->paypal->add_field('cmd', '_cart');
        $this->paypal->add_field('upload', '1');
        $i = 1;
        $this->paypal->add_field('item_number_' . $i, $i);
        $this->paypal->add_field('item_name_' . $i, $postdata);
        $this->paypal->add_field('amount_' . $i, $this->cart->format_number(30));        
        $this->paypal->add_field('currency_code', 'GBP');        
        $this->paypal->add_field('shipping_' . $i, $this->cart->format_number(0));
        $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($vat)));
        $this->paypal->add_field('quantity_' . $i, 1);
        
        //$this->paypal->add_field('amount', $grand_total);
        $this->paypal->add_field('custom', $id);
        $this->paypal->add_field('business', $paypal_email);
        $this->paypal->add_field('notify_url', base_url() . 'index.php/dna/dna_paypal_ipn');
        $this->paypal->add_field('cancel_return', base_url() . 'index.php/dna/dna_paypal_cancel');
        $this->paypal->add_field('return', base_url() . 'index.php/dna/dna_paypal_success');
        //$this->paypal->submit_paypal_post();
        $reults =  $this->paypal->submit_paypal_post();
        return $reults;
        //redirect(base_url());
      }else{
        redirect(base_url(),'refresh');  
      }
    } // end of the function here 
// function that is responsible for the payment of the dna module ends here //

    public function dna_paypal_ipn(){
      if ($this->paypal->validate_ipn() == true) {
      echo "<pre>";
      print_r(json_encode($_POST));            
      echo "</pre>";  
      die('dna_paypal_ipn');          
        $data['payment_details']   = json_encode($_POST);
        // $data['payment_timestamp'] = strtotime(date("m/d/Y"));
        // $data['payment_type']      = 'paypal';
        // $vendor_id                   = $_POST['custom'];
        // $data['status'] = 'approved';
        // $data['approve_timestamp'] = time();   
        // $this->db->where('vendor_id', $vendor_id);
        // $this->db->update('vendor', $data);
        }
    } // end of the dna_paypal_ipn function here

    public function dna_paypal_cancel(){
      redirect(base_url() . 'index.php', 'refresh');
    } // end of the dna_paypal_cancel function

    public function dna_paypal_success(){
    $paypal_response = $_POST;
    $formData = $this->session->userdata('formData'); 

    $paymentDnaField  = array('dna_id','amount','timestamp','details','method','status');
    $paypalArr = array(); 
    $paypalArr['id'] = $_POST['custom'];  
    $paypalArr['mc_gross'] = $_POST['mc_gross'];  
    $paypalArr['payment_date'] = $_POST['payment_date'];  
    $paypalArr['details'] = json_encode($_POST);  
    $paypalArr['method'] = 'paypal';  
    $paypalArr['status'] = $_POST['payment_status']; 
    $paypalArrInt =   array_values($paypalArr);    
    $counter = count($paymentDnaField);
    $payData = array();
    for($i = 0; $i <= $counter-1;$i++){
      $payKey = $paymentDnaField[$i];
      $payVal = $paypalArrInt[$i];
      $payData[$payKey] = $payVal;
    } 
    $res = $this->db->insert('dna_payment', $payData);
    //if all well redirected to next page here   
    if($res){
    $this->session->unset_userdata('formData');  
    $this->session->unset_userdata('formDataId');  
    $url = base_url().'index.php/';
        redirect($url, 'refresh');
    }
      
   //redirect(base_url() . 'index.php/home', 'refresh');

    } // end of the dna_paypal_success function 

} // end of the dna class