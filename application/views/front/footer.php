    <?php 
        $contact_address =  $this->db->get_where('general_settings',array('type' => 'contact_address'))->row()->value;
        $contact_phone =  $this->db->get_where('general_settings',array('type' => 'contact_phone'))->row()->value;
        $contact_email =  $this->db->get_where('general_settings',array('type' => 'contact_email'))->row()->value;
		$website_support =  $this->db->get_where('general_settings',array('type' => 'website_support'))->row()->value;
		$sales_queries =  $this->db->get_where('general_settings',array('type' => 'sales_queries'))->row()->value;
		$generic_qustomer_support =  $this->db->get_where('general_settings',array('type' => 'generic_qustomer_support'))->row()->value;
		$breeding_queries =  $this->db->get_where('general_settings',array('type' => 'breeding_queries'))->row()->value;
        $contact_website =  $this->db->get_where('general_settings',array('type' => 'contact_website'))->row()->value;
        $contact_about =  $this->db->get_where('general_settings',array('type' => 'contact_about'))->row()->value;
        
        $facebook =  $this->db->get_where('social_links',array('type' => 'facebook'))->row()->value;
        $googleplus =  $this->db->get_where('social_links',array('type' => 'google-plus'))->row()->value;
        $twitter =  $this->db->get_where('social_links',array('type' => 'twitter'))->row()->value;
        $youtube =  $this->db->get_where('social_links',array('type' => 'youtube'))->row()->value;
        $pinterest =  $this->db->get_where('social_links',array('type' => 'pinterest'))->row()->value;
        
        $footer_text =  $this->db->get_where('general_settings',array('type' => 'footer_text'))->row()->value;
        $footer_category =  json_decode($this->db->get_where('general_settings',array('type' => 'footer_category'))->row()->value);
    ?>
    <!-- Modal -->
    <div class="modal fade" id="v_registration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div id='ajvlup'></div>
    </div>
    <!-- End Modal -->

    <!-- Modal -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div id='ajlin'></div>
    </div>
    <!-- End Modal -->

    <!-- Modal -->
    <div class="modal fade" id="registration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div id='ajlup'></div> 
    </div>
    <!-- End Modal -->
 <!-- Modal -->
    <div class="modal fade" id="hdetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	
	<div style="margin-top:100px !important;" class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" id="close_log_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <br>
        </div>
        <div class="modal-body">
          <div id='horse_details'>horse_details</div> 
            
            
        </div>
        <div class="modal-footer">
            <button id="clsreg" type="button" class="btn-u btn-u-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
        
    </div>
    <!-- End Modal -->
    <a data-toggle="modal" data-target="#login" id="loginss" ></a>
    <a data-toggle="modal" data-target="#registration" id="regiss" ></a>
    <a data-toggle="modal" data-target="#v_registration" id="v_regiss" ></a>
    
    <!-- Footer Section -->
    <section class="footer-section">
        <div class="container top-space">
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="footer-logo">
                    <img src="<?php echo base_url(); ?>uploads/desgin/footer-logo.png" alt="" />
                </div>
                <ul class="address-t">
                    <li><?php echo $website_support; ?></li>
					<li><?php echo $sales_queries; ?></li>
					<li><?php echo $generic_qustomer_support; ?></li>
					<li><?php echo $breeding_queries; ?></li>
					<li><?php echo $contact_email; ?></li>
                </ul> 
            </div>
            <div class="col-md-5 col-sm-5 col-xs-12">
                <div class="search-div">
                Stay Connected
                <p class="stay-text">We will keep you updated with News, Events, & Promotions</p>
                <div class="search-f">
                    <input type="text" class="input-box sub-text" placeholder="ENTER YOURS EMAIL ID" id="subinput" name="email_id_sub" />
                    <input type="button" class="input-button" value="subscribe" id="subscribe_me" />
                </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="search-div">
                    QUICK NAV
                    <ul class="footer-link">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li><a href="<?php echo  base_url(); ?>index.php/home/market">Market</a></li>
                        <li><a href="<?php echo  base_url(); ?>index.php/breed">Breeding</a></li>
						<li><a href="<?php echo  base_url(); ?>index.php/home/terms_conditions">Market Terms</li>
						<li><a href="<?php echo  base_url(); ?>index.php/home/terms_conditions/breeding">Breeding Terms</li>
						<li><a href="<?php echo  base_url(); ?>index.php/home/terms_conditions/member">Member Terms</li>
						<li><a href="<?php echo  base_url(); ?>index.php/home/terms_conditions/dna">DNA Terms</li>
						<li><a href="<?php echo  base_url(); ?>index.php/home/page/about_us">About Us</a></li>
                        <li><a href="<?php echo  base_url(); ?>index.php/home/contact">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="search-div">
                    Social pages:
                    <p class="social-icon">
                    <a href="<?php echo $facebook ?>">
                        <i class="fa fa-facebook-square media-icon" aria-hidden="true"></i>
                    </a>
                    </p>
                </div>
            </div>
        </div>      
    </section>
    <div class="footer-co text-center">
        <div class="top-space">
            <span class="reserved">&copy 2016 All Rights Reserved</span>
        </div>
    </div> 
<script type="text/javascript">    
jQuery(document).ready(function() {
function check_form (a) { if (/^[a-zA-Z0-9]*$/.test(a)) { return true; }else{ return false; } }
// submitting the search form on click 
jQuery('#search_horse').submit(function(event) {
//event.preventDefault();
var error = 0;
var input = jQuery('input[name="horse_id"]').val();
var trimedinput = jQuery.trim(input);
if(input != ''){
if(check_form(trimedinput) == true){
return true;
}else{
notify('Only Numbers are Allowed,! like 5006','warning','bottom','right');
return false; 
}
}else{
notify('Empty Fileds are not Allowed','warning','bottom','right');
return false; 
} 
});
if (location.href.indexOf("#login") != -1) { 
	jQuery('.user_login a').trigger('click');
}
});
</script>
<style type="text/css">
.sub-text{text-transform: none; !important;}
</style>