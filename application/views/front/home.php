<!-- HORSES FOR SaLe Starts -->
<section>
		<div class="container">
			<div class="row">
				<div class="col-md-4 col-sm-12 col-xs-12 text-center">
					<div class="horse-sale-title">
					<?php $contents = $this->db->get_where('widget',array('widget_id'=>1))->row();
					echo $contents->content;	
					?>
					</div>
				</div>
<div class="col-md-8 col-sm-12 col-xs-12 md-space">
<div class="col-md-12 col-sm-12 col-xs-12 md-space top-space-button text-right" id="res_cat_single">
<img src="<?php echo base_url(); ?>uploads/desgin/right-button.png" id="product_prev_slide" data-pre-val="1" cat-id="1" class="load_more_pro" data-val=""/>
<img src="<?php echo base_url(); ?>uploads/desgin/left-button.png" id="product_next_slide" data-nex-val="2" cat-id="1" class="load_more_pro" data-val="" />
</div>
<div class="col-md-12 col-sm-12 col-xs-12 md-space" id="pro_row1">
<?php $query = "SELECT * FROM `product` WHERE `status` = 'sell'";
	$horse_res_arr = $this->db->query($query);
	if ($horse_res_arr->num_rows() > 0){?>	
	<?php foreach ($horse_res_arr->result_array() as $product) { ?>
		<div class="col-md-6 col-sm-12 col-xs-12 product-list01">
			<ul class="photo-grid">
			<li id="horse-name">
	
			<figure>
			<?php if(file_exists("uploads/product_image/product_".$product['product_id']."_1.jpg")){ ?>
			<img  src="/uploads/product_image/product_<?php echo $product['product_id']; ?>_1.jpg" alt="" class="img-responsive" />
			<?php }else { ?>
			<img src="/uploads/image-not-found.png" alt="Not image found" />
			<?php } ?>
		<figcaption>
		<div class="onhover-text">
		<span class="h-name01"><?php echo $product['title']; ?></span>
		<p class="h-age01">AGE - <?php
		 if(!empty($product['date_of_birth'])){
		 	$dob = $product['date_of_birth'];
		 	$dbArr = explode('/', $dob);
		 	$dob = $dbArr[2].'-'.$dbArr[1].'-'.$dbArr[0];
		 	$then_ts = strtotime($dob);
    		$then_year = date('Y', $then_ts);
    		$age = date('Y') - $then_year;
    		if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
    		echo $age;
		 }
		 $description = strip_tags($product['description']);
		 if(strlen(trim($description))>100)
			$description = substr(trim($description), 0, 100).'...';
		 else
			$description = substr(trim($description), 0, 100);
		 ?></p>
		<p><?php echo $description; ?></p>
		<a href="<?php echo base_url().'index.php/home/horse/'.$product['product_id']; ?>"><div class="see-card">See Card</div></a>
		</div>
		</figcaption>
	</figure>
	
	</li>   
	</ul>
		<div class="horse-name">
		<?php 

		$counter_id = $product['country'];
		if(!empty($counter_id)){
		$cat_query = "SELECT `country_name` FROM `country` WHERE `country_id` =".$counter_id;
		$catquery = $this->db->query($cat_query);
		$resArr  = $catquery->result_array();
		}
		 ?>
		 Country:
		<span class="location"><?php  echo $resArr[0]['country_name']; ?>
		</span>
		</div>
	</div>
	<?php }}else{?>		
	<div class="col-md-6 col-sm-12 col-xs-12 product-list01">
	<ul class="photo-grid">
	<li id="horse-name">No Records Founds</li></ul></div>	
	<?php } ?>
</div>
<!-- adding the categories and breed slider start here -->
<div class="col-md-12 col-sm-12 col-xs-12 md-space owl-cat-wrapper">
<div class="col-md-12 col-sm-12 col-xs-12 md-space text-right arrow-button">
<img src="http://staging1ab.akagypsyvannerworldwide.com/uploads/desgin/right-button.png" class="owl-cat-nex-pre-img" id="owl-cat-pre">
<img src="http://staging1ab.akagypsyvannerworldwide.com/uploads/desgin/left-button.png" class="owl-cat-nex-pre-img" id="owl-cat-next">
</div>
	<ul id="owl-cat" class="owl-carousel owl-theme horse-sale-tab">     
	<?php //echo $this->crud_model->horseBreedAll(); 
		$this->db->order_by('category_id','asc');
		$categories = $this->db->get('category')->result_array();
		$counter_cat = 1;
		foreach ($categories as $cat_value) { ?>
		<li class="owl-cat-<?php echo $counter_cat;?>">
		<?php $id = $cat_value['category_id'];?>
		<a href="<?php echo base_url().'index.php/home/market/'.$id;?>" data-cat-id="<?php echo $cat_value['category_id'];?>" <?php if($counter_cat == 1){?>class="active"<?php } ?>>
			<?php echo $cat_value['category_name'];?>
		</a></li>
		<?php
		$counter_cat++; 
		}	?>
		 </ul>
	</div>
<!-- adding the categories and breed slider start here -->

				</div>
			</div>
		</div>
	</section>
	<!-- HORSES FOR SaLe Ends -->	

	<!-- Why Not to try our Game Starts -->
	<section class="section-02">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-6 md-space">
				<?php $game_widget = $this->db->get_where('widget',array('widget_id'=>3))->row();
						
					?>
					<div class="why-title"><?php echo $game_widget->name; ?></div>
					<div class="why-content">
					<?php echo $game_widget->content; ?>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 md-space">
					<img src="<?php echo base_url(); ?>uploads/desgin/time-img.png" alt="" class="img-responsive" />
				</div>
			</div>
		</div>
	</section>
			
	<!-- Why Not to try our Game Ends -->
	
	<!-- Breeding Starts -->
	<section class="section-03">
		<div class="container">
			<div class="row">
				<div class="col-md-12 why-title text-center md-space">
					Breeding
					<div class="breeding-text">
						Breed your own Champion! Choosing both Sire and Dam personally! <a href="/index.php/home/page/Breeding">Learn more</a>
					</div>			
				</div>				
			</div>
<?php 
		$query = "SELECT * FROM `product` WHERE `status`='breeding'";
		$horse_res_arr = $this->db->query($query);
		if ($horse_res_arr->num_rows() > 0){?>
		<?php $counter = 1;?>
		
		<div class="row md-space">
		<div class="col-md-12 col-sm-12 col-xs-12 md-space text-right arrow-button">
		<img src="<?php echo base_url(); ?>uploads/desgin/right-button.png" id="owl-breed-pre" style="cursor:pointer;" />
		<img src="<?php echo base_url(); ?>uploads/desgin/left-button.png" id="owl-breed-next" style="cursor:pointer;"  />
		</div>				
				<div class="col-md-12 col-sm-12 col-xs-12 md-space" id="owl-breed">	
		<?php foreach ($horse_res_arr->result_array() as $product) { ?>
			<div class="col-md-4 col-sm-4 col-xs-12 product-list">
			<ul class="photo-grid">
			<li id="horse-name<?php echo $counter; ?>">
			
			<figure>
<?php if(file_exists("uploads/product_image/product_".$product['product_id']."_1.jpg")){ ?>
<img  src="/uploads/product_image/product_<?php echo $product['product_id']; ?>_1.jpg" alt="" class="img-responsive" />
<?php }else { ?>
<img src="/uploads/image-not-found.png" alt="Not image found" />
<?php } ?>
			<figcaption>
				<div class="onhover-text">
					<span class="h-name01"><?php echo $product['title'];?></span>
					<p class="h-age01">AGE - 
						<?php if(!empty($product['date_of_birth'])){
					 	$dob = $product['date_of_birth'];
					 	$dbArr = explode('/', $dob);
		 				$dob = $dbArr[2].'-'.$dbArr[1].'-'.$dbArr[0];
					 	$then_ts = strtotime($dob);
			    		$then_year = date('Y', $then_ts);
			    		$age = date('Y') - $then_year;
			    		if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
			    		echo $age;
		 }
		 $description = strip_tags($product['description']);
		if(strlen(trim($description))>100)
			$description = substr(trim($description), 0, 100).'...';
		else
			$description = substr(trim($description), 0, 100);
		 ?></p>
					<p><?php echo $description; ?></p>
					<a href="<?php echo base_url().'index.php/home/horse/'.$product['product_id']; ?>"><div class="see-card">See Card</div></a>
				</div>
			</figcaption>
		</figure>
		
	</li>	
</ul>
	<div id="horse-name01" class="horse-name">
		<?php 
		$counter_id = $product['country'];
		if(!empty($counter_id)){
		$cat_query = "SELECT `country_name` FROM `country` WHERE `country_id` =".$counter_id;
		$catquery = $this->db->query($cat_query);
		$resArr  = $catquery->result_array();
		}?>
		Country:
		<span class="location">
		<?php echo $resArr[0]['country_name']; ?>
		</span>
	</div>
</div>
<?php $counter++; ?>
<?php } ?>					
<?php } ?>					
	</div>
		</div>
		</div>
	</section>			
	<!-- Breeding Ends -->
	
	<!-- PRICING OPTIONS -->
	<section class="pricing-section">
		<div class="container">
			<div class="row">
				<div class="col-md-12 why-title text-center md-space">
					PRICING OPTIONS
					<div class="breeding-text">
						WE ARE HERE TO HELP BUILD YOUR BUSINESS NOT TO SHAKE YOU DOWN!
					</div>			
				</div>				
			</div>
  
			<div class="row top-space03">
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					 <div class="db-wrapper">
						<div class="db-pricing-eleven db-bk-color-three">
							<div class="basic-title">Free Membership</div>
							<div class="price">
								<sup>$</sup>0
								<small>Free For life</small>
							</div>
							<div class="type"></div>
							<ul>
								<li>See prices</li>
								<li>Play game</li>
								<li>Shop online</li>
								<li>Sell online</li>
								<li>Buy horses</li>
								<li>******</li>
								<li>******</li>
								<li>******</li>
							</ul>							
						</div>
					</div>
					<?php if($this->session->userdata('user_login') != "yes"){ ?>
					<div class="register-div text-center">
						<a href="" class="register-button" title="0"  data-toggle="modal" data-target="#registration">Register</a>
					</div>
					<?php } ?>
				</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					 <div class="db-wrapper">
						<div class="db-pricing-eleven db-bk-color-two popular">
							<div class="basic-title">Breeder Membership</div>
							<div class="price price-cross">
								<sup>$</sup><span><strike>200</strike><span>
								<small><strike>Yearly Payment</strike></small>
							</div>
							<div class="free_month">One Year Free! Only this Month</div>
							<div class="type">
								OUR MOST POPULAR
							</div>
							<ul>
								<li>See prices</li>
								<li>Play game</li>
								<li>Shop online</li>
								<li>Sell online</li>
								<li>Buy horses</li>	
								<li>Sell horses</li>
								<li>Breed horses</li>
								<li>Register unlimited horses</li>
							</ul>						
						</div>
					</div>
					<?php if($this->session->userdata('user_login') != "yes"){ ?>
					<div class="register-div text-center">
						<a href="javascript:;" class="register-button" data-pre-val="2" title="200" data-toggle="modal" data-target="#v_registration">Register</a>
					</div>
					<?php } ?>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div class="db-wrapper">
						<div class="db-pricing-eleven db-bk-color-one">
							<div class="basic-title">Owner Membership</div>
							<div class="price price-cross">
								<sup>$</sup><span><strike>100</strike></span>
								<small><strike>Yearly Payment</strike></small>
							</div>
							<div class="free_month">One Year Free! Only this Month</div>
							<div class="type"></div>
							<ul>
								<li>See prices</li>
								<li>Play game</li>
								<li>Shop online</li>
								<li>Sell online</li>
								<li>Buy horses</li>	
								<li>Sell horses</li>
								<li>Breed horses this month free</li>
								<li>Register unlimited horses this month free</li>								
							</ul>							
						</div>
					</div>
					<?php if($this->session->userdata('user_login') != "yes"){ ?>
					<div class="register-div text-center">
						<a href="" class="register-button" data-pre-val="1" title="100" data-toggle="modal" data-target="#v_registration">Register</a>
					</div>
					<?php } ?>
				</div>
			
				
			</div>			
		</div>
	</section>	
	<!-- PRICING OPTIONS --> 	
	