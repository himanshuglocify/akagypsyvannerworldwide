<?php
foreach($rate_data as $row)
{ ?>
<div class="row">
    <div class="col-md-12">
		<?php
            echo form_open(base_url() . 'index.php/admin/rate/update/'.$row['id'], array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'rate_edit'
            ));
        ?>
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                           <?php echo translate('zone_price_details'); ?>
                        </li>
                        
                    </ul>
                </div>
            </div>
        
        <div class="panel-body">
                    
                <div class="tab-base">
 
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('first_zone_area');?></label>
                                <div class="col-sm-6">
								<?php echo $row['z1_name']; ?>
								  <?php /* <select name="zone_id_1" id="zone_id_1" class="demo-chosen-select required"  data-placeholder="Choose Zone " tabindex="2" >
									 <option value="">Select Zone</option>
									 <?php foreach($zones as $zone){  ?>
										<option value="<?php echo $zone['id']; ?>"><?php echo $zone['zone']; ?></option>
									 <?php } ?>                                         
                                     </select> */ ?>
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('second_zone_area');?></label>
                                <div class="col-sm-6">
								 <?php echo $row['z2_name']; ?>
								 <?php /* <select name="zone_id_2" id="zone_id_2" class="demo-chosen-select required"  data-placeholder="Choose Zone " tabindex="2" >
									 <option value="">Select Zone</option>
									 <?php foreach($zones as $zone){  ?>
										<option value="<?php echo $zone['id']; ?>"><?php echo $zone['zone']; ?></option>
									 <?php } ?>                                         
                                     </select> */ ?>
                                </div>
                            </div>
							<div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('price');?></label>
                                <div class="col-sm-6">
									<input type="text" name="price" id="demo-hor-1" value="<?php echo $row['price']; ?>" placeholder="<?php echo translate('price');?>" class="form-control required">  
                                </div>
                            </div>
                  
                    </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-11">
                    	<span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('edit','<?php echo translate('edit_rate'); ?>','<?php echo translate('successfully_edited!'); ?>','rate_edit','<?php echo $row['id']; ?>') "><?php echo translate('reset');?>
                        </span>
                     </div>
                     <div class="col-md-1">
                     	<span class="btn btn-success btn-md btn-labeled fa fa-wrench pull-right" onclick="form_submit('rate_edit','<?php echo translate('successfully_edited!'); ?>');proceed('to_add');" ><?php echo translate('edit');?></span> 
                     </div>
                </div>
            </div>			
<script>
    function set_select(){
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
    }
	
    $(document).ready(function() {
		$('#zone_id_1').val('<?php echo $row['zone_id_1']; ?>');
		$('#zone_id_2').val('<?php echo $row['zone_id_2']; ?>');
        set_select();
    });
</script>			
<?php } ?>