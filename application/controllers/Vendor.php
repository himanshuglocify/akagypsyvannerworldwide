<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Vendor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('language');
		$this->load->helper('url');
		$this->load->helper('form');
        $this->load->database();
		$this->load->library('paypal');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
		$this->load->model('crud_model');
        $this->load->model('Email_model');
		$this->crud_model->ip_data(); 
		$vendor_system	 =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
		if($vendor_system !== 'ok'){
			redirect(base_url(), 'refresh');
		}
    }
    
    /* index of the vendor. Default: Dashboard; On No Login Session: Back to login page. */
    public function index()
    {
        if ($this->session->userdata('vendor_login') == 'yes') {
            $page_data['page_name'] = "dashboard";
            $this->load->view('back/index', $page_data);
        } else {
            $page_data['control'] = "vendor";
            $this->load->view('back/login',$page_data);
        }
    }
    
    /* Login into vendor panel */
    function login($para1 = '')
    {
        if ($para1 == 'forget_form') {
            $page_data['control'] = 'vendor';
            $this->load->view('back/forget_password',$page_data);
        } else if ($para1 == 'forget') {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');         
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $query = $this->db->get_where('vendor', array(
                    'email' => $this->input->post('email')
                ));
                if ($query->num_rows() > 0) {
                    $vendor_id         = $query->row()->vendor_id;
                    $password         = substr(hash('sha512', rand()), 0, 12);
                    $data['password'] = sha1($password);
                    $this->db->where('vendor_id', $vendor_id);
                    $this->db->update('vendor', $data);
                    if ($this->email_model->password_reset_email('vendor', $vendor_id, $password)) {
                        echo 'email_sent';
                    } else {
                        echo 'email_not_sent';
                    }
                } else {
                    echo 'email_nay';
                }
            }
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $login_data = $this->db->get_where('vendor', array(
                    'email' => $this->input->post('email'),
                    'password' => sha1($this->input->post('password'))
                ));
                if ($login_data->num_rows() > 0) {
                    if($login_data->row()->status == 'approved'){
                        foreach ($login_data->result_array() as $row) {
                            $this->session->set_userdata('login', 'yes');
                            $this->session->set_userdata('vendor_login', 'yes');
                            $this->session->set_userdata('vendor_id', $row['vendor_id']);
                            $this->session->set_userdata('vendor_name', $row['display_name']);
                            $this->session->set_userdata('title', 'vendor');
                            echo 'lets_login';
                        }
                    } else {
                        echo 'unapproved';
                    }
                } else {
                    echo 'login_failed';
                }
            }
        }
    }
    
    
    /* Loging out from vendor panel */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/vendor', 'refresh');
    }
    
   
   
    /* Product add, edit, view, delete, stock increase, decrease, discount */
    function product($para1 = '', $para2 = '', $para3 = '')
    {
		if($this->session->userdata('vendor_login')){
			$paypal_email = $this->db->get_where('vendor', array('vendor_id' => $this->session->userdata('vendor_id')))->row()->paypal_email;
			if($paypal_email == '' || $paypal_email == 'NULL'){
				redirect(base_url() . 'index.php/vendor/business_settings?msg=1');				
			}
		}
        if (!$this->crud_model->vendor_permission('product')) {
            redirect(base_url() . 'index.php/vendor');
        }
		 $page_data['countries'] = $this->db->get('country')->result_array();
		$page_data['states'] = $this->db->get('states')->result_array();
        if ($para1 == 'do_add') {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['add_timestamp']      = time();
            $data['featured']           = '0';
            $data['status']             = 'not_listed';
            $data['tag']                = $this->input->post('tag');
            $data['color']              = $this->input->post('color');
            $data['num_of_imgs']        = $num_of_imgs;
            $data['front_image']        = $this->input->post('front_image');
            $data['gender']             = $this->input->post('gender');
			$data['country_of_birth']	= $this->input->post('country_of_birth');
			$data['date_of_birth']		= $this->input->post('date_of_birth');
			$data['temperament']		= $this->input->post('temperament');
			$data['training']			= $this->input->post('training');
			$data['breeding_history']	= $this->input->post('breeding_history');
			$data['notes']				= $this->input->post('notes');
			$data['sire']				= $this->input->post('sire');
			$data['dam']				= $this->input->post('dam');
			$data['grand_sire']			= $this->input->post('grand_sire');
			$data['grand_dam']			= $this->input->post('grand_dam');
			$data['dna_reg_number']		= $this->input->post('dna_reg_number');
			$data['color_tested_result']= $this->input->post('color_tested_result');
			$data['passport_number']	= $this->input->post('passport_number');			
            $data['height']             = $this->input->post('height');
            $data['size']               = $this->input->post('size');
            $data['country']            = $this->input->post('country');
			if($this->input->post('state') !='' && $this->input->post('country') == '230')
				$data['state']          = $this->input->post('state');
			else
				$data['state']          = 0;
            $data['city']               = $this->input->post('city');
            $data['address']            = $this->input->post('address');
            $data['address1']           = $this->input->post('address1');
            $data['zipcode']            = $this->input->post('zipcode');			
            $data['current_stock']      = $this->input->post('current_stock');
            $data['front_image']        = $this->input->post('front_image');
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            $data['added_by']           = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))){
                $this->db->insert('product', $data);
                $id = $this->db->insert_id();
				$datainsert['horse_code']         = 5000+$id;
				$this->db->where('product_id',$id);
                $this->db->update('product', $datainsert);
                $this->crud_model->file_up("images", "product", $id, 'multi');
            } else {
                echo 'already uploaded maximum product';
            }
        } else if ($para1 == "update") {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
           /* $data['sale_price']         = $this->input->post('sale_price');*/
            $data['tag']                = $this->input->post('tag');
            $data['color']              = $this->input->post('color');
            $data['num_of_imgs']        = $num + $num_of_imgs;
            $data['front_image']        = $this->input->post('front_image');
            $data['gender']             = $this->input->post('gender');
			$data['country_of_birth']	= $this->input->post('country_of_birth');
			$data['date_of_birth']		= $this->input->post('date_of_birth');
			$data['temperament']		= $this->input->post('temperament');
			$data['training']			= $this->input->post('training');
			$data['breeding_history']	= $this->input->post('breeding_history');
			$data['notes']				= $this->input->post('notes');
			$data['sire']				= $this->input->post('sire');
			$data['dam']				= $this->input->post('dam');
			$data['grand_sire']			= $this->input->post('grand_sire');
			$data['grand_dam']			= $this->input->post('grand_dam');
			$data['dna_reg_number']		= $this->input->post('dna_reg_number');
			$data['color_tested_result']= $this->input->post('color_tested_result');
			$data['passport_number']	= $this->input->post('passport_number');			
            $data['height']             = $this->input->post('height');
            $data['size']               = $this->input->post('size');
            $data['country']            = $this->input->post('country');
			if($this->input->post('state') !='' && $this->input->post('country') == '230')
				$data['state']          = $this->input->post('state');
			else
				$data['state']          = 0;
            $data['city']               = $this->input->post('city');
            $data['address']            = $this->input->post('address');
            $data['address1']           = $this->input->post('address1');
            $data['zipcode']            = $this->input->post('zipcode');			
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);

            $this->crud_model->file_up("images", "product", $para2, 'multi');
            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
        } else if ($para1 == 'edit') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_edit', $page_data);
        } else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_view', $page_data);
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
        } elseif ($para1 == 'list') {
            $this->db->order_by('product_id', 'desc');
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/vendor/product_list', $page_data);
        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
        } elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        } elseif ($para1 == 'add') {
            if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))){
				$page_data['user_data'] = $this->db->get_where('vendor',array('vendor_id' => $this->session->userdata('vendor_id')))->row_array();
                $this->load->view('back/vendor/product_add', $page_data);
            } else {
                $this->load->view('back/vendor/product_limit');
            }
        } elseif ($para1 == 'stock_report') { //
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_report', $data);
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_sale_report', $data);
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $this->crud_model->set_product_publishability($this->session->userdata('vendor_id'),$product);
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        } elseif ($para1 == 'add_discount_set') {
            $product               = $this->input->post('product');
            $data['discount']      = $this->input->post('discount');
            $data['discount_type'] = $this->input->post('discount_type');
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        } else {
            $page_data['page_name']   = "product";
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
   
    /* Managing sales by users */
    function sales($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('sale')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == 'delete') {
            $carted = $this->db->get_where('stock', array(
                'sale_id' => $para2
            ))->result_array();
            foreach ($carted as $row2) {
                $this->stock('delete', $row2['stock_id']);
            }
            $this->db->where('sale_id', $para2);
            $this->db->delete('sale');
        } elseif ($para1 == 'list') {
            $all = $this->db->get_where('sale',array('payment_type' => 'go'))->result_array();
            foreach ($all as $row) {
                if((time()-$row['sale_datetime']) > 600){
                    $this->db->where('sale_id', $row['sale_id']);
                    $this->db->delete('sale');
                }
            }
            $this->db->order_by('sale_id', 'desc');
            $page_data['all_sales'] = $this->db->get('sale')->result_array();
            $this->load->view('back/vendor/sales_list', $page_data);
        } elseif ($para1 == 'view') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/sales_view', $page_data);
        } elseif ($para1 == 'send_invoice') {
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $text              = $this->load->view('back/includes_top', $page_data);
            $text .= $this->load->view('back/vendor/sales_view', $page_data);
            $text .= $this->load->view('back/includes_bottom', $page_data);
        } elseif ($para1 == 'delivery_payment') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale_id']         = $para2;
            $page_data['payment_type']    = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_type;
            $page_data['payment_details'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_details;
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            foreach ($delivery_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $page_data['delivery_status'] = $row['status'];
                    }
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            foreach ($payment_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $page_data['payment_status'] = $row['status'];
                    }
                }
            }
            
            $this->load->view('back/vendor/sales_delivery_payment', $page_data);
        } elseif ($para1 == 'delivery_payment_set') {
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            $new_delivery_status = array();
            foreach ($delivery_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$this->input->post('delivery_status'),'delivery_time'=>$row['delivery_time']);
                    } else {
                        $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status'],'delivery_time'=>$row['delivery_time']);
                    }
                }
                else if(isset($row['admin'])){
                    $new_delivery_status[] = array('admin'=>'','status'=>$row['status'],'delivery_time'=>$row['delivery_time']);
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            $new_payment_status = array();
            foreach ($payment_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$this->input->post('payment_status'));
                    } else {
                        $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status']);
                    }
                }
                else if(isset($row['admin'])){
                    $new_payment_status[] = array('admin'=>'','status'=>$row['status']);
                }
            }
            var_dump($new_payment_status);
            $data['payment_status']  = json_encode($new_payment_status);
            $data['delivery_status'] = json_encode($new_delivery_status);
            $data['payment_details'] = $this->input->post('payment_details');
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/sales_add');
        } elseif ($para1 == 'total') {
            $sales = $this->db->get('sale')->result_array();
			$i = 0;
			foreach($sales as $row){
				if($this->crud_model->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id'))){
					$i++;
				}
			}
			echo $i;
        } else {
            $page_data['page_name']      = "sales";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Checking Login Stat */
    function is_logged()
    {
        if ($this->session->userdata('vendor_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
   

    /* Manage Business Settings */
    function package($para1 = "", $para2 = "")
    {
        if ($para1 == 'upgrade') {
            $method         = $this->input->post('method');
            $type           = $this->input->post('membership');
            $vendor         = $this->session->userdata('vendor_id');
            if($type !== '0'){
                $amount         = $this->db->get_where('membership',array('membership_id'=>$type))->row()->price;
                $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
                if ($method == 'paypal') {

                    $paypal_email           = $this->db->get_where('business_settings',array('type'=>'paypal_email'))->row()->value;
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'paypal';
                    $data['membership']     = $type; 
                    $data['timestamp']      = time();

                    $this->db->insert('membership_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);
                    
                    /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_xclick');
                    
                    $this->paypal->add_field('amount', $this->cart->format_number($amount_in_usd));

                    //$this->paypal->add_field('amount', $grand_total);
                    $this->paypal->add_field('custom', $invoice_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/vendor/paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/vendor/paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/vendor/paypal_success');
                    
                    $this->paypal->submit_paypal_post();
					$page_data['page_name']     = "loadimage";
					$page_data['page_title']    = translate('redirecting_to_paypal');
					$this->load->view('front/index', $page_data);
                    // submit the fields to paypal

                } else {
                    echo 'putu';
                }
            } else {
                redirect(base_url() . 'index.php/vendor/package/', 'refresh');
            }
        } else {
            $page_data['page_name'] = "package";
			$membership_id = $this->db->get_where('vendor',array('vendor_id'=>$this->session->userdata('vendor_id')))->row()->membership;
			$page_data['current_plan'] = $this->db->get_where('membership',array('membership_id'=>$membership_id))->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
	function membership_details($para1 = "",$para2 = ""){
		if (!$this->crud_model->vendor_permission('business_settings')) {
            redirect(base_url() . 'index.php/vendor');
		}
			
		if ($para1 == "membership_info") {
            $return = '<div class="table-responsive"><table class="table table-striped">';
            if($para2 !== '0'){
                $results = $this->db->get_where('membership',array('membership_id'=>$para2))->result_array();
                foreach ($results as $row) {
                    $return .= '<tr>';
                    $return .= '<td>'.translate('title').'</td>';
                    $return .= '<td>'.$row['title'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('price').'</td>';
                    $return .= '<td>'.currency().$row['price'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('timespan').'</td>';
                    $return .= '<td>'.$row['timespan'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('maximum_product').'</td>';
					if($row['product_limit'] == '-1'){ $product_limit = "Unlimited"; }else{ $product_limit = $row['product_limit']; }
                    $return .= '<td>'.$product_limit.'</td>';
                    $return .= '</tr>';
                }
            } else if($para2 == '0'){
                $return .= '<tr>';
                $return .= '<td>'.translate('title').'</td>';
                $return .= '<td>'.translate('default').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('price').'</td>';
                $return .= '<td>'.translate('free').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('timespan').'</td>';
                $return .= '<td>'.translate('lifetime').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('maximum_product').'</td>';
                $return .= '<td>'.$this->db->get_where('general_settings',array('type'=>'default_member_product_limit'))->row()->value.'</td>';
                $return .= '</tr>';
            }
            $return .= '</table></div>';
            echo $return;
        }
	}
 
    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {
            
            $data['status']         = 'paid';
            $data['details']        = json_encode($_POST);
            $invoice_id             = $_POST['custom'];
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data);
            $type = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->membership;
            $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->vendor;
            $this->crud_model->upgrade_membership($vendor,$type);
        }
    }
    

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('membership_payment_id', $invoice_id);
        $this->db->delete('membership_payment');
        $this->session->set_userdata('invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/admin/package/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
		//echo "<pre>";
		//print_r($this->session->userdata());
		//print_r($this->input->post());
		//die('h');
		if($this->input->post('custom') != ''){
			$data['status']         = 'paid';
            $data['details']        = json_encode($_POST);
            $invoice_id             = $this->input->post('custom');
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data);
            $type = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->membership;
            $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->vendor;
            $this->crud_model->upgrade_membership($vendor,$type);		
		}
        $this->session->set_userdata('invoice_id', '');
        redirect(base_url() . 'index.php/vendor/package/', 'refresh');
    }
    

   /* Manage vendor Settings */
    function manage_vendor($para1 = "")
    {
        if ($this->session->userdata('vendor_login') != 'yes') {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == 'update_password') {
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('vendor', array(
                'vendor_id' => $this->session->userdata('vendor_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
                        $this->db->update('vendor', $data);
                        echo 'updated';
                    }
                } else {
                    echo 'pass_prb';
                }
            }
        } else if ($para1 == 'update_profile') {
			$this->crud_model->file_up("profile_image", "vendor", $this->session->userdata('vendor_id'), '');
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'username' => $this->input->post('username'),
                //'email' => $this->input->post('email'),
                'address1' => $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'company' => $this->input->post('company'),
                'display_name' => $this->input->post('display_name'),
				'gender'    => $this->input->post('gender'),
                'details' => $this->input->post('details'),
                'phone' => $this->input->post('phone'),
				'zip' =>  $this->input->post('zip')
            ));
        } else {
            $page_data['page_name'] = "manage_vendor";
            $this->load->view('back/index', $page_data);
        }
    }

    /* Manage General Settings */
    function general_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }

    }
    
    /* Manage Social Links */
    function social_links($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == "set") {

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'facebook' => $this->input->post('facebook')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'google_plus' => $this->input->post('google-plus')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'twitter' => $this->input->post('twitter')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'skype' => $this->input->post('skype')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'pinterest' => $this->input->post('pinterest')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'youtube' => $this->input->post('youtube')
            ));

            redirect(base_url() . 'index.php/vendor/site_settings/social_links/', 'refresh');
        }
    }

    /* Manage SEO relateds */
    function seo_settings($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }
        if ($para1 == "set") {
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'description' => $this->input->post('description')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'keywords' => $this->input->post('keywords')
            ));
        }
    }
    /* Manage Favicons */
    function vendor_images($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }
        move_uploaded_file($_FILES["logo"]['tmp_name'], 'uploads/vendor/logo_' . $this->session->userdata('vendor_id') . '.png');
        move_uploaded_file($_FILES["banner"]['tmp_name'], 'uploads/vendor/banner_' . $this->session->userdata('vendor_id') . '.jpg');
    }
	
   /* Horse Sell Request */
    function sell_request($para1 = "")
    {
        if ($this->session->userdata('vendor_login') != 'yes') {
            redirect(base_url() . 'index.php/vendor');
        }
		
        if ($para1 == 'do_add') {
			$data['horse_number'] = $this->input->post('horse_id');
			$horsedetails = $this->crud_model->getsiglefield('product','product_id',$this->input->post('horse_id'));
			$data['horse_code'] = $horsedetails->horse_code;
            $vendor_id = $data['vendor_id'] = $this->session->userdata('vendor_id');			
            $data['price'] = $this->input->post('price');
			if($this->db->get_where('vendor',array('vendor_id'=>$this->session->userdata('vendor_id')))->row()->membership==1){
				$data['request_for'] = $this->input->post('request_for');
			}else{
				$data['request_for'] ="sell";
			}
            $data['request_time'] = time();	
			$data['status'] = "Unapproved";
			$vendor_name = $this->session->userdata('vendor_name');
			$request = $data['request_for'];
            $this->db->insert('sell_request', $data); 
			/***** Email ******/
			$msg = "You have got a {$request} request from {$vendor_name}";
			$sub = "Horse Sell Request";
			$to  = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
			$from= $this->db->get_where('vendor', array('vendor_id' => $vendor_id))->row()->email;
			$this->Email_model->do_email($msg, $sub, $to, $from);			
        } elseif ($para1 == 'list') {
            $this->db->order_by('id', 'desc');
			$vendor_id = $data['vendor_id'] = $this->session->userdata('vendor_id');
            $page_data['all_sell_request'] = $this->db->get_where('sell_request', array('vendor_id' => $vendor_id))->result_array();
            $this->load->view('back/vendor/sell_request_list', $page_data);
        } elseif ($para1 == 'send') {
            $this->load->view('back/vendor/sell_request_send');
        } else {
            $page_data['page_name']      = "sell_request";
			$vendor_id = $data['vendor_id'] = $this->session->userdata('vendor_id');
            $page_data['all_sell_request'] = $this->db->get_where('sell_request', array('vendor_id' => $vendor_id))->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
	    /* Manage Business Settings */
    function business_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->vendor_permission('business_settings')) {
            redirect(base_url() . 'index.php/vendor');
        }

        if ($para1 == 'set') {
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'paypal_email' => $this->input->post('paypal_email')
            ));
			$page_data['page_name'] = "business_settings";
            $this->load->view('back/index', $page_data);
        } else {
            $page_data['page_name'] = "business_settings";
            $this->load->view('back/index', $page_data);
        }
    }
	function tutorial(){
		$page_data['page_name']      = "tutorial";
		$this->load->view('back/index', $page_data);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */