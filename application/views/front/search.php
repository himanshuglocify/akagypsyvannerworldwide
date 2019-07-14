<!-- Header -->     
<header class="inner-page-bg">
    <div class="container">
        <div class="inner-title">
            <p><?php echo $page_title; ?></p>
        </div>
    </div>
</header>
<section class="section-03">
<div class="container">
<div class="col-md-12 col-sm-12 col-xs-12 md-space">
<?php if(count($horse_details) > 0){?>
<?php foreach ($horse_details as $horse_single) { ?>
<div class="col-md-4 col-sm-4 col-xs-12 product-list">
<ul class="photo-grid">	
	<li id="horse-name1">
			<figure>
			<?php if(file_exists("uploads/product_image/product_".$horse_single['product_id']."_1.jpg")){ ?>
			<img  src="/uploads/product_image/product_<?php echo $horse_single['product_id']; ?>_1.jpg" alt="" class="img-responsive" />
			<?php }else { ?>
			<img src="/uploads/image-not-found.png" alt="Not image found" />
			<?php } ?>
				<figcaption>
				<div class="onhover-text">
				<?php /* if($horse_single['status'] == 'sell'){ */ ?>
					<span class="h-name01"><?php echo $horse_single['title'];?></span>
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
					 $description = strip_tags($horse_single['description']);
					if(strlen(trim($description))>100)
						$description = substr(trim($description), 0, 100).'...';
					else
						$description = substr(trim($description), 0, 100);
					?></p>
					<p><?php echo $description; ?></p>
						<a href="<?php echo base_url().'index.php/home/horse/'.$horse_single['product_id']; ?>"><div class="see-card">See Card</div></a>
				<?php /*}else if($horse_single['status'] == 'breeding'){ ?>
				<span class="h-name01"><?php echo $horse_single['title'];?></span>
					<p class="h-age01">AGE - <?php if(!empty($product['date_of_birth'])){
						 	$dob = $product['date_of_birth'];
						 	$dbArr = explode('/', $dob);
						 	$dob = $dbArr[2].'-'.$dbArr[1].'-'.$dbArr[0];
						 	$then_ts = strtotime($dob);
				    		$then_year = date('Y', $then_ts);
				    		$age = date('Y') - $then_year;
				    		if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
				    		echo $age;
		 				}?></p>
					<p><?php echo $horse_single['description'];?><br></p>
						<a href="<?php echo base_url(); ?>index.php/breed"><div class="see-card">See Card</div></a>
				<?php }else{ ?>
				<span class="h-name01"><?php echo $horse_single['title'];?></span>
					<p class="h-age01">AGE - <?php if(!empty($product['date_of_birth'])){
					 	$dob = $product['date_of_birth'];
					 	$dbArr = explode('/', $dob);
					 	$dob = $dbArr[2].'-'.$dbArr[1].'-'.$dbArr[0];
					 	$then_ts = strtotime($dob);
			    		$then_year = date('Y', $then_ts);
			    		$age = date('Y') - $then_year;
			    		if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
			    		echo $age;
					 }?></p>
					<p><?php echo $horse_single['description'];?><br></p>
					<div class="see-card">Not Approved</div>
				<?php } */?>
				</div>
				</figcaption>
			</figure>
	</li> 
<div class="horse-name">
		<?php 
		$counter_id = $horse_single['country'];
		if(!empty($counter_id)){		
		$cat_query = "SELECT `country_name` FROM `country` WHERE `country_id` =".$counter_id;
		$catquery = $this->db->query($cat_query);
		$resArr  = $catquery->result_array();
		}
		?>
		Country:
<span class="location"><?php echo $resArr[0]['country_name']; ?></span>
</div>
</ul>
</div>
<?php  } ?>
<?php }else{ ?>
<li>Sorry No results found, Please try another term.</li>
<?php } ?>  
</div>
</div>
</section>