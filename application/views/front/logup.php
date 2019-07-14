<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" id="close_logup_modal" class="close" type="button">×</button>
            <br>
        </div>
        <div class="modal-body">
            <!--Reg Block-->
            <div class="">
                <div class="reg-block-header">
                    <h2><?php echo translate('sign_up');?></h2>
                    <p style="font-weight:300 !important;"><?php echo translate('already_signed Up?_click');?><span class="color-purple"style="cursor:pointer" data-dismiss="modal" onclick="signin()" ><?php echo translate('sign_in');?></span> <?php echo translate('to_login_your_account');?></p>
                </div>
				<?php
				$countries = $this->db->get('country')->result_array();
				$states = $this->db->get('states')->result_array();
				
                    echo form_open(base_url() . 'index.php/home/registration/add_info/', array(
                        'class' => 'log-reg-v3 sky-form',
                        'method' => 'post',
                        'style' => 'padding:30px !important;',
                        'id' => 'login_form'
                    ));
					$fb_login_set = $this->crud_model->get_type_name_by_id('general_settings','51','value');
					$g_login_set = $this->crud_model->get_type_name_by_id('general_settings','52','value');
                ?>    
                <!-- first part of the form start here -->                           
                    <div class="win_one1" >
					<!-- name -->
					<section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="<?php echo translate('name*'); ?>" name="username" class="form-control cust_req 123" >
                            </div>
                        </label>
                    </section>
                <!-- surname -->
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="<?php echo translate('surname*'); ?>" name="surname" class="form-control cust_req" >
                            </div>
                        </label>
                    </section>
					
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" placeholder="<?php echo translate('email_address*'); ?>" name="email" class="form-control emails cust_req" >
                            </div>
                    		<div id='email_note'></div>
                        </label>
                    </section> 
					<!-- gender -->
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <select name="gender" class="form-control cust_req">
									<option value="">Select*</option>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
                            </div>
                        </label>
                    </section> 
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" placeholder="<?php echo translate('phone*'); ?>" name="phone" class="form-control cust_req">
                            </div>
                        </label>
                    </section> 
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('address_line_1*'); ?>" name="address1" class="form-control cust_req" >
                            </div>    
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('address_line_2'); ?>" name="address2" class="form-control">
                            </div>    
                        </label>
                    </section>
					
                    <section>
					
					<label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                               <select name="country" id="demo-hor-8" class="form-control cust_req" onChange="getState(this);">
								<option value="">Select Country*</option>
								<?php 
								foreach($countries as $country)
								{
									?>
									<option value="<?php echo $country['country_id'] ?>"><?php echo $country['country_name'] ?></option>
									<?php 
								}
								?>
								</select>
                            </div>    
                        </label>
					
                    </section>
					
					
					<section class="statebasedcountry1" style="display:none;">
					
					<label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                              <select name="state" id="demo-hor-9" >
									<option value="">Select State*</option>
									<?php 
									foreach($states as $state)
									{
										?>
										<option value="<?php echo $state['id'] ?>"><?php echo $state['name'] ?></option>
										<?php 
									}
									?>
									</select>
                            </div>    
                        </label>
					
                    </section>
					
					
					
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('city*'); ?>" name="city" class="form-control  cust_req" >
                            </div>  
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" placeholder="<?php echo translate('ZIP*'); ?>" name="zip" class="form-control cust_req">
                            </div> 
                        </label>
                    </section>
					<section>
                        <label class="input login-input no-border-top">
                            <div class="input-group validmsg">
                            </div> 
                        </label>
                    </section>
					  <!-- next button -->
					<section>
                      <button type="button" class="btn-u btn-u-default next-btn1" style="background:#a52618;"  onClick="nextWin1(this,'win_one1');" data-title="win_second1"  >Next</button>
                    </section>
					</div>


                    <!-- second part of the form start here  -->
					<div class="win_second1" style="display:none;" >
					<section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="<?php echo translate('dispaly_name*'); ?>" name="display_name" class="form-control cust_req" >
                            </div>    
                        </label>
                    </section>  
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('password*'); ?>" name="password1" class="form-control pass1 cust_req" >
                            </div>    
                        </label>
                    </section>
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('confirm_password*'); ?>" name="password2" class="form-control pass2 cust_req" >
                            </div>    
                    		<div id='pass_note'></div> 
                        </label>
                    </section>  
                   
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group validmsg">
                            </div> 
                        </label>
                    </section>
					
                    <div class="row margin-bottom-5">
                         <div class="col-xs-8">
                        <section>
                      <a  href="javascript:;"  class="btn-u btn-u-default" style="background:#a52618;" onClick="nextWin1(this,'win_second1');" data-title="win_one1" >Back</a>
                    </section>
                        </div>
                        <div class="col-xs-4 text-right">
                            <div class="btn-u btn-u-cust btn-block margin-bottom-20 reg_btn logup_btn" data-ing='<?php echo translate('registering..'); ?>' data-msg="" type="submit">
                            	<?php echo translate('register');?>
                            </div>
                        </div>
                    </div>
                    </div>
                                        
            		<?php if($fb_login_set == 'ok' || $g_login_set == 'ok'){ ?>
                    <div class="border-wings">
                        <span>or</span>
                    </div>
                    
                    <div class="row columns-space-removes">
                    <?php if($fb_login_set == 'ok'){ ?>
                        <div class="col-lg-6 <?php if($g_login_set !== 'ok'){ ?>mr_log<?php } ?> margin-bottom-10">
                        <?php if (@$user): ?>
                            <a href="<?= $url ?>" >
                                <div class="fb-icon-bg"></div>
                                    <div class="fb-bg"></div>
                            </a>
                        <?php else: ?>
                            <a href="<?= $url ?>" >
                                <div class="fb-icon-bg"></div>
                                    <div class="fb-bg"></div>
                            </a>
                        <?php endif; ?>
                        </div>
                   		<?php } if($g_login_set == 'ok'){ ?>     
                        <div class="col-lg-6 <?php if($fb_login_set !== 'ok'){ ?>mr_log<?php } ?>">
                        <?php if (@$g_user): ?>
                            <a href="<?= $g_url ?>" >
                                <div class="g-icon-bg"></div>
                                    <div class="g-bg"></div>
                            </a>							
                        <?php else: ?>
                            <a href="<?= $g_url ?>">
                                <div class="g-icon-bg"></div>
                                    <div class="g-bg"></div>
                            </a>
                        <?php endif; ?>
                        </div>
                    	<?php } ?>
                    </div>
                    <?php } ?>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn-u btn-u-default" type="button" id="clsreg" ><?php echo translate('close');?></button>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
	$('#registration').on('hidden.bs.modal', function () {
		$('body').removeClass('noScroll');
		$('html').removeClass('noScroll');
	});
	$('#registration').on('show.bs.modal', function () {
	   $('body').addClass('noScroll');
	   $('html').addClass('noScroll');
	});
	
	$(".pass2").blur(function(){
		var pass1 = $(".pass1").val();
		var pass2 = $(".pass2").val();
		if(pass1 !== pass2){
			$("#pass_note").html('<?php echo translate('password_mismatched'); ?>');
			 $(".reg_btn").attr("disabled", "disabled");
		} else if(pass1 == pass2){
			$("#pass_note").html('');
			$(".reg_btn").removeAttr("disabled");
		}
	});
	
	$(".emails").blur(function(){
		var email = $(".emails").val();
		$.post("<?php echo base_url(); ?>index.php/home/exists",
		{
			<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>',
			email: email
		},
		function(data, status){
			if(data == 'yes'){
				$("#email_note").html('*<?php echo 'email_already_registered'; ?>');
				 $(".reg_btn").attr("disabled", "disabled");
			} else if(data == 'no'){
				$("#email_note").html('');
				$(".reg_btn").removeAttr("disabled");
			}
		});
	});
	
	
	
	
	});
function getState(arg)
	{
		var countryid = $(arg).val();
		if(countryid == 230)
		{
			$('.statebasedcountry1').show();
			$('.statebasedcountry1 select').addClass('form-control'); 
			$('.statebasedcountry1 select').addClass('cust_req');
		}
		else
		{
			$('.statebasedcountry1').hide();
			$('.statebasedcountry1 select').removeClass('form-control');
			$('.statebasedcountry1 select').removeClass('cust_req');
		}
	
	}

	
	function nextWin1(arg,clss){
        var nextwin = jQuery(arg).attr('data-title');  
		var clnam = '.'+clss+' .cust_req';
		
		var validmsg = '';
		jQuery(clnam).each(function(){
			
			if(jQuery(this).val() == '')
			{
				validmsg = 1;
			}
			
		});
		
		if(validmsg != '')
		{
			 jQuery('.'+clss+' .validmsg').html('<p style="color:red;">* fields are required!</p>');
		}
		else{
			if(nextwin == 'win_one1'){
				jQuery('.'+nextwin).show();
				jQuery('.win_second1').hide();
			}else{
				jQuery('.'+nextwin).show();
				jQuery('.win_one1').hide();
			} 
		}
     
    }
   
    
  
</script>