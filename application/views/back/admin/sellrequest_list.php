<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-ignorecol="0,6" data-show-toggle="true" data-show-columns="false" data-search="true"  >

        <thead>
            <tr>
                <th><?php echo translate('vendor_name');?></th>
                <th><?php echo translate('horse_code');?></th>
                <th><?php echo translate('price');?></th>
                <th><?php echo translate('request_for');?></th>
                <th class="text-right"><?php echo translate('options');?></th>
            </tr>
        </thead>
            
        <tbody >
        <?php
            $i = 0;
            foreach($sellrequests as $row){
                $i++;
        ?>
        <tr>
            <td><?php
            $vendorid = $row['vendor_id'];
            $stripe_details      = $this->db->get_where('vendor', array('vendor_id' => $vendorid))->row();
            
             echo $stripe_details->display_name; ?></td>
         <td><a style="color:blue; font-size:14px;" href="<?php echo base_url().'index.php/admin/product/'.$row['horse_code']; ?>"><?php echo $row['horse_code']; ?></a></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['request_for']; ?></td>
            <td class="text-right">
               <select class="" name="status_sellreq" id="status_sellreq" onchange="changeStatus(this,<?php echo $row['id']; ?>,'<?php echo $row['price']; ?>');">
               
               <option value="Unapproval" <?php if($row['status'] == 'Unapproval'){ echo 'selected="selected"';} ?> >Under Approval</option>
               <option value="Rejected" <?php if($row['status'] == 'Rejected'){ echo 'selected="selected"';} ?> >Rejected</option>
               <option value="Approved" <?php if($row['status'] == 'Approved'){ echo 'selected="selected"';} ?> >Approved</option>
               </select>
            </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>
           
<script>

function changeStatus(evt,sellid,price)
{
	var valtext = evt.value;
	
	var sellstaus = "Sell Request"+valtext;
	
	ajax_set_full(valtext,sellstaus,'Successfully Updated!',price,sellid);
}


</script>           