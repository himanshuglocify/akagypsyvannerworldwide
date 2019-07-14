    <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admin extends CI_Controller
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
       // $this->crud_model->ip_data();
        $this->load->model('crud_model');
         $this->load->model('Email_model');
        $this->crud_model->ip_data(); 
    }
    
    /* index of the admin. Default: Dashboard; On No Login Session: Back to login page. */
    public function index()
    {
        if ($this->session->userdata('admin_login') == 'yes') {
            $page_data['page_name'] = "dashboard";
            $this->load->view('back/index', $page_data);
        } else {
            $page_data['control'] = "admin";
            $this->load->view('back/login',$page_data);
        }
    }
    
    /*Product Breed add, edit, view, delete */
    function category($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('category')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['category_name'] = $this->input->post('category_name');
            $this->db->insert('category', $data);
        } else if ($para1 == 'edit') {
            $page_data['category_data'] = $this->db->get_where('category', array(
                'category_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/category_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['category_name'] = $this->input->post('category_name');
            $this->db->where('category_id', $para2);
            $this->db->update('category', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('category_id', $para2);
            $this->db->delete('category');
        } elseif ($para1 == 'list') {
            $this->db->order_by('category_id', 'desc');
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/admin/category_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/category_add');
        } else {
            $page_data['page_name']      = "category";
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    

    function product($para1 = '', $para2 = '', $para3 = '')
    {   
        if (!$this->crud_model->admin_permission('product')) {
            redirect(base_url() . 'index.php/admin');
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
			if($this->input->post('state') !='' && $this->input->post('country') == '230')
				$state          = $this->input->post('state');
			else
				$state          = 0;
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['sale_price']         = $this->input->post('sale_price');
			$data['commission']         = $this->input->post('commission');
            $data['add_timestamp']      = time();
            $data['featured']           = '0';
            $data['status']             = $this->input->post('status');
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
            $data['state']              = $state;
            $data['city']               = $this->input->post('city');
            $data['address']            = $this->input->post('address');
            $data['address1']           = $this->input->post('address1');
            $data['zipcode']            = $this->input->post('zipcode');
			$data['added_by']           = json_encode(array('type'=>'admin','id'=>$this->session->userdata('admin_id')));
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
          
            $this->db->insert('product', $data);
            $id = $this->db->insert_id();
            $datainsert['horse_code']         = 5000+$id;
            $this->db->where('product_id',$id);
            $this->db->update('product', $datainsert);
            $this->crud_model->file_up("images", "product", $id, 'multi');
        } else if ($para1 == "update") {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
			if($this->input->post('state') !='' && $this->input->post('country') == '230')
				$state          = $this->input->post('state');
			else
				$state          = 0;
			
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['sale_price']         = $this->input->post('sale_price');
			$data['commission']         = $this->input->post('commission');
            $data['add_timestamp']      = time();
            $data['featured']           = '0';
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
            $data['state']              = $state;
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
            $this->load->view('back/admin/product_edit', $page_data);
        } else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/product_view', $page_data);
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
        } elseif ($para1 == 'list') {
			
			$this->db->order_by('product_id', 'desc');
			if($para2)
			{
				$page_data['hcode'] = $para2;
				$page_data['all_product'] = $this->db->get_where('product', array('horse_code' => $para2))->result_array();
			}
			else{
				$page_data['all_product'] = $this->db->get('product')->result_array();
			}
            
            $this->load->view('back/admin/product_list', $page_data);
        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
/*        } elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, 'get_sub_res');
        } elseif ($para1 == 'brand_by_cat') {
            echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select', '', 'category', $para2, '');
*/        } elseif ($para1 == 'product_by_sub') {
            echo $this->crud_model->select_html('product', 'product', 'title', 'add', 'demo-chosen-select required', '', 'sub_category', $para2, 'get_pro_res');
        } elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/product_add', $page_data);
        } elseif ($para1 == 'add_stock') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_add', $data);
        } elseif ($para1 == 'destroy_stock') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_destroy', $data);
        } elseif ($para1 == 'stock_report') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_stock_report', $data);
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_sale_report', $data);
        } elseif ($para1 == 'add_discount') {
            $data['product'] = $para2;
            $this->load->view('back/admin/product_add_discount', $data);
        } elseif ($para1 == 'product_featured_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['featured'] = 'ok';
            } else {
                $data['featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
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
        } elseif ($para1 == 'change_status') {
            $data['status'] = $para2;
            $this->db->where('product_id', $para3);
            $this->db->update('product', $data); 
			
        } else {
			$page_data['horseid'] = $para1;
            $page_data['page_name']   = "product";
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Product Stock add, edit, view, delete, stock increase, decrease, discount */
    function stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('stock')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['type']         = 'add';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['rate']         = $this->input->post('rate');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity          = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $data1['current_stock'] = $prev_quantity + $data['quantity'];
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
        } else if ($para1 == 'do_destroy') {
            $data['type']         = 'destroy';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $current       = $prev_quantity - $data['quantity'];
            if ($current <= 0) {
                $current = 0;
            }
            $data1['current_stock'] = $current;
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
        } elseif ($para1 == 'delete') {
            $quantity = $this->crud_model->get_type_name_by_id('stock', $para2, 'quantity');
            $product  = $this->crud_model->get_type_name_by_id('stock', $para2, 'product');
            $type     = $this->crud_model->get_type_name_by_id('stock', $para2, 'type');
            if ($type == 'add') {
                $this->crud_model->decrease_quantity($product, $quantity);
            } else if ($type == 'destroy') {
                $this->crud_model->increase_quantity($product, $quantity);
            }
            $this->db->where('stock_id', $para2);
            $this->db->delete('stock');
        } elseif ($para1 == 'list') {
            $this->db->order_by('stock_id', 'desc');
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/admin/stock_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/stock_add');
        } elseif ($para1 == 'destroy') {
            $this->load->view('back/admin/stock_destroy');
        } else {
            $page_data['page_name'] = "stock";
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Frontend Banner Management */
    function banner($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('banner')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $data['link']   = $this->input->post('link');
            $data['status'] = $this->input->post('status');
            $this->db->where('banner_id', $para2);
            $this->db->update('banner', $data);
            $this->crud_model->file_up("img", "banner", $para2);
        } else if ($para1 == 'banner_publish_set') {
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else if ($para3 == 'false') {
                $data['status'] = '0';
            }
            $this->db->where('banner_id', $para2);
            $this->db->update('banner', $data);
        } else {
            $page_data['page_name']      = "banner";
            $page_data['all_categories'] = $this->db->get('category')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Managing sales by users */
    function sales($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('sale')) {
            redirect(base_url() . 'index.php/admin');
        }
		
		if($this->input->post('sub_action_req'))
		{
			$upaymentid = $this->input->post('upaymentid');
			$vendor_req = $this->crud_model->getsiglefield('user_payment_request','id',$upaymentid);
			if($vendor_req->num_req_payment == 0)
			{
				$vreqdata['first_payment'] = $this->input->post('req_amount');
				$num_req_payment = 1;
				$remainingamout = $vendor_req->total_payment-($this->input->post('req_amount')+$vendor_req->advance_payment+$vendor_req->adjust_amount);
				
			}
			else
			{
				$num_req_payment = $vendor_req->num_req_payment+1;
				$remainingamout = $vendor_req->total_payment-($vendor_req->first_payment+$this->input->post('req_amount')+$vendor_req->advance_payment+$vendor_req->adjust_amount);
			}
			if( $this->input->post('user_paypal_email'))
			{
				$vreqdata['user_paypal_email'] = $this->input->post('user_paypal_email');	
			}
			
			$vreqdata['request_amount'] = $this->input->post('req_amount');
			$vreqdata['request_payment_status'] =  'pending';
			$vreqdata['remaining_payment'] =  $remainingamout;
			$vreqdata['num_req_payment'] =  $num_req_payment;
			$this->db->where('id', $upaymentid);
            $this->db->update('user_payment_request', $vreqdata);
			
			$scode = md5(microtime());
			$insertdata['token_code'] = $scode;
			$insertdata['amount'] = $this->input->post('req_amount');
			$insertdata['user_email'] = $vendor_req->user_paypal_email;
			$insertdata['user_payment_req_id'] = $upaymentid;
			$insertdata['created_date'] = time();
			$this->db->insert('user_payment_mail', $insertdata);
			
			$urllink = base_url().'index.php/home/customerpay/'.$scode;
			$to = $vendor_req->user_paypal_email;
			$sub= "Pay Remaining Payment to akagypsyvannerworldwide";
			$from ='';
			$msg = "<table>";
			$msg .= "<tr><td>Hello ".$vendor_req->user_name.",</td></tr>";
			$msg .= "<tr><td>I am infoing you that akagypsyvannerworldwide sent you a payment request for $".$this->input->post('req_amount')." amount.</td></tr>";
			$msg .= "<tr><td colspan=\"2\"> </td></tr>";
			$msg .= "<tr><td>Please Pay <a href=\"$urllink\" style=\"color:blue;font-size:12px;padding:5px;\">Click Here</a></td></tr>";
			
			$msg .= "<table>";
			$this->Email_model->do_email($msg, $sub, $to,$from);
		}
		else if($this->input->post('sub_action_adjust'))
		{
			$upaymentid = $this->input->post('upaymentid');
			$vendor_req = $this->crud_model->getsiglefield('user_payment_request','id',$upaymentid);
			
			$remainingamout = $vendor_req->total_payment-($vendor_req->first_payment+$this->input->post('req_amount')+$vendor_req->advance_payment+$this->input->post('adjust_amount_value'));
			
			$vreqdata['remaining_payment'] =  $remainingamout;
			$vreqdata['adjust_amount'] = $this->input->post('adjust_amount_value');
			$this->db->where('id', $upaymentid);
            $this->db->update('user_payment_request', $vreqdata);
			
			$to = $vendor_req->user_paypal_email;
			$nowtotalpayment = ($vendor_req->total_payment)-$this->input->post('adjust_amount_value');
			$sub= "Adjust payment by akagypsyvannerworldwide";
			$from ='';
			$msg = "<table>";
			$msg .= "<tr><td>Hello ".$vendor_req->user_name.",</td></tr>";
			$msg .= "<tr><td>Admin has adjust $".$this->input->post('adjust_amount_value')." in your payment.</td></tr>";
			$msg .= "<tr><td>Now your total amount is $ $nowtotalpayment</td></tr>";
			
			$msg .= "<table>";
			$this->Email_model->do_email($msg, $sub, $to,$from);
			
			
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
                   // $this->db->where('sale_id', $row['sale_id']);
                   // $this->db->delete('sale');
                }
            }
            $this->db->order_by('sale_id', 'desc');
            $page_data['all_sales'] = $this->db->get('sale')->result_array();
            $this->load->view('back/admin/sales_list', $page_data);
        } elseif ($para1 == 'view') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/sales_view', $page_data);
        } elseif ($para1 == 'send_invoice') {
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $text              = $this->load->view('back/includes_top', $page_data);
            $text .= $this->load->view('back/admin/sales_view', $page_data);
            $text .= $this->load->view('back/includes_bottom', $page_data);
        } elseif ($para1 == 'delivery_status') {
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
                if(isset($row['admin'])){
                    $page_data['delivery_status'] = $row['status'];
                }
            }
           
            
            $this->load->view('back/admin/sales_delivery_status', $page_data);
        } elseif ($para1 == 'delivery_status_set') {
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            $new_delivery_status = array();
            foreach ($delivery_status as $row) {
                if(isset($row['admin'])){
                    $new_delivery_status[] = array('admin'=>'','status'=>$this->input->post('delivery_status'),'delivery_time'=>$row['delivery_time']);
                } else {
                    $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status'],'delivery_time'=>$row['delivery_time']);
                }
            }
           
            $data['delivery_status'] = json_encode($new_delivery_status);
            $data['payment_details'] = $this->input->post('payment_details');
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
        }elseif ($para1 == 'payment_status') {
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
           
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            foreach ($payment_status as $row) {
                if(isset($row['admin'])){
                    $page_data['payment_status'] = $row['status'];
                }
            }
            
            $this->load->view('back/admin/sales_payment_status', $page_data);
        } elseif ($para1 == 'payment_status_set') {
            
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            $new_payment_status = array();
            foreach ($payment_status as $row) {
                if(isset($row['admin'])) {
                    $new_payment_status[] = array('admin'=>'','status'=>$this->input->post('payment_status'));
                } else {
                    $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status']);
                }
            }
            $data['payment_status']  = json_encode($new_payment_status);
           
            $data['payment_details'] = $this->input->post('payment_details');
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
        }  elseif ($para1 == 'add') {
            $this->load->view('back/admin/sales_add');
        } elseif ($para1 == 'total') {
            echo $this->db->get('sale')->num_rows();
        } elseif ($para1 == 'vendor_pay') {
			
			if($this->input->post('email') && $para2!='')
			  {
				$vat = 0;
				$paypal_email = $this->input->post('email');
			/****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_cart');
                    $this->paypal->add_field('upload', '1');
                    $i = 1;
                   /* $this->paypal->add_field('item_number_' . $i, $i);*/
                    $this->paypal->add_field('item_name_' . $i, 'Vendor Payment');
                    $this->paypal->add_field('amount_' . $i, $this->cart->format_number($this->input->post('payable_amount')));
                    
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
				   
                    $this->paypal->add_field('custom', $this->input->post('vendor_payment_id'));
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/admin/vendor_pay_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/admin/vendor_pay_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/admin/vendor_pay_success');
                    
                    //$this->paypal->submit_paypal_post();
                     $this->paypal->submit_paypal_post();
					 $page_data['page_name']     = "loadimage";
					 $page_data['page_title']    = translate('redirecting_to_paypal');
					 $this->load->view('front/index', $page_data);		
                    //redirect(base_url());
			  }else{
				redirect(base_url('admin/sales'));  
			  }
        }else {
            $page_data['page_name']      = "sales";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*User Management */
    function user($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('user')) {
            redirect(base_url() . 'index.php/admin');
        }
		$page_data['countries'] = $this->db->get('country')->result_array();
		$page_data['states'] = $this->db->get('states')->result_array();
        if ($para1 == 'do_add') {
            
            $dublicatemail = $this->db->get_where('user', array('email' => $this->input->post('email')))->result_array();
            $dublicatuser = $this->db->get_where('user', array('username' => $this->input->post('username')))->result_array();
            
            if(empty($dublicatuser) && empty($dublicatemail))
            {
                if ($_FILES["g_photo"]['name'][0] == '') {
                $num_of_imgs = 0;
                } else {
                    $num_of_imgs = count($_FILES["g_photo"]['name']);
                }
				$state ='';
				if($this->input->post('state'))
				{
						$state = $this->input->post('state');
				}
                $data['username']    = $this->input->post('username');
                $data['create_timestamp']     = time();
                $data['approve_timestamp']     = time();
                $data['member_timestamp']     = time();
                $data['password']    = sha1($this->input->post('password'));
                $data['surname']    = $this->input->post('surname');
                $data['email']    = $this->input->post('email');
                $data['phone']    = $this->input->post('phone');
                $data['address1']    = $this->input->post('address1');
                $data['address2']    = $this->input->post('address2');
                $data['city']    = $this->input->post('city');
				$data['country']    = $this->input->post('country');
				if($this->input->post('state') !='' && $this->input->post('country') == '230')
					$data['state']          = $this->input->post('state');
				else
					$data['state']          = 0;
                $data['zip']    = $this->input->post('zip');
                $data['gender']    = $this->input->post('gender');
                $data['g_photo']    = $this->input->post('g_photo');
                $data['num_of_imgs']        = $num_of_imgs; 
                $data['creation_date']        = date("m/d/y H:i:s");    
                
                $this->db->insert('user', $data);
                $id = $this->db->insert_id();
                $this->crud_model->file_up("g_photo", "user", $id, '');
            }
            else
            {
                $this->session->set_flashdata('alert', 'This email address Or Username already register, Please try again.');
            }
            
            
        } else if ($para1 == 'edit') {
            $page_data['user_data'] = $this->db->get_where('user', array(
                'user_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/user_edit', $page_data);
        } elseif ($para1 == "update") {
			$data['username']    = $this->input->post('username');
            $data['surname']    = $this->input->post('surname');
            $data['phone']    = $this->input->post('phone');
            $data['address1']    = $this->input->post('address1');
            $data['address2']    = $this->input->post('address2');
            $data['city']    = $this->input->post('city');
            $data['zip']    = $this->input->post('zip');
            $data['gender']    = $this->input->post('gender');
            $data['g_photo']    = $this->input->post('g_photo');
            $data['num_of_imgs']        = $num_of_imgs; 
            $data['creation_date']        = date("m/d/y H:i:s");
           
           
           
            $this->crud_model->file_up("g_photo", "user", $para2, '');
            $this->db->where('user_id', $para2);
            $this->db->update('user', $data);
                        
            
        } elseif ($para1 == 'delete') {
            $this->db->where('user_id', $para2);
            $this->db->delete('user');
        } elseif ($para1 == 'list') {
            $this->db->order_by('user_id', 'desc');
            $page_data['all_users'] = $this->db->get('user')->result_array();
            $this->load->view('back/admin/user_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['user_data'] = $this->db->get_where('user', array(
                'user_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/user_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/user_add', $page_data);
        } else {
            $page_data['page_name'] = "user";
            $page_data['all_users'] = $this->db->get('user')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* membership_payment Management */
    function membership_payment($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('membership_payment')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $this->db->where('membership_payment_id', $para2);
            $this->db->delete('membership_payment');
        } else if ($para1 == 'list') {
            $this->db->order_by('membership_payment_id', 'desc');
            $page_data['all_membership_payments'] = $this->db->get('membership_payment')->result_array();
            $this->load->view('back/admin/membership_payment_list', $page_data);
        } else if ($para1 == 'view') {
            $page_data['membership_payment_data'] = $this->db->get_where('membership_payment', array(
                'membership_payment_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_payment_view', $page_data);
        } elseif ($para1 == 'upgrade') {
            if($this->input->post('status')){
                $membership = $this->db->get_where('membership_payment',array('membership_payment_id'=>$para2))->row()->membership;
                $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$para2))->row()->vendor;
                $data['status'] = $this->input->post('status');
                $data['details'] = $this->input->post('details');
                if($data['status'] == 'paid'){
                    $this->crud_model->upgrade_membership($vendor,$membership);
                }
                
                $this->db->where('membership_payment_id', $para2);
                $this->db->update('membership_payment', $data);
            }
        } else {
            $page_data['page_name'] = "membership_payment";
            $page_data['all_membership_payments'] = $this->db->get('membership_payment')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

    /* Vendor Management */
    function vendor($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('vendor')) {
            redirect(base_url() . 'index.php/admin');
        }
		$page_data['countries'] = $this->db->get('country')->result_array();
		$page_data['states'] = $this->db->get('states')->result_array();
        if ($para1 == 'do_add') {
            $dublicatemail = $this->db->get_where('vendor', array('email' => $this->input->post('email')))->row();
            $dublicatuser = $this->db->get_where('vendor', array('username' => $this->input->post('username')))->row();

            if(empty($dublicatuser) && empty($dublicatemail))
            {
                $data['username']    = $this->input->post('username');
				$data['surname']    = $this->input->post('surname');
                $data['password']    = sha1($this->input->post('password'));
                $data['display_name']    = $this->input->post('display_name');
                $data['email']    = $this->input->post('email');
                $data['company']    = $this->input->post('company');
                $data['membership']    = $this->input->post('membership');
                $data['gender']    = $this->input->post('gender');
                $data['phone']    = $this->input->post('phone');
                $data['address1']    = $this->input->post('address1');
                $data['address2']    = $this->input->post('address2');
				$data['city']          = $this->input->post('city');
				if($this->input->post('state') !='' && $this->input->post('country') == '230')
					$data['state']          = $this->input->post('state');
				else
					$data['state']          = 0;
				$data['country']          = $this->input->post('country');
                $data['paypal_email']    = $this->input->post('paypal_email');
                $data['zip']    = $this->input->post('zip');
                $data['status']    = 'unapproved';
                $data['create_timestamp']    = time();
                
                
                $this->db->insert('vendor', $data);
                $id = $this->db->insert_id();
                $this->crud_model->file_up("profile_image", "vendor", $id, '');
            }
            else
            {
                $this->session->set_flashdata('alert', 'This email address Or Username already register, Please try again.');
                echo 'This email address Or Username already register, Please try again.';
                redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
            }
            
            
        } else if ($para1 == 'update') {
            $data['username']    = $this->input->post('username');
            $data['surname']    = $this->input->post('surname');			
            $data['company']    = $this->input->post('company');
            $data['membership']    = $this->input->post('membership');
            $data['gender']    = $this->input->post('gender');
            $data['phone']    = $this->input->post('phone');
            $data['address1']    = $this->input->post('address1');
            $data['address2']    = $this->input->post('address2');
			$data['city']          = $this->input->post('city');
			if($this->input->post('state') !='' && $this->input->post('country') == '230')
				$data['state']          = $this->input->post('state');
			else
				$data['state']          = 0;
			$data['country']          = $this->input->post('country');
            $data['paypal_email']    = $this->input->post('paypal_email');
            $data['zip']    = $this->input->post('zip');
         
            $this->crud_model->file_up("profile_image", "vendor", $para2, '');
            $this->db->where('vendor_id', $para2);
            $this->db->update('vendor', $data);
            
        } else if ($para1 == 'delete') {
            $this->db->where('vendor_id', $para2);
            $this->db->delete('vendor');
        } else if ($para1 == 'list') {
            $this->db->order_by('vendor_id', 'desc');
            $page_data['all_vendors'] = $this->db->get('vendor')->result_array();

            $this->load->view('back/admin/vendor_list', $page_data);
        } else if ($para1 == 'view') {
            $page_data['vendor_data'] = $this->db->get_where('vendor', array(
                'vendor_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/vendor_view', $page_data);
        } else if ($para1 == 'edit') {
            $page_data['vendor_data'] = $this->db->get_where('vendor', array(
                'vendor_id' => $para2
            ))->result_array();
            $page_data['memberships'] = $this->db->get('membership')->result_array();
        
            $this->load->view('back/admin/vendor_edit', $page_data);
        }else if ($para1 == 'pay_form') {
            $page_data['vendor_id'] = $para2;
            $this->load->view('back/admin/vendor_pay_form', $page_data);
        } else if ($para1 == 'approval') {
            $page_data['vendor_id'] = $para2;
            $page_data['status'] = $this->db->get_where('vendor', array(
                                            'vendor_id' => $para2
                                        ))->row()->status;
            $this->load->view('back/admin/vendor_approval', $page_data);

        } else if ($para1 == 'add') {
            $page_data['memberships'] = $this->db->get('membership')->result_array();
            
            $this->load->view('back/admin/vendor_add',$page_data);
        } else if ($para1 == 'approval_set') {
            $vendor = $para2;
            $approval = $this->input->post('approval');
            $vendorinfo = $this->db->get_where('vendor', array('vendor_id' => $para2))->row();
            $memberinfo = $this->db->get_where('membership', array('membership_id' => $vendorinfo->membership))->row();
            $numdays = "+".$memberinfo->timespan." days";
            if ($approval == 'ok') {
                $data['status'] = 'approved';
                $data['approve_timestamp']    = time();
                $data['member_timestamp']    = time();
                $data['approve_timestamp']    = time();
                $data['member_expire_timestamp']    = strtotime(time())+strtotime($numdays);
                
            } else {
                $data['status'] = 'pending';
            }
            $this->db->where('vendor_id', $vendor);
            $this->db->update('vendor', $data);
            $this->Email_model->status_email('vendor', $vendor);
        } elseif ($para1 == 'pay') {
            $vendor         = $para2;
            $method         = $this->input->post('method');
            $amount         = $this->input->post('amount');
            $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
            if ($method == 'paypal') {
                $paypal_email  = $this->crud_model->get_type_name_by_id('vendor', $vendor, 'paypal_email');
                $data['vendor_id']      = $vendor;
                $data['amount']         = $this->input->post('amount');
                $data['status']         = 'due';
                $data['method']         = 'paypal';
                $data['timestamp']      = time();

                $this->db->insert('vendor_invoice', $data);
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
                $this->paypal->add_field('notify_url', base_url() . 'index.php/admin/paypal_ipn');
                $this->paypal->add_field('cancel_return', base_url() . 'index.php/admin/paypal_cancel');
                $this->paypal->add_field('return', base_url() . 'index.php/admin/paypal_success');
                
                $this->paypal->submit_paypal_post();
                // submit the fields to paypal

            } else if ($method == 'stripe') {
                if($this->input->post('stripeToken')) {
                                    
                    $vendor         = $para2;
                    $method         = $this->input->post('method');
                    $amount         = $this->input->post('amount');
                    $amount_in_usd  = $amount/$this->db->get_where('business_settings',array('type'=>'exchange'))->row()->value;
                    
                    $stripe_details      = json_decode($this->db->get_where('vendor', array(
                        'vendor_id' => $vendor
                    ))->row()->stripe_details,true);
                    $stripe_publishable  = $stripe_details['publishable'];
                    $stripe_api_key      =  $stripe_details['secret'];

                    require_once(APPPATH . 'libraries/stripe-php/init.php');
                    \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                    $vendor_email = $this->db->get_where('vendor' , array('vendor_id' => $vendor))->row()->email;
                    
                    $vendora = \Stripe\Customer::create(array(
                        'email' => $this->db->get_where('general_settings',array('type'=>'system_email'))->row()->value, // customer email id
                        'card'  => $_POST['stripeToken']
                    ));

                    $charge = \Stripe\Charge::create(array(
                        'customer'  => $vendora->id,
                        'amount'    => ceil($amount_in_usd*100),
                        'currency'  => 'USD'
                    ));

                    if($charge->paid == true){
                        $vendora = (array) $vendora;
                        $charge = (array) $charge;
                        
                        $data['vendor_id']          = $vendor;
                        $data['amount']             = $amount;
                        $data['status']             = 'paid';
                        $data['method']             = 'stripe';
                        $data['timestamp']          = time();
                        $data['payment_details']    = "Customer Info: \n".json_encode($vendora,true)."\n \n Charge Info: \n".json_encode($charge,true);
                        
                        $this->db->insert('vendor_invoice', $data);
                        
                        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                    } else {
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                    }
                    
                } else{
                    $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                    redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
                }

            } else if ($method == 'cash') {
                $data['vendor_id']          = $para2;
                $data['amount']             = $this->input->post('amount');
                $data['status']             = 'due';
                $data['method']             = 'cash';
                $data['timestamp']          = time();
                $data['payment_details']    = "";
                $this->db->insert('vendor_invoice', $data);
                redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
            }
        } else {

            $page_data['page_name'] = "vendor";
            $page_data['all_vendors'] = $this->db->get('vendor')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }

  
    /* FUNCTION: Sell Request*/
    function sellrequest($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('sellrequest')) {
            redirect(base_url() . 'index.php/admin');
        } 
        
        $admininfo = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('admin_id')))->row();

        $this->load->library('email');
        $from = $admininfo->email;
              

        if($para1 == 'list') {
            $this->db->order_by('id', 'desc');
            $page_data['sellrequests'] = $this->db->get('sell_request')->result_array();
            $this->load->view('back/admin/sellrequest_list', $page_data);
        }
        else if($para1 == 'Unapproval') {

            
            $data['status'] = $para1;
            $this->db->where('id', $para2);
            $this->db->update('sell_request', $data);

            $this->db->order_by('id', 'desc');
            $page_data['sellrequests'] = $this->db->get('sell_request')->result_array();
            $vensellinfo = $this->db->get_where('sell_request',array('id'=>$para2))->row();

            $admininfo = $this->db->get_where('vendor',array('vendor_id'=>$vensellinfo->vendor_id))->row();
            $to = $admininfo->email; 
            $sub = 'Notification of sell request';
            $msg = "Your sell request is Under Approved.";
            $this->Email_model->do_email($msg, $sub, $to, $from);


            $this->load->view('back/admin/sellrequest_list', $page_data);
         }   
        else if($para1 == 'Rejected') {

            $data['status'] = $para1;
            $this->db->where('id', $para2);
            $this->db->update('sell_request', $data); 
            $this->db->order_by('id', 'desc');
            $page_data['sellrequests'] = $this->db->get('sell_request')->result_array();
            $vensellinfo = $this->db->get_where('sell_request',array('id'=>$para2))->row();

            $admininfo = $this->db->get_where('vendor',array('vendor_id'=>$vensellinfo->vendor_id))->row();
            $to = $admininfo->email; 
            $sub = 'Notification of sell request';
            $msg = "Your sell request is Rejected.";
            $this->Email_model->do_email($msg, $sub, $to, $from);

            $this->load->view('back/admin/sellrequest_list', $page_data);
        } 
        else if($para1 == 'Approved') {

            $data['status'] = $para1;
            $this->db->where('id', $para2);
            $this->db->update('sell_request', $data); 
            $this->db->order_by('id', 'desc');
            $page_data['sellrequests'] = $this->db->get('sell_request')->result_array();
            $vensellinfo = $this->db->get_where('sell_request',array('id'=>$para2))->row();
			
			$datahorse['sale_price'] = $para3;
            $this->db->where('product_id', $vensellinfo->horse_number);
            $this->db->update('product', $datahorse);
			
            $admininfo = $this->db->get_where('vendor',array('vendor_id'=>$vensellinfo->vendor_id))->row();

            $to = $admininfo->email; 
            $sub = 'Notification of sell request';
            $msg = "Your sell request is Approved.";
            $this->Email_model->do_email($msg, $sub, $to, $from);

            $this->load->view('back/admin/sellrequest_list', $page_data);
        }
        else
        {
            $page_data['page_name'] = "sellrequest";
            $page_data['sellrequests'] = $this->db->get('sell_request')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
     
    /*FUNCTION: widget */
    function widget($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('widget')) {
            redirect(base_url() . 'index.php/admin');
        } 
        
        $admininfo = $this->db->get_where('admin',array('admin_id'=>$this->session->userdata('admin_id')))->row();

        $this->load->library('email');
        $from = $admininfo->email;
              

        if($para1 == 'list') {
            $this->db->order_by('widget_id', 'desc');
            $page_data['widgets'] = $this->db->get('widget')->result_array();
            $this->load->view('back/admin/widget_list', $page_data);
        }
        else if($para1 == 'do_add') {
           
                $data['name']             = $this->input->post('widget_title');
                $data['content']             = $this->input->post('widget_content');
               
                $this->db->insert('widget', $data);
                redirect(base_url() . 'index.php/admin/widget/', 'refresh');
         }  
        else if($para1 == 'add') {
            
            $this->load->view('back/admin/widget_add');
         }    
        else if($para1 == 'edit') {
            
            $page_data['user_data'] = $this->db->get_where('widget', array(
                'widget_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/widget_edit', $page_data);

        }
        else if($para1 == 'update') {

            $data['name']             = $this->input->post('widget_title');
            $data['content']             = $this->input->post('widget_content');
            $this->db->where('widget_id', $para2);
            $this->db->update('widget', $data);
            redirect(base_url() . 'index.php/admin/widget/', 'refresh');
        }else if ($para1 == 'delete') {
            $this->db->where('widget_id', $para2);
            $this->db->delete('widget');
             redirect(base_url() . 'index.php/admin/widget/', 'refresh');
        }
        else
        {
            $page_data['page_name'] = "widget";
            $page_data['widgets'] = $this->db->get('widget')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
     
    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {
            
            $data['status']             = 'paid';
            $data['payment_details']    = json_encode($_POST);
            $invoice_id                 = $_POST['custom'];
            $this->db->where('vendor_invoice_id', $invoice_id);
            $this->db->update('vendor_invoice', $data);
        }
    }
    

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('vendor_invoice_id', $invoice_id);
        $this->db->delete('vendor_invoice');
        $this->session->set_userdata('vendor_invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $this->session->set_userdata('invoice_id', '');
        redirect(base_url() . 'index.php/admin/vendor/', 'refresh');
    }
    
    /* Membership Management */
    function membership($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('membership')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['title']    = $this->input->post('title');
            $data['price']    = $this->input->post('price');
            $data['timespan']    = $this->input->post('timespan');
            $data['product_limit']    = $this->input->post('product_limit');
            $this->db->insert('membership', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("img", "membership", $id, '', '', '.png');
        } else if ($para1 == 'edit') {
            $page_data['membership_data'] = $this->db->get_where('membership', array(
                'membership_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title']    = $this->input->post('title');
            $data['price']    = $this->input->post('price');
            $data['timespan']    = $this->input->post('timespan');
            $data['product_limit']    = $this->input->post('product_limit');
            $this->db->where('membership_id', $para2);
            $this->db->update('membership', $data);
            $this->crud_model->file_up("img", "membership", $para2, '', '', '.png');
        } elseif ($para1 == "default_set") {
            $this->db->where('type', "default_member_product_limit");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('product_limit')
            ));
            $this->crud_model->file_up("img", "membership", 0, '', '', '.png');
        } elseif ($para1 == 'delete') {
            $this->db->where('membership_id', $para2);
            $this->db->delete('membership');
        } elseif ($para1 == 'list') {
            $this->db->order_by('membership_id', 'desc');
            $page_data['all_memberships'] = $this->db->get('membership')->result_array();
            $this->load->view('back/admin/membership_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['membership_data'] = $this->db->get_where('membership', array(
                'membership_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/membership_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/membership_add');
        } elseif ($para1 == 'default') {
            $this->load->view('back/admin/membership_default');
        } elseif ($para1 == 'publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'approved';
            } else {
                $data['status'] = 'pending';
            }
            $this->db->where('membership_id', $product);
            $this->db->update('membership', $data);
        } else {
            $page_data['page_name'] = "membership";
            $page_data['all_memberships'] = $this->db->get('membership')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Administrator Management */
    function admins($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('admin')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['name']      = $this->input->post('name');
            $data['email']     = $this->input->post('email');
            $data['phone']     = $this->input->post('phone');
            $data['address']   = $this->input->post('address');
            $password          = substr(hash('sha512', rand()), 0, 12);
            $data['password']  = sha1($password);
            $data['role']      = $this->input->post('role');
            $data['timestamp'] = time();
            $this->db->insert('admin', $data);
            $this->Email_model->account_opening('admin', $data['email'], $password);
        } else if ($para1 == 'edit') {
            $page_data['admin_data'] = $this->db->get_where('admin', array(
                'admin_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/admin_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['name']    = $this->input->post('name');
            $data['email']   = $this->input->post('email');
            $data['phone']   = $this->input->post('phone');
            $data['address'] = $this->input->post('address');
            $data['role']    = $this->input->post('role');
            $this->db->where('admin_id', $para2);
            $this->db->update('admin', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('admin_id', $para2);
            $this->db->delete('admin');
        } elseif ($para1 == 'list') {
            $this->db->order_by('admin_id', 'desc');
            $page_data['all_admins'] = $this->db->get('admin')->result_array();
            $this->load->view('back/admin/admin_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['admin_data'] = $this->db->get_where('admin', array(
                'admin_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/admin_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/admin_add');
        } else {
            $page_data['page_name']  = "admin";
            $page_data['all_admins'] = $this->db->get('admin')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Account Role Management */
    function role($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('role')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $data['name']        = $this->input->post('name');
            $data['permission']  = json_encode($this->input->post('permission'));
            $data['description'] = $this->input->post('description');
            $this->db->insert('role', $data);
        } elseif ($para1 == "update") {
            $data['name']        = $this->input->post('name');
            $data['permission']  = json_encode($this->input->post('permission'));
            $data['description'] = $this->input->post('description');
            $this->db->where('role_id', $para2);
            $this->db->update('role', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('role_id', $para2);
            $this->db->delete('role');
        } elseif ($para1 == 'list') {
            $this->db->order_by('role_id', 'desc');
            $page_data['all_roles'] = $this->db->get('role')->result_array();
            $this->load->view('back/admin/role_list', $page_data);
        } elseif ($para1 == 'view') {
            $page_data['role_data'] = $this->db->get_where('role', array(
                'role_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/role_view', $page_data);
        } elseif ($para1 == 'add') {
            $page_data['all_permissions'] = $this->db->get('permission')->result_array();
            $this->load->view('back/admin/role_add', $page_data);
        } else if ($para1 == 'edit') {
            $page_data['all_permissions'] = $this->db->get('permission')->result_array();
            $page_data['role_data']       = $this->db->get_where('role', array(
                'role_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/role_edit', $page_data);
        } else {
            $page_data['page_name'] = "role";
            $page_data['all_roles'] = $this->db->get('role')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    
    /* Checking if email exists*/
    function load_dropzone()
    {
        $this->load->view('back/admin/dropzone');
    }

    /* Checking if email exists*/
    function exists()
    {
        $email  = $this->input->post('email');
        $admin  = $this->db->get('admin')->result_array();
        $exists = 'no';
        foreach ($admin as $row) {
            if ($row['email'] == $email) {
                $exists = 'yes';
            }
        }
        echo $exists;
    }
    
    /* Login into Admin panel */
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
                $query = $this->db->get_where('admin', array(
                    'email' => $this->input->post('email')
                ));
                if ($query->num_rows() > 0) {
                    $admin_id         = $query->row()->admin_id;
                    $password         = substr(hash('sha512', rand()), 0, 12);
                    $data['password'] = sha1($password);
                    $this->db->where('admin_id', $admin_id);
                    $this->db->update('admin', $data);
                    if ($this->Email_model->password_reset_email('admin', $admin_id, $password)) {
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
                $login_data = $this->db->get_where('admin', array(
                    'email' => $this->input->post('email'),
                    'password' => sha1($this->input->post('password'))
                ));
                if ($login_data->num_rows() > 0) {
                    foreach ($login_data->result_array() as $row) {
                        $this->session->set_userdata('login', 'yes');
                        $this->session->set_userdata('admin_login', 'yes');
                        $this->session->set_userdata('admin_id', $row['admin_id']);
                        $this->session->set_userdata('admin_name', $row['name']);
                        $this->session->set_userdata('title', 'admin');
                        echo 'lets_login';

                    }
                } else {
                    echo 'login_failed';
                }
            }
        }
    }
    
    /* Loging out from Admin panel */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'index.php/admin', 'refresh');
    }
    
    /* Sending Newsletters */
    function newsletter($para1 = "")
    {
        if (!$this->crud_model->admin_permission('newsletter')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "send") {
            $users       = explode(',', $this->input->post('users'));
            $subscribers = explode(',', $this->input->post('subscribers'));
            $text        = $this->input->post('text');
            $title       = $this->input->post('title');
            $from        = $this->input->post('from');
            foreach ($users as $key => $user) {
                if ($user !== '') {
                    $this->Email_model->newsletter($title, $text, $user, $from);
                }
            }
            foreach ($subscribers as $key => $subscriber) {
                if ($subscriber !== '') {
                    $this->Email_model->newsletter($title, $text, $subscriber, $from);
                }
            }
        } else {
            $page_data['users']       = $this->db->get('user')->result_array();
            $page_data['subscribers'] = $this->db->get('subscribe')->result_array();
            $page_data['page_name']   = "newsletter";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Add, Edit, Delete, Duplicate, Enable, Disable Sliders */
    function slider($para1 = '', $para2 = '', $para3 = '')
    {
        if ($para1 == 'list') {
            $this->db->order_by('slider_id', 'desc');
            $page_data['all_slider'] = $this->db->get('slider')->result_array();
            $this->load->view('back/admin/slider_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/slider_set');
        } elseif ($para1 == 'add_form') {
            $page_data['style_id'] = $para2;
            $page_data['style']    = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $para2
            ))->row()->value, true);
            $this->load->view('back/admin/slider_add_form', $page_data);
        } else if ($para1 == 'delete') { //ll
            $elements = json_decode($this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->row()->elements, true);
            $style    = $this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->row()->style;
            $style    = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $style
            ))->row()->value, true);
            $images   = $style['images'];
            if (file_exists('uploads/slider_image/background_' . $para2 . '.jpg')) {
                unlink('uploads/slider_image/background_' . $para2 . '.jpg');
            }
            foreach ($images as $row) {
                if (file_exists('uploads/slider_image/' . $para2 . '_' . $row . '.png')) {
                    unlink('uploads/slider_image/' . $para2 . '_' . $row . '.png');
                }
            }
            $this->db->where('slider_id', $para2);
            $this->db->delete('slider');
        } else if ($para1 == 'serial') {
            $this->db->order_by('serial', 'desc');
            $this->db->order_by('slider_id', 'desc');
            $page_data['slider'] = $this->db->get_where('slider', array(
                'status' => 'ok'
            ))->result_array();
            $this->load->view('back/admin/slider_serial', $page_data);
        } else if ($para1 == 'do_serial') {
            $input  = json_decode($this->input->post('serial'), true);
            $serial = array();
            foreach ($input as $r) {
                $serial[] = $r['id'];
            }
            $serial  = array_reverse($serial);
            $sliders = $this->db->get('slider')->result_array();
            foreach ($sliders as $row) {
                $data['serial'] = 0;
                $this->db->where('slider_id', $row['slider_id']);
                $this->db->update('slider', $data);
            }
            foreach ($serial as $i => $row) {
                $data1['serial'] = $i + 1;
                $this->db->where('slider_id', $row);
                $this->db->update('slider', $data1);
            }
        } else if ($para1 == 'slider_publish_set') {
            $slider = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
                $data['serial'] = 0;
            }
            $this->db->where('slider_id', $slider);
            $this->db->update('slider', $data);
        } else if ($para1 == 'edit') {
            $page_data['slider_data'] = $this->db->get_where('slider', array(
                'slider_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/slider_edit_form', $page_data);
        } elseif ($para1 == 'create') {
            $data['style']  = $this->input->post('style_id');
            $data['title']  = $this->input->post('title');
            $data['serial'] = 0;
            $data['status'] = 'ok';
            $style          = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $data['style']
            ))->row()->value, true);
            $images         = array();
            $texts          = array();
            foreach ($style['images'] as $image) {
                if ($_FILES[$image['name']]['name']) {
                    $images[] = $image['name'];
                }
            }
            foreach ($style['texts'] as $text) {
                if ($this->input->post($text['name']) !== '') {
                    $texts[] = array(
                        'name' => $text['name'],
                        'text' => $this->input->post($text['name']),
						'font' => $this->input->post($text['name'] . '_font'),
                        'color' => $this->input->post($text['name'] . '_color'),
                        'background' => $this->input->post($text['name'] . '_background')
                    );
                }
            }
            $elements         = array(
                'images' => $images,
                'texts' => $texts
            );
            $data['elements'] = json_encode($elements);
            $this->db->insert('slider', $data);
            $id = $this->db->insert_id();
            
            move_uploaded_file($_FILES['background']['tmp_name'], 'uploads/slider_image/background_' . $id . '.jpg');
            foreach ($elements['images'] as $image) {
                move_uploaded_file($_FILES[$image]['tmp_name'], 'uploads/slider_image/' . $id . '_' . $image . '.png');
            }
        } elseif ($para1 == 'update') {
            $data['style'] = $this->input->post('style_id');
            $data['title'] = $this->input->post('title');
            $style         = json_decode($this->db->get_where('slider_style', array(
                'slider_style_id' => $data['style']
            ))->row()->value, true);
            $images        = array();
            $texts         = array();
            foreach ($style['images'] as $image) {
                if ($_FILES[$image['name']]['name'] || $this->input->post($image['name'] . '_same') == 'same') {
                    $images[] = $image['name'];
                }
            }
            foreach ($style['texts'] as $text) {
                if ($this->input->post($text['name']) !== '') {
                    $texts[] = array(
                        'name' => $text['name'],
                        'text' => $this->input->post($text['name']),
						'font' => $this->input->post($text['name'] . '_font'),
                        'color' => $this->input->post($text['name'] . '_color'),
                        'background' => $this->input->post($text['name'] . '_background')
                    );
                }
            }
            $elements         = array(
                'images' => $images,
                'texts' => $texts
            );
            $data['elements'] = json_encode($elements);
            $this->db->where('slider_id', $para2);
            $this->db->update('slider', $data);
            
            move_uploaded_file($_FILES['background']['tmp_name'], 'uploads/slider_image/background_' . $para2 . '.jpg');
            foreach ($elements['images'] as $image) {
                move_uploaded_file($_FILES[$image]['tmp_name'], 'uploads/slider_image/' . $para2 . '_' . $image . '.png');
            }
        } else {
            $page_data['page_name'] = "slider";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Frontend User Interface */
    function ui_settings($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "ui_home") {
            if ($para2 == 'update') {
                $this->db->where('type', "side_bar_pos");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('side_bar_pos')
                ));
                $this->db->where('type', "latest_item_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('latest_item_div')
                ));
                $this->db->where('type', "most_popular_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('most_popular_div')
                ));
                $this->db->where('type', "most_view_div");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('most_view_div')
                ));
                $this->db->where('type', "home_category");
                $this->db->update('ui_settings', array(
                    'value' => json_encode($this->input->post('category'))
                ));
                $this->db->where('type', "home_brand");
                $this->db->update('ui_settings', array(
                    'value' => json_encode($this->input->post('brand'))
                ));
                redirect(base_url() . 'index.php/admin/page_settings/home/', 'refresh');
            }
        }
        if ($para1 == "ui_category") {
            if ($para2 == 'update') {
                $this->db->where('type', "side_bar_pos_category");
                $this->db->update('ui_settings', array(
                    'value' => $this->input->post('side_bar_pos')
                ));
                redirect(base_url() . 'index.php/admin/page_settings/category_page/', 'refresh');
            }
        }
        $this->load->view('back/index', $page_data);
    }
    
    /* Checking Login Stat */
    function is_logged()
    {
        if ($this->session->userdata('admin_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
    
    /* Manage Frontend User Interface */
    function page_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "page_settings";
        $page_data['tab_name']  = $para1;
        $this->load->view('back/index', $page_data);
    }
    
    /* Manage Frontend User Messages */
    function contact_message($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('contact_message')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'delete') {
            $this->db->where('contact_message_id', $para2);
            $this->db->delete('contact_message');
        } elseif ($para1 == 'list') {
            $this->db->order_by('contact_message_id', 'desc');
            $page_data['contact_messages'] = $this->db->get('contact_message')->result_array();
            $this->load->view('back/admin/contact_message_list', $page_data);
        } elseif ($para1 == 'reply') {
            $data['reply'] = $this->input->post('reply');
            $this->db->where('contact_message_id', $para2);
            $this->db->update('contact_message', $data);
            $this->db->order_by('contact_message_id', 'desc');
            $query = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->row();
            $this->Email_model->do_email($data['reply'], 'RE: ' . $query->subject, $query->email);
        } elseif ($para1 == 'view') {
            $page_data['message_data'] = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/contact_message_view', $page_data);
        } elseif ($para1 == 'reply_form') {
            $page_data['message_data'] = $this->db->get_where('contact_message', array(
                'contact_message_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/contact_message_reply', $page_data);
        } else {
            $page_data['page_name']        = "contact_message";
            $page_data['contact_messages'] = $this->db->get('contact_message')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Logos */
    function logo_settings($para1 = "", $para2 = "", $para3 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "select_logo") {
            $page_data['page_name'] = "select_logo";
        } elseif ($para1 == "delete_logo") {
            if (file_exists("uploads/logo_image/logo_" . $para2 . ".png")) {
                unlink("uploads/logo_image/logo_" . $para2 . ".png");
            }
            $this->db->where('logo_id', $para2);
            $this->db->delete('logo');
        } elseif ($para1 == "set_logo") {
            $type    = $this->input->post('type');
            $logo_id = $this->input->post('logo_id');
            $this->db->where('type', $type);
            $this->db->update('ui_settings', array(
                'value' => $logo_id
            ));
        } elseif ($para1 == "show_all") {
            $page_data['logo'] = $this->db->get('logo')->result_array();
            if ($para2 == "") {
                $this->load->view('back/admin/all_logo', $page_data);
            }
            if ($para2 == "selectable") {
                $page_data['logo_type'] = $para3;
                $this->load->view('back/admin/select_logo', $page_data);
            }
        } elseif ($para1 == "upload_logo") {
            foreach ($_FILES["file"]['name'] as $i => $row) {
                $data['name'] = '';
                $this->db->insert("logo", $data);
                $id = $this->db->insert_id();
                move_uploaded_file($_FILES["file"]['tmp_name'][$i], 'uploads/logo_image/logo_' . $id . '.png');
            }
            return;
        } else {
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Favicons */
    function favicon_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $name = $_FILES["fav"]["name"];
        $ext  = end((explode(".", $name)));
        move_uploaded_file($_FILES["fav"]['tmp_name'], 'uploads/others/favicon.' . $ext);
        $this->db->where('type', "fav_ext");
        $this->db->update('ui_settings', array(
            'value' => $ext
        ));
    }
    
    /* Manage Frontend Facebook Login Credentials */
    function social_login_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "fb_appid");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('appid')
        ));
        $this->db->where('type', "fb_secret");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('secret')
        ));
        $this->db->where('type', "application_name");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('application_name')
        ));
        $this->db->where('type', "client_id");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('client_id')
        ));
        $this->db->where('type', "client_secret");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('client_secret')
        ));
        $this->db->where('type', "redirect_uri");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('redirect_uri')
        ));
        $this->db->where('type', "api_key");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('api_key')
        ));
    }
    
    /* Manage Frontend Facebook Login Credentials */
    function product_comment($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "discus_id");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('discus_id')
        ));
        $this->db->where('type', "comment_type");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('type')
        ));
        $this->db->where('type', "fb_comment_api");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('fb_comment_api')
        ));
    }
    
    /* Manage Frontend Captcha Settings Credentials */
    function captcha_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $this->db->where('type', "captcha_public");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('cpub')
        ));
        $this->db->where('type', "captcha_private");
        $this->db->update('general_settings', array(
            'value' => $this->input->post('cprv')
        ));
    }
    
    /* Manage Site Settings */
    function site_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        $page_data['page_name'] = "site_settings";
        $page_data['tab_name']  = $para1;
        $this->load->view('back/index', $page_data);
    }
    
    /* Manage Languages */
    function language_settings($para1 = "", $para2 = "", $para3 = "")
    {
        if (!$this->crud_model->admin_permission('language')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'add_lang') {
            $this->load->view('back/admin/language_add');
        } elseif ($para1 == 'lang_list') {
            //if($para2 !== ''){
            $this->db->order_by('word_id', 'desc');
            $page_data['words'] = $this->db->get('language')->result_array();
            $page_data['lang']  = $para2;
            $this->load->view('back/admin/language_list', $page_data);
            //}
        } elseif ($para1 == 'add_word') {
            $page_data['lang'] = $para2;
            $this->load->view('back/admin/language_word_add', $page_data);
        } elseif ($para1 == 'upd_trn') {
            $word_id     = $para2;
            $translation = $this->input->post('translation');
            $language    = $this->input->post('lang');
            $word        = $this->db->get_where('language', array(
                'word_id' => $word_id
            ))->row()->word;
            add_translation($word, $language, $translation);
        } elseif ($para1 == 'do_add_word') {
            $language = $para2;
            $word     = $this->input->post('word');
            add_lang_word($word);
        } elseif ($para1 == 'do_add_lang') {
            $language = $this->input->post('language');
            add_language($language);
        } elseif ($para1 == 'check_existed') {
            echo lang_check_exists($para2);
        } elseif ($para1 == 'lang_select') {
            $this->load->view('back/admin/language_select');
        } elseif ($para1 == 'dlt_lang') {
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $para2);
        } elseif ($para1 == 'dlt_word') {
            $this->db->where('word_id', $para2);
            $this->db->delete('language');
        } else {
            $page_data['page_name'] = "language";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Business Settings */
    function business_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('business_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "paypal_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
          /*  $this->db->where('type', "paypal_set");
            $this->db->update('business_settings', array(
                'value' => $val
            )); */
        }
        if ($para1 == 'set') {
        /*    $this->db->where('type', "paypal_email");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('paypal_email')
            ));
            $this->db->where('type', "paypal_type");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('paypal_type')
            ));
            $this->db->where('type', "currency");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('currency')
            ));
            $this->db->where('type', "currency_name");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('currency_name')
            ));
            $this->db->where('type', "exchange");
            $this->db->update('business_settings', array(
                'value' => $this->input->post('exchange')
            ));
		*/
        } else {
            $page_data['page_name'] = "business_settings";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage Admin Settings */
    function manage_admin($para1 = "")
    {
        if ($this->session->userdata('admin_login') != 'yes') {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'update_password') {
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('admin', array(
                'admin_id' => $this->session->userdata('admin_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('admin_id', $this->session->userdata('admin_id'));
                        $this->db->update('admin', $data);
                        echo 'updated';
                    }
                } else {
                    echo 'pass_prb';
                }
            }
        } else if ($para1 == 'update_profile') {
            $this->db->where('admin_id', $this->session->userdata('admin_id'));
            $this->db->update('admin', array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'phone' => $this->input->post('phone')
            ));
        } else {
            $page_data['page_name'] = "manage_admin";
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Page Management */
    function page($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('page')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == 'do_add') {
            $parts             = array();
            $data['page_name'] = $this->input->post('page_name');
            $data['parmalink'] = $this->input->post('parmalink');
            $size              = $this->input->post('part_size');
            $type              = $this->input->post('part_content_type');
            $content           = $this->input->post('part_content');
            $widget            = $this->input->post('part_widget');
            var_dump($widget);
            foreach ($size as $in => $row) {
                $parts[] = array(
                    'size' => $size[$in],
                    'type' => $type[$in],
                    'content' => $content[$in],
                    'widget' => $widget[$in]
                );
            }
            $data['parts']  = json_encode($parts);
            $data['status'] = 'ok';
            $this->db->insert('page', $data);
        } else if ($para1 == 'edit') {
            $page_data['page_data'] = $this->db->get_where('page', array(
                'page_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/page_edit', $page_data);
        } elseif ($para1 == "update") {
            $parts             = array();
            $data['page_name'] = $this->input->post('page_name');
            $data['parmalink'] = $this->input->post('parmalink');
            $size              = $this->input->post('part_size');
            $type              = $this->input->post('part_content_type');
            $content           = $this->input->post('part_content');
            $widget            = $this->input->post('part_widget');
            var_dump($widget);
            foreach ($size as $in => $row) {
                $parts[] = array(
                    'size' => $size[$in],
                    'type' => $type[$in],
                    'content' => $content[$in],
                    'widget' => $widget[$in]
                );
            }
            $data['parts'] = json_encode($parts);
            $this->db->where('page_id', $para2);
            $this->db->update('page', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('page_id', $para2);
            $this->db->delete('page');
        } elseif ($para1 == 'list') {
            $this->db->order_by('page_id', 'desc');
            $page_data['all_page'] = $this->db->get('page')->result_array();
            $this->load->view('back/admin/page_list', $page_data);
        } else if ($para1 == 'page_publish_set') {
            $page = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('page_id', $page);
            $this->db->update('page', $data);
        } elseif ($para1 == 'view') {
            $page_data['page_data'] = $this->db->get_where('page', array(
                'page_id' => $para2
            ))->result_array();
            $this->load->view('back/admin/page_view', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/admin/page_add');
        } else {
            $page_data['page_name'] = "page";
            $page_data['all_pages'] = $this->db->get('page')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Manage General Settings */
    function general_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "terms") {
            $this->db->where('type', "terms_conditions");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('terms')
            ));
        }
		if ($para1 == "terms_member") {
            $this->db->where('type', "terms_conditions_member");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('terms_member')
            ));
        }
		if ($para1 == "terms_breeding") {
            $this->db->where('type', "terms_conditions_breeding");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('terms_breeding')
            ));
        }
		if ($para1 == "terms_dna") {
            $this->db->where('type', "terms_conditions_dna");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('terms_dna')
            ));
        }
        if ($para1 == "privacy_policy") {
            $this->db->where('type', "privacy_policy");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('privacy_policy')
            ));
        }
        if ($para1 == "set_slider") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            $this->db->where('type', "slider");
            $this->db->update('general_settings', array(
                'value' => $val
            ));
        }
        if ($para1 == "set") {
            $this->db->where('type', "system_name");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_name')
            ));
            $this->db->where('type', "system_email");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_email')
            ));
            $this->db->where('type', "system_title");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('system_title')
            ));
        }
        if ($para1 == "contact") {
            $this->db->where('type', "contact_address");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_address')
            ));
            $this->db->where('type', "contact_email");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_email')
            ));
			$this->db->where('type', "website_support");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('website_support')
            ));
            $this->db->where('type', "sales_queries");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('sales_queries')
            ));
            $this->db->where('type', "generic_qustomer_support");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('generic_qustomer_support')
            ));
            $this->db->where('type', "breeding_queries");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('breeding_queries')
            ));			
            $this->db->where('type', "contact_phone");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_phone')
            ));
            $this->db->where('type', "contact_website");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_website')
            ));
            $this->db->where('type', "contact_about");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('contact_about')
            ));
        }
    }
    
    /* Manage Social Links */
    function social_links($para1 = "")
    {
        if (!$this->crud_model->admin_permission('site_settings')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $this->db->where('type', "facebook");
            $this->db->update('social_links', array(
                'value' => $this->input->post('facebook')
            ));
            $this->db->where('type', "google-plus");
            $this->db->update('social_links', array(
                'value' => $this->input->post('google-plus')
            ));
            $this->db->where('type', "twitter");
            $this->db->update('social_links', array(
                'value' => $this->input->post('twitter')
            ));
            $this->db->where('type', "pinterest");
            $this->db->update('social_links', array(
                'value' => $this->input->post('pinterest')
            ));
            $this->db->where('type', "youtube");
            $this->db->update('social_links', array(
                'value' => $this->input->post('youtube')
            ));
            redirect(base_url() . 'index.php/admin/site_settings/social_links/', 'refresh');
        }
    }
    /* Manage SEO relateds */
    function seo_settings($para1 = "")
    {
        if (!$this->crud_model->admin_permission('seo')) {
            redirect(base_url() . 'index.php/admin');
        }
        if ($para1 == "set") {
            $this->db->where('type', "meta_description");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('description')
            ));
            $this->db->where('type', "meta_keywords");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('keywords')
            ));
            $this->db->where('type', "meta_author");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('author')
            ));

            $this->db->where('type', "revisit_after");
            $this->db->update('general_settings', array(
                'value' => $this->input->post('revisit_after')
            ));
        }
        else {
            require_once (APPPATH . 'libraries/SEOstats/bootstrap.php');
            $page_data['page_name'] = "seo";
            $this->load->view('back/index', $page_data);
        }
    }
    /* Zone Management */
    function zone($para1 = '', $para2 = '', $para3 = '')
    {

        if (!$this->crud_model->admin_permission('zone')) {
            redirect(base_url() . 'index.php/admin');
        }
        
        if ($para1 == 'do_add') {
            $dublicatzone = $this->db->get_where('zone', array('zone' => $this->input->post('zone')))->result_array();
			
			if(empty($dublicatzone) && empty($dublicatzone))
			{
				$data['zone']    = $this->input->post('zone');
				$this->db->insert('zone', $data);
				$id = $this->db->insert_id();
			}
        }
		else if ($para1 == "update") {
            $data['zone']              = $this->input->post('zone');
            $this->db->where('id', $para2);
            $this->db->update('zone', $data);
        }
        elseif ($para1 == 'delete') {
            $this->db->where('id', $para2);
            $this->db->delete('zone');
			$this->db->where('zone_id',$para2);
			$this->db->delete('zone_area_division');
		}	
        else if ($para1 == 'add') {
			$this->load->view('back/admin/zone_add');
        }
        
        else if ($para1 == 'edit') {
            $page_data['zone_data'] = $this->db->get_where('zone', array(
                'id' => $para2
            ))->result_array();

		    $this->load->view('back/admin/zone_edit', $page_data);
        }
        
        else if ($para1 == 'list') {
            $this->db->order_by('id', 'asc');
            $page_data['all_zones'] = $this->db->get('zone')->result_array();
            $this->load->view('back/admin/zone_list', $page_data);
        }
        
        else if($para1 == 'manage') {
            $page_data['all_zones'] = $this->db->get('zone')->result_array();
            $page_data['all_countries'] = $this->db->get('country')->result_array();
            $this->load->view('back/admin/zone_manage', $page_data);
        }
        
        else {
            $page_data['page_name'] = "zone";
            $page_data['all_zones'] = $this->db->get('zone')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
  
    /* Country Management */
    function country($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('country')) {
            redirect(base_url() . 'index.php/admin');
        }
        
        if ($para1 == 'do_add') {
			$dublicatcountry = $this->db->get_where('country', array('country_code' => $this->input->post('country_code')))->result_array();
			
			if(empty($dublicatcountry) && empty($dublicatcountry))
			{
				$data['country_code']    = $this->input->post('country_code');
				$data['country_name']    = $this->input->post('country_name');
				$this->db->insert('country', $data);
				$id = $this->db->insert_id();
			} 
        }
		else if ($para1 == "update") {
			$data['country_code']    = $this->input->post('country_code');
			$data['country_name']    = $this->input->post('country_name');
            $this->db->where('country_id', $para2);
            $this->db->update('country', $data);
        }
        elseif ($para1 == 'delete') {
            $this->db->where('country_id', $para2);
            $this->db->delete('country');
		}        
        else if ($para1 == 'add') {
			$this->load->view('back/admin/country_add');
        }
        else if ($para1 == 'edit') {
            $page_data['country_data'] = $this->db->get_where('country', array(
                'country_id' => $para2
            ))->result_array();
		    $this->load->view('back/admin/country_edit', $page_data);
        }
        else if ($para1 == 'list') {
            $this->db->order_by('country_id', 'asc');
            $page_data['all_countries'] = $this->db->get('country')->result_array();
            $this->load->view('back/admin/country_list', $page_data);
        }
        
        else {
            $page_data['page_name'] = "country";
            $page_data['all_countries'] = $this->db->get('country')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
   
    /* State Management */
    function state($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->admin_permission('zone')) {
            redirect(base_url() . 'index.php/admin');
        }       
        if ($para1 == 'do_add') {
        }        
        else if ($para1 == 'add') {
            $this->load->view('back/admin/zone_add', $page_data);
        }
        else if ($para1 == 'list') {
            $this->db->order_by('name', 'asc');
            $page_data['all_state'] = $this->db->get('states')->result_array();
            $this->load->view('back/admin/state_list', $page_data);
        }
        else {
            $page_data['page_name'] = "state";
            $page_data['all_states'] = $this->db->get('states')->result_array();
            $this->load->view('back/index', $page_data);
        }
    } 

    function get_states()
    { 
        $country_id = $this->input->post('country_id');
        $zone_id = $this->input->post('zone_id');
        
        if($country_id) {
            $get_states = $this->crud_model->get_states($country_id, $zone_id);
        } 
        
        echo json_encode($get_states);
        
        exit;
   }
	function get_countries()
	{
		$zone_id = $this->input->post('zone_id');
		if($zone_id){
			$get_countries = $this->crud_model->get_countries($zone_id);
		}
		 echo json_encode($get_countries);
        
        exit;
	}
    
    function manage_zone()
    {
        $this->load->view('back/admin/manage_zone');
    }
   
    function add_zone_area() 
    {
        if(isset($_POST['zone'])) {
     
            $zone_id = $this->input->post('zone');
            $countries = $this->input->post('country');
            $data = array();
			$existing_ids = array();
			$new_ids = array();
            $i = 0;
			if(!empty($this->input->post('state'))){
				$states = $this->input->post('state');
				foreach($countries as $country)
				{
					foreach($states as $state)
					{
						$st = explode('_', $state);
						
						if($st[0] == $country) 
						{
							$data[$country][] = array(
								'zone_id'       => $zone_id,
								'country_id'    => $country,
								'state_id'      => $st[1]
							);
						}
					}
				}
			}else{
				foreach($countries as $country)
				{
					$data[$country][] = array(
						 'zone_id'       => $zone_id,
						 'country_id'    => $country,
						 'state_id'      => 0
					);
				}
			}

            $check_countries = $this->crud_model->check_country($zone_id);
            foreach($check_countries as $check_country) {
				$existing_ids[] = $check_country['country_id'];
            }
			foreach($data as $key => $value)
			{
				$new_ids[] = $key;
			}
            $new_country_ids = array_merge(array_diff($existing_ids, $new_ids), array_diff($new_ids, $existing_ids));		
			
			$this->crud_model->zone_countries($new_country_ids, $existing_ids, $zone_id, $data);

            redirect('admin/zone');
        }

    }
   function rate($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->admin_permission('rates')) {
            redirect(base_url() . 'index.php/admin');
        }
        
        if ($para1 == 'do_add') {
			$data_1 = $data['zone_id_1'] = $this->input->post('zone_id_1');
			$data_2 = $data['zone_id_2'] = $this->input->post('zone_id_2');
			$data['price']    = $this->input->post('price');
			$where = "(zone_id_1 = {$data_1} and zone_id_2 = {$data_2}) or (zone_id_2 = {$data_1} and zone_id_1 = {$data_2})";
			$this->db->where($where);
			$query = $this->db->get('rates');
			if($query->num_rows()>0){

			}else{
				$this->db->insert('rates', $data);
				$id = $this->db->insert_id();
			}
        }
		else if ($para1 == "update") {
			$data['price']    = $this->input->post('price');
            $this->db->where('id', $para2);
            $this->db->update('rates', $data);
        }
        elseif ($para1 == 'delete') {
            $this->db->where('id', $para2);
            $this->db->delete('rates');

		}	
        else if ($para1 == 'add') {
			$page_data['zones'] = $this->db->get('zone')->result_array();
			$this->load->view('back/admin/rate_add', $page_data);
        }
        else if ($para1 == 'edit') {
            $page_data['rate_data'] = $this->db->select('r.*, z.zone as z1_name, zo.zone as z2_name')
												->from('rates as r')
												->join('zone as z', 'r.zone_id_1 = z.id')
												->join('zone as zo', 'r.zone_id_2 = zo.id')
												->where(array('r.id' => $para2))
												->get()->result_array();
			
		    $this->load->view('back/admin/rate_edit', $page_data);
        }
        else if ($para1 == 'list') {
            $page_data['all_rates'] = $this->db->select('r.*, z.zone as z1_name, zo.zone as z2_name')
												->from('rates as r')
												->join('zone as z', 'r.zone_id_1 = z.id')
												->join('zone as zo', 'r.zone_id_2 = zo.id')
												->get()->result_array();
            $this->load->view('back/admin/rate_list', $page_data);
        }
        else {
            $page_data['page_name'] = "rate";
            $page_data['all_rate'] = $this->db->get('rates')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
	
	
	function vendor_pay_ipn()
	{
		redirect('admin/sales');
	}
	function vendor_pay_cancel()
	{
		redirect('admin/sales');
	}
	function vendor_pay_success()
	{
		if(isset($_REQUEST))
		{
			$payment = $_REQUEST['payment_gross'];
			$vendor_payment_id = $_REQUEST['custom'];
			$vendor_payment = $this->crud_model->getsiglefield('vendor_payment','vendor_payment_id',$vendor_payment_id);
			$totalamount = $vendor_payment->amount;
			$data['payed_amount']    = $vendor_payment->payed_amount+$payment;
            $this->db->where('vendor_payment_id', $vendor_payment_id);
            $this->db->update('vendor_payment', $data);
		}
		redirect('admin/sales');
	}
	function tutorial(){
		$page_data['page_name']      = "tutorial";
		$this->load->view('back/index', $page_data);
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */