   <!-- Header -->

   
    <header class="inner-page-bg">
        <div class="container">
            <div class="inner-title">
                <p><?php echo $page_title; ?></p>
            </div>
        </div>
    </header>
      
    <!-- Breeding Starts -->
    <section class="section-03">
        <div class="container">
            <div class="row">
                <div class="col-md-12 why-title md-space">                  
                    <div class="breeding-text">
                        <span class="inner-breeding">Market</span> YOUR DREAM HORSE READY AND WAITING FOR YOU! <a href="<?php echo  base_url(); ?>index.php/home/terms_conditions">learn more...</a>
                    </div>          
                </div>              
            </div>
            <div class="row md-space">
                <?php $attributes = array('class' => 'filter_form', 'id' => 'fl_form');?>
                <?php echo form_open('home/market',$attributes) ?>
                <?php if($user_login == 'yes' && !empty($user_id)){?>
                <div class="col-md-12 col-sm-12 col-xs-12 md-space filter-select">
                    <span class="filter-title">Filter By:</span>
                    <select class="filter-by" id="select_cat" name="cat">
                        <option value="">Select Category</option>
                    <?php 
                    $cat_query = "SELECT * FROM `category`";
                    $carArr = $this->db->query($cat_query);
                    if ($carArr->num_rows() > 0){ 
                    foreach ($carArr->result_array() as $catvalue) {?>
                    <option value="<?php echo $catvalue['category_id'];?>" <?php if((!empty($cat) && $cat == $catvalue['category_id'])){?> selected="selected"<?php } ?>><?php echo $catvalue['category_name'];?></option>   
                    <?php } } ?>                                              
                    </select>
                    <select class="filter-by" id="select_size" name="size">
                        <option value="">Select Size</option>
                    <option value="small" <?php if((!empty($size) && $size == 'small')){?> selected="selected"<?php } ?>>Up to 12hh</option>
					<option value="medium" <?php if((!empty($size) && $size == 'medium')){?> selected="selected"<?php } ?>>12hh to 14hh</option>
					<option value="large" <?php if((!empty($size) && $size == 'large')){?> selected="selected"<?php } ?>>14hh+</option>                        
                    </select>
                    <input type="hidden" name="page" id="curr_page" value="<?php echo $current;?>" />
                    <input type="submit" class="btn btn-primary" name="submit_filters" id="submit_fil" value="Search">
                
                </div> 
                <?php }else{ ?>
                <input type="hidden" name="cat" value="" />
                <input type="hidden" name="age"  value="" />
                <input type="hidden" name="order" value="" />
                <input type="hidden" name="page" id="curr_page" value="<?php echo $current;?>" />
                <?php } ?>             
                <div class="col-md-12 col-sm-12 col-xs-12 md-space"> 
                <?php if($empty > 0){?> 
                <?php foreach($all_products as $product){
                 ?>                  
                    <div class="col-md-4 col-sm-4 col-xs-12 product-list">
                        <ul class="photo-grid">
                            <li id="horse-name01">
                                
                                <figure>
                                <?php if(file_exists("uploads/product_image/product_".$product['product_id']."_1_thumb.jpg")){ ?>
                                    <img  src="/uploads/product_image/product_<?php echo $product['product_id']; ?>_1_thumb.jpg" alt="" class="img-responsive" />
                                    <?php }else { ?>
                                    <img src="/uploads/image-not-found.png" alt="Not image found" />
                                    <?php } ?>
                                    <figcaption>
                                        <div class="onhover-text">
                                            <span class="h-name01"><?php echo $product['title'] ; ?></span>
                                            <p class="h-age01">AGE - 
                                                <?php 
                                                if(!empty($product['date_of_birth'])){
                                                $dob = $product['date_of_birth'];
                                                $dbArr = explode('/', $dob);
                                                $dob = $dbArr[2].'-'.$dbArr[1].'-'.$dbArr[0];
                                                $then_ts = strtotime($dob);
                                                $then_year = date('Y', $then_ts);
                                                $age = date('Y') - $then_year;
                                                if(strtotime('+' . $age . ' years', $then_ts) > time()) $age--;
                                                echo $age;
                                             }
											 
											$description = strip_tags($product['description']);
											if(strlen(trim($description))>100)
												$description = substr(trim($description), 0, 100).'...';
											else
												$description = substr(trim($description), 0, 100); 
                                            ?>
                                            </p>
                                            <p><?php echo $description; ?></p>
                                            <a href="<?php echo base_url().'index.php/home/horse/'.$product['product_id']; ?>"><div class="see-card">         See Card</div></a>
                                        </div>
                                    </figcaption>
                                </figure>
                                <div id="horse-name01" class="horse-name">
									<?php 
                                    $counter_id = $product['country'];
                                    if(!empty($counter_id)){                                     
									$cat_query = "SELECT `country_name` FROM `country` WHERE `country_id` =".$counter_id;
									$catquery = $this->db->query($cat_query);
									$resArr  = $catquery->result_array();
                                    }
									?>
									Country: 
                                    <span class="location"><?php echo $resArr[0]['country_name']; ?></span>
                                </div>
                            </li>                           
                        </ul>                       
                    </div>
                <?php } ?>    
                <?php }else{ ?>
                <div style="font-size: 25px;padding: 13px 3px 3px;text-align: center;"><span>No Record found.</span></div>
                    <?php  }  ?>
                </div>
            </div>
            <div class="row">
                <?php if($total_rows > $item_per_page):?>
                <div class="page-number text-right">
                    <ul>
                        <li data-id="-1"><a href="javascript:void(0);">Prev Page</a></li>
                        <?php 
                        $total_pages = $total_rows;
                        $per_page_item = $item_per_page;
                        $pages = ceil($total_pages / $per_page_item);
                        for($page=1; $page<=$pages;$page++){
                        ?>                        
                        <li data-id="<?php echo $page;?>" <?php if($page == $pages){?> data-last="true"<?php } ?>><a href="javascript:void(0);" <?php if($current == $page){?>class="active"<?php }?>><?php echo $page; ?></a></li>
                        <?php } ?>
                        <li data-id="+1"><a href="javascript:void(0);">Next Page</a></li>
                    </ul>
                </div>
            <?php echo form_close();?>
            <?php endif; ?>
            </div>
        </div>
    </section>          
    <!-- Breeding Ends -->
<script type="text/javascript">
jQuery('.page-number li').click(function(event) {
var thisVal = jQuery(this).attr('data-id');
var last = '';
jQuery('.page-number li').each(function(index, el) { 
if(jQuery(this).attr('data-last') == 'true'){
    last = jQuery(this).attr('data-id');
}
});
var value = jQuery('#curr_page').val();
if(thisVal == '-1' || thisVal == '+1'){
if(thisVal == '-1'){
if((value != '') && (parseInt(value) > 1)){
var new_val=  parseInt(value)-1;
jQuery('#curr_page').val(new_val);
jQuery('#fl_form').submit();
}else{
notify( 'Not allowed','warning','bottom','right');
return false;
}
}else{
if((value != '') && (parseInt(value)+1 <= parseInt(last))){
var new_val=  parseInt(value)+1;
jQuery('#curr_page').val(new_val);
jQuery('#fl_form').submit();
}else{
notify( 'Not allowed','warning','bottom','right');
return false;
}
}
}else{
jQuery('#curr_page').val(thisVal);
jQuery('#fl_form').submit();
}
});
var li = '.filter-by';
jQuery(li).change(function(event) {
 jQuery('#curr_page').val(1);   
})
</script>  