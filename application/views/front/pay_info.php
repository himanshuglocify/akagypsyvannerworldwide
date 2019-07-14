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
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 why-title md-space">                  
                    <div class="breeding-text">
                        <span class="inner-breeding"><?php echo $page_title; ?></span> 
                    </div>          
                </div>              
            </div> 
            <div><p><br/></br/>Once deposit of 20% will be completed. Our Sales department will contact you in next 24 hours, to agree details of the delivery. To continue please add your Phone number and submit the form. </p></div>
                                
            <div class="row md-space">                              
                
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-xs-10 md-space" style="padding-top:30px;">
                    <div class="col-md-10">
                    <form role="form" class="form-horizontal" action="<?php echo base_url(); ?>index.php/home/checkout/go" method="post">
                        <div class="form-area">  
                          <input type="hidden" name="payment_type" value="paypal" >  
                          <?php $imgUrl = base_url().'uploads/product_image/product_'.$product->product_id.'_1_thumb.jpg'; ?>
                          <input type="hidden" name="p_image" value="<?php echo $imgUrl; ?>">
                          <input type="hidden" name="p_id" value="<?php echo $product->product_id; ?>">
                            <br style="clear:both">
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="name">Horse Name :</label> 
                                     <div class="col-sm-9"><input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $product->title; ?>" readonly required>
                                   </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label col-sm-3" for="code">Horse code</label>
                                  <div class="col-sm-9"><input type="text" class="form-control" id="product_code" name="product_id" value="<?php echo $product->horse_code; ?>" readonly  ></div>
                                </div>
                                <div class="form-group">
                                 <label class="control-label col-sm-3" for="final_price">Final Price </label>
                                 <div class="col-sm-9"> <input type="text" class="form-control" id="price" name="price" value="<?php echo $this->session->userdata('horsetotalprice'); ?>" readonly  ></div>
                                </div>
								<!--<div class="form-group">
                                 <div class="col-md-3">Horse Commission </div>
                                 <div class="col-md-9"> <input type="text" class="form-control" id="commission" name="commission" value="<?php echo $product->commission; ?>" readonly  ></div>
                                </div>
								<div class="form-group">
                                 <div class="col-md-3">Horse Shipping Cost </div>
                                 <div class="col-md-9"> <input type="text" class="form-control" id="shipping_cost" name="shipping_cost" value="<?php echo $this->session->userdata('shipping_cost'); ?>" readonly  ></div>
                                </div>-->
                                <div class="form-group">
                                 <label class="control-label col-sm-3" for="payable">Payable 20% Amount:</label>
								 <div class="col-sm-9"> <strong style="float: left; padding-top: 8px;">$ <?php echo ($this->session->userdata('horsetotalprice')*20)/100; 
								 ?></strong></div>
                               </div>     
                                
                        </div>
<!-- user details --><br /> 
                <h4>User Info</h4>
				<br>
                    <div class="form-area">  
                                <div class="form-group">
                                     <label class="control-label col-sm-3" for="uname">User Name : </label> 
                                     <div class="col-sm-9"><input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $userinfo->surname; ?>"  readonly required></div>
                                    
                                </div>
                                     <input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo $userinfo->user_id; ?>" required>
                                <div class="form-group">
                                     <label class="control-label col-sm-3" for="email">Email :</label> 
                                     <div class="col-sm-9"><input type="text" class="form-control" id="email" name="email" value="<?php echo $userinfo->email; ?>" readonly  required></div>
                                </div>
                                 <div class="form-group">
                                     <label class="control-label col-sm-3" for="phone">Phone : </label> 
                                     <div class="col-sm-9"><input type="text" class="form-control" id="phone" name="phone" value="<?php echo $userinfo->phone; ?>" required></div>
                                    
                                </div>
                                 
                                <div class="form-group">
                                     <label class="control-label col-sm-3" for="address1">Address 1 : </label> 
                                     <div class="col-sm-9"><input type="text" class="form-control" id="address1" name="address1" value="<?php echo $userinfo->address1; ?>" readonly required></div>
                                    
                                </div>
                                <div class="form-group">
                                     <label class="control-label col-sm-3" for="address2">Address 2 : </label> 
                                     <div class="col-sm-9"> <input type="text" class="form-control" id="address2" name="address2" value="<?php echo $userinfo->address2; ?>" readonly required></div>
                                   
                                </div>
                                <div class="form-group">
                                     <label class="control-label col-sm-3" for="city">City : </label> 
                                     <div class="col-sm-9"> <input type="text" class="form-control" readonly id="city" name="city" value="<?php echo $userinfo->city; ?>" required></div>
                                   
                                </div>
								<?php if($userinfo->state != '' && $userinfo->state != 0) { ?>
                                     <div class="form-group">
                                     <label class="control-label col-sm-3" for="state">State : </label> 
                                     <div class="col-sm-9"> <input type="text" class="form-control" readonly id="state" name="state" value="<?php $state =array(); $state = $this->crud_model->getsiglefield('states','id',$userinfo->state); 
									 echo $state->name;  ?>" ></div>
                                   
                                </div>
								<?php } ?>
                                <div class="form-group">
                                     <label class="control-label col-sm-3" for="code">Country : </label> 
                                     <div class="col-sm-9"> <input type="text" class="form-control" readonly id="country" name="country" value="<?php $country=$this->crud_model->getsiglefield('country','country_id',$userinfo->country);echo $country->country_name; ?>" ></div>
                                   
                                </div>
                                <div class="form-group">
                                     <label class="control-label col-sm-3" for="code">Zip : </label> 
                                     <div class="col-sm-9"><input type="text" class="form-control" readonly id="zip" name="zip" value="<?php echo $userinfo->zip; ?>" ></div>
                                    
                                </div>
                             <input type="hidden" value="<?php echo $this->security->get_csrf_hash();?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" >

                                
                            <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right term-button">Submit Form</button>
                            
                        </div>
</form>

                    </div>
                
                    
                </div>
            </div>
        </div>
    </section>          
    <!-- Breeding Ends -->
    