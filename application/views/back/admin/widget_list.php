<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,2" data-show-toggle="false" data-show-columns="false" data-search="true" >

        <thead>
            <tr>
                <th><?php echo translate('s_no.');?></th>
                <th><?php echo translate('widget_name');?></th>
                <th class="text-right"><?php echo translate('options');?></th>
            </tr>
        </thead>
            
        <tbody >
        <?php
            $i = 0;
            foreach($widgets as $row){
                $i++;
        ?>
       <tr>
            <td><?php echo $i; ?></td>
         <td><?php echo $row['name']; ?></td>
         <td>

         <td>
              <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                    onclick="ajax_set_full('edit','<?php echo translate('edit_widget'); ?>','<?php echo translate('successfully_edited!'); ?>','widget_edit','<?php echo $row['widget_id']; ?>');proceed('to_list');" data-original-title="Edit" data-container="body">
                        <?php echo translate('edit');?>
                </a>
                <a onclick="delete_confirm('<?php echo $row['widget_id']; ?>','<?php echo translate('really_want_to_delete_this?'); ?>')" class="btn btn-xs btn-danger btn-labeled fa fa-trash" data-toggle="tooltip" 
                    data-original-title="Delete" data-container="body">
                        <?php echo translate('delete');?>
                </a>
             
         </td>   
        </tr> 
        <?php
            }
        ?>
        </tbody>
    </table>
</div>
           
<script>

function changeStatus(evt,sellid)
{
	var valtext = evt.value;
	var sellstaus = "Sell Request"+valtext;
	
	ajax_set_full(valtext,sellstaus,'Successfully Updated!',valtext,sellid);
}


</script>           