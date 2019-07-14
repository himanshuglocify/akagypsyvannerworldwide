<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" id="v_close_logup_modal" class="close" type="button">×</button>
            <br>
        </div>
        <div class="modal-body">
            <!--Reg Block-->
            <div class="">
                <div class="reg-block-header">
                    <h2><?php echo translate('be_a_seller');?></h2>
                    <p style="font-weight:300 !important;"><?php echo translate('already_a_seller?');?> <?php echo translate('click'); ?> <a class="color-purple" href="<?php echo base_url(); ?>index.php/vendor" ><?php echo translate('sign_in');?></a> <?php echo translate('to_login_your_account');?></p>
                </div>
				<?php
				$countries = $this->db->get('country')->result_array();
				$states = $this->db->get('states')->result_array();
				
                    echo form_open(base_url() . 'index.php/home/vendor_logup/add_info/', array(
                        'class' => 'log-reg-v3 sky-form',
                        'method' => 'post',
                        'style' => 'padding:30px !important;',
                        'id' => 'login_form'
                    ));
                ?> 
                <!-- first part of the form start here -->                           
                    <div class="win_one" >
                <!-- name -->
					<section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="<?php echo translate('name'); ?>" name="name" class="form-control cust_req" >
                            </div>
                        </label>
                    </section>
                <!-- surname -->
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" placeholder="<?php echo translate('surname'); ?>" name="surname" class="form-control cust_req" >
                            </div>
                        </label>
                    </section>
                    <!-- email -->
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" placeholder="<?php echo translate('email_address'); ?>" name="email" class="form-control cust_req" >
                            </div>
                        </label>
                    </section> 
					<!-- gender -->
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <select name="gender" class="form-control cust_req">
									<option value="">Select</option>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
                            </div>
                        </label>
                    </section> 
                    <!-- company -->
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                <input type="text" placeholder="<?php echo translate('company'); ?>" name="company" class="form-optional cust_req" >
                            </div>
                        </label>
                    </section>
                    <!-- ADDRESS1 -->
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('address_line_1'); ?>" name="address1" class="form-control cust_req" >
                            </div>    
                        </label>
                    </section> 
                    <!-- address2 -->
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('address_line_2'); ?>" name="address2" class="form-control">
                            </div>    
                        </label>
                    </section>
                   <!-- country -->  
                   <section>                    
                    <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                               <select name="country" id="demo-hor-7" class="form-control cust_req" onChange="getState(this);">
                                <option value="">Select Country</option>
                                <?php foreach($countries as $country){?>
                                    <option value="<?php echo $country['country_id'] ?>"><?php echo $country['country_name'] ?></option>
                                <?php } ?>
                                </select>
                            </div>    
                        </label>                    
                    </section>
                    <!-- state -->  
                  <section class="statebasedcountry" style="display:none;">                    
                    <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                              <select name="state" id="demo-hor-17" class="">
                                    <option value="">Select State</option>
                                    <?php foreach($states as $state){?>
                                        <option value="<?php echo $state['id'] ?>"><?php echo $state['name'] ?></option>
                                    <?php } ?>
                                    </select>
                            </div>    
                        </label>                    
                    </section> 
                    <!-- city -->
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('city'); ?>" name="city" class="form-control cust_req" >
                            </div>  
                        </label>
                    </section>
                    <!-- zip -->
                    <section>
                        <label class="input login-input">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <input type="text" placeholder="<?php echo translate('zip'); ?>" name="zip" class="form-control cust_req" >
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
                      <button type="button" class="btn-u btn-u-default next-btn" onClick="nextWin(this,'win_one');" data-title="win_second" style="background:#a52618;" >Next</button>
                    </section>
					</div>


                    <!-- second part of the form start here  -->
					<div class="win_second" style="display:none;" >

                    <!-- display name -->
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-desktop"></i></span>
                                <input type="text" placeholder="<?php echo translate('display_name'); ?>" name="display_name" class="form-control cust_req" >
                            </div>    
                        </label>
                    </section>
                    <!-- password -->
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('password'); ?>" name="password1" class="form-control cust_req" >
                            </div>    
                        </label>
                    </section>
                    <!-- confirm password -->
                    <section>
                        <label class="input login-input no-border-top">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="password" placeholder="<?php echo translate('confirm_password'); ?>" name="password2" class="form-control cust_req" >
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
                    <!-- back button -->
                    <div class="row margin-bottom-5">
                        <div class="col-xs-8">
                        <section>
                      <a  href="javascript:;"  class="btn-u btn-u-default" onClick="nextWin(this,'win_second');" data-title="win_one" >Back</a>
                    </section>
                        </div>
                        <div class="col-xs-4 text-right">
                            <div class="btn-u btn-u-cust btn-block margin-bottom-20 reg_btn v_logup_btn" data-ing='<?php echo translate('registering..'); ?>' data-msg="" type="submit">
                            	<?php echo translate('register');?>
                            </div>
                        </div>
                    </div>
				</div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn-u btn-u-default" type="button" id="v_clsreg" ><?php echo translate('close');?></button>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
	$('#v_registration').on('hidden.bs.modal', function () {
		$('body').removeClass('noScroll');
		$('html').removeClass('noScroll');
	});
	$('#v_registration').on('show.bs.modal', function () {
	   $('body').addClass('noScroll');
	   $('html').addClass('noScroll');
	});
	});
    var logup_success = '<?php echo translate('registration_successful!'); ?> <?php echo translate('you_need_to_accept_term_and_conditions_to_get_approved_your_account'); ?>';
        function isJson(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
        }
    $('body').on('click','.v_logup_btn',function(){
        var here = $(this); // alert div for show alert message
        var form = here.closest('form');
        var can = '';
        var ing = here.data('ing');
        var msg = here.data('msg');
        var prv = here.html();
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: formdata ? formdata : form.serialize(), // serialize form data 
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                here.html(ing); // change submit button text
            },
            success: function(data) {
             here.fadeIn();
                here.html(prv);
                if($.trim(data) == 'done'){
                   /* here.closest('.modal-content').find('#v_close_logup_modal').click();*/
                    notify(logup_success,'success','bottom','right'); 
                    sound('successful_logup');      
					window.location.href= '<?php echo base_url().'index.php/home/memberterm'; ?>';
                } else {
                    //here.closest('.modal-content').find('#v_close_logup_modal').click();
                    notify(logup_fail+'<br>'+data,'warning','bottom','right');
                    //vend_logup();
                    sound('unsuccessful_logup');
                }
            },
            error: function(e) {
                console.log(e)
            }
        });
    });

 
	function nextWin(arg,clss){
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
			 jQuery('.'+clss+' .validmsg').html('');
			if(nextwin == 'win_one'){
				jQuery('.'+nextwin).show();
				jQuery('.win_second').hide();
			}else{
				jQuery('.'+nextwin).show();
				jQuery('.win_one').hide();
			} 
		}
     
    }
 function getState(arg)
	{
		var countryid = $(arg).val();
		if(countryid == 230)
		{
			$('.statebasedcountry').show();
			$('.statebasedcountry select').addClass('form-control'); 
			$('.statebasedcountry select').addClass('cust_req');
		}
		else
		{
			$('.statebasedcountry').hide();
			$('.statebasedcountry select').removeClass('form-control');
			$('.statebasedcountry select').removeClass('cust_req');
		}
	
	}
</script>
