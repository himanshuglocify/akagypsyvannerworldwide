<?php
    foreach($product_data as $row){
?>
<div class="row">
    <div class="col-md-12">
        <?php
			echo form_open(base_url() . 'index.php/admin/product/update/' . $row['product_id'], array(
				'class' => 'form-horizontal',
				'method' => 'post',
				'id' => 'product_edit',
				'enctype' => 'multipart/form-data'
			));
		?>
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#product_details"><?php echo translate('horse_details'); ?></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#business_details"><?php echo translate('business_details'); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <div class="tab-base">
                    <!--Tabs Content-->                    
                    <div class="tab-content">
                        <div id="product_details" class="tab-pane fade active in">

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1">
                                    <?php echo translate('name');?> (*)
                                        </label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" id="demo-hor-1" value="<?php echo $row['title']; ?>" placeholder="<?php echo translate('name');?>" class="form-control required">
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-2"><?php echo translate('category');?> (*)</label>
                                <div class="col-sm-6">
                                    <?php echo $this->crud_model->select_html('category','category','category_name','edit','demo-chosen-select required',$row['category'],'','',''); ?>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-24"><?php echo translate('height').'<span style="color:red;"> '.translate('(in_hands)').'</span>';?> (*)</label>
                                <div class="col-sm-6">
                                    <input type="number" value="<?php echo $row['height']; ?>" name="height" id="demo-hor-24" min='0' step='.01' placeholder="<?php echo translate('height');?>" class="form-control required">
                                </div>
                            </div> 							

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('images');?> (*)</label>
                                <div class="col-sm-6">
                                    <span class="pull-left btn btn-default btn-file"> <?php echo translate('choose_file');?>
                                        <input type="file" multiple name="images[]" onchange="preview(this);" id="demo-hor-inputpass" class="form-control">
                                    </span>
									<div style="color: red; display: block; float: left; width: 100%; margin-top: 5px;">You can select multiple images by pressing and holding ctrl button.</div>									
                                    <br><br>
                                    <span id="previewImg" ></span>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-13"></label>
                                <div class="col-sm-6">
                                    <?php 
                                        $images = $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','all');
                                        if($images){
                                            foreach ($images as $row1){
                                                $a = explode('.', $row1);
                                                $a = $a[(count($a)-2)];
                                                $a = explode('_', $a);
                                                $p = $a[(count($a)-2)];
                                                $i = $a[(count($a)-3)];
                                    ?>
                                        <div class="delete-div-wrap">
                                            <span class="close">&times;</span>
                                            <div class="inner-div">
                                                <img class="img-responsive" width="100" src="<?php echo $row1; ?>" data-id="<?php echo $i.'_'.$p; ?>" alt="User_Image" >
                                            </div>
                                        </div>
                                    <?php 
                                            }
                                        } 
                                    ?>
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-14">
                                    <?php echo translate('description');?>
                                        </label>
                                <div class="col-sm-6">
                                    <textarea rows="9" class="summernotes" data-height="200" data-name="description">
                                        <?php echo $row['description']; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group btm_border">'
                                <label class="col-sm-4 control-label" for="demo-hor-15">
                                    <?php echo translate('color');?> (*)
                                </label>
								<div class="col-sm-6">
									<input type="text" value="<?php echo $row['color']; ?>" name="color" class="form-control required" />
								</div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-22"><?php echo translate('size');?> (*)</label>
                                <div class="col-sm-6">
                                     <select name="size" class="demo-chosen-select required"  data-placeholder="Choose Size " tabindex="2" >
                                     <option value="small" <?php if($row['size'] == 'small' ){ echo 'selected="selected"';} ?>>Up to 12hh</option>
                                     <option value="medium" <?php if($row['size'] == 'medium' ){ echo 'selected="selected"';} ?>>12hh to 14hh</option>
                                     <option value="large" <?php if($row['size'] == 'large' ){ echo 'selected="selected"';} ?>>14hh+</option>
                                     </select>
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-23"><?php echo translate('gender');?> (*)</label>
                                <div class="col-sm-6">
								
								
									 
									  <select name="gender" class="demo-chosen-select required"  data-placeholder="Choose Gender " tabindex="2" >
									 <?php 
									 $this->db->group_by("gender_group");
									 $genders = $this->db->get('gender')->result_array(); 
									 
										foreach($genders as $gender)
										{
									?>
									  <optgroup label="<?php echo $gender['gender_group']; ?>">
									  <?php 
									  $loopgenders = $this->db->get_where('gender',array('gender_group'=>$gender['gender_group']))->result_array(); 
									  foreach($loopgenders as $loopgender)
									  {
									  ?>
									  <option value="<?php echo $loopgender['gender_id']; ?>" <?php if($row['gender'] == $loopgender['gender_id'] ){ echo 'selected="selected"';} ?> ><?php echo $loopgender['gender']; ?></option>
									  <?php } ?>
									  </optgroup>
										<?php } ?>    
                                     </select>
							 
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-31"><?php echo translate('country_of_birth');?> (*)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="country_of_birth" value="<?php echo $row['country_of_birth']; ?>" id="demo-hor-31" placeholder="<?php echo translate('country_of_birth');?>" class="form-control required">
                                </div>
                            </div>
							 <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-32"><?php echo translate('date_of_birth');?> (*)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="date_of_birth" id="demo-hor-32"  value="<?php echo $row['date_of_birth']; ?>"  placeholder="<?php echo translate('date_of_birth');?>" class="form-control required">
                                </div>
                            </div>	
														
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-33"><?php echo translate('temperament');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="temperament" value="<?php echo $row['temperament']; ?>" id="demo-hor-33" placeholder="<?php echo translate('temperament');?>" class="form-control">
                                </div>
                            </div>	
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-34"><?php echo translate('training');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="training" value="<?php echo $row['training']; ?>" id="demo-hor-34" placeholder="<?php echo translate('training');?>" class="form-control">
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-35"><?php echo translate('breeding_history');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="breeding_history" value="<?php echo $row['breeding_history']; ?>" id="demo-hor-35" placeholder="<?php echo translate('breeding_history');?>" class="form-control">
                                </div>
                            </div>							
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-36"><?php echo translate('notes');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="notes" id="demo-hor-36" value="<?php echo $row['notes']; ?>" placeholder="<?php echo translate('notes');?>" class="form-control">
                                </div>
                            </div>	
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-37"><?php echo translate('sire');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="sire" id="demo-hor-37" value="<?php echo $row['sire']; ?>" placeholder="<?php echo translate('sire');?>" class="form-control">
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-38"><?php echo translate('dam');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="dam" id="demo-hor-38" value="<?php echo $row['dam']; ?>" placeholder="<?php echo translate('dam');?>" class="form-control">
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-39"><?php echo translate('grand_sire');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="grand_sire" id="demo-hor-39" value="<?php echo $row['grand_sire']; ?>" placeholder="<?php echo translate('grand_sire');?>" class="form-control">
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-40"><?php echo translate('grand_dam');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="grand_dam" id="demo-hor-40" value="<?php echo $row['grand_dam']; ?>" placeholder="<?php echo translate('grand_dam');?>" class="form-control">
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-41"><?php echo translate('dna_reg_number');?> (*)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="dna_reg_number" value="<?php echo $row['dna_reg_number']; ?>" id="demo-hor-41" placeholder="<?php echo translate('dna_reg_number');?>" class="form-control required">
									<span style="display: block; float: left; width: 100%; margin-top: 5px;">You can request DNA testing <a style="color: blue; text-decoration: underline;" href="<?php echo base_url(); ?>index.php/dna" target="_blank">here</a></span> 
								</div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-42"><?php echo translate('color_tested_result');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="color_tested_result" value="<?php echo $row['color_tested_result']; ?>" id="demo-hor-42" placeholder="<?php echo translate('color_tested_result');?>" class="form-control">
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-43"><?php echo translate('passport_number');?> (*)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="passport_number" value="<?php echo $row['passport_number']; ?>" id="demo-hor-43" placeholder="<?php echo translate('passport_number');?>" class="form-control required">
                                </div>
                            </div>

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-11"><?php echo translate('tags');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="tag" data-role="tagsinput" placeholder="<?php echo translate('tags');?>" value="<?php echo $row['tag']; ?>" class="form-control">
                                </div>
                            </div>

                            
                            <?php
                                $all_af = $this->crud_model->get_additional_fields($row['product_id']);
                                $all_c = json_decode($row['color']);
                                $all_op = json_decode($row['options'],true);
                            ?>

                            
                            <div id="more_additional_fields">
                            <?php
                            //var_dump($all_af);
                                if(!empty($all_af)){
                                    foreach($all_af as $row1){
                            ?> 
                                <div class="form-group btm_border">
                                    <div class="col-sm-4">
                                        <input type="text" name="ad_field_names[]" value="<?php echo $row1['name']; ?>" placeholder="Field Name" class="form-control" >
                                    </div>
                                    <div class="col-sm-5">
                                          <textarea rows="9"  class="summernotes" data-height="100" data-name="ad_field_values[]"><?php echo $row1['value']; ?></textarea>
                                    </div>
                                    <div class="col-sm-2">
                                        <span class="remove_it_v btn btn-primary" onclick="delete_row(this)">X</span>
                                    </div>
                                </div>
                            <?php
                                    }
                                }
                            ?> 
                            </div>
                            <!--<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-17"></label>
                                <div class="col-sm-6">
                                        <h4 class="pull-left">
                                            <i><?php echo translate('if_you_need_more_field_for_your_product_,_please_click_here_for_more...');?></i>
                                        </h4>
                                        <div id="more_btn" class="btn btn-primary btn-labeled fa fa-plus pull-right">
                                        <?php echo translate('add_more_fields');?></div>
                                </div>
                            </div> -->
                            
                        </div>

                        <div id="business_details" class="tab-pane fade">
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-6"><?php echo translate('price');?> (*)</label>
                                <div class="col-sm-4">
                                    <input type="number" name="sale_price" id="demo-hor-6" min='0' step='.01' value="<?php echo $row['sale_price']; ?>" placeholder="<?php echo translate('price');?>" class="form-control required">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"><?php echo $row['unit']; ?></span>
                            </div>
						
						 <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-6"><?php echo translate('commission');?></label>
                                <div class="col-sm-4">
                                    <input type="number" name="commission" id="demo-hor-6" min='0' value="<?php echo $row['commission']; ?>" step='.01' placeholder="<?php echo translate('commission');?>" class="form-control required">
                                </div>
                                <span class="btn"><?php echo currency(); ?> / </span>
                                <span class="btn unit_set"></span>
                            </div>
						
						 <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-7"><?php echo translate('country');?> (*)</label>
                                <div class="col-sm-6">
								<select name="country" id="demo-hor-7" class="form-control required" onChange="getState(this);">
								<option value="">Select Country</option>
								<?php 
								foreach($countries as $country)
								{
									?>
									<option value="<?php echo $country['country_id'] ?>" <?php if($row['country'] == $country['country_id']){ echo 'selected="selected"';} ?> ><?php echo $country['country_name'] ?></option>
									<?php 
								}
								?>
								</select>
                                </div>
                            </div>
							
                            <div class="form-group btm_border statebasedcountry" <?php if($row['country'] != 230){ echo 'style="display:none;"';}?>>
                                <label class="col-sm-4 control-label" for="demo-hor-8"><?php echo translate('state');?> (*)</label>
                                <div class="col-sm-6">
                                    
									<select name="state" id="demo-hor-8" class="form-control">
									<option value="">Select State</option>
									<?php 
									foreach($states as $state)
									{
										?>
										<option value="<?php echo $state['id'] ?>" <?php if($row['state'] == $state['id']){ echo 'selected="selected"';} ?> ><?php echo $state['name'] ?></option>
										<?php 
									}
									?>
									</select>
                                </div>
                            </div>
						
						    <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-9"><?php echo translate('city');?> (*)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="city" id="demo-hor-9" value="<?php echo $row['city'];?>" class="form-control required">
                                </div>
                            </div>                            

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-10"><?php echo translate('zip_code');?> (*)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="zipcode" id="demo-hor-10" value="<?php echo $row['zipcode'];?>" class="form-control required">
                                </div>
                            </div>   

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-20"><?php echo translate('address');?> (*)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="address" id="demo-hor-20" value="<?php echo $row['address'];?>" class="form-control required">
                                </div>
                            </div> 

                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-21"><?php echo translate('address_1');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="address1" id="demo-hor-21" value="<?php echo $row['address1'];?>" class="form-control">
                                </div>
                            </div>
						
						
						<div class="panel-footer">
                <div class="row">
                    <div class="col-md-10">
                    	<span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('edit','<?php echo translate('edit_product'); ?>','<?php echo translate('successfully_edited!'); ?>','product_edit','<?php echo $row['product_id']; ?>') "><?php echo translate('reset');?>
                        </span>
                     </div>
                     <div class="col-md-2">
                     	<span class="btn btn-success btn-md btn-labeled fa fa-wrench pull-right" onclick="form_submit('product_edit','<?php echo translate('successfully_edited!'); ?>');proceed('to_add');" ><?php echo translate('Update');?></span> 
                     </div>
                </div>
            </div>
						
                        </div>         
                    </div>
                </div>

                <span id="next_btn" class="btn btn-purple btn-labeled fa fa-hand-o-right pull-right" onclick="next_tab()"><?php echo translate('next'); ?></span>
                <span id="previous_btn" class="btn btn-purple btn-labeled fa fa-hand-o-left pull-right" onclick="previous_tab()"><?php echo translate('previous'); ?></span>
        
            </div>
            
        </form>
    </div>
</div>
<?php
    }
?>
<!--Bootstrap Tags Input [ OPTIONAL ]-->
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<input type="hidden" id="option_count" value="<?php if($row == 1){ echo $row1['no']; } else { echo '0'; } ?>">
<script type="text/javascript">
$(function() {
    $( "#datepicker" ).datepicker();
  });
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

     $('.delete-div-wrap .close').on('click', function() { 
	 	var pid = $(this).closest('.delete-div-wrap').find('img').data('id'); 
		var here = $(this); 
		msg = 'Really want to delete this Image?'; 
		bootbox.confirm(msg, function(result) {
			if (result) { 
				 $.ajax({ 
					url: base_url+'index.php/'+user_type+'/'+module+'/dlt_img/'+pid, 
					cache: false, 
					success: function(data) { 
						$.activeitNoty({ 
							type: 'success', 
							icon : 'fa fa-check', 
							message : 'Deleted Successfully', 
							container : 'floating', 
							timer : 3000 
						}); 
						here.closest('.delete-div-wrap').remove(); 
					} 
				}); 
			}else{ 
				$.activeitNoty({ 
					type: 'danger', 
					icon : 'fa fa-minus', 
					message : 'Cancelled', 
					container : 'floating', 
					timer : 3000 
				}); 
			}; 
		  }); 
		});

    function other_forms(){}
	
	function set_summer(){
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
        });
	}

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
        set_summer();
        createColorpickers();
    });

    function other(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        $('#sub').show('slow');
        $('#brn').show('slow');
    }
    function get_cat(id){
        $('#brand').html('');
        $('#sub').hide('slow');
        $('#brn').hide('slow');
        ajax_load(base_url+'index.php/admin/product/sub_by_cat/'+id,'sub_cat','other');
        ajax_load(base_url+'index.php/admin/product/brand_by_cat/'+id,'brand','other');
    }

    function get_sub_res(id){}

    $(".unit").on('keyup',function(){
        $(".unit_set").html($(".unit").val());
    });
	
	function createColorpickers() {
	
		$('.demo2').colorpicker({
			format: 'rgba'
		});
		
	}
	
   /* 
    $("#more_btn").click(function(){
        $("#more_additional_fields").append(''
            +'<div class="form-group">'
            +'    <div class="col-sm-4">'
            +'        <input type="text" name="ad_field_names[]" class="form-control"  placeholder="<?php echo translate('field_name'); ?>">'
            +'    </div>'
            +'    <div class="col-sm-5">'
            +'        <textarea rows="9"  class="summernotes" data-height="100" data-name="ad_field_values[]"></textarea>'
            +'    </div>'
            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'
            +'    </div>'
            +'</div>'
        );
        set_summer();
    }); */ 
    
    
    $("#more_option_btn").click(function(){
        option_count('add');
        var co = $('#option_count').val();
        $("#more_additional_options").append(''
            +'<div class="form-group" data-no="'+co+'">'
            +'    <div class="col-sm-4">'
            +'        <input type="text" name="op_title[]" class="form-control required"  placeholder="<?php echo translate('customer_input_title'); ?>">'
            +'    </div>'
            +'    <div class="col-sm-5">'
            +'        <select class="demo-chosen-select op_type required" name="op_type[]" >'
            +'            <option value="">(none)</option>'
            +'            <option value="text">Text Input</option>'
            +'            <option value="single_select">Dropdown Single Select</option>'
            +'            <option value="multi_select">Dropdown Multi Select</option>'
            +'            <option value="radio">Radio</option>'
            +'        </select>'
            +'        <div class="col-sm-12 options">'
            +'          <input type="hidden" name="op_set'+co+'[]" value="none" >'
            +'        </div>'
            +'    </div>'
            +'    <input type="hidden" name="op_no[]" value="'+co+'" >'
            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_o rmo btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'
            +'    </div>'
            +'</div>'
        );
        set_select();
    });
    
    $("#more_additional_options").on('change','.op_type',function(){
        var co = $(this).closest('.form-group').data('no');
        if($(this).val() !== 'text' && $(this).val() !== ''){
            $(this).closest('div').find(".options").html(''
                +'    <div class="col-sm-12">'
                +'        <div class="col-sm-12 options margin-bottom-10"></div><br>'
                +'        <div class="btn btn-mint btn-labeled fa fa-plus pull-right add_op">'
                +'        <?php echo translate('add_options_for_choice');?></div>'
                +'    </div>'
            );
        } else if ($(this).val() == 'text' || $(this).val() == ''){
            $(this).closest('div').find(".options").html(''
                +'    <input type="hidden" name="op_set'+co+'[]" value="none" >'
            );
        }
    });
    
    $("#more_additional_options").on('click','.add_op',function(){
        var co = $(this).closest('.form-group').data('no');
        $(this).closest('.col-sm-12').find(".options").append(''
            +'    <div>'
            +'        <div class="col-sm-10">'
            +'          <input type="text" name="op_set'+co+'[]" class="form-control required"  placeholder="<?php echo translate('option_name'); ?>">'
            +'        </div>'
            +'        <div class="col-sm-2">'
            +'          <span class="remove_it_n rmon btn btn-danger btn-icon btn-circle icon-sm fa fa-times" onclick="delete_row(this)"></span>'
            +'        </div>'
            +'    </div>'
        );
    });
    
    $('body').on('click', '.rmo', function(){
        $(this).parent().parent().remove();
    });

    function next_tab(){
        $('.nav-tabs li.active').next().find('a').click();    
		if($('.nav-tabs li:last-child').hasClass('active')){
			$('#next_btn').hide();
			$('#previous_btn').show();
		}		
    }
    function previous_tab(){
        $('.nav-tabs li.active').prev().find('a').click(); 
		if($('.nav-tabs li:first-child').hasClass('active')){
			$('#previous_btn').hide();
			$('#next_btn').show(); 
		}		
    }
    
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


    $("#more_color_btn").click(function(){
        $("#more_colors").append(''
            +'      <div class="col-md-12" style="margin-bottom:8px;">'
            +'          <div class="col-md-8">'
            +'              <div class="input-group demo2">'
            +'                 <input type="text" value="#ccc" name="color[]" class="form-control" />'
            +'                 <span class="input-group-addon"><i></i></span>'
            +'              </div>'
            +'          </div>'
            +'          <span class="col-md-4">'
            +'              <span class="remove_it_v rmc btn btn-danger btn-icon btn-circle icon-lg fa fa-times" ></span>'
            +'          </span>'
            +'      </div>'
        );
        createColorpickers();
    });                

    $('body').on('click', '.rmc', function(){
        $(this).parent().parent().remove();
    });

	
    function delete_row(e)
    {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }    
	
	
	$(document).ready(function() {
		$('#previous_btn').hide();
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

