<?php 
class Ipn extends CI_Controller{
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
        redirect(base_url(),'refresh');
      } // end of the index function

      public function ipn_check(){

      } // end of the ipn_check function
} // end of the class here