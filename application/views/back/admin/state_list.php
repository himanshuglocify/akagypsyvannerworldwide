<div class="panel-body" id="demo_s">
	<table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-show-toggle="false" data-show-columns="true" data-search="false" >
            <thead>
                <tr>
                    <th><?php echo translate('no');?></th>
                    <th><?php echo translate('state_name');?></th>
                    <th><?php echo translate('state_code');?></th>
                </tr>
            </thead>				
            <tbody id="states">
        <?php
            $i = 0;
            foreach($all_state as $row){
                $i++;
        ?>                
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['abbrev']; ?></td>
        </tr>
        <?php
            }
        ?>			
            </tbody>
	</table> 
</div>