
<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_site');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="tab-base tab-stacked-left">
                <ul class="nav nav-tabs">
                    <li class="active" >
                        <a data-toggle="tab" href="#demo-stk-lft-tab-1"><?php echo translate('general_settings');?></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-2"><?php echo translate('logo');?></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-3"><?php echo translate('favicon');?></a>
                    </li>
                    <li >
                        <a data-toggle="tab" href="#demo-stk-lft-tab-4"><?php echo translate('social_media');?></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-8"><?php echo translate('captcha_settings');?></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-6"><?php echo translate('terms_&_condition_market');?></a>
                    </li>
					<li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-20"><?php echo translate('terms_&_condition_member');?></a>
                    </li>
					<li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-21"><?php echo translate('terms_&_condition_breeding');?></a>
                    </li>
					<li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-22"><?php echo translate('terms_&_condition_dna');?></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#demo-stk-lft-tab-p"><?php echo translate('privacy_policy');?></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#demo-contact"><?php echo translate('contact_page');?></a>
                    </li>
                </ul>

                <div class="tab-content bg_grey">
                    <div id="demo-stk-lft-tab-1" class="tab-pane fade active in">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('general_settings');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/general_settings/set/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => 'gen_set',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo translate('system_name');?></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="system_name" value="<?php echo $this->crud_model->get_type_name_by_id('general_settings','1','value'); ?>"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ><?php echo translate('system_email');?></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="system_email" value="<?php echo $this->crud_model->get_type_name_by_id('general_settings','2','value'); ?>"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ><?php echo translate('system_title');?></label>
                                        <div class="col-sm-6">
                                            <input type="text" name="system_title" value="<?php echo $this->crud_model->get_type_name_by_id('general_settings','3','value'); ?>" class="form-control">
                                        </div>
                                    </div>
                                    
                                    <input type="hidden" id="nowslide">
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter" type="submit"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <span id="genset"></span>
                    <div id="demo-stk-lft-tab-2" class="tab-pane fade">
                        <div class="col-md-12 col-sm-12">
                             <div class="col-md-12">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo translate('upload_logo');?></h3>
                                </div>
                                <div class="form-group" id="drpzu">
                                    <label class="col-sm-1 control-label" for="demo-hor-inputemail"></label>
                                    <div class="col-sm-10" id="dropz"><?php include 'dropzone.php'; ?></div>
                                </div>
                             </div>
                         </div>
                         <br>
                         <div class="col-md-12 col-sm-12" style="margin-top:20px;">
                             <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo translate('all_logos');?></h3>
                                </div>
                                <div class="panel-body" id="list" >

                                </div>
                            </div>
                        </div>
                        <form >
                         <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo translate('select_logo');?></h3>
                                </div>
                                <?php
                                    $admin_login_logo = $this->db->get_where('ui_settings',array('type' => 'admin_login_logo'))->row()->value;
                                    $admin_nav_logo = $this->db->get_where('ui_settings',array('type' => 'admin_nav_logo'))->row()->value;
                                    $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
                                    $home_bottom_logo = $this->db->get_where('ui_settings',array('type' => 'home_bottom_logo'))->row()->value;
                                ?>
                                
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th><?php echo translate('place');?></th>
                                                <th><?php echo translate('logo');?></th>
                                                <th class="text-right"><?php echo translate('options');?></th>
                                            </tr>
                                        </thead>
                                            
                                        <tbody>
                                            <tr>
                                                <td><?php echo translate('admin_logo');?></td>
                                                <td>
                                                	<div class="inner-div tr-bg img-fixed">
                                                    	<img class="img-responsive img-sm" src="<?php echo base_url(); ?>uploads/logo_image/logo_<?php echo $admin_login_logo; ?>.png" id="admin_login_logo">
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <span class="btn btn-info btn-labeled fa fa-plus-circle" 
                                                        onclick="ajax_modal('show_all/selectable','<?php echo translate('select_logo'); ?>','<?php echo translate('successfully_selected!'); ?>','logo_set','admin_login_logo')">
                                                            <?php echo translate('change');?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php echo translate('homepage_header_logo');?></td>
                                                <td>
                                                	<div class="inner-div tr-bg img-fixed">
                                                    	<img class="img-responsive img-sm" src="<?php echo base_url(); ?>uploads/logo_image/logo_<?php echo $home_top_logo; ?>.png" id="home_top_logo" >
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <span class="btn btn-info btn-labeled fa fa-plus-circle" 
                                                        onclick="ajax_modal('show_all/selectable','<?php echo translate('select_logo'); ?>','<?php echo translate('successfully_selected!'); ?>','logo_set','home_top_logo')">
                                                            <?php echo translate('change');?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><?php echo translate('homepage_footer_logo');?></td>
                                                <td>
                                                	<div class="inner-div tr-bg img-fixed">
                                                    	<img class="img-responsive img-sm" src="<?php echo base_url(); ?>uploads/logo_image/logo_<?php echo $home_bottom_logo; ?>.png" id="home_bottom_logo" alt="User_Image" >
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <span class="btn btn-info btn-labeled fa fa-plus-circle" 
                                                        onclick="ajax_modal('show_all/selectable','<?php echo translate('select_logo'); ?>','<?php echo translate('successfully_selected!'); ?>','logo_set','home_bottom_logo')">
                                                            <?php echo translate('change');?>
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                             </div>         
                         </div>
                         </form>
                    </div>
                    
                    <!--UPLOAD : FAVICON---------->
                    <div id="demo-stk-lft-tab-3" class="tab-pane fade">
                         <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo translate('select_favicon');?></h3>
                                </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/favicon_settings/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="form-group margin-top-10">
                                    <label class="col-sm-3 control-label margin-top-10" for="demo-hor-inputemail">Favicon</label>
                                    <div class="col-sm-9">
                                        <div class="col-sm-2">
                                            <?php $ext =  $this->db->get_where('ui_settings',array('type' => 'fav_ext'))->row()->value;?>
                                            <img class="img-responsive img-md img-circle img-border" src="<?php echo base_url(); ?>uploads/others/favicon.<?php echo $ext; ?>" id="blah" >
                                        </div>
                                        <div class="col-sm-2">
                                        <span class="pull-left btn btn-default btn-file margin-top-10">
                                            <?php echo translate('select_favicon');?>
                                            <input type="file" name="fav" class="form-control" id="imgInp">
                                        </span>
                                        </div>
                                        <div class="col-sm-5"></div>
                                    </div>
                                </div>
                                <br />
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>	
                            </div>              
                        </div>
                    </div>
                    
                    <!--UPLOAD : SOCIAL LINKS---------->
                    <div id="demo-stk-lft-tab-4" class="tab-pane fade <?php if($tab_name=="social_links") {?>active in<?php } ?>">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('social_links');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/social_links/set/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <!--FACEBOOK---------->
                                    <div class="form-group mar-btm">
                                        <label class="col-sm-3 control-label"></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon fb_font">
                                                    <i class="fa fa-facebook-square fa-lg"></i>
                                                </span>
                                                <input type="text" name="facebook" value="<?php echo $this->crud_model->get_type_name_by_id('social_links','1','value'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!--G+---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon g_font">
                                                    <i class="fa fa-google-plus-square fa-lg"></i>
                                                </span>
                                                <input type="text" name="google-plus" value="<?php echo $this->crud_model->get_type_name_by_id('social_links','2','value'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!--TWITTER---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon tw_font">
                                                    <i class="fa fa-twitter-square fa-lg"></i>
                                                </span>
                                                <input type="text" name="twitter" value="<?php echo $this->crud_model->get_type_name_by_id('social_links','3','value'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!--PINTEREST---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon pin_font">
                                                    <i class="fa fa-pinterest fa-lg"></i>
                                                </span>
                                                <input type="text" name="pinterest" value="<?php echo $this->crud_model->get_type_name_by_id('social_links','5','value'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <!--YOUTUBE---------->
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" ></label>
                                        <div class="col-sm-6">
                                            <div class="input-group mar-btm">
                                                <span class="input-group-addon youtube_font">
                                                    <i class="fa fa-youtube fa-lg"></i>
                                                </span>
                                                <input type="text" name="youtube" value="<?php echo $this->crud_model->get_type_name_by_id('social_links','6','value'); ?>" id="demo-hor-inputemail" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--SAVE---------->
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--UPLOAD : SOCIAL LINKS END---------->                  
                    <div id="demo-stk-lft-tab-8" class="tab-pane fade">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-heading margin-bottom-15">
                                    <h3 class="panel-title"><?php echo translate('save');?><?php echo translate('captcha_settings'); ?></h3>
                                </div>
                                <?php $cpub =  $this->db->get_where('general_settings',array('type' => 'captcha_public'))->row()->value;?>
                                <?php $cprv =  $this->db->get_where('general_settings',array('type' => 'captcha_private'))->row()->value;?>
								<?php
                                    echo form_open(base_url() . 'index.php/admin/captcha_settings/', array(
                                        'class' => 'form-horizontal',
                                        'method' => 'post',
                                        'id' => '',
                                        'enctype' => 'multipart/form-data'
                                    ));
                                ?>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
											<?php echo translate('public_key');?>
                                            	</label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="cpub" value="<?php echo $cpub; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
											<?php echo translate('private_key');?>
                                            	</label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="cprv" value="<?php echo $cprv; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="panel-footer text-right">
                                        <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                            <?php echo translate('save');?>
                                        </span>
                                    </div>
                                </form> 
                            </div>                
                        </div>
                    </div>
                    
                    <div id="demo-stk-lft-tab-p" class="tab-pane fade">
                        <div class="panel">
                            <?php 
                                $privacy_policy =  $this->db->get_where('general_settings',array('type' => 'privacy_policy'))->row()->value;
                            ?>
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('privacy_policy');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/general_settings/privacy_policy/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <textarea class="summernotes" data-height='700' data-name='privacy_policy' ><?php echo $privacy_policy; ?></textarea>
                                    <!--===================================================-->
                                    <!-- End Summernote -->
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div id="demo-stk-lft-tab-6" class="tab-pane fade">
                        <div class="panel">
                            <?php 
                                $terms_conditions =  $this->db->get_where('general_settings',array('type' => 'terms_conditions'))->row()->value;
                            ?>
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('terms_&_condition');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/general_settings/terms/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <textarea class="summernotes" data-height='700' data-name='terms' ><?php echo $terms_conditions; ?></textarea>
                                    <!--===================================================-->
                                    <!-- End Summernote -->
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    
					     <div id="demo-stk-lft-tab-20" class="tab-pane fade">
                        <div class="panel">
                            <?php 
                                $terms_conditions_member =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_member'))->row()->value;
                            ?>
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('terms_&_condition_member');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/general_settings/terms_member/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <textarea class="summernotes" data-height='700' data-name='terms_member' ><?php echo $terms_conditions_member; ?></textarea>
                                    <!--===================================================-->
                                    <!-- End Summernote -->
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
					
					     <div id="demo-stk-lft-tab-21" class="tab-pane fade">
                        <div class="panel">
                            <?php 
                                $terms_conditions_breeding =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_breeding'))->row()->value;
                            ?>
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('terms_&_condition_breeding');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/general_settings/terms_breeding/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <textarea class="summernotes" data-height='700' data-name='terms_breeding' ><?php echo $terms_conditions_breeding; ?></textarea>
                                    <!--===================================================-->
                                    <!-- End Summernote -->
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
					  <div id="demo-stk-lft-tab-22" class="tab-pane fade">
                        <div class="panel">
                            <?php 
                                $terms_conditions_dna =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_dna'))->row()->value;
                            ?>
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('terms_&_condition_dna');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/general_settings/terms_dna/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    <textarea class="summernotes" data-height='700' data-name='terms_dna' ><?php echo $terms_conditions_dna; ?></textarea>
                                    <!--===================================================-->
                                    <!-- End Summernote -->
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
					
                    <div id="demo-contact" class="tab-pane fade">
                        <div class="panel">
                            <?php 
                                $contact_address =  $this->db->get_where('general_settings',array('type' => 'contact_address'))->row()->value;
                                $contact_phone =  $this->db->get_where('general_settings',array('type' => 'contact_phone'))->row()->value;
                                $contact_email =  $this->db->get_where('general_settings',array('type' => 'contact_email'))->row()->value;
								$website_support =  $this->db->get_where('general_settings',array('type' => 'website_support'))->row()->value;
								$sales_queries =  $this->db->get_where('general_settings',array('type' => 'sales_queries'))->row()->value;
								$generic_qustomer_support =  $this->db->get_where('general_settings',array('type' => 'generic_qustomer_support'))->row()->value;
								$breeding_queries =  $this->db->get_where('general_settings',array('type' => 'breeding_queries'))->row()->value;
                                $contact_website =  $this->db->get_where('general_settings',array('type' => 'contact_website'))->row()->value;
                                $contact_about =  $this->db->get_where('general_settings',array('type' => 'contact_about'))->row()->value;
                            ?>
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo translate('contact_page');?></h3>
                            </div>
							<?php
                                echo form_open(base_url() . 'index.php/admin/general_settings/contact', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post',
                                    'id' => '',
                                    'enctype' => 'multipart/form-data'
                                ));
                            ?>
                                <div class="panel-body">
                                    
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('contact_address'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="contact_address" value="<?php echo $contact_address; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('contact_phone'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="contact_phone" value="<?php echo $contact_phone; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('website_support_email'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="website_support" value="<?php echo $website_support; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
									
									
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('sales_queries_email'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="sales_queries" value="<?php echo $sales_queries; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('generic_qustomer_support_email'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="generic_qustomer_support" value="<?php echo $generic_qustomer_support; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('breeding_queries_email'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="breeding_queries" value="<?php echo $breeding_queries; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>									

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('information_office'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="contact_email" value="<?php echo $contact_email; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>										
									
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('contact_website'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <input type="text" name="contact_website" value="<?php echo $contact_website; ?>" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="demo-hor-inputemail">
                                            <?php echo translate('contact_about'); ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <div class="col-sm-">
                                                <textarea class="summernotes" data-height='400' data-name='contact_about'><?php echo $contact_about; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="btn btn-success btn-labeled fa fa-check submitter"  data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>'>
                                        <?php echo translate('save');?>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>           
                </div>
            </div>
        </div>
    </div>
</div>
<div style="display:none;" id="site"></div>
<!-- for logo settings -->
<script>
    function load_logos(){
        ajax_load('<?php echo base_url(); ?>index.php/admin/logo_settings/show_all','list','');
    }
    function load_dropzone(){
        //$('#dropz').remove();
        //$('#drpzu').append('<div class="col-sm-10" id="dropz"></div>');
        //$('#dropz').load('<?php echo base_url(); ?>index.php/admin/load_dropzone');
        // DROPZONE.JS
        // =================================================================
        // Require Dropzone
        // http://www.dropzonejs.com/
        // =================================================================
        Dropzone.options.demoDropzone = { // The camelized version of the ID of the form element
            // The configuration we've talked about above
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 25,
            maxFiles: 25,
    
            // The setting up of the dropzone
            init: function() {
                var myDropzone = this;
                this.on("queuecomplete", function (file) {
                    load_logos();
                });
            }
        }
        load_logos();
    }

	$(document).ready(function() {
		
        $('.summernotes').each(function() {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            now.closest('div').append('<input type="hidden" class="val" name="'+n+'">');
            now.summernote({
                height: h,
                onChange: function() {
                    now.closest('div').find('.val').val(now.code());
                }
            });
			now.closest('div').find('.val').val(now.code());
			now.focus();
        });
        load_dropzone();
        load_logos();
		
	});

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#wrap').hide('fast');
                $('#blah').attr('src', e.target.result);
                $('#wrap').show('fast');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });


    var base_url = '<?php echo base_url(); ?>'
    var user_type = 'admin';
    var module = 'logo_settings';
    var list_cont_func = 'show_all';
    var dlt_cont_func = 'delete_logo';
</script>
<!-- for logo settings -->



<script type="text/javascript">

    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    });



    $(".range-def").on('slide', function(){
        var vals    = $("#nowslide").val();
        $(this).closest(".form-group").find(".range-def-val").html(vals);
        $(this).closest(".form-group").find("input").val(vals);
    });

    function sets(now){
        $(".range-def").each(function(){
            var min = $(this).data('min');
            var max = $(this).data('max');
            var start = $(this).data('start');
            $(this).noUiSlider({
                start: Number(start) ,
                range: {
                    'min': Number(min),
                    'max': Number(max)
                }
            }, true);
            if(now == 'first'){
                $(this).noUiSlider({
                    start: 500 ,
                    connect : 'lower',
                    range: {
                        'min': 0 ,
                        'max': 10
                    }
                },true).Link('lower').to($("#nowslide"));
                $(this).closest(".form-group").find(".range-def-val").html(start);
                $(this).closest(".form-group").find("input").val(start);
            } else if(now == 'later'){
                var than = $(this).closest(".form-group").find(".range-def-val").html();
                
                if(than !== 'undefined'){
                    $(this).noUiSlider({
                        start: than,
                        connect : 'lower',
                        range: {
                            'min': min ,
                            'max': max
                        }
                    },true).Link('lower').to($("#nowslide"));
                } 
                $(this).closest(".form-group").find(".range-def-val").html(than);
                $(this).closest(".form-group").find("input").val(than);
            }
        });
    }
	$(document).ready(function() {
        sets('later');
		$("form").submit(function(e){
			return false;
		});

	});
</script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js">
</script>
<style>
.img-fixed{
	width: 100px;	
}
.tr-bg{
background-image: url(http://www.mikechambers.com/files/html5/canvas/exportWithBackgroundColor/images/transparent_graphic.png)	
}

.cc-selector input{
    margin:0;padding:0;
    -webkit-appearance:none;
       -moz-appearance:none;
            appearance:none;
}
 
.cc-selector input:active +.drinkcard-cc
{
	opacity: 1;
	border:4px solid #169D4B;
}
.cc-selector input:checked +.drinkcard-cc{
	-webkit-filter: none;
	-moz-filter: none;
	filter: none;
	border:4px solid black;
}
.drinkcard-cc{
	cursor:pointer;
	background-size:contain;
	background-repeat:no-repeat;
	display:inline-block;
	-webkit-transition: all 100ms ease-in;
	-moz-transition: all 100ms ease-in;
	transition: all 100ms ease-in;
	-webkit-filter:opacity(.3);
	-moz-filter:opacity(.3);
	filter:opacity(.3);
	transition: all .6s ease-in-out;
	border:4px solid transparent;
	border-radius:5px !important;
}
.drinkcard-cc:hover{
	-webkit-filter:opacity(1);
	-moz-filter: opacity(1);
	filter:opacity(1);
	transition: all .6s ease-in-out;
	border:4px solid #8400C5;
			
}

</style>

