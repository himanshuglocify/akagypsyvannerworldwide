<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller
{
    
	/*	
	 *	Developed by: Active IT zone
	 *	Date	: 14 July, 2015
	 *	Active Supershop eCommerce CMS
	 *	http://codecanyon.net/user/activeitezone
	 */
    
    function __construct()
    {
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
        /*cache control*/
		// $cache_time	 =  $this->db->get_where('general_settings',array('type' => 'cache_time'))->row()->value;
		// if(!$this->input->is_ajax_request()){
		// 	$this->output->set_header('HTTP/1.0 200 OK');
		// 	$this->output->set_header('HTTP/1.1 200 OK');
		// 	$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
		// 	$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		// 	$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		// 	$this->output->set_header('Pragma: no-cache');
		// 	$this->output->cache($cache_time);
		// }
       
    }
    
    /* FUNCTION: Loads Homepage*/
    public function index()
    {
        $page_data['min'] = $this->get_range_lvl('product_id !=', '', "min");
        $page_data['max'] = $this->get_range_lvl('product_id !=', '', "max");
        $this->db->order_by('product_id', 'desc');
        $page_data['featured_data'] = $this->db->get_where('product', array(
            'featured' => "ok",
            'status' => 'ok'
        ))->result_array();        
        $page_data['page_name']     = "home";
        $page_data['page_title']    = translate('home');
        $page_data['user_login'] = $this->session->userdata('user_login');
        $page_data['user_id'] = $this->session->userdata('user_id');
        $this->load->view('front/index', $page_data);
    }
    
    function vendor($vendor_id){
		$vendor_system	 =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
        if($vendor_system	 == 'ok' && 
			$this->db->get_where('vendor',array('vendor_id'=>$vendor_id))->row()->status == 'approved'){
            $min = $this->get_range_lvl('added_by', '{"type":"vendor","id":"'.$vendor_id.'"}', "min");
            $max = $this->get_range_lvl('added_by', '{"type":"vendor","id":"'.$vendor_id.'"}', "max");
            $this->db->order_by('product_id', 'desc');
            $page_data['featured_data'] = $this->db->get_where('product', array(
                'featured' => "ok",
                'status' => 'ok',
                'added_by' => '{"type":"vendor","id":"'.$vendor_id.'"}'
            ))->result_array();
            $page_data['range']             = $min . ';' . $max;
            $page_data['all_category']      = $this->db->get('category')->result_array();
            $page_data['all_sub_category']  = $this->db->get('sub_category')->result_array();
            $page_data['page_name']         = 'vendor_home';
            $page_data['vendor']            = $vendor_id;
            $page_data['page_title']        = $this->db->get_where('vendor',array('vendor_id'=>$vendor_id))->row()->display_name;
            $this->load->view('front/index', $page_data); 
        } else {
             redirect(base_url(), 'refresh');
        }
    }


    /* FUNCTION: Loads Customer Profile Page */
    function profile()
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url(), 'refresh');
        }
		$page_data['countries'] = $this->db->get('country')->result_array();
		$page_data['states'] = $this->db->get('states')->result_array();
        $page_data['page_name']    = "profile";
        $page_data['page_title']   = translate('my_profile');
        $page_data['all_products'] = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')
        ))->result_array();
        $page_data['user_info']    = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')
        ))->result_array();
        
        $this->load->view('front/index', $page_data);
    }
	function cancel_payment($para='',$para1=''){
		if($para != '' && $para1 != '')
		{
			$payment_status = $this->db->get_where('sale',array('sale_id'=>$para,'sale_code'=>$para1))->row()->payment_status;
			$payment_status = json_decode($payment_status);
			$payment_status[0]->status = 'cancel';
			$data['payment_status'] = json_encode($payment_status);
			$this->db->where(array('sale_id' => $para,'sale_code'=>$para1));
            $this->db->update('sale', $data);
		}
		$this->session->set_flashdata('alert','payment_canceled');
		redirect(base_url() . 'index.php/home/profile', 'refresh');
	}
   /* FUNCTION : market page */ 
    function market($para=''){ 

        if($this->input->post()){
			$cat = $this->input->post('cat');
			$size = $this->input->post('size');
			$page = $this->input->post('page');
			$query = "SELECT * from `product`"; 
			if(!empty($cat) || !empty($size)){
				$query .= " WHERE";        
				$page_data['cat'] = $cat;        
				$page_data['size'] = $size;        
			}else{         
				$page_data['cat'] = '';
				$page_data['size'] = '';         
			} 
			if(!empty($cat)){
				$query .= " category=".$cat." AND";         
			}        
			if(!empty($size)){
				$query .= " size ='".$size."' AND";
			}
			if(empty($cat) && empty($size)){
				$query .= " WHERE";   
			}
			$query .='  status="sell"';
			if($page == 1){
				$to = 0;
			}else{
				$to  = ($page*12)-12;
			}        
			$limit = 12;
			$query1 = $query;
			$query .= " LIMIT ".$to.','.$limit;
			$horse_res_arr = $this->db->query($query);
			if(!empty($cat) ||!empty($size)){
				$total_horse_count = $this->db->query($query1);
				$page_data['total_rows'] = $total_horse_count->num_rows();
			}else{
				$total_horse_count = $this->db->query($query1);
				$page_data['total_rows'] = $total_horse_count->num_rows();
			}
			$page_data['current'] = $page;
		}elseif(!empty($para)){
			$page_data['cat'] = $para;
			$query = "SELECT * from `product`";
			$query .= " WHERE";
			$query .= " category=".$para." AND";
			$query .='  status="sell"';
			$qr =  $query;
			$to = 0; $limit =12;
			$query .= " LIMIT ".$to.','.$limit;
			$arr_res = $this->db->query($qr);
			$horse_res_arr = $this->db->query($query);
			$page_data['total_rows'] = $arr_res->num_rows();
			$page_data['current'] = 1;
        }else{         
			$horse_res_arr = $this->db->get_where('product', array('status'=>'sell'),12,0); 
			$sell = 'sell';
			$this->db->select('*');
			$this->db->from('product');
			$this->db->where('status=',$sell);
			$arr_res = $this->db->get();
			$page_data['total_rows'] = $arr_res->num_rows();
			$page_data['current'] = 1;
        }
		$page_data['all_products'] =  $horse_res_arr->result_array();
        $page_data['empty'] =  $horse_res_arr->num_rows();
        $page_data['page_name']     = "market";
        $page_data['page_title']    = translate('market');
        $page_data['user_login'] = $this->session->userdata('user_login');
        $page_data['user_id'] = $this->session->userdata('user_id');
        $page_data['item_per_page'] = 12;
        $this->load->view('front/index', $page_data);
    }
    /*FUNCTIOn : horese details page*/
    function horse($pid)
    {

        $page_data['product'] = $this->db->get_where('product',array('product_id'=>$pid))->row();
		if(!empty($page_data['product']))
		{
			$page_data['page_name']     = "horse";
			$page_data['page_title']    = translate('horse');
			$this->load->view('front/index', $page_data);
		}
		else
		{
			redirect('/','refresh');
		}
        
    }
    /*FUNCTIOn : horese dterms and condition page*/
    function productterms($pid)
    {
        if ($this->session->userdata('user_login') == 'yes' && $pid !='' && $pid !=0) 
        {
			
        $page_data['productid'] = $pid;
		$order_info = array();
		
		$product = $this->db->get_where('product',array('product_id'=>$pid))->row(); 

        $userinfo = $this->db->get_where('user',array('user_id'=>$this->session->userdata('user_id')))->row();
		$satename = '';
		$countryname = '';
		if($userinfo->state != '' && $userinfo->state > 0) {		
		$state=$this->crud_model->getsiglefield('states','id',$userinfo->state);
		$satename = $state->name;
		}
		$country=$this->crud_model->getsiglefield('country','country_id',$userinfo->country);
		$countryname = $country->country_name;
		$imgUrl = base_url().'uploads/product_image/product_'.$product->product_id.'_1_thumb.jpg';
		$order_info['p_id']=$pid;
		$order_info['price'] = $this->session->userdata('horsetotalprice');
		$order_info['shipping_cost'] = $this->session->userdata('shipping_cost');
		$order_info['commission'] = $product->commission;
		$order_info['horse_code'] = $product->horse_code;
		$order_info['product_name'] = $product->title;
		$order_info['sale_price'] = $product->sale_price;
		$order_info['p_image'] = $imgUrl;
		$order_info['ad_price'] = ($this->session->userdata('horsetotalprice')*20)/100;
		$order_info['user_name'] = $userinfo->surname;
		$order_info['user_id'] = $userinfo->user_id;
		$order_info['email'] = $userinfo->email;
		$order_info['phone'] = $userinfo->phone;
		$order_info['address1'] = $userinfo->address1;
		$order_info['address2'] = $userinfo->address2;
		$order_info['city'] = $userinfo->city;
		$order_info['state'] = $satename;
		$order_info['country'] = $countryname;
		$order_info['zip'] = $userinfo->zip;
		$order_info['product_type'] = 'Market';
		$order_info['payment_type'] = 'paypal';
		$this->session->set_userdata('order_info',$order_info);
		
        $page_data['page_name']     = "productterms";
        $page_data['page_title']    = translate('product_terms_and_condition');
        $this->load->view('front/index', $page_data);
        }
        else
        {
            redirect(base_url() . 'index.php/home/', 'refresh');
        }
    }
     /* FUNCTION: pay info page */

    function  pay_info()
    {
        if ($this->session->userdata('user_login') == 'yes') 
        {
			
            if($this->input->post('product_id') && $this->input->post('product_id') !='')
            {
                
                    $page_data['product'] = $this->db->get_where('product',array('product_id'=>$this->input->post('product_id')))->row(); 

                    $page_data['userinfo'] = $this->db->get_where('user',array('user_id'=>$this->session->userdata('user_id')))->row(); 


                    $page_data['page_name']     = "pay_info";
                    $page_data['page_title']    = translate('pay_info');
                    $this->load->view('front/index', $page_data);
                
                
            }
            else
            {
                $page_data['productid'] = $this->input->post('product_id');
                $page_data['page_name']     = "productterms";
                $page_data['page_title']    = translate('product_terms_and_condition');
                $this->load->view('front/index', $page_data);
            }
        }
        else
        {
            redirect(base_url() . 'index.php/home/', 'refresh');
        }
    }


    
    /* FUNCTION: Finalising Purchase*/
    function checkout($para1 = "", $para2 = "")
    {
	    if ($this->session->userdata('user_login') == 'yes' && $this->session->userdata('order_info')) {
			$order_info=$this->session->userdata('order_info');
            $arrkey = md5(time());
             $carted = array($arrkey =>array('id'=>$order_info['p_id'],
                'qty'=>1,
                'option'=>0,
                'price'=>$order_info['ad_price'],
                'name'=>$order_info['product_name'],
                'shipping'=>$order_info['shipping_cost'],
                'tax'=>0,
				'commission'=>$order_info['commission'],
                'image'=>$order_info['p_image'],
                'coupon'=>0,
                'rowid'=>0,
				'product_type'=>$order_info['product_type'],
				'user_name'=>$order_info['user_name'],
				'user_id'=>$order_info['user_id'],
				'email'=>$order_info['email'],
				'sale_price'=>$order_info['sale_price'],
                'total_price'=>$order_info['price'],
                'subtotal'=>$order_info['ad_price']
                )); 
            $this->session->set_userdata('carted', $carted);       
            $total    = $order_info['ad_price'];//$this->cart->total();
            $exchange = $this->crud_model->get_type_name_by_id('business_settings', '8', 'value');
            $vat_per  = '';
            $vat      = $this->crud_model->cart_total_it('tax');
            if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
				
                $shipping = $this->crud_model->cart_total_it('shipping');
            } else {
					
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            } 
            $grand_total     = $order_info['ad_price'];//$total + $vat + $shipping;
            $product_details = json_encode($carted);
            
            
            $shipping = json_encode(array('firstname'=>$order_info['user_name'],'email'=>$order_info['email'],'lastname'=>'','phone'=>$order_info['phone'],'address1'=>$order_info['address1'],'address2'=>$order_info['address2'],'city'=>$order_info['city'],'zip'=>$order_info['zip'],'payment_type'=>'paypal'));
			
            if ($order_info['payment_type'] == 'paypal') {
                if ($para1 == 'go')
                 {
                    
                    $data['buyer']             = $this->session->userdata('user_id');
                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = $shipping;
                    $data['vat']               = $vat;
                    $data['vat_percent']       = $vat_per;
                    $data['shipping']          = '';
                    $data['delivery_status']   = '[]';
                    $data['payment_type']      = $para1;
                    $data['payment_status']    = '[]';
                    $data['payment_details']   = 'none';
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = time();
                    $data['delivary_datetime'] = '';
					$data['product_type'] = $order_info['product_type'];
                    $paypal_email              = $this->crud_model->get_type_name_by_id('business_settings', '1', 'value');
                    
                    $this->db->insert('sale', $data);
                    $sale_id           = $this->db->insert_id();
                    
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                    
                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'due');
                    }
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'due');
                    }
                
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);
                   
                    $this->session->set_userdata('sale_id', $sale_id);
                    
                    /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_cart');
                    $this->paypal->add_field('upload', '1');
                    $i = 1;

                      $this->paypal->add_field('item_number_' . $i, $i);
                        $this->paypal->add_field('item_name_' . $i, $order_info['product_name']);
                        $this->paypal->add_field('amount_' . $i, $this->cart->format_number(($order_info['ad_price'] / $exchange)));
                        if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                            $this->paypal->add_field('shipping_' . $i, $this->cart->format_number(((0/ $exchange) * 1)));
                        }
                        $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($vat/ $exchange)));
                        $this->paypal->add_field('quantity_' . $i, 1);
                    /*
                    foreach ($carted as $val) {
                        $this->paypal->add_field('item_number_' . $i, $i);
                        $this->paypal->add_field('item_name_' . $i, $val['name']);
                        $this->paypal->add_field('amount_' . $i, $this->cart->format_number(($val['price'] / $exchange)));
                        if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                            $this->paypal->add_field('shipping_' . $i, $this->cart->format_number((($val['shipping'] / $exchange) * $val['qty'])));
                        }
                        $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($val['tax'] / $exchange)));
                        $this->paypal->add_field('quantity_' . $i, $val['qty']);
                        $i++;
                    } */
                    if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') {
                        $this->paypal->add_field('shipping_1', $this->cart->format_number(($this->crud_model->get_type_name_by_id('business_settings', '2', 'value') / $exchange)));
                    }
					
                    //$this->paypal->add_field('amount', $grand_total);
                    $this->paypal->add_field('custom', $sale_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/home/paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/home/paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/home/paypal_success');
                    $this->load->view('front/loadimage');
                    $this->paypal->submit_paypal_post();
                    // submit the fields to paypal
					
                }
                
            } 
            
        } else {
            //echo 'nope';
            redirect(base_url() . 'index.php/home/cart_checkout/need_login', 'refresh');
        }
        
    }
    
	/*
    function about()
	{
		$page_data['page_name']     = "about";
        $page_data['page_title']    = translate('about');
        $this->load->view('front/index', $page_data);
	}	*/
	function breed()
	{
		$page_data['page_name']     = "breed";
        $page_data['page_title']    = translate('breed');
        $this->load->view('front/index', $page_data);
	}
	/* get particular field of horse */
	function getHosefield($para1 = "", $para2 = "")
	{
		if($para1 != '')
		{
			$horses = $this->db->get_where('product',array('size' => strtolower($para1)))->result_array();
			$sting = '';
			foreach($horses as $horse)
			{
				$imgurl = base_url().'uploads/product_image/product_'.$horse['product_id'].'_1_thumb.jpg';
				$sting .='<li>';
				$sting .='<span class="breed_horse"><img src="'.$imgurl.'"  alt="'.$horse['title'].'" /></span><div><p>'.$horse['title'].'<p><span>'.$horse['sale_price'].'</span></div>';
				$sting .='</li>';
			}
			echo $sting;
		}
		else
		{
			echo 'Size not found';
		}
		
	}
	/*function horse filter by size*/
	function getFilterhose($para1='', $para2='')
	{
		
		$ret ='';
		$horses = $this->db->query("SELECT * FROM product WHERE gender IN (SELECT gender_id FROM gender where gender_group='$para2') and size = '$para1'")->result_array();
		$count = count($horses);
			if($count>0)
			{
				$ret .='<option value="">Select a Horse</option>';
				foreach($horses as $horse)
				{
					$ret .='<option value="'.$horse['product_id'].'">'.$horse['title'].'</option>';
				}
			}
			else
			{
				$ret .='<option value="">Select a Horse</option>';
			}
			
		echo $ret;
	}
	
    /* FUNCTION: Loads Category filter page */
    function category($para1 = "", $para2 = "", $min = "", $max = "")
    {
        
        if ($para2 == "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'category' => $para1
            ))->result_array();
        } else if ($para2 != "") {
            $page_data['all_products'] = $this->db->get_where('product', array(
                'sub_category' => $para2
            ))->result_array();
        }
        $page_data['range']            = $min . ';' . $max;
        $page_data['page_name']        = "product_list";
        $page_data['page_title']       = translate('products');
        $page_data['all_category']     = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['cur_sub_category'] = $para2;
        $page_data['cur_category']     = $para1;
        $page_data['category_data']    = $this->db->get_where('category', array(
            'category_id' => $para1
        ))->result_array();
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Search Products */
    function home_search($param = '')
    {
        $category = $this->input->post('category');
        $this->session->set_userdata('searched_cat', $category);
        if ($param !== 'top') {
            $sub_category = $this->input->post('sub_category');
            $range        = $this->input->post('range');
            $p            = explode(';', $range);
            redirect(base_url() . 'index.php/home/category/' . $category . '/' . $sub_category . '/' . $p[0] . '/' . $p[1], 'refresh');
        } else if ($param == 'top') {
            redirect(base_url() . 'index.php/home/category/' . $category, 'refresh');
        }
    }
    
    /* FUNCTION: Check if user logged in */
    function is_logged()
    {
        if ($this->session->userdata('user_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
  
    /* FUNCTION: Loads Featured Product Page */
    function featured_item($min = '', $max = '')
    {
        $page_data['page_name']        = "featured_list";
        $page_data['page_title']       = translate('featured_products');
        $page_data['range']            = $min . ';' . $max;
        $page_data['all_category']     = $this->db->get('category')->result_array();
        $page_data['all_sub_category'] = $this->db->get('sub_category')->result_array();
        $page_data['all_products']     = $this->db->get_where('product', array(
            'featured' => "ok",
            'status' => 'ok'
        ))->result_array();
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Loads Custom Pages */
    function page($parmalink = '')
    {
        $pagef                   = $this->db->get_where('page', array(
            'parmalink' => $parmalink
        ));
        $page_data['page_name']  = "page";
        $page_data['page_title'] = $parmalink;
        $page_data['page_items'] = $pagef->result_array();
        if ($this->session->userdata('admin_login') !== 'yes' && $pagef->row()->status !== 'ok') {
            redirect(base_url() . 'index.php/home/', 'refresh');
        }
        $this->load->view('front/index', $page_data);
    }
    
    
    /* FUNCTION: Loads Product View Page */
    function product_view($para1 = "")
    {
        $page_data['page_name']    = "product_view";
        $product_data              = $this->db->get_where('product', array(
            'product_id' => $para1,
            'status' => 'ok'
        ));
        $page_data['product_data'] = $product_data->result_array();
        $page_data['page_title']   = $product_data->row()->title;
        $page_data['product_tags'] = $product_data->row()->tag;
        
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Setting Frontend Language */
    function set_language($lang)
    {
        $this->session->set_userdata('language', $lang);
        $page_data['page_name'] = "home";
        redirect(base_url() . 'index.php/home/', 'refresh');
    }
    
    /* FUNCTION: Loads Contact Page */
    function contact($para1 = "")
    {
        $this->load->library('recaptcha');
        $this->load->library('form_validation');
        if ($para1 == 'send') {
            $safe = 'yes';
            $char = '';
            foreach($_POST as $row){
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
                {
                    $safe = 'no';
                    $char = $match[0];
                }
            }

            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('message', 'Message', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                if($safe == 'yes'){
                    $this->recaptcha->recaptcha_check_answer();
                    if ($this->recaptcha->getIsValid()) {
                        $data['name']      = $this->input->post('name',true);
                        $data['subject']   = $this->input->post('subject');
                        $data['email']     = $this->input->post('email');
                        $data['message']   = $this->security->xss_clean(($this->input->post('message')));
                        $data['view']      = 'no';
                        $data['timestamp'] = time();
                        $this->db->insert('contact_message', $data);
                        echo 'sent';
                    } else {
                        echo 'incor';
                    }
                } else {
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
        } else {
            $page_data['recaptcha_html'] = $this->recaptcha->recaptcha_get_html();
            $page_data['page_name']      = "contact";
            $page_data['page_title']     = translate('contact');
            $this->load->view('front/index', $page_data);
        }
    }
    
    /* FUNCTION: Concerning Login */
    function vendor_logup($para1 = "", $para2 = "")
    {
        if ($para1 == "add_info") {
            $message  = array();
            $this->load->library('form_validation');
            $safe = 'yes';
            $char = '';
            foreach($_POST as $k=>$row){
                if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match)){
                    if($k !== 'password1' && $k !== 'password2'){
                        $safe = 'no';
                        $char = $match[0];
                }}}
            $this->form_validation->set_rules('name', 'Your First Name', 'required');
            $this->form_validation->set_rules('surname', 'Your Surname', 'required');
            $this->form_validation->set_rules('email', 'Email', 'valid_email|required|is_unique[vendor.email]',array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
			$this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'required');
            $this->form_validation->set_rules('country', 'Your Country', 'required');
            $this->form_validation->set_rules('city', 'Your City', 'required');
            $this->form_validation->set_rules('zip', 'Your Zip', 'required');
            $this->form_validation->set_rules('display_name', 'Your Display Name', 'required');
            $this->form_validation->set_rules('password1', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');

            if ($this->form_validation->run() == FALSE){                
                echo validation_errors();
            }else{               
                if($safe == 'yes'){		
                    $data['username']           = $this->input->post('name');
                    $data['surname']           = $this->input->post('surname');
                    $data['email']              = $this->input->post('email');
					$data['gender']              = $this->input->post('gender');
                    $data['address1']           = $this->input->post('address1');
                    $data['address2']           = $this->input->post('address2');
					$data['city']         		= $this->input->post('city');
					if($this->input->post('state') !='' && $this->input->post('country') == '230')
						$data['state']          = $this->input->post('state');
					else
						$data['state']          = 0;				
					$data['country']          	= $this->input->post('country');
                    $data['company']            = $this->input->post('company');
                    $data['zip']                = $this->input->post('zip');
                    $data['display_name']       = $this->input->post('display_name');
                    $data['create_timestamp']   = time();
                    $data['approve_timestamp']  = 0;
                    $data['membership']         = 0;
                    $data['status']             = 'pending';
                    $data['price']              =$this->input->post('price');
                    $data['plan']              =$this->input->post('plan');
					$membership_plan = $this->db->get_where('membership', array(
								'membership_id' => $this->input->post('plan')))->row();
					$numdays = "+".$membership_plan->timespan." days";
					/*$data['member_expire_timestamp']    = strtotime(time())+strtotime($numdays);*/
					
					
                    $dataUser['username']           = $this->input->post('name');
					$dataUser['surname']           = $this->input->post('surname');
                    $dataUser['email']              = $this->input->post('email');
					$dataUser['gender']              = $this->input->post('gender');
                    $dataUser['address1']           = $this->input->post('address1');
                    $dataUser['address2']           = $this->input->post('address2');
                    $dataUser['city']         		= $this->input->post('city');
					if($this->input->post('state') !='' && $this->input->post('country') == '230')
						$dataUser['state']          = $this->input->post('state');
					else
						$dataUser['state']          = 0;
                    $dataUser['country']            = $this->input->post('country');
                    $dataUser['company']            = $this->input->post('company');
					$dataUser['zip']          	= $this->input->post('zip');

                    $dataUser['create_timestamp']   = time();
                    //$dataUser['approve_timestamp']  = time();
                    $dataUser['member_timestamp']   = time();
					$dataUser['creation_date']      = time();
                    if ($this->input->post('password1') == $this->input->post('password2')){
                        $password         = $this->input->post('password1');
                        $data['password'] = sha1($password);
						$dataUser['password'] = sha1($password);
                        // inserting the user into db if all is well 
                        $this->db->insert('vendor', $data);
						$vendor_id = $this->db->insert_id(); 
						$this->db->insert('user', $dataUser);
						$vendorinfo = array();
                        $this->email_model->account_opening('vendor', $data['email'], $password);
						$this->email_model->account_opening('user', $data['email'], $password);
						$dataMS['vendor']         = $vendor_id;
						$dataMS['amount']         = $membership_plan->price;
						$dataMS['status']         = 'due';
						$dataMS['method']         = 'paypal';
						$dataMS['membership']     = $membership_plan->membership_id; 
						$dataMS['timestamp']      = time();

						$this->db->insert('membership_payment', $dataMS);
						$invoice_id           = $this->db->insert_id();
						//$this->session->set_userdata('invoice_id', $invoice_id);
						$vendorinfo['venderdata'] = $data;
						$vendorinfo['venderid'] = $vendor_id;
						$vendorinfo['invoice_id'] = $invoice_id;
						$vendorinfo['plan_name'] = $membership_plan->title;
						$this->session->set_userdata('vendorinfo',$vendorinfo);
                        echo 'done';
                    }else{
						echo 'Password does not match!';
					}
                } else {
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
            }
        } else if($para1 == 'registration') {
            $this->load->view('front/vendor_logup');
        }

    }
	function memberterm()
	{
		$page_data['page_name']     = "memberterm";
        $page_data['page_title']    = translate('terms_of_member');
        $this->load->view('front/index', $page_data);
	}
	
	function vendor_membership()
	{
      $vendorinfo = $this->session->userdata('vendorinfo');
	  $postdata = $vendorinfo['venderdata'];
	  $vendor_id = $vendorinfo['venderid'];
	  $invoice_id = $vendorinfo['invoice_id'];
	  if($vendor_id != '' && $vendor_id >0)
	  {
		$vat = 0;
		$paypal_email = $this->crud_model->get_type_name_by_id('business_settings', '1', 'value');
			/****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_cart');
                    $this->paypal->add_field('upload', '1');
                    $i = 1;
                    $this->paypal->add_field('item_number_' . $i, $i);
                    $this->paypal->add_field('item_name_' . $i, $vendorinfo['plan_name']);
                    $this->paypal->add_field('amount_' . $i, $this->cart->format_number($postdata['price']));
                    if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                    $this->paypal->add_field('shipping_' . $i, $this->cart->format_number(0));
                    }
                    $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($vat)));
                    $this->paypal->add_field('quantity_' . $i, 1);
                    /*
                    foreach ($carted as $val) {
                        $this->paypal->add_field('item_number_' . $i, $i);
                        $this->paypal->add_field('item_name_' . $i, $val['name']);
                        $this->paypal->add_field('amount_' . $i, $this->cart->format_number(($val['price'] / $exchange)));
                        if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                            $this->paypal->add_field('shipping_' . $i, $this->cart->format_number((($val['shipping'] / $exchange) * $val['qty'])));
                        }
                        $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($val['tax'] / $exchange)));
                        $this->paypal->add_field('quantity_' . $i, $val['qty']);
                        $i++;
                    } */
                    if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') {
                        $this->paypal->add_field('shipping_1', $this->cart->format_number(($this->crud_model->get_type_name_by_id('business_settings', '2', 'value') / $exchange)));
                    }
                    //$this->paypal->add_field('amount', $grand_total);
                    $this->paypal->add_field('custom', $invoice_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/home/vendor_paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/home/vendor_paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/home/vendor_paypal_success');
                    
                    //$this->paypal->submit_paypal_post();
                    //$reults =  $this->paypal->submit_paypal_post();
					$page_data['page_name']     = "loadimage";
					 //$page_data['page_title']    = translate('redirecting_to_paypal');
					 $page_data['page_title']    = translate('account_setup');
					 $this->load->view('front/index', $page_data);
					 $this->first_month_free($invoice_id);
                    //return $reults;
                    //redirect(base_url());
	  }else{
		redirect(base_url());  
	  }
		
	}
	function first_month_free($custom='')
    {
		$vendorinfo = $this->session->userdata('vendorinfo');
		$postdata = $vendorinfo['venderdata'];
		$vendor_id = $vendorinfo['venderid'];
		
		
		$membership_id = $postdata['plan'];
		$membership_plan = $this->db->get_where('membership', array(
				'membership_id' => $membership_id
		))->row();
		$numdays = "+".$membership_plan->timespan." days";
		$data['status'] = 'approved'; 
		$data['approve_timestamp']    = time();
		$data['member_timestamp']    = time();
		$data['membership']    = 1;
        $data['member_expire_timestamp']    = strtotime(time())+strtotime($numdays);
		$this->db->where('vendor_id', $vendor_id);
            $this->db->update('vendor', $data);
            $this->email_model->status_email('vendor', $vendor_id);
		if($custom != ''){
			$dataMS['status']         = 'paid';
            $dataMS['details']        = json_encode($_POST);
            $invoice_id             = $custom;
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $dataMS);
		}
        $this->session->unset_userdata('vendorinfo');	
		$this->session->set_flashdata('alert','vendorapprove');
        redirect(base_url() . 'index.php/home', 'refresh');
    }
	
    /* FUNCTION: Concerning Login */
    function login($para1 = "", $para2 = "")
    {
        $page_data['page_name'] = "login";
        $this->load->library('form_validation');
        if ($para1 == "do_login") {
			$this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$signin_data = $this->db->get_where('user', array(
					'email' => $this->input->post('email'),
					'password' => sha1($this->input->post('password'))
				));
				if ($signin_data->num_rows() > 0) {
					foreach ($signin_data->result_array() as $row) {
						$this->session->set_userdata('user_login', 'yes');
						$this->session->set_userdata('user_id', $row['user_id']);
						$this->session->set_userdata('user_name', $row['username']);
						$this->session->set_flashdata('alert', 'successful_signin');
						$this->db->where('user_id', $row['user_id']);
						$this->db->update('user', array(
							'last_login' => time()
						));
						echo 'done';                    
					}
				} else {
					echo 'failed';
				}
			}
        } else if ($para1 == 'forget') {
        	$this->load->library('form_validation');
			$this->form_validation->set_rules('email', 'Email', 'required');
			
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
				$query = $this->db->get_where('user', array(
					'email' => $this->input->post('email')
				));
				if ($query->num_rows() > 0) {
					$user_id          = $query->row()->user_id;
					$password         = substr(hash('sha512', rand()), 0, 12);
					$data['password'] = sha1($password);
					$this->db->where('user_id', $user_id);
					$this->db->update('user', $data);
					if ($this->email_model->password_reset_email('user', $user_id, $password)) {
						echo 'email_sent';
					} else {
						echo 'email_not_sent';
					}
				} else {
					echo 'email_nay';
				}
			}
        }
    }
    /* FUNCTION: Setting login page with facebook and google */
    function login_set($para1 = '', $para2 = '')
    {
        $fb_login_set = $this->crud_model->get_type_name_by_id('general_settings', '51', 'value');
        $g_login_set  = $this->crud_model->get_type_name_by_id('general_settings', '52', 'value');
        $page_data    = array();
        $appid        = $this->db->get_where('general_settings', array(
            'type' => 'fb_appid'
        ))->row()->value;
        $secret       = $this->db->get_where('general_settings', array(
            'type' => 'fb_secret'
        ))->row()->value;
        $config       = array(
            'appId' => $appid,
            'secret' => $secret
        );
        $this->load->library('Facebook', $config);
        
        if ($fb_login_set == 'ok') {
            // Try to get the user's id on Facebook
            $userId = $this->facebook->getUser();
            
            // If user is not yet authenticated, the id will be zero
            if ($userId == 0) {
                // Generate a login url
                //$page_data['url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 
                $page_data['url'] = $this->facebook->getLoginUrl(array(
                    'redirect_uri' => site_url('home/login_set/back/' . $para2),
                    'scope' => array(
                        "email"
                    ) // permissions here
                ));
                //redirect($data['url']);
            } else {
                // Get user's data and print it
                $page_data['user'] = $this->facebook->api('/me');
                $page_data['url']  = site_url('home/login_set/back/' . $para2); // Logs off application
                //print_r($user);
            }
            if ($para1 == 'back') {
                $user = $this->facebook->api('/me');
                if ($user_id = $this->crud_model->exists_in_table('user', 'fb_id', $user['id'])) {
                    
                } else {
                    $data['username']      = $user['name'];
                    $data['email']         = $user['email'];
                    $data['fb_id']         = $user['id'];
                    $data['wishlist']      = '[]';
                    $data['creation_date'] = time();
                    $data['password']      = substr(hash('sha512', rand()), 0, 12);
                    
                    $this->db->insert('user', $data);
                    $user_id = $this->db->insert_id();
                }
                $this->session->set_userdata('user_login', 'yes');
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('user_name', $this->db->get_where('user', array(
                    'user_id' => $user_id
                ))->row()->username);
                $this->session->set_flashdata('alert', 'successful_signin');
                
                $this->db->where('user_id', $user_id);
                $this->db->update('user', array(
                    'last_login' => time()
                ));
                
                if ($para2 == 'cart') {
                    redirect(base_url() . 'index.php/home/cart_checkout', 'refresh');
                } else {
                    redirect(base_url() . 'index.php/home', 'refresh');
                }
            }
        }
        
        
        if ($g_login_set == 'ok') {
            $this->load->library('googleplus');
            if (isset($_GET['code'])) { //just_logged in
                $this->googleplus->client->authenticate();
                $_SESSION['token'] = $this->googleplus->client->getAccessToken();
                $g_user            = $this->googleplus->people->get('me');
                if ($user_id = $this->crud_model->exists_in_table('user', 'g_id', $g_user['id'])) {
                    
                } else {
                    $data['username']      = $g_user['displayName'];
                    $data['email']         = 'required';
                    $data['wishlist']      = '[]';
                    $data['g_id']          = $g_user['id'];
                    $data['g_photo']       = $g_user['image']['url'];
                    $data['creation_date'] = time();
                    $data['password']      = substr(hash('sha512', rand()), 0, 12);
                    $this->db->insert('user', $data);
                    $user_id = $this->db->insert_id();
                }
                $this->session->set_userdata('user_login', 'yes');
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('user_name', $this->db->get_where('user', array(
                    'user_id' => $user_id
                ))->row()->username);
                $this->session->set_flashdata('alert', 'successful_signin');
                
                $this->db->where('user_id', $user_id);
                $this->db->update('user', array(
                    'last_login' => time()
                ));
                
                if ($para2 == 'cart') {
                    redirect(base_url() . 'index.php/home/cart_checkout', 'refresh');
                } else {
                    redirect(base_url() . 'index.php/home', 'refresh');
                }
            }
            if (@$_SESSION['token']) {
                $this->googleplus->client->setAccessToken($_SESSION['token']);
            }
            if ($this->googleplus->client->getAccessToken()) //already_logged_in
                {
                $page_data['g_user'] = $this->googleplus->people->get('me');
                $page_data['g_url']  = $this->googleplus->client->createAuthUrl();
                $_SESSION['token']   = $this->googleplus->client->getAccessToken();
            } else {
                $page_data['g_url'] = $this->googleplus->client->createAuthUrl();
            }
        }
        
        if ($para1 == 'login') {
            $this->load->view('front/login', $page_data);
        } elseif ($para1 == 'registration') {
            $this->load->view('front/logup', $page_data);
        }
    }
    
    /* FUNCTION: Logout set */
    function logout()
    {
        $appid  = $this->db->get_where('general_settings', array(
            'type' => 'fb_appid'
        ))->row()->value;
        $secret = $this->db->get_where('general_settings', array(
            'type' => 'fb_secret'
        ))->row()->value;
        $config = array(
            'appId' => $appid,
            'secret' => $secret
        );
        $this->load->library('Facebook', $config);
        
        $this->facebook->destroySession();
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/home/logged_out', 'refresh');
    }
    
    /* FUNCTION: Logout */
    function logged_out()
    {
        $this->session->set_flashdata('alert', 'successful_signout');
        redirect(base_url() . 'index.php/home/', 'refresh');
    }
    
    /* FUNCTION: Check if Email user exists */
    function exists()
    {
        $email  = $this->input->post('email');
        $user   = $this->db->get('user')->result_array();
        $exists = 'no';
        foreach ($user as $row) {
            if ($row['email'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }
    
    /* FUNCTION: Newsletter Subscription */
    function subscribe()
    {
        $safe = 'yes';
        $char = '';
        foreach($_POST as $row){
            if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
            {
                $safe = 'no';
                $char = $match[0];
            }
        }

        $this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
            if($safe == 'yes'){
    			$subscribe_num = $this->session->userdata('subscriber');
    			$email         = $this->input->post('email');
    			$subscriber    = $this->db->get('subscribe')->result_array();
    			$exists        = 'no';
    			foreach ($subscriber as $row) {
    				if ($row['email'] == $email) {
    					$exists = 'yes';
    				}
    			}
    			if ($exists == 'yes') {
    				echo 'already';
    			} else if ($subscribe_num >= 3) {
    				echo 'already_session';
    			} else if ($exists == 'no') {
    				$subscribe_num = $subscribe_num + 1;
    				$this->session->set_userdata('subscriber', $subscribe_num);
    				$data['email'] = $email;
    				$this->db->insert('subscribe', $data);
    				echo 'done';
    			}
            } else {
                echo 'Disallowed charecter : " '.$char.' " in the POST';
            }
		}
    }
    
    /* FUNCTION: Customer Registration*/
    function registration($para1 = "", $para2 = "")
    {
        $safe = 'yes';
        $char = '';
        foreach($_POST as $k=>$row){
            if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row,$match))
            {
                if($k !== 'password1' && $k !== 'password2')
                {
                    $safe = 'no';
                    $char = $match[0];
                }
            }
        }

        $this->load->library('form_validation');
        $page_data['page_name'] = "registration";
        if ($para1 == "add_info") {
			$this->form_validation->set_rules('username', 'Your First Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email]',array('required' => 'You have not provided %s.', 'is_unique' => 'This %s already exists.'));
            $this->form_validation->set_rules('password1', 'Password', 'required');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('address1', 'Address Line 1', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required');
            $this->form_validation->set_rules('surname', 'Your Last Name', 'required');
            $this->form_validation->set_rules('zip', 'ZIP', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');

            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                if($safe == 'yes'){
    				$data['username']      = $this->input->post('username');
    				$data['email']         = $this->input->post('email');
    				$data['address1']      = $this->input->post('address1');
    				$data['address2']      = $this->input->post('address2');
    				$data['phone']         = $this->input->post('phone');
					$data['gender']        = $this->input->post('gender');
    				$data['surname']       = $this->input->post('surname');
					$data['display_name']  = $this->input->post('display_name');
    				$data['zip']           = $this->input->post('zip');
    				$data['city']          = $this->input->post('city');
					if($this->input->post('state') !='' && $this->input->post('country') == '230')
						$data['state']          = $this->input->post('state');
					else
						$data['state']          = 0;
					$data['country']          = $this->input->post('country');
    				$data['langlat']       = '';
    				$data['wishlist']      = '[]';
    				$data['create_timestamp'] = time();
					$data['member_timestamp'] = time();
    				
    				if ($this->input->post('password1') == $this->input->post('password2')) {
    					$password         = $this->input->post('password1');
    					$data['password'] = sha1($password);
    					$this->db->insert('user', $data);
    					$this->email_model->account_opening('user', $data['email'], $password);
    					echo 'done';
    				}
                } else {
                    echo 'Disallowed charecter : " '.$char.' " in the POST';
                }
			}
        }
        else if ($para1 == "update_info") {
            $id                  = $this->session->userdata('user_id');
            $data['username']    = $this->input->post('username');
            $data['surname']     = $this->input->post('surname');
            $data['address1']    = $this->input->post('address1');
            $data['address2']    = $this->input->post('address2');
			$data['gender']        = $this->input->post('gender');
            $data['phone']       = $this->input->post('phone');
            $data['city']        = $this->input->post('city');
			if($this->input->post('state') !='' && $this->input->post('country') == '230')
				$data['state']   = $this->input->post('state');
			else
				$data['state']   = 0;
			$data['country']     = $this->input->post('country');
            $data['skype']       = $this->input->post('skype');
            $data['google_plus'] = $this->input->post('google_plus');
            $data['facebook']    = $this->input->post('facebook');
            $data['zip']         = $this->input->post('zip');
            
            $this->crud_model->file_up('image', 'user', $id);
            
            $this->db->where('user_id', $id);
            $this->db->update('user', $data);
            redirect(base_url() . 'index.php/home/profile/', 'refresh');
        }
        else if ($para1 == "update_password") {
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('user', array(
                'user_id' => $this->session->userdata('user_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('user_id', $this->session->userdata('user_id'));
                        $this->db->update('user', $data);
                        redirect(base_url() . 'index.php/home/profile/', 'refresh');
                    }
                } else {
                    echo 'pass_prb';
                }
            }
            redirect(base_url() . 'index.php/home/', 'refresh');
        } else {
            $this->load->view('front/registration', $page_data);
        }
    }
    
    function error()
    {
        $this->load->view('front/error');
    }
    
    
    /* FUNCTION: Product rating*/
    function rating($product_id, $rating)
    {
        if ($this->session->userdata('user_login') != "yes") {
            redirect(base_url() . 'index.php/home/login/', 'refresh');
        }
        if ($rating <= 5) {
            if ($this->crud_model->set_rating($product_id, $rating) == 'yes') {
                echo 'success';
            } else if ($this->crud_model->set_rating($product_id, $rating) == 'no') {
                echo 'already';
            }
        } else {
            echo 'failure';
        }
    }
    
    
    
    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
		
        if ($this->paypal->validate_ipn() == true) {
            
            $data['payment_details']   = json_encode($_POST);
            $data['payment_timestamp'] = strtotime(date("m/d/Y"));
            $data['payment_type']      = 'paypal';
            $sale_id                   = $_POST['custom'];
            $vendors = $this->crud_model->vendors_in_sale($sale_id);
            $payment_status = array();
            foreach ($vendors as $p) {
                $payment_status[] = array('vendor'=>$p,'status'=>'paid');
            }
            if($this->crud_model->is_admin_in_sale($sale_id)){
                $payment_status[] = array('admin'=>'','status'=>'paid');
            }
            $data['payment_status'] = json_encode($payment_status);
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sale', $data);
        }
    }
    
    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $sale_id = $this->session->userdata('sale_id');
        $this->db->where('sale_id', $sale_id);
        $this->db->delete('sale');
        $this->session->set_userdata('sale_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/home/profile/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $carted  =$this->session->userdata('carted');
        $sale_id = $this->session->userdata('sale_id');
		
		    $data['payment_details']   = json_encode($_POST);
            $data['payment_timestamp'] = strtotime(date("m/d/Y"));
            $data['payment_type']      = 'paypal';
            $sale_id                   = $_POST['custom'];
            $vendors = $this->crud_model->vendors_in_sale($sale_id);
			$datareqpay = array();
			
			$addvendorpay= array();
            $payment_status = array();
            foreach ($vendors as $p) {
				 foreach ($carted as $value) {
						$addvendorpay['vendor_id'] = $p;	
						$addvendorpay['sale_id'] = $sale_id;	
						$addvendorpay['product_id'] = $value['id'];	
						$addvendorpay['amount'] = $value['sale_price'];	
						$addvendorpay['create_date'] = time();	
						$this->db->insert('vendor_payment', $addvendorpay);	
					$prodctdata['status'] = 'sold_out';
					$this->db->where('product_id', $value['id']);
					$this->db->update('product', $prodctdata);
				 }		
                $payment_status[] = array('vendor'=>$p,'status'=>'paid');
            }
			
				$datareqpay['sale_id'] = $sale_id;
				$datareqpay['create_date'] = time();
				$datareqpay['product_type'] = 'Market';
				
				foreach($carted as $value){
					$datareqpay['user_id'] = $value['user_id'];
					$datareqpay['user_name'] = $value['user_name'];
					$datareqpay['user_paypal_email'] = $value['email'];
					$datareqpay['advance_payment'] = $value['price'];
					$datareqpay['total_payment'] = $value['total_price'];
					$datareqpay['remaining_payment'] = $value['total_price']-$value['price'];
					
				}
			$this->db->insert('user_payment_request', $datareqpay);
			
            if($this->crud_model->is_admin_in_sale($sale_id)){
                $payment_status[] = array('admin'=>'','status'=>'paid');
            }
            $data['payment_status'] = json_encode($payment_status);
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sale', $data);
		
        $this->cart->destroy();
        $this->session->set_userdata('couponer','');
        $this->crud_model->email_invoice($sale_id);
        $this->session->set_userdata('sale_id', '');
        redirect(base_url() . 'index.php/home/invoice/' . $sale_id, 'refresh');
    }
    
    /*---------------------------for vendor ---------------------------------------------- */
	
	    /* FUNCTION: Verify paypal payment by IPN*/
    function vendor_paypal_ipn()
    {

        if ($this->paypal->validate_ipn() == true) {
            
            $data['payment_details']   = json_encode($_POST);
            $data['payment_timestamp'] = strtotime(date("m/d/Y"));
            $data['payment_type']      = 'paypal';
            $vendor_id                   = $_POST['custom'];
            $data['status'] = 'approved';
			$data['approve_timestamp'] = time();
			 
            $this->db->where('vendor_id', $vendor_id);
            $this->db->update('vendor', $data);
        }
    }
    
    /* FUNCTION: Loads after cancelling paypal*/
    function vendor_paypal_cancel()
    {
        /* $sale_id = $this->session->userdata('sale_id');
        $this->db->where('sale_id', $sale_id);
        $this->db->delete('sale');
        $this->session->set_userdata('sale_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel'); */
        redirect(base_url() . 'index.php/home', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function vendor_paypal_success()
    {
		$vendorinfo = $this->session->userdata('vendorinfo');
		$postdata = $vendorinfo['venderdata'];
		$vendor_id = $vendorinfo['venderid'];
		
		
		$membership_id = $postdata['plan'];
		$membership_plan = $this->db->get_where('membership', array(
				'membership_id' => $membership_id
		))->row();
		$numdays = "+".$membership_plan->timespan." days";
		$data['status'] = 'approved'; 
		$data['approve_timestamp']    = time();
		$data['member_timestamp']    = time();
		$data['membership']    = $membership_id;
        $data['member_expire_timestamp']    = strtotime(time())+strtotime($numdays);
		$this->db->where('vendor_id', $vendor_id);
            $this->db->update('vendor', $data);
            $this->email_model->status_email('vendor', $vendor_id);
		if($this->input->post('custom') != ''){
			$dataMS['status']         = 'paid';
            $dataMS['details']        = json_encode($_POST);
            $invoice_id             = $this->input->post('custom');
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $dataMS);
		}
        $this->session->unset_userdata('vendorinfo');	
        redirect(base_url() . 'index.php/home', 'refresh');
    }
	
	
	
	
	
	
    /* FUNCTION: Concerning wishlist*/
    function wishlist($para1 = "", $para2 = "")
    {
        if ($para1 == 'add') {
            $this->crud_model->add_wish($para2);
        } else if ($para1 == 'remove') {
            $this->crud_model->remove_wish($para2);
        } else if ($para1 == 'num') {
            echo $this->crud_model->wished_num();
        }
        
    }
    
    /* FUNCTION: Concerning wishlist*/
    function chat($para1 = "", $para2 = "")
    {
        
    }
    
    /* FUNCTION: Check if Customer is logged in*/
    function check_login($para1 = "")
    {
        if ($para1 == 'state') {
			
            if ($this->session->userdata('user_login') == 'yes') {
                echo 'hypass';
            }
            if ($this->session->userdata('user_login') !== 'yes') {
                echo 'nypose';
            }
        } else if ($para1 == 'id') {
            echo $this->session->userdata('user_id');
        } else {
            echo $this->crud_model->get_type_name_by_id('user', $this->session->userdata('user_id'), $para1);
        }
    }
    
    /* FUNCTION: Invoice showing*/
    function invoice($para1 = "", $para2 = "")
    {
        if ($this->session->userdata('user_login') != "yes"
             || $this->crud_model->get_type_name_by_id('sale', $para1, 'buyer') !==  $this->session->userdata('user_id'))
        {
            redirect(base_url(), 'refresh');
        }

        $page_data['sale_id']    = $para1;
        $page_data['page_name']  = "invoice";
        $page_data['page_title'] = translate('invoice');
        if($para2 == 'email'){
            $this->load->view('front/invoice_email', $page_data);
        } else {
            $this->load->view('front/index', $page_data);
        }
    }
    
    /* FUNCTION: Legal pages load - terms & conditions / privacy policy*/
    function legal($type = "")
    {
        $page_data['type']       = $type;
        $page_data['page_name']  = "legal";
        $page_data['page_title'] = translate($type);
        $this->load->view('front/index', $page_data);
    }
    
    /* FUNCTION: Price Range Load by AJAX*/
    function get_ranger($by = "", $id = "", $start = '', $end = '')
    {
        $min = $this->get_range_lvl($by, $id, "min");
        $max = $this->get_range_lvl($by, $id, "max");
        if ($start == '') {
            $start = $min;
        }
        if ($end == '') {
            $end = $max;
        }
        
        $return = '' . '<input type="text" id="rangelvl" value="" name="range" />' . '<script>' . '	$("#rangelvl").ionRangeSlider({' . '		hide_min_max: false,' . '		keyboard: true,' . '		min:' . $min . ',' . '		max:' . $max . ',' . '		from:' . $start . ',' . '		to:' . $end . ',' . '		type: "double",' . '		step: 1,' . '		prefix: "'.currency().'",' . '		grid: true,' . '		onFinish: function (data) {' . "			filter('click','none','none','0');" . '		}' . '	});' . '</script>';
        return $return;
    }
    
    /* FUNCTION: Price Range Load by AJAX*/
    function get_range_lvl($by = "", $id = "", $type = "")
    {
        if ($type == "min") {
            $set = 'asc';
        } elseif ($type == "max") {
            $set = 'desc';
        }
        $this->db->limit(1);
        $this->db->order_by('sale_price', $set);
        if (count($a = $this->db->get_where('product', array(
            $by => $id
        ))->result_array()) > 0) {
            foreach ($a as $r) {
                return $r['sale_price'];
            }
        } else {
            return 0;
        }
    }
    
    /* FUNCTION: AJAX loadable scripts*/
    function others($para1 = "", $para2 = "", $para3 = "", $para4 = "")
    {
        if ($para1 == "get_sub_by_cat") {
            $return = '';
            $subs   = $this->db->get_where('sub_category', array(
                'category' => $para2
            ))->result_array();
            foreach ($subs as $row) {
                $return .= '<option value="' . $row['sub_category_id'] . '">' . ucfirst($row['sub_category_name']) . '</option>' . "\n\r";
            }
            echo $return;
        } else if ($para1 == "get_range_by_cat") {
            if ($para2 == 0) {
                echo $this->get_ranger("product_id !=", "", $para3, $para4);
            } else {
                echo $this->get_ranger("category", $para2, $para3, $para4);
            }
        } else if ($para1 == "get_range_by_sub") {
            echo $this->get_ranger("sub_category", $para2);
        }
    }

    //SITEMAP
    function sitemap(){
        $otherurls = array(
                        base_url().'index.php/home/contact/',
                        base_url().'index.php/home/legal/terms_conditions',
                        base_url().'index.php/home/legal/privacy_policy'
                    );
        $producturls = array();
        $products = $this->db->get_where('product',array('status'=>'ok'))->result_array();
        foreach ($products as $row) {
            $producturls[] = $this->crud_model->product_link($row['product_id']);
        }
        $vendorurls = array();
        $vendors = $this->db->get_where('vendor',array('status'=>'approved'))->result_array();
        foreach ($vendors as $row) {
            $vendorurls[] = $this->crud_model->vendor_link($row['vendor_id']);
        }
        $page_data['otherurls']  = $otherurls;
        $page_data['producturls']  = $producturls;
        $page_data['vendorurls']  = $vendorurls;
        $this->load->view('front/sitemap', $page_data);
    }
    
    // adding the function for the getting the breed of the horses based on clicked id start here //

function getAllHorse(){
	$cat_id1 ='cat_id'; $cat_id2 = $this->input->post('cat_id');
if($cat_id1 == 'cat_id' && $cat_id2 != ''){
if(!empty($para) && $para >=2){ $limit1=(($para-1)*4)+1;$limit = "LIMIT ".$limit1.",4";}else{$limit = "LIMIT 0,4";}
$query = "SELECT * FROM `product` WHERE `category` =".$cat_id2." ".$limit;
$horse_res_arr = $this->db->query($query);
if ($horse_res_arr->num_rows() > 0){?>
<?php $counter = 1;?>
<?php foreach ($horse_res_arr->result_array() as $product) {
if($counter % 2 != 0){ 
if($counter > 2){$count = $counter-1;}else{$count = $counter;}
?>    
<div class="col-md-12 col-sm-12 col-xs-12 md-space" id="pro_row<?php echo $count;?>">
<?php } ?>
<div class="col-md-6 col-sm-6 col-xs-12 product-list01">
<ul class="photo-grid">
<li id="horse-name<?php echo $counter;?>">
<a href="javascript:void(0);">
<figure>
<?php if(file_exists("uploads/product_image/product_".$product['product_id']."_1.jpg")){ ?>
<img  src="/uploads/product_image/product_<?php echo $product['product_id']; ?>_1.jpg" alt="" class="img-responsive" />
<?php }else { ?>
<img src="/uploads/image-not-found.png" alt="Not image found" />
<?php } ?>
<figcaption>
<div class="onhover-text">
<span class="h-name01"><?php echo $product['title']; ?></span>
<p class="h-age01">AGE - <?php echo $product['age']; ?></p>
<?php echo $product['description']; ?>
<div class="see-card">
    See Card
</div>
</div>
</figcaption>
</figure>
</a>
</li>   
</ul>
<div class="horse-name">
<?php echo $product['title']; ?>
<span class="location"><?php echo $product['country']; ?></span>
</div>
</div>
<?php if($counter % 2 == 0){ ?>
</div>     
<?php } ?>
<?php $counter++;
}
}else{?>
<div class="col-md-12 col-sm-12 col-xs-12 md-space" id="pro_row1">
<div class="col-md-6 col-sm-6 col-xs-12 product-list01">
<ul class="photo-grid">
<li id="horse-name">No Records Founds</li></ul></div>
</div>
<?php }      
}
}
/*------------single product details*/

function singleproduct($para)
{
	if($para!= '')
	{
		$product = $this->db->get_where('product',array('product_id'=>$para))->row();
		$count = count($product);
		if($count>0)
		{
			?>
			<div class="col-md-12 col-sm-12 col-xs-12 md-space" >

			<div class="col-md-6 col-sm-6 col-xs-12 product-list01">
			<ul class="photo-grid">
			<li >
			<a href="javascript:void(0);">
			<figure>
			<?php if(file_exists("uploads/product_image/product_".$product->product_id."_1.jpg")){ ?>
			<img  src="/uploads/product_image/product_<?php echo $product->product_id; ?>_1.jpg" alt="" class="img-responsive" />
			<?php }else { ?>
			<img src="/uploads/image-not-found.png" alt="Not image found" />
			<?php } ?>
			<!--<figcaption>
			<div class="onhover-text">
			<span class="h-name01"><?php echo $product->title; ?></span>
			<p class="h-age01">AGE - <?php echo $product->age; ?></p>
			<?php echo $product->description; ?>
			<div class="see-card">
				See Card
			</div>
			</div>
			</figcaption> -->
			</figure>
			</a>
			</li>   
			</ul>
			<ul>
			<li>Name :&nbsp; <?php echo $product->title; ?></li>
			<li>horse Code :&nbsp; <?php echo $product->horse_code; ?></li>
			<li>Age :&nbsp; <?php echo $product->age; ?></li>
			<li>Height :&nbsp;<?php echo $product->height; ?></li>
			<li>width :&nbsp;<?php echo $product->weight; ?> </li>
			<li>Price :&nbsp; <?php echo $product->sale_price; ?></li>
			<li>Size :&nbsp; <?php echo $product->size; ?></li>
			<li>Address :&nbsp; <?php echo $product->address; ?></li>
			<li>City :&nbsp; <?php echo $product->city; ?></li>
			<li>State :&nbsp; <?php echo $product->state; ?></li>
			<li>Country :&nbsp; <?php echo $product->country; ?></li>
			<li>Zip :&nbsp; <?php echo $product->country; ?></li>
			</ul>
			<div class="horse-name">
			<?php echo $product->title; ?>
			<span class="location"><?php echo $product->country; ?></span>
			</div>
			</div>

			</div>  
			<?php 
		}
		else
		{
			?>
			<div class="col-md-12 col-sm-12 col-xs-12 md-space" id="pro_row1">
			<div class="col-md-6 col-sm-6 col-xs-12 product-list01">
			<ul class="photo-grid">
			<li id="horse-name">No Records Founds</li></ul></div>
			</div>
			<?php
		}
		
		
	}
}
/*customer payment*/
function customerpay($para)
{
	if($para != '')
	{
		$result = $this->crud_model->getsiglefield('user_payment_mail','token_code',$para);
		$page_data['info_msg'] ='';
		
		if(count($result)>0)
		{
			
		  if($result->status =='Approved')
		  {
			  $page_data['info_msg'] ="You have already payed.";
		  }
		  else{
			  $page_data['result'] =$result;
			$this->session->set_userdata('rem_payment',$result);
		  }
			
		}
		else{
			$page_data['info_msg'] ="Code does't match!";
		}
		$page_data['page_name']     = "remaining_paymnet"; 
		$page_data['page_title']    = translate('remaining_paymnet');
		$this->load->view('front/index', $page_data);	
	}
	else{
			redirect('/');
	}
}
	function remaining_amount()
	{
      $amountinfo = $this->session->userdata('rem_payment');
	  
	  if(count($amountinfo)>0)
	  {
		$vat = 0;
		$paypal_email = $this->crud_model->get_type_name_by_id('business_settings', '1', 'value');
			/****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_cart');
                    $this->paypal->add_field('upload', '1');
                    $i = 1;
                   /* $this->paypal->add_field('item_number_' . $i, $i);*/
                    $this->paypal->add_field('item_name_' . $i, 'remaining Payment');
                    $this->paypal->add_field('amount_' . $i, $this->cart->format_number($amountinfo->amount));
                    
                    $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($vat)));
                    /*$this->paypal->add_field('quantity_' . $i, 1); */
                    
                   if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
                    $this->paypal->add_field('shipping_' . $i, $this->cart->format_number(0));
                    }
                    $this->paypal->add_field('tax_' . $i, $this->cart->format_number(($vat)));
                    /*$this->paypal->add_field('quantity_' . $i, 1);*/
                    
                    if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'fixed') {
                        $this->paypal->add_field('shipping_1', $this->cart->format_number(($this->crud_model->get_type_name_by_id('business_settings', '2', 'value') / $exchange)));
                    }
				   
                    $this->paypal->add_field('custom', $amountinfo->user_payment_req_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/home/remaining_amount_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/home/remaining_amount_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/home/remaining_amount_success');
                    
                    //$this->paypal->submit_paypal_post();
                     $this->paypal->submit_paypal_post();
					 $page_data['page_name']     = "loadimage";
					 $page_data['page_title']    = translate('redirecting_to_paypal');
					 $this->load->view('front/index', $page_data);		
                    //redirect(base_url());
	  }else{
		redirect(base_url());  
	  }
		
	}
	function remaining_amount_ipn()
	{
		redirect('/');
	}
	function remaining_amount_cancel()
	{
		redirect('/');
	}
	function remaining_amount_success()
	{
		$amountinfo = $this->session->userdata('rem_payment');
		$dataPAM['status'] = 'Approved';
		$id = $amountinfo->id;
		$this->db->where('id', $id);
        $this->db->update('user_payment_mail', $dataPAM);
		
		$dataPA['request_payment_status'] = 'Approved';
		$pay_req_id = $amountinfo->user_payment_req_id;
		$this->db->where('id', $pay_req_id);
        $this->db->update('user_payment_request', $dataPA);
		$page_data['page_name']     = "remaining_paymnet_thanks"; 
		$page_data['page_title']    = translate('remaining_paymnet_thanks');
		$this->load->view('front/index', $page_data);
	}
// adding the function for the getting the breed of the horses ends here //
    function vendor_list()
    {

        $page_data['vendorlist'] = $this->db->get_where('vendor', array('status'=>'approved'))->result_array();
		$page_data['page_name']     = "vendor_list";
		$page_data['page_title']    = translate('vendors');
		$this->load->view('front/index', $page_data);
        
    }
	function vendor_detail($parm='')
    {
		if($parm!='')
		{
			$page_data['vendor'] = array();
			$page_data['vendor'] = $this->db->get_where('vendor', array('vendor_id'=>$parm))->row_array();
			if(!empty($page_data['vendor'])){
				$page_data['vendor']['country_name'] = $this->db->get_where('country', array('country_id'=>$page_data['vendor']['country']))->row()->country_name;
				$page_data['vendor']['state_name'] = '';
				if($page_data['vendor']['country'] == 230 && $page_data['vendor']['state'] > 0){
					$page_data['vendor']['state_name'] = $this->db->get_where('states', array('id'=>$page_data['vendor']['state'],'country_id'=>$page_data['vendor']['country']))->row()->name;
				}
				$added_by = '{"type":"vendor","id":"'.$parm.'"}';
				$page_data['sell_products'] = $this->db->get_where('product', array('added_by'=>$added_by, 'status'=>'sell'))->result_array();
				$page_data['breed_products'] = $this->db->get_where('product', array('added_by'=>$added_by, 'status'=>'breeding'))->result_array();
				$page_data['user_login'] = $this->session->userdata('user_login');
				$page_data['user_id'] = $this->session->userdata('user_id');
				$page_data['page_name']     = "vendor_detail";
				$page_data['page_title']    = translate('vendor');
				$this->load->view('front/index', $page_data);
			}else{
				$this->load->view('front/error');
			}
		}else{
			$page_data['page_name']     = "vendor_list";
			$page_data['page_title']    = translate('vendors');
			$this->load->view('front/index', $page_data);
		}
    }
	function terms_conditions($parm="")
	{
		if($parm == 'member'){
			$page_data['page_title']    = translate('member_terms_and_conditions');
			$page_data['terms_conditions'] =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_member'))->row()->value;
		}else if($parm == 'breeding'){
			$page_data['page_title']    = translate('breeding_terms_and_conditions');
			$page_data['terms_conditions'] =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_breeding'))->row()->value;
		}else if($parm == 'dna'){
			$page_data['page_title']    = translate('dna_terms_and_conditions');
			$page_data['terms_conditions'] =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_dna'))->row()->value;
		}else{
			$page_data['page_title']    = translate('market_terms_and_conditions');		
			$page_data['terms_conditions'] =  $this->db->get_where('general_settings',array('type' => 'terms_conditions'))->row()->value;			
		}
		$page_data['page_name']     = "term-condition";
		$this->load->view('front/index', $page_data);		
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
