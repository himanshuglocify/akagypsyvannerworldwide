<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >

        <thead>
            <tr>
                <th style="width:4ex"><?php echo translate('ID');?></th>
                <th><?php echo translate('sale_code');?></th>
                <th><?php echo translate('buyer');?></th>
                <th><?php echo translate('date');?></th>
                <th><?php echo translate('total');?></th>
                <th><?php echo translate('delivery_status');?></th>
                <th><?php echo translate('payment_status');?></th>
				<th><?php echo translate('order_related_to');?></th>
                <th class="text-right width286"><?php echo translate('options');?></th>
            </tr>
        </thead>
            
        <tbody>
        <?php
            $i = 0;
            foreach($all_sales as $row){
                $i++; 
        ?>
        <tr class="<?php if($row['viewed'] !== 'ok'){ echo 'pending'; } ?>" >
            <td><?php echo $i; ?></td>
            <td>#<?php echo $row['sale_code']; ?></td>
            <td><?php echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); ?></td>
            <td><?php echo date('d-m-Y',$row['sale_datetime']); ?></td>
            <td class="pull-right"><?php echo currency().$this->cart->format_number($row['grand_total']); ?></td>
            <td>
				<?php 
                    $delivery_status = json_decode($row['delivery_status'],true); 
					$j=1;
                    foreach ($delivery_status as $dev) {
						if($j==count($delivery_status))
							{
                ?>

                <div class="label label-<?php if($dev['status'] == 'delivered'){ ?>purple<?php } else { ?>danger<?php } ?>">
                <?php
                        if(isset($dev['vendor'])){
                            
								echo $dev['status'];
							
                        } else if(isset($dev['admin'])) {
                            echo $dev['status'];
                        }
						}
							$j++;
							
                ?>
                </div>
                <?php
                    }
                ?>
            </td>
            <td>

                <?php 
                    $payment_status = json_decode($row['payment_status'],true); 
					$i=1;
                    foreach ($payment_status as $dev) {
						if($i==1)
							{
                ?>

                <div class="label label-<?php if($dev['status'] == 'paid'){ ?>purple<?php } else { ?>danger<?php } ?>">
			  <?php echo $dev['status']; }
						
                        if(isset($dev['vendor'])){
							if($i==1)
							{
								echo "<br /> Vendor:";
							}
                            echo $this->crud_model->get_type_name_by_id('vendor', $dev['vendor'], 'display_name').' ';
							
							
                        } 					
							$i++;
                    }
                ?> </div>
            </td>
			<td><?php echo $row['product_type']; ?></td>
            <td class="text-right width286">

                <a class="btn btn-info btn-xs btn-labeled fa fa-file-text" data-toggle="tooltip" 
                    onclick="ajax_set_full('view','<?php echo translate('title'); ?>','<?php echo translate('successfully_edited!'); ?>','sales_view','<?php echo $row['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body"><?php echo translate('invoice'); ?>
                </a>
                
                <a class="btn btn-success btn-xs btn-labeled fa fa-usd" data-toggle="tooltip" 
                    onclick="ajax_modal('delivery_status','<?php echo translate('delivery_status'); ?>','<?php echo translate('successfully_edited!'); ?>','delivery_status','<?php echo $row['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body">
                            <?php echo translate('d_status'); ?>
                </a>
                <a class="btn btn-success btn-xs btn-labeled fa fa-usd" data-toggle="tooltip" 
                    onclick="ajax_modal('payment_status','<?php echo translate('payment_status'); ?>','<?php echo translate('successfully_edited!'); ?>','payment_status','<?php echo $row['sale_id']; ?>')" 
                        data-original-title="Edit" data-container="body">
                            <?php echo translate('p_status'); ?>
                </a>
                <a onclick="delete_confirm('<?php echo $row['sale_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" 
                    class="btn btn-danger btn-xs btn-labeled fa fa-trash" data-toggle="tooltip" 
                        data-original-title="Delete" data-container="body"><?php echo translate('del'); ?>
                </a>
            </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>  
    <div id='export-div' style="padding:40px;">
		<h1 id ='export-title' style="display:none;"><?php echo translate('sales'); ?></h1>
		<table id="export-table" class="table" data-name='sales' data-orientation='l' data-width='1500' style="display:none;">
				<colgroup>
					<col width="50">
					<col width="150">
					<col width="150">
					<col width="150">
					<col width="150">
				</colgroup>
				<thead>
					<tr>
                        <th>#</th>
                        <th>Sale Code</th>
                        <th>Buyer</th>
                        <th>Date</th>
                        <th>Total</th>
					</tr>
				</thead>

				<tbody >
				<?php
					$i = 0;
	            	foreach($all_sales as $row){
	            		$i++;
				?>
				<tr>
					<td><?php echo $i; ?></td>
                    <td>#<?php echo $row['sale_code']; ?></td>
                    <td><?php echo $this->crud_model->get_type_name_by_id('user',$row['buyer'],'username'); ?></td>
                    <td><?php echo date('d-m-Y',$row['sale_datetime']); ?></td>
                    <td><?php echo currency().$this->cart->format_number($row['grand_total']); ?></td>              	
				</tr>
	            <?php
	            	}
				?>
				</tbody>
		</table>
	</div>
    
<style type="text/css">
	.pending{
		background: #D2F3FF  !important;
	}
	.pending:hover{
		background: #9BD8F7 !important;
	}
	.width286{ width:286px;}
</style>



           