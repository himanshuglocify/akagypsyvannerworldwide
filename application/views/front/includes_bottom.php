<script>
jQuery(document).ready(function(){
	
	var hasval = window.location.hash.substr(1);
	
	if(hasval == 'reg_vebdor')
	{
		setTimeout(function(){
			$('html, body').animate({
			  scrollTop: 3000
			}, 1500);	
		},1000);
	}
	
	jQuery('.register-button').on('click',function(){
		var valu = jQuery(this).attr('title');
		var valid = jQuery(this).attr('data-pre-val');
		jQuery('.membershipprice').remove();
		jQuery('#v_registration #ajvlup form').append('<input type="hidden" class="membershipprice" name="price" value=\"'+valu+'\" >');
		jQuery('#v_registration #ajvlup form').append('<input type="hidden" class="membershipprice" name="plan" value=\"'+valid+'\" >');
	});
});


	jQuery(document).ready(function(){
		jQuery('.showHorsedetails').on('click',function(){
			
			var disbleid = jQuery(this).attr('title');
			var diskey = '#'+disbleid+'_avalibe_id';
			var horse_id = jQuery(diskey).val();
			
			$.ajax({
						url: base_url+'index.php/home/singleproduct/'+horse_id, // form action url
						type: 'POST', // form submit method get/post
						dataType: 'html', // request type html/json/xml
						cache       : false,
						contentType : false,
						processData : false,
						
						success: function(data) {
						jQuery('#horse_details').html(data);
						},
						error: function(e) {
							console.log(e)
						}
					});
			
		});
	
	});

    function set_loggers(){
        var state = check_login_stat('state');
        var name = check_login_stat('username');
        state.success(function (data) {
            if(data == 'hypass'){
                name.success(function (data) {
                    var menuhtml = '<li>'
                    +'        <a href="<?php echo base_url(); ?>index.php/home/profile/">'+data+'</a>'
                    +'    </li>'
                    +'    <li>'
                    +'       <a href="<?php echo base_url(); ?>index.php/home/logout/"><?php echo translate('logout');?></a>'
                    +'    </li>'
					+'<li><a href="#" class="search"><img alt="" src="<?php echo base_url();?>template/front/assets/img/search-icon.png"></a></li>'
                    +'';
					//jQuery('#loginsets').append(menuhtml);
                });
                if($('body').find('.shopping-cart').length){
                    set_cart_form();
                }
            } else {
                var vloginurl = '<?php echo base_url()."index.php/vendor";?>';
                var form_action ='<?php echo base_url()."index.php/search/results"?>';
                var menuhtml = '<li>'
                +'        <a data-toggle="modal" data-target="#login" class="point"><?php echo translate('login');?></a>'
                +'    </li>'
                +'    <li>'
                +'        <a href="'+vloginurl+'" class="point"><?php echo translate('vendor_login');?></a>'
                +'    </li>'
                +'    <li>'
                +'       <a data-toggle="modal" onclick="scrollregistration();" id="reg_vebdor" class="point"><?php echo translate('registration');?></a>'
                +'    </li>'    
				+'<li><a href="#" class="search"><img alt="" src="<?php echo base_url();?>template/front/assets/img/search-icon.png"></a></li>'
                +'';
				//jQuery('#loginsets').append(menuhtml);
            }
        });  
        //onclick="ajax_load('+"'<?php echo base_url(); ?>index.php/home/login_set/login','login')"+';"
        var cart = '';
        if($('body').find('.shopping-cart').length){
            cart = 'cart';
        }
        ajax_load('<?php echo base_url(); ?>index.php/home/vendor_logup/registration/','ajvlup');
        ajax_load('<?php echo base_url(); ?>index.php/home/login_set/registration/'+cart,'ajlup');
        ajax_load('<?php echo base_url(); ?>index.php/home/login_set/login/'+cart,'ajlin');
    }

    function check_login_stat(thing){
        return $.ajax({
            url: '<?php echo base_url(); ?>index.php/home/check_login/'+thing
        });
    }


    function set_cart_form(){
        check_login_stat('langlat').success(function (data) { $('#langlat').val(data); });
        check_login_stat('username').success(function (data) { $('#name').val(data); });
        check_login_stat('email').success(function (data) { $('#email').val(data); });
        check_login_stat('surname').success(function (data) { $('#surname').val(data); });
        check_login_stat('phone').success(function (data) { $('#phone').val(data); });
        check_login_stat('address1').success(function (data) { $('#address_1').val(data); });
        check_login_stat('address2').success(function (data) { $('#address_2').val(data); });
        check_login_stat('city').success(function (data) { $('#city').val(data); });
        check_login_stat('zip').success(function (data) { $('#zip').val(data); });
    }
  function scrollregistration()
  {
	    var urli = '<?php echo $_SERVER['REQUEST_URI']; ?>';
		var n = urli.length;
		if(n>1)
		{
			window.location.href = '<?php echo base_url(); ?>#reg_vebdor';
		}
		else{
		$('html, body').animate({
          scrollTop: 3000
        }, 1500);	
		}
	     
        //window.scrollBy(0, 2500);
  }
    $( document ).ready(function() {


        set_loggers();
		$(document).on('click', 'a.search', function(){
			$('.top-search-div').animate({
            height: 'toggle'
        });
		});
		
    <?php 
      $a = $this->session->flashdata('alert');
      if(isset($a)){ 
    ?>
      <?php if($this->session->flashdata('alert') == 'successful_signup'){ ?>
                setTimeout(function(){ sound('successful_logup');}, 800);  
        setTimeout(function(){ notify('<?php echo translate('you_registered_successfully'); ?>','success','bottom','right');}, 800);
      <?php } ?>
      <?php if($this->session->flashdata('alert') == 'successful_signin'){ ?>
        setTimeout(function(){ sound('successful_login');}, 800);  
                setTimeout(function(){ notify('<?php echo translate('you_logged_in_successfully'); ?>','success','bottom','right');}, 800);
      <?php } ?>
		<?php if($this->session->flashdata('alert') == 'successful_signout'){ ?>
			setTimeout(function(){ sound('successful_logout');}, 800);  
			setTimeout(function(){ notify('<?php echo translate('you_logged_out_successfully'); ?>','success','bottom','right');}, 800);
		<?php } ?>
		<?php if($this->session->flashdata('alert') == 'unsuccessful_stripe'){ ?>
			setTimeout(function(){ sound('successful_login');}, 800);  
			setTimeout(function(){ notify('<?php echo translate('something_wrong_with_stripe,_try_again!'); ?>','success','bottom','right');}, 800);
		<?php } ?>
		<?php if($this->session->flashdata('alert') == 'payment_canceled'){ ?>
			setTimeout(function(){ notify('<?php echo translate('payment_canceled_successfully'); ?>','success','bottom','right');}, 800);
		<?php } ?>	
		<?php if($this->session->flashdata('alert') == 'vendorapprove'){ ?>
			setTimeout(function(){ notify('<?php echo translate('your_account_has_been_approved.'); ?>','success','bottom','right');}, 800);
		<?php } ?>			
    <?php } ?>
    });

    var base_url = '<?php echo base_url(); ?>';
    function register(){
        setTimeout( function(){ 
            $('#regiss').click();
        }
        , 400 );
    }

    function signin(){
        setTimeout( function(){ 
            $('#loginss').click();
        }
        , 400 );
    }

    function vend_logup(){
        setTimeout( function(){ 
            $('#v_regiss').click();
        }
        , 5000 );
    }

</script>

<?php
    echo form_open('', array(
        'method' => 'post',
        'id' => 'cart_form_singl'
    ));
?>
<input type="hidden" name="color" value="">
<input type="hidden" name="qty" value="1">
</form>

<!-- JS Global Compulsory -->
<script src="<?php echo base_url(); ?>template/front/assets/plugins/jquery/jquery-migrate.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- JS Implementing Plugins -->
<script src="<?php echo base_url(); ?>template/front/assets/plugins/back-to-top.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/scrollbar/src/jquery.mousewheel.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/scrollbar/src/perfect-scrollbar.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/noUiSlider/jquery.nouislider.full.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/jquery.parallax.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/jquery-steps/build/jquery.steps.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/sky-forms/version-2.0.1/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/sky-forms/version-2.0.1/js/jquery-ui.min.js"></script>


<script src="<?php echo base_url(); ?>template/front/assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/plugins/revolution-slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<!-- JS Customization -->
<script src="<?php echo base_url(); ?>template/front/assets/js/custom.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/stepWizard.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/forms/page_login.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/forms/product-quantity.js"></script>
<script src="<?php echo base_url(); ?>template/front/assets/js/ajax_method.js"></script>


<!-- JS Page Level -->
<script src="<?php echo base_url(); ?>template/front/assets/js/shop.app.js"></script>


<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/owl-carousel.js"></script>

<script src="<?php echo base_url(); ?>template/front/assets/js/plugins/revolution-slider.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/js/plugins/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/counter/waypoints.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/js/pages/page_contacts.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/flexslider/jquery.flexslider-min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/js/plugins/parallax-slider.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/parallax-slider/js/modernizr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/parallax-slider/js/jquery.cslider.js"></script>

<script  type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/ionrangeslider/js/ion.rangeSlider.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/js/plugins/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/js/plugins/fancy-box.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/image-hover/js/modernizr.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/image-hover/js/touch.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/bootbox/bootbox.min.js"></script>
<script>
  $('html, body').css({
    'overflow': 'hidden',
    'height': '100%'
  });
  
    // jQuery(document).ready(function() {
    //     App.init();  
    //     App.initParallaxBg();
    //     OwlCarousel.initOwlCarousel();
    //     RevolutionSlider.initRSfullWidth();
    //     ParallaxSlider.initParallaxSlider(); 
    //     FancyBox.initFancybox(); 
    // });
  
    $(document).ready(function() {
        ajax_load('<?php echo base_url(); ?>index.php/home/cart/added_list/','added_list');
      <?php
      if($this->session->userdata('user_login') == 'yes'){
    ?>
    setInterval(session_check, 6000);
    function session_check(){
      $.ajax({
        url: '<?php echo base_url(); ?>index.php/home/is_logged/',
        success: function(data) {
          if(data == 'yah!good'){}
          else if (data == 'nope!bad') {
            location.replace('<?php echo base_url(); ?>');
          }
        },
        error: function(e) {
          console.log(e)
        }
      });
    }
    <?php
      }
    ?>
    // Hide it after 3 seconds
        setTimeout(function(){
            $('html, body').css({
                'overflow': 'auto',
                'height': 'auto'
            });
            $('#preloader').fadeOut("slow");
        }, 1200);
        setTimeout(function(){
            if($('#layerslider').length){
                start_slider();
            }
            //$('#chatContainer').show('slow');
        }, 800);
    }); 

    <?php
        $volume = $this->crud_model->get_type_name_by_id('general_settings','50','value');
        if($this->crud_model->get_type_name_by_id('general_settings','49','value') == 'ok'){
    ?>
        function sound(type){
            document.getElementById(type).volume = <?php if($volume == '10'){ echo 1 ; }else{echo '0.'.round($volume); } ?>;
            document.getElementById(type).play();
        }
    <?php
        } else {
    ?>
        function sound(type){}
    <?php
        }
    ?>
</script>
<?php
    $audios = scandir('uploads/audio/home/');
    foreach ($audios as $row) {
        if($row !== '' && $row !== '.' && $row !== '..'){
            $row = str_replace('.mp3', '', $row);
?>
<audio style='display:none;' id='<?php echo $row; ?>' ><source type="audio/mpeg" src="<?php echo base_url(); ?>uploads/audio/home/<?php echo $row; ?>.mp3"></audio>
<?php
        }
    }
?>
<!--[if lt IE 9]>
    <script src="<?php echo base_url(); ?>template/front/assets/plugins/respond.js"></script>
    <script src="<?php echo base_url(); ?>template/front/assets/plugins/html5shiv.js"></script>
    <script src="<?php echo base_url(); ?>template/front/assets/js/plugins/placeholder-IE-fixes.js"></script>
<![endif]-->
<!-- adding the script files for the carousal start here -->
<script type="text/javascript">
jQuery(document).ready(function() {
//adding the owl carousal at the middle section of the page
var owl_cat = jQuery("#owl-cat");
owl_cat.owlCarousel({
autoPlay : true,
goToFirst: false,
goToFirstSpeed:1000,
slideSpeed : 2000,
items : 4,
navigation: false,
navigationText: ["<",">"],
pagination: false,
responsive: true,
//itemsDesktop : [1000,5], //5 items between 1000px and 901px
//itemsDesktopSmall : [900,3], // betweem 900px and 601px
//itemsTablet: [600,2], //2 items between 600 and 0;
//itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option 
});
jQuery('#owl-cat-next').click(function(event) {
// trigger the pre on the custom button start here
owl_cat.trigger('owl.next'); 
});
jQuery('#owl-cat-pre').click(function(event) {
// trigger the next on the custom button start here
owl_cat.trigger('owl.prev'); 
});

// clicked on the item and perform the regarding task ends here //
}); // ending the ready function here  
//adding the second owl-carousal for the breed section start here //
jQuery(document).ready(function() {
var owl_breed = jQuery("#owl-breed");
owl_breed.owlCarousel({
autoPlay : true,
goToFirst: false,
goToFirstSpeed:1000,
slideSpeed : 2000,
items : 3,
navigation: false,
navigationText: ["<",">"],
pagination: false,
responsive: true,
//itemsDesktop : [1000,5], //5 items between 1000px and 901px
//itemsDesktopSmall : [900,3], // betweem 900px and 601px
//itemsTablet: [600,2], //2 items between 600 and 0;
//itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option 
});
jQuery('#owl-breed-next').click(function(event) {
// trigger the pre on the custom button start here
owl_breed.trigger('owl.next'); 
});
jQuery('#owl-breed-pre').click(function(event) {
// trigger the next on the custom button start here
owl_breed.trigger('owl.prev'); 
});
//adding the second owl-carousal for the breed section ends here //


var subme = '#subscribe_me';
function checkMail(t) {
var testEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
if(testEmail.test(t)){return true;}else{return false;} 
}
jQuery(subme).click(function(event) {
var e = jQuery('#subinput').val();
if(e != ''){
if(checkMail(e) == true){
var ajaxUrl = base_url+'index.php/newsletter/add/email_id/';
var token = '<?php echo $this->security->get_csrf_hash();?>';
jQuery.ajax({
url: ajaxUrl,
type: 'POST',
dataType: 'html',
data: {'email_id' : e,'token':token},
cache       : false,
success: function(data) {
var data = JSON.parse(data);
if(jQuery.trim(data.sts) == 'success'){
notify( data.message,'success','bottom','right');
}else{
notify( data.message,'warning','bottom','right');
}
}
});
}else{
notify('Email format is not correct','warning','bottom','right');
return false;   
}
}else{
notify('Empty Fields are not Allowed','warning','bottom','right');
return false;
}
});

jQuery('#fl_form').submit(function(event) {
   return true;

});
}); // end of ready function here
jQuery(document).ready(function($) {
// adding  the third carousal on the homepage start here
var owl_all = jQuery('#pro_row1');
owl_all.owlCarousel({
autoPlay : true,
goToFirst: false,
goToFirstSpeed:1000,
slideSpeed : 2000,
items : 2,
navigation: false,
navigationText: ["<",">"],
pagination: false,
responsive: true,
//itemsDesktop : [1000,5], //5 items between 1000px and 901px
//itemsDesktopSmall : [900,3], // betweem 900px and 601px
//itemsTablet: [600,2], //2 items between 600 and 0;
//itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option 
});
jQuery('#product_next_slide').click(function(event) {
// trigger the pre on the custom button start here
owl_all.trigger('owl.next'); 
});
jQuery('#product_prev_slide').click(function(event) {
// trigger the next on the custom button start here
owl_all.trigger('owl.prev'); 
});
// adding  the third carousal on the homepage ends here 
}); // end of the ready function here
</script>
<!-- adding the script files for the carousal ends here -->
</body>
</html> 