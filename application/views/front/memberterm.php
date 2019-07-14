
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
            <?php if(isset($_REQUEST['msg'])){
                echo '<p style="color:red; font-size:18px;">(*) field is required.</p>';
                }
                 ?>
                <div class="col-md-10 col-md-offset-1 why-title md-space">                  
                    <div class="breeding-text">
                        <span class="inner-breeding"><?php echo $page_title; ?></span> 
                    </div>          
                </div>               
            </div>
           <?php echo form_open('/home/vendor_membership'); ?>
            <div class="row md-space">   

                 <?php echo $terms_conditions =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_member'))->row()->value; ?>                         
                <!--<div class="col-md-10 col-md-offset-1 col-sm-10 col-xs-10 md-space">
                    <h3 class="term-title">Entire Agreement</h3>
                    <div>If you require a complete delivery of your orders, please enter an X in the Complete Delivery field on the shipping screen of the customer master record. The indicator is copied into the order header, which you can also use for the purpose. </div>
                </div>
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-xs-10 md-space">
                    <h3 class="term-title">controlling terms</h3>
                    <div>If you require a complete delivery of your orders, please enter an X in the Complete Delivery field on the shipping screen of the customer master record. The indicator is copied into the order header, which you can also use for the purpose. </div>
                </div>-->
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-xs-10 md-space" style="padding-top:30px;">	
                    <input type="checkbox" id="myCheck" class="term-check required tccheck" name="agree" />* I Agree with terms and conditions
                    <input type="submit" value="Submit" name="name_agr" onClick="return check();" class="term-button subbtn">
					<p class="notificationerror" style="color:red;"></p>
                </div> 
            </div>
            <?php echo form_close();?>
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