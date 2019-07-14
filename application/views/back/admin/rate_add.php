<div class="row">
    <div class="col-md-12">
		<?php
            echo form_open(base_url() . 'index.php/admin/rate/do_add/', array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'rate_add'
            ));
        ?>
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                           <?php echo translate('zone_rates'); ?>
                        </li>
                        
                    </ul>
                </div>
            </div>
        
        <div class="panel-body">
                    
                <div class="tab-base">
        
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('first_zone_area');?></label>
                                <div class="col-sm-6">
								  <select name="zone_id_1" class="demo-chosen-select required"  data-placeholder="Choose Zone " tabindex="2" >
									 <option value="">Select Zone</option>
									 <?php foreach($zones as $zone){  ?>
										<option value="<?php echo $zone['id']; ?>"><?php echo $zone['zone']; ?></option>
									 <?php } ?>                                         
                                     </select>
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('second_zone_area');?></label>
                                <div class="col-sm-6">
								  <select name="zone_id_2" class="demo-chosen-select required"  data-placeholder="Choose Zone " tabindex="2" >
									 <option value="">Select Zone</option>
									 <?php foreach($zones as $zone){  ?>
										<option value="<?php echo $zone['id']; ?>"><?php echo $zone['zone']; ?></option>
									 <?php } ?>                                         
                                     </select>
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('price');?></label>
                                <div class="col-sm-6">
									<input type="text" name="price" id="demo-hor-1" placeholder="<?php echo translate('price');?>" class="form-control required">  
                                </div>
                            </div>
                    
                    </div>
            </div>
    
            <div class="panel-footer">
                <div class="row">
                	<div class="col-md-11">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('add','<?php echo translate('add_zone_rate'); ?>','<?php echo translate('successfully_added!'); ?>','rate_add',''); "><?php echo translate('reset');?>
                        </span>
                    </div>
                    
                    <div class="col-md-1">
                        <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right" onclick="form_submit('rate_add','<?php echo translate('zone_rate_has_been_uploaded!'); ?>');proceed('to_add');" ><?php echo translate('upload');?></span>
                    </div>
                    
                </div>
            </div>
    
        </form>
    </div>
</div>
<script>
    function set_select(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    }
	
    $(document).ready(function() {
        set_select();
	
		
    });
</script>