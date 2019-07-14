<?php
		foreach($zone_data as $row)
		{ ?>
<div class="row">
    <div class="col-md-12">
		<?php
            echo form_open(base_url() . 'index.php/admin/zone/update/'.$row['id'], array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'zone_edit'
            ));
        ?>
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                           <?php echo translate('zone_details'); ?>
                        </li>
                        
                    </ul>
                </div>
            </div>
        
        <div class="panel-body">
                    
                <div class="tab-base">
        
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('zone');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="zone" id="demo-hor-1" value="<?php echo $row['zone']; ?>" placeholder="<?php echo translate('zone');?>" class="form-control required">
                                </div>
                            </div>
                    
                    </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-11">
                    	<span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('edit','<?php echo translate('edit_zone'); ?>','<?php echo translate('successfully_edited!'); ?>','zone_edit','<?php echo $row['id']; ?>') "><?php echo translate('reset');?>
                        </span>
                     </div>
                     <div class="col-md-1">
                     	<span class="btn btn-success btn-md btn-labeled fa fa-wrench pull-right" onclick="form_submit('zone_edit','<?php echo translate('successfully_edited!'); ?>');proceed('to_add');" ><?php echo translate('edit');?></span> 
                     </div>
                </div>
            </div>
			<?php } ?>