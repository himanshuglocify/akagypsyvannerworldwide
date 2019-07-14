	<div class="panel-body" id="demo_s">
		<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,2" data-show-toggle="true" data-show-columns="false" data-search="true" >

			<thead>
				<tr>
					<th><?php echo translate('no');?></th>
					<th><?php echo translate('horse_code');?></th>
					<th><?php echo translate('price');?></th>
					<th><?php echo translate('request');?></th>
					<th><?php echo translate('time');?></th>			
					<th><?php echo translate('status');?></th>						
				</tr>
			</thead>
				
			<tbody >
			<?php
				$i = 0;
            	foreach($all_sell_request as $row){
            		$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['horse_code']; ?></td>
				<td><?php echo $row['price']; ?></td>
				<td><?php echo $row['request_for']; ?></td>
				<td><?php echo date('H:i A d M Y', $row['request_time']); ?></td>		
				<td><?php if($row['status'] == 'Unapproved'){ echo "Under approval"; }else { echo $row['status']; } ?></td>					
			</tr>
            <?php
            	}
			?>
			</tbody>
		</table>
	</div>
           
