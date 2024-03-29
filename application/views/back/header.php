<header id="navbar">
    <div id="navbar-container" class="boxed">
        <!--Brand logo & name-->
        <div class="navbar-header">
            <a href="<?php echo base_url(); ?>index.php/<?php echo $this->session->userdata('title'); ?>" class="navbar-brand">
                <img src="<?php echo $this->crud_model->logo('admin_login_logo'); ?>" alt="<?php echo $system_name;?>" class="brand-icon" style="padding:8px;">
                <div class="brand-title">
                    <span class="brand-text"><?php echo $system_name;?></span>
                </div>
            </a>
        </div>
        <!--End brand logo & name-->

        <!--Navbar Dropdown-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">
                <!--Navigation toogle button-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle">
                        <i class="fa fa-navicon fa-lg"></i>
                    </a>
                </li>
                <!--End Navigation toogle button-->
            </ul>
            
            <ul class="nav navbar-top-links pull-right">
			<?php if ($this->session->userdata('title') == 'vendor') { ?>
			    <li>
                    <div class="lang-selected" style="margin-top:10px; margin-right: 20px">
                                <a data-target="#login" href="<?php echo base_url(); ?>index.php/home/#login" target="_blank" class="btn btn-default">
                                    <i class="fa fa-desktop"></i>  <?php echo translate('login_to_buy_a_horse');?> 
                                </a>
                    </div>
                </li>
			<?php } ?>	
                <li>
                    <div class="lang-selected" style="margin-top:10px;">
                                <a href="<?php echo base_url(); ?>" target="_blank" class="btn btn-default">
                                    <i class="fa fa-desktop"></i>  <?php echo translate('visit_home_page');?>
                                </a>
                    </div>
                </li>
                <li id="dropdown-user" class="dropdown">
                    <a href="<?php echo base_url(); ?>template/back/#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="pull-right">
                            <?php
                                if($this->session->userdata('title') == 'admin'){
                            ?>
                                <img class="img-circle img-user media-object" src="<?php echo base_url(); ?>template/back/img/av1.png" alt="Profile Picture">
                            <?php
                                } elseif ($this->session->userdata('title') == 'vendor') {
									$vendor_id = $this->session->userdata('vendor_id');
									$images = $this->crud_model->file_view('vendor',$vendor_id,'','','thumb','src','','all');
									if($images == ''){ $images = base_url().'template/back/img/av1.png'; }
                            ?>
                                <img class="img-circle img-user media-object" src="<?php echo $images; ?>" onerror="this.src='<?php echo base_url(); ?>template/back/img/av1.png'" alt="Profile Picture">
                            <?php
                                } 
                            ?>
                        </span>
                        <div class="username hidden-xs">
							<?php 
								if($this->session->userdata('title') == 'admin'){
									echo $this->session->userdata('admin_name');
								} elseif ($this->session->userdata('title') == 'vendor') {
									echo $this->session->userdata('vendor_name');	
								}
							?>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">
                        <!-- User dropdown menu -->
                        <ul class="head-list">
                            <li>
							<?php if($this->session->userdata('title') == 'admin'){ ?>
                                <a href="<?php echo base_url(); ?>index.php/admin/manage_admin/">
                                    <i class="fa fa-user fa-fw fa-lg"></i> <?php echo translate('profile');?>
                                </a>
							<?php }else{ ?>
								<a href="<?php echo base_url(); ?>index.php/vendor/manage_vendor/">
                                    <i class="fa fa-user fa-fw fa-lg"></i> <?php echo translate('profile');?>
                                </a>
							<?php } ?>	
                            </li>
                        </ul>

                        <!-- Dropdown footer -->
                        <div class="pad-all text-right">
                            <a href="<?php echo base_url(); ?>index.php/<?php echo $this->session->userdata('title'); ?>/logout/" class="btn btn-primary">
                                <i class="fa fa-sign-out fa-fw"></i> <?php echo translate('logout');?>
                            </a>
                        </div>
                    </div>
                </li>
                <!--End user dropdown-->
            </ul>
        </div>
    </div>
</header>