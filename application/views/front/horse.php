 <!-- Header -->     
    <header class="inner-page-bg">
        <div class="container">
            <div class="inner-title">
                <p><?php echo $page_title; ?></p>
            </div>
        </div>
    </header>
    <!-- Breeding Starts -->
    <section class="section-03">
        <!-- Trelated -->
            <div class="container">
                <div class="row title-sp-in">
                    <div class="col-md-12 why-title md-space">                  
                        <div class="breeding-text">
                            <span class="inner-breeding">Horse</span>Your Dream Horse delivered to your door
                        </div>          
                    </div>              
                </div>
                
                <div class="row">               
                <div class="col-md-12 md-space">
                    <div class="col-md-4 ext-center">
                       <div class="ms-showcase2-template">
                        <div id="slider" class="flexslider" style="overflow:hidden;">
                        <?php
							$thumbs = $this->crud_model->file_view('product',$product->product_id,'','','thumb','src','multi','all');
							$mains = $this->crud_model->file_view('product',$product->product_id,'','','no','src','multi','all');
						?>
                          <ul class="slides" >
							<?php 
                                foreach ($mains as $row1) {
                            ?>
                                <li class="zoom">
                                  <img src="<?php echo $row1; ?>" class="img-responsive zoom" />
                                </li>
                            <?php 
                                }
                             ?>
                            <!-- items mirrored twice, total of 12 -->
                          </ul>
                        </div>
                        <!--<span id="zom" class="btn-u btn-u-xs btn-u-cust">
                        	<i class="fa fa-search-plus"></i> <?php echo translate('preview');?>
                        </span>-->
                        <?php
                        	if(count($mains) > 1){
						?>
                        <div id="carousel" class="flexslider" style="overflow:hidden;">
                          <ul class="slides" >
                            <?php
								$i = 0;
								foreach ($thumbs as $row1) {
							?>
								<li style="border:4px solid #fff;">
                                 <a class="fancybox-button zoomer" data-rel="fancybox-button" title="<?php echo $product->title.' ('.($i+1).')'; ?>" href="<?php echo $mains[$i]; ?>" ></a>
								  <img src="<?php echo $row1; ?>" />
                                  
								</li>
							<?php
								$i++;
								}
							 ?>
                             
                          </ul>
                        </div>
                        <script>
                            $( "#zom" ).click(function() {
                                $('.flex-active-slide').find('a').click();
                            });
                        </script>
                        <?php
                            } else if(count($mains) == 1) {
                        ?>
                            <a class="fancybox-button zoomer fancyier" data-rel="fancybox-button" title="<?php echo $product->title; ?>" href="<?php echo $mains[0]; ?>" ></a>
                            <script>
                                $( "#zom" ).click(function() {
                                    $('.fancyier').click();
                                });
                            </script>
                        <?php
                            }
                        ?>
                    </div>
                    </div>
                    <div class="col-md-8 product-title-in md-space">
                        <div class="col-md-6"><span class="rounded-title"><?php echo $product->title; ?></span></div>
						<div class="col-md-6 trial-box-text">
						<?php
						if ($product->status == 'sell') 
						{
							if ($this->session->userdata('user_login') == 'yes') 
							{ 	/* user testing login or not*/	
								/*check user shipping address*/
								$userinfo = $this->crud_model->getsiglefield('user','user_id',$this->session->userdata('user_id'));				
								$usercountry = $userinfo->country;
								$userstate = $userinfo->state;
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
								if($uzoneid != '' && $uzoneid !=0)
								{
									/*check horse shipping address*/
									$horsecountry = $product->country;
									$horsestate = $product->state;
									if($horsestate !='' && $horsestate > 0)
									{
										$zoneinfo = $this->crud_model->getdublefield('zone_area_division','country_id',$horsecountry,'state_id',$horsestate);
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
										$zoneinfo = $this->crud_model->getsiglefield('zone_area_division','country_id',$horsecountry);
										if(!empty($zoneinfo))
										{
											$pzoneid = $zoneinfo->zone_id;
										}
										else
										{
											$pzoneid =  '';
										}	 
									}
									if($pzoneid != '' && $pzoneid !=0)
									{
										$where = "(zone_id_1 = {$uzoneid} and zone_id_2 = {$pzoneid}) or (zone_id_2 = {$uzoneid} and zone_id_1 = {$pzoneid})";
										$this->db->select('price');
										$this->db->where($where);
										$query = $this->db->get('rates')->row();
										$zoneprice = $query->price;
										?>
										                           
										<span class="trial-price">Price - $<?php $horsetotalprice = $product->sale_price+$zoneprice+$product->commission; 
										$this->session->set_userdata('horsetotalprice',$horsetotalprice);
										$this->session->set_userdata('shipping_cost',$zoneprice);
										echo $horsetotalprice;
										?></span><span><a href="<?php echo base_url().'index.php/home/productterms/'.$product->product_id; ?>" class="cart-button">BUY THIS HORSE</a></span>
										<?php
									}
									else
									{
										?>
										<div class="col-md-12 trial-box-text">                           
										<span class="trial-price-msg">This Horse is not available for shipping.</span>	
										</div> 
										<?php
									}
								}else 
								{ ?>                                             
									<div class="col-md-12 trial-box-text">                           
										<span class="trial-price-msg">We can't ship horse on your current address. Please chose another country.</span>
									</div> 
									<?php 
								} 
						
							}else 
								{ ?>                                             
									<div class="col-md-12 trial-box-text">                           
										<span class="trial-price-msg">YOU MUST LOG IN AS USER TO SEE PRICES!</span>
									</div> 
									<?php 
								} 
                          
						}
                       
						else if ($product->status != 'sell' && $product->status != 'breeding')
						{ ?>
							<div class="col-md-12 trial-box-text">                           
								<span class="trial-price-msg">Horse currently not listed for sale or breeding.</span>
                            </div> 
							<?php
						}
						?>	
						</div>
						
						
						
						
						
						
						
						
						<?php $added_by = json_decode($product->added_by); 
							  if($added_by->type == 'vendor'){
								  $name = $this->db->get_where('vendor',array('vendor_id'=>$added_by->id))->row()->username;
								  $owner_name = '<a href="'.base_url().'index.php/home/vendor_detail/'.$added_by->id.'">'.$name.'</a>';
							  }else{
								  $owner_name = 'Admin';
							  }
						?>
						<div class="clear"></div>
						<div class="customer-text">
                            <?php echo $product->description; ?>
                        </div>
                        <div class="col-md-12">
                                <ul class="horse-detai-ul">
									<li><strong>AKA Registration Number:</strong>&nbsp;&nbsp;<?php echo $product->horse_code; ?> 
									<li><strong>Sex:</strong>&nbsp;&nbsp;<?php $genderinfo = $this->crud_model->getsiglefield('gender','gender_id',$product->gender); 
									if(!empty($genderinfo))
									{
											echo $genderinfo->gender.' - '.$genderinfo->gender_group;
									}
									
									?></li>
									<li><strong>Height(Height in hands):</strong>&nbsp;&nbsp;<?php echo $product->height; if($product->height != '') echo " hh"; ?></li> 
									<li><strong>Name:</strong>&nbsp;&nbsp;<?php echo $product->title; ?></li>
									<li><strong>Country of Birth:</strong>&nbsp;&nbsp;<?php echo $product->country_of_birth; ?></li>
									<li><strong>Date of Birth:</strong>&nbsp;&nbsp;<?php echo $product->date_of_birth; ?></li>
									<li><strong>Present Location:</strong>&nbsp;&nbsp;<?php $countryinfo = $this->crud_model->getsiglefield('country','country_id',$product->country); 
									echo $product->address.', '.$product->city.', '.$countryinfo->country_name; ?></li>
                                    <li><strong>Temperament:</strong>&nbsp;&nbsp;<?php echo $product->temperament; ?></li>
									<li><strong>Training:</strong>&nbsp;&nbsp;<?php echo $product->training; ?></li>
									<li><strong>Breeding history:</strong>&nbsp;&nbsp;<?php echo $product->breeding_history; ?></li>
									<li><strong>Notes:</strong>&nbsp;&nbsp;<?php echo $product->notes; ?></li>
									<li><strong>Sire:</strong>&nbsp;&nbsp;<?php echo $product->sire; ?></li>
									<li><strong>Dam:</strong>&nbsp;&nbsp;<?php echo $product->dam; ?></li>
									<li><strong>Grand Sire:</strong>&nbsp;&nbsp;<?php echo $product->grand_sire; ?></li>
									<li><strong>Grand Dam:</strong>&nbsp;&nbsp;<?php echo $product->grand_dam; ?></li>
									<li><strong>DNA Reg Number:</strong>&nbsp;&nbsp;<?php echo $product->dna_reg_number; ?></li>
									<li><strong>Colour Tested Results:</strong>&nbsp;&nbsp;<?php echo $product->color_tested_result; ?></li>
									<li><strong>Passport Number:</strong>&nbsp;&nbsp;<?php echo $product->passport_number; ?></li>
                                    <li><strong>Color:</strong>&nbsp;&nbsp;<?php 
                                         echo $product->color; 
                                        ?>
                                    </li>
                                </ul>
                          
                        </div>
                    </div>
                </div>
                </div>              
            </div>
    </section>  

<script>
	
	
	$(window).load(function() {
	<?php
		if(count($mains) > 1){
	?>
	  $('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		itemWidth: 100,
		itemMargin: 5,
		asNavFor: '#slider'
	  });
	<?php
		}
	?>
	 
	  $('#slider').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		slideshow: false,
		sync: "#carousel"
	  });
	});

	$(function(){
		$('.zoom').zoome({hoverEf:'transparent',showZoomState:true,magnifierSize:[200,200]});
	});
	
	function destroyZoome(obj){
		if(obj.parent().hasClass('zm-wrap'))
		{
			obj.unwrap().next().remove();
		}
	}
	
</script>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<script>
    $('body').on('click', '.quantity-button', function(){
        $('.add_to_cart').html('<i class="fa fa-shopping-cart"></i><?php echo translate('add_to_cart'); ?>');
    });
    $('body').on('change', '.optional', function(){
        $('.add_to_cart').html('<i class="fa fa-shopping-cart"></i><?php echo translate('add_to_cart'); ?>');
    });
</script>

<style>
    .heading_alt{
        font-size: 50px;
        font-weight: 100;
        color: #18BA9B;	
    }
</style>
	
    <!-- Breeding Ends -->