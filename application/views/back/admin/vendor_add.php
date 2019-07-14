<div class="row">

    <div class="col-md-12">
		<?php
            echo form_open(base_url() . 'index.php/admin/vendor/do_add/', array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'vendor_add',
				'enctype' => 'multipart/form-data'
            ));
        ?>
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                           <?php echo translate('vendor_details'); ?>
                        </li>
                        
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                    
                <div class="tab-base">
        
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('name');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="username" id="demo-hor-1" placeholder="<?php echo translate('name');?>" class="form-control required">
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('surname');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="surname" id="demo-hor-2" placeholder="<?php echo translate('surname');?>" class="form-control required">
                                </div>
                            </div>                            

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-6"><?php echo translate('password');?></label>
                                <div class="col-sm-6">
                                    <input type="password" name="password" id="demo-hor-6" placeholder="<?php echo translate('password');?>" class="form-control required">
                                </div>
                            </div>
							
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-7"><?php echo translate('confirm password');?></label>
                                <div class="col-sm-6">
                                    <input type="password" name="confirm_password" id="demo-hor-7" placeholder="<?php echo translate('confirm_password');?>" class="form-control required">
                                </div>
                            </div>
							
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('display_name');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="display_name" id="demo-hor-2" placeholder="<?php echo translate('display_name');?>" class="form-control required">
                                </div>
                            </div>
                    
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('email');?></label>
                                <div class="col-sm-6">
                                    <input type="email" name="email"  placeholder="<?php echo translate('email');?>" class="form-control required">
                                </div>
                            </div>
                                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('profile_image');?></label>
                                <div class="col-sm-6">
                                <span class="pull-left btn btn-default btn-file"> <?php echo translate('profile_image');?>
                                    <input type="file" multiple name="profile_image" onchange="preview(this);" id="demo-hor-12" class="form-control required">
                                    </span>
                                    <br><br>
                                    <span id="previewImg" ></span>
                                </div>
                            </div>
                            
                             <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"><?php echo translate('company');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="company"  placeholder="<?php echo translate('company');?>" class="form-control">
                                </div>
                            </div>

                         
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-23"><?php echo translate('vendor_membership');?></label>
                                <div class="col-sm-6">
                                     <select name="membership" class="demo-chosen-select required"  data-placeholder="Choose Membership " tabindex="2" >
									 <option value="">Select Membership</option>
									 <?php foreach($memberships as $membership){  ?>
									 
									 <option value="<?php echo $membership['membership_id']; ?>"><?php echo 'Title :'.$membership['title'].' ,&nbsp;Price : '.$membership['price'].' ,&nbsp;Time :  '.$membership['timespan']; ?></option>
									 <?php } ?>
                                                                               
                                     </select>
                                </div>
                            </div>
                                <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-23"><?php echo translate('gender');?></label>
                                <div class="col-sm-6">
                                     <select name="gender" class="demo-chosen-select required"  data-placeholder="Choose Gender " tabindex="2" >
                                         <option value="male">Male</option>
                                         <option value="female">Female</option>
                                     </select>
                                </div>
                            </div>                     
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('phone');?></label>
                                <div class="col-sm-6">
                                    <input type="number" name="phone" id="demo-hor-5" placeholder="<?php echo translate('phone');?>" class="form-control required">
                                </div>
                            </div>
							
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-7"><?php echo translate('address1');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="address1" id="demo-hor-7" placeholder="<?php echo translate('address1');?>" class="form-control required">
                                </div>
                            </div>
							
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('address2');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="address2" id="demo-hor-8" placeholder="<?php echo translate('address2');?>" class="form-control required">
                                </div>
                            </div>
							
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-7"><?php echo translate('country');?></label>
                                <div class="col-sm-6">
								<select name="country" id="demo-hor-7" class="form-control required" onChange="getState(this);">
								<option value="">Select Country</option>
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
                            </div>

                            <div class="form-group btm_border statebasedcountry" style="display:none;">
                                <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('state');?></label>
                                <div class="col-sm-6">
                                    
									<select name="state" id="demo-hor-8" class="form-control">
									<option value="">Select State</option>
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
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('city');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="city" id="demo-hor-9" placeholder="<?php echo translate('city');?>" class="form-control required">
                                </div>
                            </div>
							
							 <div class="form-group btm_border">
                                <label class="col-sm-4 control-label"><?php echo translate('paypal_email');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="paypal_email" class="form-control required" placeholder="<?php echo translate('paypal_email');?>"> 
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-10"><?php echo translate('zip');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="zip" id="demo-hor-10" placeholder="<?php echo translate('zip');?>" class="form-control required">
                                </div>
                            </div>
						                        
                </div>

               
        
            </div>
    
            <div class="panel-footer">
                <div class="row">
                	<div class="col-md-11">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('add','<?php echo translate('add_vendor'); ?>','<?php echo translate('successfully_added!'); ?>','vendor_add',''); "><?php echo translate('reset');?>
                        </span>
                    </div>
                    
                    <div class="col-md-1">
                        <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right" onclick="form_submit('vendor_add','<?php echo translate('vendor_has_been_uploaded!'); ?>');proceed('to_add');" ><?php echo translate('upload');?></span>
                    </div>
                    
                </div>
            </div>
    
        </form>
    </div>
</div>

<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js">
</script>

<input type="hidden" id="option_count" value="-1">

<script>

function getState(arg)
	{
		var countryid = $(arg).val();
		if(countryid == 230)
		{
			$('.statebasedcountry').show();
			$('.statebasedcountry select').addClass('required');
		}
		else
		{
			$('.statebasedcountry').hide();
			$('.statebasedcountry select').removeClass('required');
		}
	
	}
    window.preview = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImg").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }

    function other_forms(){}
	
	

    function option_count(type){
        var count = $('#option_count').val();
        if(type == 'add'){
            count++;
        }
        if(type == 'reduce'){
            count--;
        }
        $('#option_count').val(count);
    }

    function set_select(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    }
	
    $(document).ready(function() {
        set_select();
	
		
    });

    function other(){
        set_select();
        $('#sub').show('slow');
        $('#brn').show('slow');
    }
    function get_sub_res(id){}

    $(".unit").on('keyup',function(){
        $(".unit_set").html($(".unit").val());
    });

	
    
    
    
    function next_tab(){
        $('.nav-tabs li.active').next().find('a').click();                    
    }
    function previous_tab(){
        $('.nav-tabs li.active').prev().find('a').click();                     
    }
    
 
    
    $('body').on('click', '.rmo', function(){
        $(this).parent().parent().remove();
    });

    $('body').on('click', '.rmon', function(){
        var co = $(this).closest('.form-group').data('no');
        $(this).parent().parent().remove();
        if($(this).parent().parent().parent().html() == ''){
            $(this).parent().parent().parent().html(''
                +'   <input type="hidden" name="op_set'+co+'[]" value="none" >'
            );
        }
    });

    $('body').on('click', '.rms', function(){
        $(this).parent().parent().remove();
    });

  	           

    $('body').on('click', '.rmc', function(){
        $(this).parent().parent().remove();
    });


	$(document).ready(function() {
		$("form").submit(function(e){
			return false;
		});
	});
</script>

<style>
	.btm_border{
		border-bottom: 1px solid #ebebeb;
		padding-bottom: 15px;	
	}
</style>


<!--Bootstrap Tags Input [ OPTIONAL ]-->

