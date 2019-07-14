
 <!-- Header -->     
    <header class="inner-page-bg">
        <div class="container">
            <div class="inner-title">
                <span><?php echo $page_title; ?></span>
            </div>
        </div>
    </header>
    
    
    
    <!-- Breeding Starts -->
    <section class="section-03">
        <div class="container">
            <div class="row">
          
                <div class="col-md-10 col-md-offset-1 why-title md-space">                  
                    <div class="breeding-text">
                        <span class="inner-breeding"><?php echo $page_title; ?></span> 
                    </div>          
                </div>               
            </div>
            <form method="post" action="<?php echo base_url(); ?>index.php/home/pay_info">
            <div class="row md-space">   
               <?php echo $terms_conditions =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_member'))->row()->value; ?>                           
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-xs-10 md-space" style="padding-top:30px;">
                <input type="hidden" name="product_id" value="<?php echo $productid; ?>" />
				<input type="hidden" value="<?php echo $this->security->get_csrf_hash();?>" name="<?php echo $this->security->get_csrf_token_name(); ?>" >
				
                 <input type="checkbox" id="myCheck" class="term-check required tccheck" name="agree" />* I Agree with terms and conditions
				 <p class="notificationerror" style="color:red;"></p>
                    <input type="submit" value="Submit" name="name_agr" onClick="return check();" class="term-button subbtn">
                </div> 
            </div>
            </form>
        </div>
    </section>          
    <!-- Breeding Ends -->
<script>
jQuery(document).ready(function(){
	jQuery('.tccheck').on('click',function(){
		
		if($(this).prop("checked"))
		{
			jQuery('.notificationerror').html('');
		}
		else
		{
			jQuery('.notificationerror').html('This field is requried.');
		}
	});	
});
function check(){
	if(jQuery("#myCheck").is(':checked')){
		return true;
	}else{
		jQuery('.notificationerror').html('This field is requried.');
		return false;
	}
}	
</script>