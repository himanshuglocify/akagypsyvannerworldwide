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
?>
<!-- Header -->


<header class="inner-page-bg">
	<div class="container">
		<div class="inner-title">
			<p><?php echo $page_title; ?></p>
			<span class="innerbanner-title"><a href="#">Home</a>   /  <a href="#">Contact</a></span>
		</div>
	</div>
</header>

<div class="container content">		
    <div class="row margin-bottom-60">
        <div class="col-md-6 col-sm-6">
            <!-- Google Map -->
            <div id="contact_map" class="height-450">
            </div>
            <!-- End Google Map -->
        </div>
        <div class="col-md-6 col-sm-6">
            <!-- Contacts -->
            <h3><?php echo translate('contact');?></h3>
            <ul class="list-unstyled who">
                <li><a href="#"><i class="fa fa-home"></i><?php echo $contact_address; ?></a></li>
                <li><a href="mailto:<?php echo $contact_email; ?>"><i class="fa fa-envelope"></i><?php echo $contact_email; ?></a></li>
                <li><a href="mailto:<?php echo $website_support; ?>"><i class="fa fa-envelope"></i><?php echo $website_support; ?></a></li>
				<li><a href="mailto:<?php echo $sales_queries; ?>"><i class="fa fa-envelope"></i><?php echo $sales_queries; ?></a></li>
				<li><a href="mailto:<?php echo $generic_qustomer_support; ?>"><i class="fa fa-envelope"></i><?php echo $generic_qustomer_support; ?></a></li>
				<li><a href="mailto:<?php echo $breeding_queries; ?>"><i class="fa fa-envelope"></i><?php echo $breeding_queries; ?></a></li>
            </ul>

            <hr>
            
            <!-- Business Hours -->
            <h3><?php echo translate('about_us');?></h3>
            <?php echo $contact_about; ?>
        </div>
    </div>

    <!-- Contact form Start -->
    <h3><?php echo translate('get_in_touch');?></h3>
	<?php
        echo form_open(base_url() . 'index.php/home/contact/send', array(
            'class' => 'sky-form',
            'method' => 'post',
            'enctype' => 'multipart/form-data',
            'id' => 'sky-form3'
        ));
    ?>    
        <header><?php echo translate('contact_form');?></header>
        
        <fieldset>                  
            <div class="row">
                <section class="col col-6">
                    <label class="label"><?php echo translate('name');?></label>
                    <label class="input">
                        <i class="icon-append fa fa-user"></i>
                        <input type="text" name="name" id="name" class='required' >
                    </label>
                </section>
                <section class="col col-6">
                    <label class="label"><?php echo translate('e-mail');?></label>
                    <label class="input">
                        <i class="icon-append fa fa-envelope-o"></i>
                        <input type="email" name="email" id="email" class='required' >
                    </label>
                </section>
            </div>
            
            <section>
                <label class="label"><?php echo translate('subject');?></label>
                <label class="input">
                    <i class="icon-append fa fa-tag"></i>
                    <input type="text" name="subject" id="subject" class='required' >
                </label>
            </section>
            
            <section>
                <label class="label"><?php echo translate('message');?></label>
                <label class="textarea">
                    <i class="icon-append fa fa-comment"></i>
                    <textarea rows="4" name="message" id="message" class='required' ></textarea>
                </label>
            </section>
            
            </section>
            	<?php echo $recaptcha_html; ?>
            <section>
        </fieldset>
        
        <footer>
            <span class="button submittertt" data-ing='<?php echo translate('sending..'); ?>' ><?php echo translate('send_message:');?></span>
        </footer>
    </form>
    <!-- Contact form End -->
</div>

<script>
	var add_to_cart = '<?php echo translate('add_to_cart'); ?>';
	var valid_email = '<?php echo translate('must_be_a_valid_email_address'); ?>';
	var required = '<?php echo translate('required'); ?>';
	var sent = '<?php echo translate('message_sent!'); ?>';
	var incor = '<?php echo translate('incorrect_captcha!'); ?>';
	var required = '<?php echo translate('required'); ?>';
    var address = '<?php echo $contact_address; ?>';
	var base_url = '<?php echo base_url(); ?>';
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=false"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/custom/contact.js"></script>