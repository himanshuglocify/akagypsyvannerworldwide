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
               <div class="row">               
                <div class="col-md-12 md-space">
                    <div class="col-md-4 ext-center">
                       <div class="ms-showcase2-template">
                        <div id="slider" class="flexslider" style="overflow:hidden;">
                        <?php
							$file = base_url().'uploads/vendor_image/vendor_'.$vendor['vendor_id'].'_thumb.jpg';
							$file_headers = @get_headers($file);
							if($file_headers[0] == 'HTTP/1.1 404 Not Found'){
								$file = base_url()."template/front/assets/img/avtar.png";
							}
						?>
                            <img src="<?php echo $file; ?>" class="img-responsive" style="margin: 0px auto; text-align: center;"/>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-8 product-title-in md-space">
                        <span class="rounded-title"><?php echo $vendor['username']; ?></span>
                        <div class="col-md-12">
                                <ul class="horse-detai-ul">
									<li><strong>Name:</strong>&nbsp;&nbsp;<?php echo $vendor['username'].' '.$vendor['surname']; ?></li>	
									<li><strong>Email:</strong>&nbsp;&nbsp;<?php echo $vendor['email']; ?></li>
									<li><strong>Company:</strong>&nbsp;&nbsp;<?php echo $vendor['company']; ?></li>
									<li><strong>Gender:</strong>&nbsp;&nbsp;<?php echo $vendor['gender']; ?></li>
									<li><strong>Country:</strong>&nbsp;&nbsp;<?php echo $vendor['country_name']; ?></li> 
									<li><strong>State:</strong>&nbsp;&nbsp;<?php echo $vendor['state_name']; ?></li>
									<li><strong>City:</strong>&nbsp;&nbsp;<?php echo $vendor['city']; ?></li>
									<li><strong>Address:</strong>&nbsp;&nbsp;<?php echo $vendor['address1']; ?></li>
									<li><strong>Address1:</strong>&nbsp;&nbsp;<?php echo $vendor['address2']; ?></li>
                                </ul>
                          
                        </div>
                    </div>
                </div>
			</div>	

			<br><br><br>
			<div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 md-space"> 
				<span class="rounded-title" style="width: 100%; float: left; display: block;"><?php echo translate('horse_for_sell'); ?></span>
                <?php if(!empty($sell_products)){?> 
                <?php foreach($sell_products as $product){
                 ?>                  
                    <div class="col-md-4 col-sm-4 col-xs-12 product-list">
                        <ul class="photo-grid">
                            <li id="horse-name01">
                                
                                <figure>
                                <?php if(file_exists("uploads/product_image/product_".$product['product_id']."_1_thumb.jpg")){ ?>
                                    <img  src="/uploads/product_image/product_<?php echo $product['product_id']; ?>_1_thumb.jpg" alt="" class="img-responsive" />
                                    <?php }else { ?>
                                    <img src="/uploads/image-not-found.png" alt="Not image found" />
                                    <?php } ?>
                                    <figcaption>
                                        <div class="onhover-text">
                                            <span class="h-name01"><?php echo $product['title'] ; ?></span>
                                            <p class="h-age01">AGE - 
                                                <?php 
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
                                            ?>
                                            </p>
                                            <p><?php echo $description; ?></p>
                                            <a href="<?php echo base_url().'index.php/home/horse/'.$product['product_id']; ?>"><div class="see-card">         See Card</div></a>
                                        </div>
                                    </figcaption>
                                </figure>
                                <div id="horse-name01" class="horse-name">
									<?php 
                                    $counter_id = $product['country'];
                                    if(!empty($counter_id)){                                     
									$cat_query = "SELECT `country_name` FROM `country` WHERE `country_id` =".$counter_id;
									$catquery = $this->db->query($cat_query);
									$resArr  = $catquery->result_array();
									echo $resArr[0]['country_name'];
                                    }
									 ?>
                                    <span class="location"><?php if($user_login == 'yes' && !empty($user_id)){ echo floor($product['sale_price']);}?></span>
                                </div>
                            </li>                           
                        </ul>                       
                    </div>
                <?php } ?>    
                <?php }else{ ?>
                <div style="font-size: 25px;padding: 13px 3px 3px;text-align: center;"><span>No Record found.</span></div>
                    <?php  }  ?>
                </div>				
				<div class="clear"></div>
				<hr style="background: rgb(51, 51, 51) none repeat scroll 0% 0%; height: 2px;">
				<div class="col-md-12 col-sm-12 col-xs-12 md-space"> 
				<span class="rounded-title" style="width: 100%; float: left; display: block;"><?php echo translate('horse_for_breed'); ?></span>
                <?php if(!empty($breed_products)){?> 
                <?php foreach($breed_products as $product){
                 ?>                  
                    <div class="col-md-4 col-sm-4 col-xs-12 product-list">
                        <ul class="photo-grid">
                            <li id="horse-name01">
                                
                                <figure>
                                <?php if(file_exists("uploads/product_image/product_".$product['product_id']."_1_thumb.jpg")){ ?>
                                    <img  src="/uploads/product_image/product_<?php echo $product['product_id']; ?>_1_thumb.jpg" alt="" class="img-responsive" />
                                    <?php }else { ?>
                                    <img src="/uploads/image-not-found.png" alt="Not image found" />
                                    <?php } ?>
                                    <figcaption>
                                        <div class="onhover-text">
                                            <span class="h-name01"><?php echo $product['title'] ; ?></span>
                                            <p class="h-age01">AGE - 
                                                <?php 
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
                                            ?>
                                            </p>
                                            <p><?php echo $description; ?></p>
                                            <a href="<?php echo base_url().'index.php/home/horse/'.$product['product_id']; ?>"><div class="see-card">         See Card</div></a>
                                        </div>
                                    </figcaption>
                                </figure>
                                <div id="horse-name01" class="horse-name">
									<?php 
                                    $counter_id = $product['country'];
                                    if(!empty($counter_id)){                                     
									$cat_query = "SELECT `country_name` FROM `country` WHERE `country_id` =".$counter_id;
									$catquery = $this->db->query($cat_query);
									$resArr  = $catquery->result_array();
									echo $resArr[0]['country_name'];
                                    }
									 ?>
                                    <span class="location"><?php if($user_login == 'yes' && !empty($user_id)){ echo floor($product['sale_price']);}?></span>
                                </div>
                            </li>                           
                        </ul>                       
                    </div>
                <?php } ?>    
                <?php }else{ ?>
                <div style="font-size: 25px;padding: 13px 3px 3px;text-align: center;"><span>No Record found.</span></div>
                    <?php  }  ?>
                </div>	
				<div class="clear"></div>				
                </div>              
            </div>
    </section>  