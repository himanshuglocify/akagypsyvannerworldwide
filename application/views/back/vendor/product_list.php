<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,6" data-show-toggle="true" data-show-columns="false" data-search="true" >
        <thead>
            <tr>
                <th><?php echo translate('image');?></th>
                <th><?php echo translate('name');?></th>
				<th><?php echo translate('registration_number');?></th>
				<th><?php echo translate('status');?></th>
                <th class="text-right"><?php echo translate('options');?></th>
            </tr>
        </thead>

        <tbody >
        <?php
            $i=0;
            foreach($all_product as $row){
                if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id'))){
                $i++;
        ?>
        <tr>
            <td>
                <img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;"
                    src="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'); ?>"  />
            </td>
            <td><?php echo $row['title']; ?></td>
			<td><?php echo $row['horse_code']; ?></td>
			<td><?php echo $row['status']; ?></td>
            <td class="text-right">
                <a class="btn btn-info btn-xs btn-labeled fa fa-location-arrow" data-toggle="tooltip" 
                    onclick="ajax_set_full('view','<?php echo translate('view_product'); ?>','<?php echo translate('successfully_viewed!'); ?>','product_view','<?php echo $row['product_id']; ?>');proceed('to_list');" data-original-title="View" data-container="body">
                        <?php echo translate('view');?>
                </a>
               
                <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                    onclick="ajax_set_full('edit','<?php echo translate('edit_product'); ?>','<?php echo translate('successfully_edited!'); ?>','product_edit','<?php echo $row['product_id']; ?>');proceed('to_list');" data-original-title="Edit" data-container="body">
                        <?php echo translate('edit');?>
                </a>
                
                <a onclick="delete_confirm('<?php echo $row['product_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" 
                    class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip" data-original-title="Delete" data-container="body">
                        <?php echo translate('delete');?>
                </a>
                
            </td>
        </tr>
        <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>
    <div id='export-div' style="padding:40px;">
		<h1 id ='export-title' style="display:none;"><?php echo translate('horse');?></h1>
		<table id="export-table" class="table" data-name='product' data-orientation='l' data-width='1500' style="display:none;">
				<colgroup>
					<col width="50">
					<col width="150">
					<col width="150">
					<col width="150">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
						<th><?php echo translate('no');?></th>
						<th><?php echo translate('name');?></th>
						<th><?php echo translate('registration_number');?></th>
						<th><?php echo translate('category');?></th>
						<th><?php echo translate('sale Price');?></th>
						<th><?php echo translate('creation Date');?></th>
					</tr>
				</thead>

 

				<tbody >
				<?php
					$i = 0;
	            	foreach($all_product as $row){
                        if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id'))){
	            		$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
					<td><?php echo $row['title']; ?></td>
					<td><?php echo $row['horse_code']; ?></td>
					<td><?php echo $this->crud_model->get_type_name_by_id('category',$row['category'],'category_name'); ?></td>
					<td><?php echo currency().$row['sale_price']; ?></td>
					<td><?php echo date('d M, Y',$row['add_timestamp']); ?></td>
				</tr>
	            <?php
                        }
	            	}
				?>
				</tbody>
		</table>
	</div>
