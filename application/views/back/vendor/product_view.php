<!--CONTENT CONTAINER-->
<?php 
	foreach($product_data as $row){
        if($this->crud_model->is_added_by('product',$row['product_id'],$this->session->userdata('vendor_id'))){ 
?>

<h4 class="modal-title text-center padd-all"><?php echo translate('details_of');?> <?php echo $row['title'];?></h4>
	<hr style="margin: 10px 0 !important;">
    <div class="row">
    <div class="col-md-12">
        <div class="text-center pad-all">
            <div class="col-md-3">
                <div class="col-md-12">
                    <img class="img-responsive thumbnail" alt="Profile Picture" 
                        src="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one'); ?>">
                </div>
                <div class="col-md-12" style="text-align:justify;">
                    <p><?php echo $row['description'];?></p>
                </div>
            </div>
            <div class="col-md-9">   
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('name');?></th>
                        <td class="custom_td"><?php echo $row['title']?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('category');?></th>
                        <td class="custom_td">
                            <?php echo $this->crud_model->get_type_name_by_id('category',$row['category'],'category_name');?>
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('sale_price');?></th>
                        <td class="custom_td"><?php echo $row['sale_price']; ?> / <?php echo $row['unit']; ?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('tag');?></th>
                        <td class="custom_td">
                            <?php foreach(explode(',',$row['tag']) as $tag){ ?>
                                <?php echo $tag; ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('status');?></th>
                        <td class="custom_td"><?php echo $row['status']; ?></td>
                    </tr>
                    
                    <tr>
                        <th class="custom_td"><?php echo translate('colors');?></th>
                        <td class="custom_td">
                            <?php echo $row['color']; ?>
                        </td>
                    </tr>
                    
                    <?php
                        if(!empty($all_af)){
                            foreach($all_af as $row1){
                    ?>
                    <tr>
                        <th class="custom_td"><?php echo $row1['name']; ?></th>
                        <td class="custom_td"><?php echo $row1['value']; ?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
					<tr>
                        <th class="custom_td"><?php echo translate('size');?></th>
                        <td class="custom_td"><?php echo $row['size']; ?></td>
                    </tr>
					<tr>
                        <th class="custom_td"><?php echo translate('height');?></th>
                        <td class="custom_td"><?php echo $row['height']; ?></td>
                    </tr>

					<tr>
                        <th class="custom_td"><?php echo translate('country');?></th>
                        <td class="custom_td"><?php $countryinfo = $this->crud_model->getsiglefield('country','country_id',$row['country']); echo $countryinfo->country_name; ?></td>
                    </tr>
					<tr>
                        <th class="custom_td"><?php echo translate('state');?></th>
                        <td class="custom_td"><?php if($row['state']>0){ $stateinfo = $this->crud_model->getsiglefield('states','id',$row['state']); echo $stateinfo->name; } ?></td>
                    </tr>

					<tr>
                        <th class="custom_td"><?php echo translate('city');?></th>
                        <td class="custom_td"><?php echo $row['city']; ?></td>
                    </tr>
					<tr>
                        <th class="custom_td"><?php echo translate('zip_code');?></th>
                        <td class="custom_td"><?php echo $row['zipcode']; ?></td>
                    </tr>

					<tr>
                        <th class="custom_td"><?php echo translate('address');?></th>
                        <td class="custom_td"><?php echo $row['address']; ?></td>
                    </tr>
					<tr>
                        <th class="custom_td"><?php echo translate('address_1');?></th>
                        <td class="custom_td"><?php echo $row['address1']; ?></td>
                    </tr>					
                </table>
            </div>
            <hr>
        </div>
    </div>
</div>				

<?php 
        }
	}
?>
            
<style>
.custom_td{
border-left: 1px solid #ddd;
border-right: 1px solid #ddd;
border-bottom: 1px solid #ddd;
}
</style>

<script>
	$(document).ready(function(e) {
		proceed('to_list');
	});
</script>