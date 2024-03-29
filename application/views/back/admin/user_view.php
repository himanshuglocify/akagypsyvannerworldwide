<?php 
	foreach($user_data as $row)
	{ 
?>
    <div id="content-container" style="padding-top:0px !important;">
        <div class="text-center pad-all">
            <div class="pad-ver">
			<?php if($this->crud_model->file_view('user',$row['user_id'],'','','thumb','src','','one') != ''){$src = $this->crud_model->file_view('user',$row['user_id'],'','','thumb','src','','one'); }else{ $src = base_url().'template/back/img/av1.png';} ?>
                     <img class="img-sm" onerror="this.src='<?php echo base_url(); ?>template/back/img/av1.png'" alt="Profile Picture" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;"
                    src="<?php echo $src; ?>"  />	
            </div>
            <h4 class="text-lg text-overflow mar-no"><?php echo $row['username']?></h4>
            <p class="text-sm"><?php echo translate('user');?></p>
            <div class="pad-ver btn-group">
                <?php if($row['facebook'] != ''){ ?>
                    <a href="<?php echo $row['facebook'];?>" target="_blank" class="btn btn-icon btn-hover-primary fa fa-facebook icon-lg"></a>
                <?php } if($row['skype'] != ''){ ?>
                    <a href="<?php echo $row['skype'];?>" target="_blank" class="btn btn-icon btn-hover-info fa fa-twitter icon-lg"></a>
                <?php } if($row['google_plus'] != ''){ ?>
                    <a href="<?php echo $row['google_plus'];?>" target="_blank" class="btn btn-icon btn-hover-danger fa fa-google-plus icon-lg"></a>
                <?php } ?>
                <a href="#" class="btn btn-icon btn-hover-mint fa fa-envelope icon-lg"></a>
            </div>
            <hr>
        </div>
    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-body">
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('full_name');?></th>
                        <td class="custom_td"><?php echo $row['username'].' '.$row['surname']; ?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('address');?></th>
                        <td class="custom_td">
                            <?php echo $row['address1']?><br>
                            <?php echo $row['address2']?><br>
                            <?php echo $row['city']?>-<?php echo $row['zip']?>
                        </td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('email');?></th>
                        <td class="custom_td"><?php echo $row['email']?></td>
                    </tr>
                    <tr>
                        <th class="custom_td"><?php echo translate('phone_number');?></th>
                        <td class="custom_td"><?php echo $row['phone']?></td>
                    </tr>
                    <?php if($row['skype'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('skype');?></th>
                        <td class="custom_td"><?php echo $row['skype']?></td>
                    </tr>
                    <?php } if($row['facebook'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('facebook');?></th>
                        <td class="custom_td"><?php echo $row['facebook']?></td>
                    </tr>
                    <?php } if($row['google_plus'] != ''){ ?>
                    <tr>
                        <th class="custom_td"><?php echo translate('google_plus');?></th>
                        <td class="custom_td"><?php echo $row['google_plus']?></td>
                    </tr>
                    <?php } ?>
                  <!--  <tr>
                        <th class="custom_td"><?php echo translate('creation_date');?></th>
                        <td class="custom_td"><?php echo date('d M,Y',$row['creation_date']);?></td>
                    </tr> -->
                </table>
              </div>
            </div>
        </div>					
    </div>					
<?php 
	}
?>
            
<style>
.custom_td{
border-left: 1px solid #ddd;
border-right: 1px solid #ddd;
border-bottom: 1px solid #ddd;
}
</style>