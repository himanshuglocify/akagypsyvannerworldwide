<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" >
        <thead>
            <tr>
                <th><?php echo translate('no');?></th>
                <th><?php echo translate('name');?></th>
                <th class="text-right"><?php echo translate('options');?></th>
            </tr>
        </thead>				
        <tbody >
        <?php
            $i = 0;
            foreach($all_zones as $row){
                $i++;
        ?>                
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['zone']; ?></td>
            
            <td class="text-right">
                
				 <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                    onclick="ajax_set_full('edit','<?php echo translate('edit_zone'); ?>','<?php echo translate('successfully_edited!'); ?>','zone_edit','<?php echo $row['id']; ?>');proceed('to_list');" data-original-title="Edit" data-container="body">
                        <?php echo translate('edit');?>
                </a>
                <a onclick="delete_confirm('<?php echo $row['id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" class="btn btn-xs btn-danger btn-labeled fa fa-trash" data-toggle="tooltip" 
                    data-original-title="Delete" data-container="body">
                        <?php echo translate('delete'); ?>
                </a>
            </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>
    <div id="vendr"></div>
    <div id='export-div' style="padding:40px;">
		<h1 id ='export-title' style="display:none;"><?php echo translate('zones'); ?></h1>
		<table id="export-table" class="table" data-name='zone' data-orientation='p' data-width='1500' style="display:none;">
				<colgroup>
					<col width="50">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
						<th><?php echo translate('no');?></th>
						<th><?php echo translate('zone_name');?></th>
                        
					</tr>
				</thead>



				<tbody >
				<?php
					$i = 0;
	            	foreach($all_zones as $row){
	            		$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
                    <td><?php echo $row['zone']; ?></td>         	
				</tr>
	            <?php
	            	}
				?>
				</tbody>
		</table>
	</div>
           