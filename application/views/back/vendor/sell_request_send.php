<div class="row">
    <div class="col-md-12">
		<?php
            echo form_open(base_url() . 'index.php/vendor/sell_request/do_add/', array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'sell_request_send',
				'enctype' => 'multipart/form-data'
            ));
        ?>
            <div class="panel-body">
                    
                <div class="tab-base">
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-23"><?php echo translate('horse');?>(*)</label>
                                <div class="col-sm-6">
								<?php $vendor_id = '{"type":"vendor","id":"'.$this->session->userdata('vendor_id').'"}';
								echo $this->crud_model->select_html('product','horse_id','title','add','demo-chosen-select required','','added_by',$vendor_id,''); ?>
                                </div>
                            </div>        
                           <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('price');?>(*)</label>
                                <div class="col-sm-6">
                                    <input type="text" name="price" id="demo-hor-1" placeholder="<?php echo translate('price');?>" class="form-control required">
                                </div>
                            </div>
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-23"><?php echo translate('request_for');?>(*)</label>
                                <div class="col-sm-6">
								<?php $membership = $this->db->get_where('vendor',array('vendor_id'=>$this->session->userdata('vendor_id')))->row()->membership; 
								if($membership == 1){ ?>
                                     <select name="request_for" class="demo-chosen-select required"  data-placeholder="Request for" tabindex="2" >
                                         <option value="sell">Sell</option>
                                         <option value="breed">Breed</option>
                                     </select>
								<?php 
								}else{
									echo '<select name="request_for" class="demo-chosen-select required"  data-placeholder="Request for" tabindex="2" ><option value="sell">Sell</option></select>';
								}
								?>
                                </div>
                            </div>                         
                </div>

               
        
            </div>
    
            <div class="panel-footer">
                <div class="row">
                	<div class="col-md-11">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('send','<?php echo translate('send_request'); ?>','<?php echo translate('successfully_added!'); ?>','sell_request_send',''); "><?php echo translate('reset');?>
                        </span>
                    </div>
                    
                    <div class="col-md-1">
                        <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right" onclick="form_submit('sell_request_send','<?php echo translate('request_has_been_sent!'); ?>');proceed('to_add');" ><?php echo translate('upload');?></span>
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

