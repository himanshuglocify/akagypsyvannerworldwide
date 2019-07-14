<nav id="mainnav-container">
    <div id="mainnav">
        <!--Menu-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">
                        <!--Category name-->
                        <li class="list-header"></li>
            
                        <!--Menu list item-->
                        <li <?php if($page_name=="dashboard"){?> class="active-link" <?php } ?> 
                        	style="border-top:1px solid rgba(69, 74, 84, 0.7);">
                            <a href="<?php echo base_url(); ?>index.php/vendor/">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">
									<?php echo translate('dashboard');?>
                                </span>
                            </a>
                        </li>
                        
            			<?php
                        	if( $this->crud_model->vendor_permission('product') ){
						?>
                        <!--Menu list item-->
                        <li <?php if( $page_name=="product" ){?> class="active-sub" <?php } ?> >
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-title">
                                        <?php echo translate('my_listing');?>
                                    </span>
                                	<i class="fa arrow"></i>
                            </a>
            
                            <!--PRODUCT------------------>
                            <ul class="collapse <?php if( $page_name=="product" ){?>
                                                                 in
                                                                    <?php } ?> >" >
                                
                                <?php
                                 if($this->crud_model->vendor_permission('product')){
                                ?>
                                    <li <?php if($page_name=="product"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/vendor/product">
                                        	<i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('horse_list');?>
                                        </a>
                                    </li>
								<?php
									} 
                                ?>
                            </ul>
                        </li>
                      
            			<?php
							}
						?>  
                   		
                       <?php
                            if($this->crud_model->vendor_permission('business_settings')){
                        ?>
                        <li <?php if($page_name=="package"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/package/">
                                <i class="fa fa-gift"></i>
                                <span class="menu-title">
                                    <?php echo translate('my_membership');?>
                                </span>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                         <li <?php if($page_name=="sell_request"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/sell_request/">
                                <i class="fa fa-send"></i>
                                <span class="menu-title">
                                	<?php echo translate('sell_request');?>
                                </span>
                            </a>
                        </li>                       
                        <li <?php if($page_name=="manage_vendor"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/manage_vendor/">
                                <i class="fa fa-lock"></i>
                                <span class="menu-title">
                                	<?php echo translate('manage_vendor_profile');?>
                                </span>
                            </a>
                        </li>
						<?php
                            if($this->crud_model->vendor_permission('business_settings')){
                        ?>
                        <li <?php if($page_name=="business_settings"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/business_settings/">
                                <i class="fa fa-dollar"></i>
                                <span class="menu-title">
                                    <?php echo translate('payment_settings');?>
                                </span>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
						<li <?php if($page_name=="tutorial"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/vendor/tutorial/">
                                <i class="fa fa-youtube-play"></i>
                                <span class="menu-title">
                                	<?php echo translate('tutorials');?>
                                </span>
                            </a>
                        </li>
                </div>
            </div>
        </div>
    </div>
</nav>