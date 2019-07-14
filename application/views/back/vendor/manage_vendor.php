<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_profile');?></h1>
    </div>
    <div class="tab-base">
        <div class="panel">
            <div class="panel-body">
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="" style="border:1px solid #ebebeb; border-radius:4px;">
                        <?php
							$vendor_data = $this->db->get_where('vendor', array(
								'vendor_id' => $this->session->userdata('vendor_id')
							))->result_array();
							foreach ($vendor_data as $row) {
						?>
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo translate('manage_details');?></h3>
                        </div>
						<?php
                            echo form_open(base_url() . 'index.php/vendor/manage_vendor/update_profile/', array(
                                'class' => 'form-horizontal',
                                'method' => 'post',
								'enctype' => 'multipart/form-data'
                            ));
                        ?>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-1">
                                    	<?php echo translate('username');?>
                                        	</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="username" value="<?php echo $row['username']; ?>" id="demo-hor-1" class="form-control required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-1">
                                    	<?php echo translate('display_name');?>
                                        	</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="display_name" value="<?php echo $row['display_name']; ?>" id="demo-hor-1" class="form-control required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-2">
										<?php echo translate('email');?>
                                        	</label>
                                    <div class="col-sm-6">
                                        <input type="email" name="email" value="<?php echo $row['email']; ?>" id="demo-hor-2" class="form-control required" disabled>
                                    </div>
                                </div>
								<div class="form-group btm_border">
									<label class="col-sm-3 control-label" for="demo-hor-12"><?php echo translate('profile_image');?></label>
									<div class="col-sm-6">
									<span class="pull-left btn btn-default btn-file"> <?php echo translate('profile_image');?>
										<input type="file" multiple name="profile_image" onchange="preview(this);" id="demo-hor-12" class="form-control">
										</span>
										<br><br>
										<span id="previewImg" ></span>
									</div>
								</div>
								<div class="form-group btm_border">
									<label class="col-sm-3 control-label" for="demo-hor-13"></label>
									<div class="col-sm-6">
										<?php 
											$images = $this->crud_model->file_view('vendor',$row['vendor_id'],'','','thumb','src','','all');
											
											if($images){
												
										?>
											<div class="delete-div-wrap">
												<span class="close">&times;</span>
												<div class="inner-div">
													<img class="img-responsive" width="100" src="<?php echo $images.'?'.rand(2,5); ?>"  alt="vendor_Image" >
												</div>
											</div>
										<?php 
											   
											} 
										?>
									</div>
                            </div>
								<div class="form-group btm_border">
									 <label class="col-sm-3 control-label" for="demo-hor-2"><?php echo translate('gender');?></label>
									<div class="col-sm-6">
										 <select name="gender" class="demo-chosen-select required"  data-placeholder="Choose Gender " tabindex="2" >
											 <option value="male" <?php if($row['gender'] =='male'){ echo "Selected"; } ?>>Male</option>
											 <option value="female" <?php if($row['gender'] =='female'){ echo "Selected"; } ?>>Female</option>
										 </select>
									</div>
								</div>   								
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-3">
										<?php echo translate('phone');?>
                                        	</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="phone" value="<?php echo $row['phone']; ?>" id="demo-hor-3" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-4">
										<?php echo translate('address_line_1');?>
                                        	</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="address1" value="<?php echo $row['address1']; ?>" id="demo-hor-4" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-4">
										<?php echo translate('address_line_2');?>
                                        	</label>
                                    <div class="col-sm-6">
                                        <input type="text" name="address2" value="<?php echo $row['address2']; ?>" id="demo-hor-4" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label" for="demo-hor-4">
										<?php echo translate('about');?>
                                        	</label>
                                    <div class="col-sm-6">
                                        <textarea name="details" rows="10" class="form-control"><?php echo $row['details']; ?></textarea>
                                    </div>
                                </div>
							  <div class="form-group btm_border">
									 <label class="col-sm-3 control-label" for="demo-hor-4"><?php echo translate('zip');?></label>
									<div class="col-sm-6">
										<input type="text" name="zip" id="demo-hor-10" value="<?php echo $row['zip']; ?>" placeholder="<?php echo translate('zip');?>" class="form-control required">
							</div>
                            </div>
                            </div>
                            <div class="panel-footer text-right">
                                <span class="btn btn-info submitter" data-ing='<?php echo translate('updating..'); ?>' data-msg='<?php echo translate('profile_updated!'); ?>'>
									<?php echo translate('update_profile');?>
                                    	</span>
                            </div>
                        </form>

                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo translate('change_password');?></h3>
                        </div>
							<?php
                                echo form_open(base_url() . 'index.php/vendor/manage_vendor/update_password/', array(
                                    'class' => 'form-horizontal',
                                    'method' => 'post'
                                ));
                            ?>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="demo-hor-5">
                                        	<?php echo translate('current_password');?>
                                            	</label>
                                        <div class="col-sm-6">
                                            <input type="password" name="password" value="" id="demo-hor-5" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="demo-hor-6">
                                        	<?php echo translate('new_password*');?>
                                            	</label>
                                        <div class="col-sm-6">
                                            <input type="password" name="password1" value="" id="demo-hor-6" class="form-control pass pass1 required">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="demo-hor-7">
                                        	<?php echo translate('confirm_password');?>
                                            	</label>
                                        <div class="col-sm-6">
                                            <input type="password" name="password2" value="" id="demo-hor-7" class="form-control pass pass2 required">
                                        </div>
                                        <div id="pass_note">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <span class="btn btn-info pass_chng disabled" disabled='disabled' data-ing='<?php echo translate('updating..'); ?>' data-msg='<?php echo translate('password_updated!'); ?>'>
                                    	<?php echo translate('update_password');?>
                                    		</span>
                                </div>
                        	</form>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        <!--Panel body-->
        </div>
    </div>
</div>

<script type="text/javascript">
    function set_select(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    }
	
    $(document).ready(function() {
        set_select();
		$('.close').on('click', function(){
			$('.delete-div-wrap').remove();
		});
	
		
    });
	$(".pass").blur(function() {
		var pass1 = $(".pass1").val();
		var pass2 = $(".pass2").val();
		if (pass1 !== pass2) {
			$("#pass_note").html('' + '  <span class="require_alert" >' + '      <?php echo translate('password_mismatched'); ?>' + '  </span>');
			$(".pass_chng").attr("disabled", "disabled");
			$(".pass_chng").addClass("disabled");
		} else if (pass1 == pass2) {
			$("#pass_note").html('');
			$(".pass_chng").removeAttr("disabled");
			$(".pass_chng").removeClass("disabled");
		}
	});
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
	$('.pass_chng').on('click', function() {
	
		//alert('vdv');
		var here = $(this); // alert div for show alert message
		var form = here.closest('form');
		var can = '';
		var ing = here.data('ing');
		var msg = here.data('msg');
		var prv = here.html();
	
		//var form = $(this);
		var formdata = false;
		if (window.FormData) {
			formdata = new FormData(form[0]);
		}
	
		var a = 0;
		var take = '';
		form.find(".required").each(function() {
			var txt = '*<?php echo translate('required'); ?>';
			a++;
			if (a == 1) {
				take = 'scroll';
			}
			var here = $(this);
			if (here.val() == '') {
				if (!here.is('select')) {
					here.css({
						borderColor: 'red'
					});
	
					if (here.closest('div').find('.require_alert').length) {
	
					} else {
						sound('form_submit_problem');
						here.closest('div').append('' + '  <span id="' + take + '" class="label label-danger require_alert" >' + '      ' + txt + '  </span>');
					}
				}
				var topp = 100;
	
				$('html, body').animate({
					scrollTop: $("#scroll").offset().top - topp
				}, 500);
				can = 'no';
			}
	
			take = '';
		});
	
		if (can !== 'no') {
			$.ajax({
				url: form.attr('action'), // form action url
				type: 'POST', // form submit method get/post
				dataType: 'html', // request type html/json/xml
				data: formdata ? formdata : form.serialize(), // serialize form data 
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					here.html(ing); // change submit button text
				},
				success: function(data) {
					here.fadeIn();
					here.html(prv);
					if (data == 'updated') {
						$.activeitNoty({
							type: 'success',
							icon: 'fa fa-check',
							message: msg,
							container: 'floating',
							timer: 3000
						});
					} else if (data == 'pass_prb') {
						$.activeitNoty({
							type: 'danger',
							icon: 'fa fa-check',
							message: '<?php echo translate('incorrect_password!'); ?>',
							container: 'floating',
							timer: 3000
						});
					}
				},
				error: function(e) {
					console.log(e)
				}
			});
		} else {
			sound('form_submit_problem');
			return false;
		}
	});

    var base_url = '<?php echo base_url(); ?>';

</script>


