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
                            <a href="<?php echo base_url(); ?>index.php/admin/">
                                <i class="fa fa-tachometer"></i>
                                <span class="menu-title">
									<?php echo translate('dashboard');?>
                                </span>
                            </a>
                        </li>
                        
            			<?php
                        	if($this->crud_model->admin_permission('category') ||
								$this->crud_model->admin_permission('product') || 
										$this->crud_model->admin_permission('stock') ){
						?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="category" || 
                                          $page_name=="product" || 
                                                $page_name=="stock" ){?>
                                                     class="active-sub" 
                                                        <?php } ?> >
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-title">
                                        <?php echo translate('listing_management');?>
                                    </span>
                                	<i class="fa arrow"></i>
                            </a>
            
                            <!--PRODUCT------------------>
                            <ul class="collapse <?php if($page_name=="category" || 
                                                               $page_name=="product" || 
                                                                        $page_name=="stock" ){?>
                                                                             in
                                                                                <?php } ?> >" >
                                
								<?php
                                    if($this->crud_model->admin_permission('category')){
                                ?>                                            
                                    <li <?php if($page_name=="category"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/admin/category">
                                        	<i class="fa fa-circle fs_i"></i>
                                        		<?php echo translate('categories');?>
                                        </a>
                                    </li>
								<?php
									} if($this->crud_model->admin_permission('product')){
                                ?>
                                    <li <?php if($page_name=="product"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/admin/product">
                                        	<i class="fa fa-circle fs_i"></i>
                                            	<?php echo translate('all_listing');?>
                                        </a>
                                    </li>
								<?php
									} /*if($this->crud_model->admin_permission('stock')){
                                ?>
                                    <li <?php if($page_name=="stock"){?> class="active-link" <?php } ?> >
                                        <a href="<?php echo base_url(); ?>index.php/admin/stock">
                                        	<i class="fa fa-circle fs_i"></i>
                                        		<?php echo translate('product_stock');?>
                                        </a>
                                    </li>
								<?php
									}*/
                                ?>
                            </ul>
                        </li>
                      
            			<?php
							}
						?>  
                        
                        <!--SALE-------------------->
						<?php 
							if($this->crud_model->admin_permission('sale')){
						?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="sales"){?> class="active-link" <?php } ?>>
                            <a href="<?php echo base_url(); ?>index.php/admin/sales/">
                                <i class="fa fa-usd"></i>
                                    <span class="menu-title">
                                		<?php echo translate('sale');?>
                                    </span>
                            </a>
                        </li>
                        <?php
							} 
						?>
                    
                        <?php 
                            if($this->crud_model->admin_permission('user')){
                        ?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="user"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/user/">
                                <i class="fa fa-users"></i>
                                    <span class="menu-title">
                                        <?php echo translate('customers');?>
                                    </span>
                            </a>
                        </li>
                        <!--Menu list item-->
                        <?php
                            } 
                        ?>
                         <?php 
                            if($this->crud_model->admin_permission('sellrequest')){
                        ?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="sellrequest"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/sellrequest/">
                                <i class="fa fa-users"></i>
                                    <span class="menu-title">
                                        <?php echo translate('sell_request');?>
                                    </span>
                            </a>
                        </li>
                        <!--Menu list item-->
                        <?php
                            } 
                        ?>
                        <?php 
                            if($this->crud_model->admin_permission('vendor') ||
                                $this->crud_model->admin_permission('membership_payment') ||
                                    $this->crud_model->admin_permission('membership')){
                        ?>
                        <!--Menu list item-->
                        <li <?php if($page_name=="vendor" || 
                                        $page_name=="membership_payment" ||
                                            $page_name=="membership" ){?>
                                                     class="active-sub" 
                                                        <?php } ?>>
                            <a href="#">
                                <i class="fa fa-user-plus"></i>
                                    <span class="menu-title">
                                        <?php echo translate('vendors');?>
                                    </span>
                                        <i class="fa arrow"></i>
                            </a>
                            
                            <!--REPORT-------------------->
                            <ul class="collapse <?php if($page_name=="vendor" || 
                                                            $page_name=="membership_payment" || $page_name=="membership" ){?>in <?php } ?> ">
                                <li <?php if($page_name=="vendor"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/vendor/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('vendor_list');?>
                                    </a>
                                </li>
                                <li <?php if($page_name=="membership_payment"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/membership_payment/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('membership_payments');?>
                                    </a>
                                </li>
                              <!--  <li <?php if($page_name=="membership"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/membership/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('membership_type');?>
                                    </a>
                                </li>-->
                            </ul>
                        </li>
                        <?php
                            } 
                        ?>
						<?php 
                            if($this->crud_model->admin_permission('zone') ||
                                $this->crud_model->admin_permission('country')){
                        ?>
                        
                        <li <?php if($page_name=="zone" || 
                                        $page_name=="country" ||
                                            $page_name=="state" ){?>
                                                     class="active-sub" 
                                                        <?php } ?>>
                            <a href="#">
                                <span class="menu-title">
                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                    <?php echo translate('zones'); ?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
                            
                            <ul class="collapse <?php if($page_name=="zone" || 
                                                            $page_name=="country" || $page_name=="state" || $page_name=="rate" ){?>in <?php } ?>">
                                
                                <li <?php if($page_name=="zone"){?> class="active-link" <?php } ?>>
                                    <a href="<?php echo base_url(); ?>index.php/admin/zone/">
                                        <i class="fa fa-circle fs_i"></i>
                                        <?php echo translate('zone_list'); ?>
                                    </a>
                                </li>
                                
                                <li <?php if($page_name=="country"){?> class="active-link" <?php } ?>>
                                    <a href="<?php echo base_url(); ?>index.php/admin/country/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('countries');?>
                                    </a>
                                </li>
                                
                                <li <?php if($page_name=="state"){?> class="active-link" <?php } ?>>
                                    <a href="<?php echo base_url(); ?>index.php/admin/state/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('states');?>
                                    </a>
                                </li>
                                
                                
                                
                                <li <?php if($page_name=="rate"){?> class="active-link" <?php } ?>>
                                    <a href="<?php echo base_url(); ?>index.php/admin/rate/">
                                        <i class="fa fa-circle fs_i"></i>
                                            <?php echo translate('rates');?>
                                    </a>
                                </li>
                                
                            </ul>
                        </li>
                        
                         <?php
                            } 
                        ?>                         
                        <?php 
                            if($this->crud_model->admin_permission('page')){
                        ?>                      
                            <li <?php if($page_name=="widget"){?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/widget/">
                                    <i class="fa fa-file-text"></i>
                                    <span class="menu-title">
                                        <?php echo translate('widgets');?>
                                    </span>
                                </a>
                            </li>
                        <?php
                            } 
                        ?>

                        <?php 
                            if($this->crud_model->admin_permission('page')){
                        ?>                      
                            <li <?php if($page_name=="page"){?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/page/">
                                    <i class="fa fa-file-text"></i>
                                    <span class="menu-title">
                                        <?php echo translate('create_new_page');?>
                                    </span>
                                </a>
                            </li>
                        <?php
                            } 
                        ?>
                        <?php  
                            if($this->crud_model->admin_permission('slider')){
                        ?>
                            <!--Menu list item-->
                            <li <?php if($page_name=="slider"){?> class="active-link" <?php } ?> >
                                <a href="<?php echo base_url(); ?>index.php/admin/slider/">
                                    <i class="fa fa-sliders"></i>
                                    <span class="menu-title">
                                        <?php echo translate('create_slider');?>
                                    </span>
                                </a>
                            </li>
                            <!--Menu list item-->
                        <?php
                            }  
                        ?>
            			<?php 
                        	if($this->crud_model->admin_permission('site_settings')){
						?>                   
							<li <?php if($page_name=="site_settings"){?> class="active-link" <?php } ?> >
								<a href="<?php echo base_url(); ?>index.php/admin/site_settings/general_settings/">
									<i class="fa fa-desktop"></i>
										<?php echo translate('site_settings');?>
								</a>
							</li>
						<?php
                            } 
                        ?>
                        
                        
            			<?php /*
                        	if($this->crud_model->admin_permission('role') ||
								$this->crud_model->admin_permission('admin') ){
						?>
                        <li <?php if($page_name=="role" || 
                                        $page_name=="admin" ){?>
                                             class="active-sub" 
                                                <?php } ?> >
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span class="menu-title">
                                	<?php echo translate('staffs');?>
                                </span>
                                <i class="fa arrow"></i>
                            </a>
            
                            <ul class="collapse <?php if($page_name=="admin" || 
															$page_name=="role"){?>
                                                                 in
                                                                    <?php } ?>" >
                                
								<?php
                                    if($this->crud_model->admin_permission('admin')){
                                ?>
                                <li <?php if($page_name=="admin"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/admins/">
                                        <i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('all_staffs');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                                <?php
                                    if($this->crud_model->admin_permission('role')){
                                ?>
                                <!--Menu list item-->
                                <li <?php if($page_name=="role"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/role/">
                                        <i class="fa fa-circle fs_i"></i>
                                        	<?php echo translate('staff_permissions');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </li>
						<?php
                            } */
                        ?>
                        <?php
                            if($this->crud_model->admin_permission('contact_message')){
                                ?>
                                <li <?php if($page_name=="contact_message"){?> class="active-link" <?php } ?> >
                                    <a href="<?php echo base_url(); ?>index.php/admin/contact_message">
                                        <i class="fa fa-envelope"></i>
                                        	<?php echo translate('contact_messages');?>
                                    </a>
                                </li>
                                <?php
                                    }
                                ?>
            			

                        <?php /*
                            if($this->crud_model->admin_permission('seo')){
                        ?>
                        <li <?php if($page_name=="seo_settings"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/seo_settings">
                                <i class="fa fa-search-plus"></i>
                                <span class="menu-title">
                                    SEO
                                </span>
                            </a>
                        </li>
                        <?php
                            } */
                        ?>
                        
                        <?php /*
                            if($this->crud_model->admin_permission('language')){
                        ?> 
                        <li <?php if($page_name=="language"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/language_settings">
                                <i class="fa fa-language"></i>
                                <span class="menu-title">
                                    <?php echo translate('language');?>
                                </span>
                            </a>
                        </li>
                        <?php
                            } */
                        ?>
                        
                        
                        <?php
						
							if($this->crud_model->admin_permission('business_settings')){
						?>
                        <li <?php if($page_name=="business_settings"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/business_settings/">
                                <i class="fa fa-briefcase"></i>
                                <span class="menu-title">
                                	<?php echo translate('payment_settings');?>
                                </span>
                            </a>
                        </li>
                        <?php
							} 
						?>
                        
                   <li <?php if($page_name=="manage_admin"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/manage_admin/">
                                <i class="fa fa-lock"></i>
                                <span class="menu-title">
                                	<?php echo translate('manage_admin_profile');?>
                                </span>
                            </a>
                   </li> 
				  <li <?php if($page_name=="tutorial"){?> class="active-link" <?php } ?> >
                            <a href="<?php echo base_url(); ?>index.php/admin/tutorial/">
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