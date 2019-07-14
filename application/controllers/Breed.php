<?php 

class Breed extends CI_Controller{

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
	
	function index()
	{
		$zoneinfo = array();
		$page_data['info'] = '';
		if($this->session->userdata('user_id'))
		{
			$userinfo = $this->crud_model->getsiglefield('user','user_id',$this->session->userdata('user_id'));	
			$user_country = $userinfo->country;
			$zoneinfo = $this->crud_model->getsiglefield('zone_area_division','country_id',$user_country);
			if(empty($zoneinfo))
			{
				$page_data['info'] = 'Shipping is not available in your counrty.';
			}
		}
		
		$page_data['page_name']     = "breed";
		$page_data['page_title']    = translate('breeding');
		$this->load->view('front/index', $page_data);
	}
/* get particular field of horse */
	function getHosefield($para1 = "", $para2 = "")
	{
		if($para1 != '')
		{	
			$p1 = strtolower($para1);
			$p2 = strtolower($para2);
			/*$horses = $this->db->get_where('product',array('size' => strtolower($para1),''=>))->result_array();*/
			
			$zoneinfo = array();
			$page_data['info'] = '';
				if($this->session->userdata('user_id'))
				{
					
					$userinfo = $this->crud_model->getsiglefield('user','user_id',$this->session->userdata('user_id'));	
					$userid = $this->session->userdata('user_id');
					$user_country = $userinfo->country;
					$userstate = $userinfo->state;
					$zoneinfo = $this->crud_model->getfieldsval('zone_area_division', array('country_id'=>$user_country,'state_id'=>$userstate));
					if(!empty($zoneinfo))
					{
						$horses =	$this->db->query("SELECT * FROM product WHERE gender IN (SELECT gender_id FROM gender where gender_group='".$p2."') AND size= '".$p1."' AND status='breeding'")->result_array();
						if($userstate !='' && $userstate > 0)
						{
							if(!empty($zoneinfo))
							{
								$uzoneid = $zoneinfo->zone_id;
							}
							else
							{
								$uzoneid =  '';
							}
							
						}
						else
						{
							if(!empty($zoneinfo))
							{
								$uzoneid = $zoneinfo->zone_id;
							}
							else
							{
								$uzoneid =  '';
							}
							
						}
						$sting = '';
						$cont = count($horses);
					if($cont >0)
					{
						foreach($horses as $horse)
						{
							$horsecountryid = $horse['country'];
							$zoneinfo = $this->crud_model->getsiglefield('zone_area_division','country_id',$horsecountryid);
							$cont = count($zoneinfo);
							$shippingavalable = '';
							$dis= '';
							if($cont != '' && $cont > 0)
							{
								$shippingavalable = '';
								$dis= '';
							}
							else
							{
								$shippingavalable = '(Not available for shipping)';
								$dis= 'disabled';
							}
							
							
							if (file_exists('uploads/product_image/product_'.$horse['product_id'].'_1_thumb.jpg')) {
								$imgurl = base_url().'uploads/product_image/product_'.$horse['product_id'].'_1_thumb.jpg';
							} else {
								$imgurl = base_url().'uploads/image-not-found.png';
							}
							$age='';
							if(!empty($horse['date_of_birth'])){
								$dob = $horse['date_of_birth'];
								$dbArr = explode('/', $dob);
								$dob = $dbArr[2].'-'.$dbArr[1].'-'.$dbArr[0];
								$then_ts = strtotime($dob);
								$then_year = date('Y', $then_ts);
								$age = date('Y') - $then_year;
								if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
							}
							$genderinfo = $this->crud_model->getsiglefield('gender','gender_id',$horse['gender']); 
							$countryinfo = $this->crud_model->getsiglefield('country','country_id',$horse['country']); 
							$state_name = "";
							if($horse['state'] !='' && $horse['state'] > 0)
							{
								$stateinfo =$this->crud_model->getsiglefield('states','id',$horse['state']);
								$state_name = $stateinfo->name;
							}	
							$location=$horse['address'].', '.$horse['city'].', '.$countryinfo->country_name;
							$price = 0;
							$shipping_price = 0;
							if($p2=="female"){
								$fhorsestate = $horse['state'];
								if($fhorsestate !='' && $fhorsestate > 0)
								{
									$zoneinfo = $this->crud_model->getdublefield('zone_area_division','country_id',$horsecountryid,'state_id',$fhorsestate);
									if(!empty($zoneinfo))
									{
										$pzoneid = $zoneinfo->zone_id;
									}
									else
									{
										$pzoneid = '';
									}
									
								}
								else
								 {
									$zoneinfo = $this->crud_model->getsiglefield('zone_area_division','country_id',$horsecountryid);
									if(!empty($zoneinfo))
									{
										$pzoneid = $zoneinfo->zone_id;
									}
									else
									{
										$pzoneid =  '';
									}
									
									 
								 }
								if($uzoneid != '' && $pzoneid != '')
								{
									$where = "(zone_id_1 = {$uzoneid} and zone_id_2 = {$pzoneid}) or (zone_id_2 = {$uzoneid} and zone_id_1 = {$pzoneid})";
									$this->db->select('price');
									$this->db->where($where);
									$query = $this->db->get('rates')->row();
									$shipping_price = $query->price;
									
								}
								$commission = $horse['commission'];
								$sale_price = $horse['sale_price'];
								$price = $sale_price+$commission+$shipping_price;
							}else{
								$commission = $horse['commission'];
								$sale_price = $horse['sale_price'];
								$price = $sale_price+$commission;
							}
							$sting .='<li>';
							$sting .='<div class="row md-space"><div class="col-md-12 col-sm-12 col-xs-12 md-space"><div class="col-md-6 col-sm-6 col-xs-12"><img class="img-responsive" src="'.$imgurl.'"  alt="'.$horse['title'].'" /></div><div  class="col-md-6 col-sm-6 col-xs-12 breeding_detail">
							<p>Name: '.$horse['title'].'  <b>'.$shippingavalable.'</b></p>
							<p>Age: '.$age.'</p>
							<p>Sex: '.$genderinfo->gender.'</p>
							<p>Height: '.$horse['height'].' hh</p>
							<p>Country: '.$countryinfo->country_name.'</p>
							<p>State: '.$state_name.'</p>
							<p>City: '.$horse['city'].'</p>
							<div id="hor_'.$horse['product_id'].'" class="breed_checkbox"><span class="breed_btn_check"><input type="hidden" value="'.$price.'" id="price">
							<input id="r'.$horse['product_id'].'" class="breed_btn_check breed_sel_'.$p2.'" type="radio" '.$dis.' name="breed_sel_'.$p2.'" value="'.$horse['product_id'].'" /><label for="r'.$horse['product_id'].'"></label>Select </span></div> 
							<a class="showHorsedetails point btn btn-primary pull-right term-button" title="male" target="_blank" href="'.base_url().'index.php/home/horse/'.$horse['product_id'].'">View details</a></div></div></div>';
							$sting .='</li>';
						}	
					}
					else
					{
						$sting = 'Records not found';	
					}
				}
				else
				{
					$sting = '<li>Shipping is not available in your counrty</li>';
				}
			}
			else
			{
				
					$horses =	$this->db->query("SELECT * FROM product WHERE gender IN (SELECT gender_id FROM gender where gender_group='".$p2."') AND size= '".$p1."' AND status='breeding'")->result_array();
					$sting = '';
					$cont = count($horses);
					if($cont >0)
					{
						foreach($horses as $horse)
						{
										
						
						if (file_exists('uploads/product_image/product_'.$horse['product_id'].'_1_thumb.jpg')) {
							$imgurl = base_url().'uploads/product_image/product_'.$horse['product_id'].'_1_thumb.jpg';
						} else {
							$imgurl = base_url().'uploads/image-not-found.png';
						}
						$age='';
						if(!empty($horse['date_of_birth'])){
							$dob = $horse['date_of_birth'];
							$dbArr = explode('/', $dob);
							$dob = $dbArr[2].'-'.$dbArr[1].'-'.$dbArr[0];
							$then_ts = strtotime($dob);
							$then_year = date('Y', $then_ts);
							$age = date('Y') - $then_year;
							if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
						}
						$genderinfo = $this->crud_model->getsiglefield('gender','gender_id',$horse['gender']); 
						$countryinfo = $this->crud_model->getsiglefield('country','country_id',$horse['country']);
						$state_name = "";
						if($horse['state'] !='' && $horse['state'] > 0)
						{
							$stateinfo =$this->crud_model->getsiglefield('states','id',$horse['state']);
							$state_name = $stateinfo->name;
						}						
						$location=$horse['address'].', '.$horse['city'].', '.$countryinfo->country_name;
						$price = 0;
						$shipping_price = 0;
						
						$sting .='<li>';
						$sting .='<div class="row md-space"><div class="col-md-12 col-sm-12 col-xs-12 md-space"><div class="col-md-6 col-sm-6 col-xs-12"><img class="img-responsive" src="'.$imgurl.'"  alt="'.$horse['title'].'" /></div><div  class="col-md-6 col-sm-6 col-xs-12 breeding_detail">
						<p>Name: '.$horse['title'].'</p>
						<p>Age: '.$age.'</p>
						<p>Sex: '.$genderinfo->gender.'</p>
						<p>Height: '.$horse['height'].' hh</p>
						<p>Country: '.$countryinfo->country_name.'</p>
						<p>State: '.$state_name.'</p>
						<p>City: '.$horse['city'].'</p>
						<a class="showHorsedetails point btn btn-primary pull-right term-button" title="male" target="_blank" href="'.base_url().'index.php/home/horse/'.$horse['product_id'].'">View details</a></div></div></div>';
						$sting .='</li>';	
					}
				
			
					
				}
				else
				{
					$sting ='Records not found';	
				}
			}
			echo $sting;
		}
		else
		{
			echo 'Size not found';
		}
		
	}
	/* single prosuct*/
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

			<ul class="photo-grid" >
			<li> <b>Name</b> :&nbsp; <?php echo $product->title; ?></li>
			</ul>
			<ul class="photo-grid">
			<li >
			<a href="javascript:void(0);">
			<figure>
			<?php if(file_exists("uploads/product_image/product_".$product->product_id."_1_thumb.jpg")){ ?>
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
			<ul class="photo-grid horse-detai-ul" >
			<li> <b>Name</b> :&nbsp; <?php echo $product->title; ?></li>
			<li><b>Horse Code</b> :&nbsp; <?php echo $product->horse_code; ?></li>
			<li><b>Age</b> :&nbsp; <?php echo $product->age; ?></li>
			<li><b>Height</b> :&nbsp;<?php echo $product->height; ?></li>
			<li><b>width</b> :&nbsp;<?php echo $product->weight; ?> </li>
			<li><b>Price</b> :&nbsp; <?php echo $product->sale_price; ?></li>
			<li><b>Size</b> :&nbsp; <?php echo $product->size; ?></li>
			<li><b>Address </b>:&nbsp; <?php echo $product->address; ?></li>
			<li><b>City</b> :&nbsp; <?php echo $product->city; ?></li>
			<li><b>Country</b> :&nbsp; <?php 
			$countryinfo = $this->crud_model->getsiglefield('country','country_id',$product->country); 
								echo $countryinfo->country_name; ?></li>
			<li><b>Zip</b> :&nbsp; <?php echo $product->country; ?></li>
			</ul>
			
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
/* function : breed horse checkout*/

 function checkoutBreed()
 {
	 
    if($this->session->userdata('user_login') == 'yes')
	 {
		if($this->input->post('breed_sel_male'))
		{
			$malehoseid = $this->input->post('breed_sel_male');
			$femalehoseid = $this->input->post('breed_sel_female');
			$page_data['page_name']     = "breedterm";
			$page_data['page_title']    = translate('breed_term_and_condition');
			$page_data['malehoseid'] = $malehoseid; 
			$page_data['femalehoseid'] = $femalehoseid;
			$this->load->view('front/index', $page_data);
		}
	   else
		{
		   redirect(base_url() . 'index.php/breed/index/?emp=valid', 'refresh'); 
		}
	 }
	 else
	 {
		 redirect('/', 'refresh');
	 }
	
 }
/* function : pay breed payment*/

 function breed_pay_info()
 {
	 if($this->session->userdata('user_login') == 'yes')
	 {
		if( $this->input->post('femalehoseid') &&  $this->input->post('malehoseid'))
		{
			$female_hid = $this->input->post('femalehoseid');
			$male_hid = $this->input->post('malehoseid');
			
			$userid = $this->session->userdata('user_id');
			$userrow = $this->crud_model->getsiglefield('user','user_id',$userid);
			$usercountry = $userrow->country;
			$userstate = $userrow->state;
			
			$fhorseid =  $this->crud_model->getsiglefield('product','product_id',$female_hid);
			$fhorsecountry = $fhorseid->country;
			$fhorsestate = $fhorseid->state;
			$fhorseprice = $fhorseid->sale_price;
			$fcommissioninfo = $fhorseid->commission;
			
			$mhorseid =  $this->crud_model->getsiglefield('product','product_id',$male_hid);
			$mhorseprice = $mhorseid->sale_price;
			$mcommissioninfo = $mhorseid->commission;
			
			if($userstate !='' && $userstate > 0)
			{
				$zoneinfo = $this->crud_model->getdublefield('zone_area_division','country_id',$usercountry,'state_id',$userstate);
				if(!empty($zoneinfo))
				{
					$uzoneid = $zoneinfo->zone_id;
				}
				else
				{
					$uzoneid =  '';
				}
				
			}
			else
			{
				$zoneinfo = $this->crud_model->getsiglefield('zone_area_division','country_id',$usercountry);
				if(!empty($zoneinfo))
				{
					$uzoneid = $zoneinfo->zone_id;
				}
				else
				{
					$uzoneid =  '';
				}
				
			}
			
			
			if($fhorsestate !='' && $fhorsestate > 0)
			{
				$zoneinfo = $this->crud_model->getdublefield('zone_area_division','country_id',$fhorsecountry,'state_id',$fhorsestate);
				if(!empty($zoneinfo))
				{
					$pzoneid = $zoneinfo->zone_id;
				}
				else
				{
					$pzoneid = '';
				}
				
			}
			else
			 {
				$zoneinfo = $this->crud_model->getsiglefield('zone_area_division','country_id',$fhorsecountry);
				if(!empty($zoneinfo))
				{
					$pzoneid = $zoneinfo->zone_id;
				}
				else
				{
					$pzoneid =  '';
				}
				
				 
			 }
			if($uzoneid != '' && $pzoneid != '')
			{
				$where = "(zone_id_1 = {$uzoneid} and zone_id_2 = {$pzoneid}) or (zone_id_2 = {$uzoneid} and zone_id_1 = {$pzoneid})";
				$this->db->select('price');
				$this->db->where($where);
				$query = $this->db->get('rates')->row();
			}
			else
			{
				$this->session->set_flashdata('breed_msg', "Please change your address, Because I can't shipping in this address.");
				redirect('/breed');
			}
			
			$fimg = base_url()."uploads/product_image/product_".$fhorseid->product_id."_1.jpg";
			$mimg = base_url()."uploads/product_image/product_".$mhorseid->product_id."_1.jpg";
			
			$zoneprice = $query->price;
			$totalprice = $mhorseprice+$mcommissioninfo+$fhorseprice+$fcommissioninfo+$zoneprice;
			
			$payprice = ($totalprice*25)/100;
			
			$para = array();
			$para[0] = array('p_id'=>$fhorseid->product_id,'ad_price'=>$fhorseid->sale_price,'product_name'=>$fhorseid->title,'p_image'=>$fimg,'commission'=>$fhorseid->commission);
			$para[1] = array('p_id'=>$mhorseid->product_id,'ad_price'=>$mhorseid->sale_price,'product_name'=>$mhorseid->title,'p_image'=>$mimg,'commission'=>$mhorseid->commission);
			$para['payprice'] = $payprice;		
			$para['total_price'] = $totalprice;
			$para['user_name'] = $userrow->username;
			$para['email'] = $userrow->email;
			$para['phone'] = $userrow->phone;
			$para['address1'] = $userrow->address1;
			$para['address2'] = $userrow->address2;
			$para['shipping'] = $zoneprice;
			$para['city'] = $userrow->city;
			$para['zip'] = $userrow->zip;
			$para['payment_type'] = 'paypal';			$para['product_type'] = 'Breeding';
			$userstatename = $this->crud_model->getsiglefield('states','id',$userstate);
			$para['state'] = $userstatename->name;
			$usercountryname = $this->crud_model->getsiglefield('country','country_id',$usercountry);
			$para['country'] = $usercountryname->country_name;
			$this->breed_checkout($para);
			 //$this->load->view('front/front/loadimage');
		}			
		else
		{
			$this->session->set_flashdata('breed_msg', 'I have not goted stallion and mare id, Please try again.');
			 redirect('/breed');
		}
	 }
	 else
	 {
		 redirect('/');
	 }
	 
 } 
 

	
	/* FUNCTION: breeding checkout*/
    function breed_checkout($para)
    {		
		$carted = array();
	    if ($this->session->userdata('user_login') == 'yes') {
           
			for($i=0;$i<2;$i++)
			{
				$arrkey = md5(microtime()+$i);
				$carted[$arrkey] = array('id'=>$para[$i]['p_id'],
                'qty'=>1,
                'option'=>0,
                'price'=>$para[$i]['ad_price'],
                'name'=>$para[$i]['product_name'],
                'shipping'=>$para['shipping'],
                'tax'=>0,
                'image'=>$para[$i]['p_image'],
                'coupon'=>0,
				'commission'=>$para[$i]['commission'],
				
                'rowid'=>0,				'product_type'=>$para['product_type'],	
				
				'user_name'=>$para['user_name'],	
				
				'user_id'=>$this->session->userdata('user_id'),	
				
				'email'=>$para['email'],			
				
				'advance_payment'=>$para['payprice'], 
				
				'total_price'=>$para['total_price'], 
				
                'subtotal'=>$para[$i]['ad_price']
                ); 
			}
		
            $this->session->set_userdata('carted', $carted);       
            $total    = $para['payprice'];//$this->cart->total();
            $exchange = $this->crud_model->get_type_name_by_id('business_settings', '8', 'value');
            $vat_per  = '';
            $vat      = $this->crud_model->cart_total_it('tax');
            if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
				
                $shipping = $this->crud_model->cart_total_it('shipping');
            } else {
					
                $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
            } 
            $grand_total     = $para['payprice'];//$total + $vat + $shipping;
            $product_details = json_encode($carted);
            
            $shipping = json_encode(array('firstname'=>$para['user_name'],'email'=>$para['email'],'lastname'=>'','phone'=>$para['phone'],'address1'=>$para['address1'],'address2'=>$para['address2'],'city'=>$para['city'],'zip'=>$para['zip'],'payment_type'=>'paypal'));
			
            if ($para['payment_type'] == 'paypal') {
                                   
                    $data['buyer']             = $this->session->userdata('user_id');
                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = $shipping;
                    $data['vat']               = $vat;
                    $data['vat_percent']       = $vat_per;
                    $data['shipping']          = $para['shipping'];
                    $data['delivery_status']   = '[]';
                    $data['payment_type']      = 'go';
                    $data['payment_status']    = '[]';
                    $data['payment_details']   = 'none';
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = time();
                    $data['delivary_datetime'] = '';
					$data['product_type'] = $para['product_type'];
                    $paypal_email              = $this->crud_model->get_type_name_by_id('business_settings', '1', 'value');
                    
                    $this->db->insert('sale', $data);
                    $sale_id = $this->db->insert_id();
                    
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
					$productmultiname = $para[0]['product_name'].', '.$para[1]['product_name'];
                      $this->paypal->add_field('item_number_' . $i, $i);
                        $this->paypal->add_field('item_name_' . $i, $productmultiname);
                        $this->paypal->add_field('amount_' . $i, $this->cart->format_number(($para['payprice'] / $exchange)));
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
					$this->paypal->add_field('token', $this->security->get_csrf_hash());
                    $this->paypal->add_field('custom', $sale_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'index.php/breed/breed_paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'index.php/breed/breed_paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'index.php/breed/breed_paypal_success');
                   
                    $this->paypal->submit_paypal_post();
					$page_data['page_name']     = "loadimage";
					$page_data['page_title']    = translate('redirecting_to_paypal');
					$this->load->view('front/index', $page_data);                
                
            } 
            
        } else {
            //echo 'nope';
            redirect(base_url() . 'index.php/home/cart_checkout/need_login', 'refresh');
        }
        
    }
 /* FUNCTION: Verify paypal payment by IPN*/
    function breed_paypal_ipn()
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
    function breed_paypal_cancel()
    {
        $sale_id = $this->session->userdata('sale_id');
        $this->db->where('sale_id', $sale_id);
        $this->db->delete('sale');
        $this->session->set_userdata('sale_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'index.php/home/profile', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function breed_paypal_success()
    {
		$carted  =$this->session->userdata('carted');
        $sale_id = $this->session->userdata('sale_id');		$datareqpay =array();
		$datareqpay['sale_id'] = $sale_id;		$datareqpay['create_date'] = time();		$datareqpay['product_type'] = 'Bredding';
        foreach ($carted as $value) {
            $this->crud_model->decrease_quantity($value['id'], $value['qty']);
            $data1['type']         = 'destroy';
            $data1['category']     = $this->db->get_where('product', array(
                'product_id' => $value['id']
            ))->row()->category;
            $data1['sub_category'] = $this->db->get_where('product', array(
                'product_id' => $value['id']
            ))->row()->sub_category;
            $data1['product']      = $value['id'];
            $data1['quantity']     = $value['qty'];
            $data1['total']        = 0;
            $data1['reason_note']  = 'sale';
            $data1['sale_id']      = $sale_id;
            $data1['datetime']     = time();
            $this->db->insert('stock', $data1);						$datareqpay['user_id'] = $value['user_id'];			$datareqpay['user_name'] = $value['user_name'];			$datareqpay['user_paypal_email'] = $value['email'];			$datareqpay['advance_payment'] = $value['advance_payment'];			$datareqpay['total_payment'] = $value['total_price'];			$datareqpay['remaining_payment'] = $value['total_price']-$value['advance_payment'];
       
			$prodctdata['status'] = 'sold_out';
            $this->db->where('product_id', $value['id']);
            $this->db->update('product', $prodctdata);
	
	   }     			$this->db->insert('user_payment_request', $datareqpay);			
		      $data['payment_details']   = json_encode($_POST);
            $data['payment_timestamp'] = strtotime(date("m/d/Y"));
            $data['payment_type']      = 'paypal';
            $sale_id                   = $_POST['custom'];
            $vendors = $this->crud_model->vendors_in_sale($sale_id);
            $payment_status = array();
			$addvendorpay = array();
            foreach ($vendors as $p) {
				 foreach ($carted as $value) {
					 $result = $this->crud_model->getsiglefield('product','product_id',$value['id']);
					 $addedby = json_decode($result->added_by);	
					 
					 if($addedby->id == $p)
					 {
						$addvendorpay['vendor_id'] = $p;	
						$addvendorpay['sale_id'] = $sale_id;	
						$addvendorpay['product_id'] = $result->product_id;	
						$addvendorpay['amount'] = $result->sale_price;	
						$addvendorpay['create_date'] = time();	
						$this->db->insert('vendor_payment', $addvendorpay);	
					 }
				 }
                $payment_status[] = array('vendor'=>$p,'status'=>'paid');
            }
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
       
	// adding the function that perform the search results on the db and return the results
	
}
?>