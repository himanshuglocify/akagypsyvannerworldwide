
<div class="row">
    <div class="col-md-12">
	<?php foreach($user_data as $row)
			{
			?>
		<?php
            echo form_open(base_url() . 'index.php/admin/user/update/' . $row['user_id'], array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'user_edit',
				'enctype' => 'multipart/form-data'
            ));
        ?>
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                          <?php echo translate('user_details'); ?>
                        </li>
                        
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                    
                <div class="tab-base">
        
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('name');?></label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $row['username']; ?>" name="username" id="demo-hor-2" placeholder="<?php echo translate('name');?>" class="form-control required">
                                </div>
                            </div>
							
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('surname');?></label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $row['surname']; ?>" name="surname" id="demo-hor-2" placeholder="<?php echo translate('surname');?>" class="form-control required">
                                </div>
                            </div>
                    
                                                       
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('images');?></label>
                                <div class="col-sm-6">
                                <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                                    
									<input type="file" multiple name="g_photo" onchange="preview(this);" id="demo-hor-inputpass" class="form-control">
									
                                    </span>
                                    <br><br>
                                    <span id="previewImg" ></span>
                                </div>
                            </div>
                              <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                                <div class="col-sm-6">
                                    <?php 
                                        $images = $this->crud_model->file_view('user',$row['user_id'],'','','thumb','src','','all');
										
                                        if($images){
                                            
                                    ?>
                                        <div class="delete-div-wrap">
                                            <span class="close">&times;</span>
                                            <div class="inner-div">
                                                <img class="img-responsive" width="100" src="<?php echo $images; ?>"  alt="User_Image" >
                                            </div>
                                        </div>
                                    <?php 
                                           
                                        } 
                                    ?>
                                </div>
                            </div>
                           

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-23"><?php echo translate('gender');?></label>
                                <div class="col-sm-6">
                                     <select name="gender" class="demo-chosen-select required"  data-placeholder="Choose Gender " tabindex="2" >
                                         <option value="male"  <?php if($row['surname'] == 'male'){ echo 'selected="selected"';} ?> >Male</option>
                                         <option value="female"  <?php if($row['surname'] == 'female'){ echo 'selected="selected"';} ?> >Female</option>
                                     </select>
                                </div>
                            </div>

                                                   
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-5"><?php echo translate('phone');?></label>
                                <div class="col-sm-6">
                                    <input type="number" value="<?php echo $row['phone']; ?>"  name="phone" id="demo-hor-5" placeholder="<?php echo translate('phone');?>" class="form-control required">
                                </div>
                            </div>
							
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-7"><?php echo translate('address1');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="address1" id="demo-hor-7" value="<?php echo $row['address1']; ?>"  placeholder="<?php echo translate('address1');?>" class="form-control required">
                                </div>
                            </div>
							
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('address2');?></label>
                                <div class="col-sm-6">
                                    <input type="text" value="<?php echo $row['address2']; ?>"  name="address2" id="demo-hor-8" placeholder="<?php echo translate('address2');?>" class="form-control required">
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
									<option value="<?php echo $country['country_id'] ?>"  <?php if($row['country']==$country['country_id']){ echo 'selected="selected"';} ?> ><?php echo $country['country_name'] ?></option>
									<?php 
								}
								?>
								</select>
                                </div>
                            </div>

                            <div class="form-group btm_border statebasedcountry" <?php if($row['country'] != 230){ echo 'style="display:none;"';}?>>
                                <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('state');?></label>
                                <div class="col-sm-6">
                                    
									<select name="state" id="demo-hor-8" class="form-control">
									<option value="">Select State</option>
									<?php 
									foreach($states as $state)
									{
										?>
										<option value="<?php echo $state['id']; ?>" <?php if($row['state']==$state['id']){ echo 'selected="selected"';} ?>><?php echo $state['name'] ?></option>
										<?php 
									}
									?>
									</select>
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('city');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="city" id="demo-hor-9" value="<?php echo $row['city']; ?>"  placeholder="<?php echo translate('city');?>" class="form-control required">
                                </div>
                            </div>
							
							
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-10"><?php echo translate('zip');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="zip" id="demo-hor-10" value="<?php echo $row['zip']; ?>"  placeholder="<?php echo translate('zip');?>" class="form-control required">
                                </div>
                            </div>
						                        
                </div>

               
        
            </div>
    
            <div class="panel-footer">
                <div class="row">
                	
                    <div class="col-md-12">
                        <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right" onclick="form_submit('user_edit','<?php echo translate('user_has_been_uploaded!'); ?>');proceed('to_add');" ><?php echo translate('update');?></span>
                    </div>
                    
                </div>
            </div>
    
        </form>
		<?php } ?>
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


	
</script>

<style>
	.btm_border{
		border-bottom: 1px solid #ebebeb;
		padding-bottom: 15px;	
	}
</style>


<!--Bootstrap Tags Input [ OPTIONAL ]-->

