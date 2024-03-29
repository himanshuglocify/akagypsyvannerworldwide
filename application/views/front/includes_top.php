<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  
<head>
    <title><?php echo $page_title; ?> | <?php echo $system_title; ?></title>
    
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo $description; if($page_name == 'vendor_home'){ echo ', '.$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->description; } ?> ?>">
    <meta name="keywords" content="<?php echo $keywords; if($page_name == 'vendor_home'){ echo ', '.$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->keywords; } ?>">
    <meta name="author" content="<?php echo $author; ?>">
    <meta name="revisit-after" content="<?php echo $revisit_after; ?> days">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="expires" content="Mon, 10 Dec 2001 00:00:00 GMT" />
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    
    <?php 
        if($page_name == 'product_view'){
            foreach($product_data as $row)
            {
    ?>
        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $row['title']; ?>">
        <meta itemprop="description" content="<?php echo strip_tags($row['description']); ?>">
        <meta itemprop="image" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>">
        
        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@publisher_handle">
        <meta name="twitter:title" content="<?php echo $row['title']; ?>">
        <meta name="twitter:description" content="<?php echo strip_tags($row['description']); ?>">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>">
        
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $row['title']; ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php  echo base_url(); ?>index.php/home/product_view/<?php echo $row['product_id']; ?>" />
        <meta property="og:image" content="<?php echo $this->crud_model->file_view('product',$row['product_id'],'','','no','src','multi','one'); ?>" />
        <meta property="og:description" content="<?php echo strip_tags($row['description']); ?>" />
        <meta property="og:site_name" content="<?php echo $row['title']; ?>" />
    <?php
            }
        } 
        if($page_name == 'vendor_home'){
            $vendor_data = $this->db->get_where('vendor',array('vendor_id'=>$vendor))->result_array();
            foreach($vendor_data as $row)
            {
    ?>
        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $row['display_name']; ?>">
        <meta itemprop="description" content="<?php echo strip_tags($row['description']); ?>">
        <meta itemprop="image" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png">
        
        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@publisher_handle">
        <meta name="twitter:title" content="<?php echo $row['display_name']; ?>">
        <meta name="twitter:description" content="<?php echo strip_tags($row['description']); ?>">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png">
        
        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $row['display_name']; ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?php  echo base_url(); ?>index.php/home/vendor/<?php echo $row['vendor_id']; ?>" />
        <meta property="og:image" content="<?php echo base_url(); ?>uploads/vendor/logo_<?php echo $vendor; ?>.png" />
        <meta property="og:description" content="<?php echo strip_tags($row['description']); ?>" />
        <meta property="og:site_name" content="<?php echo $system_title; ?>" />
    <?php
            }
        }
    ?>
    
     <!-- Favicon -->
    <?php $ext =  $this->db->get_where('ui_settings',array('type' => 'fav_ext'))->row()->value;?>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/others/favicon.<?php echo $ext; ?>">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/shop.style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/app.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/ie8.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/blocks.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/plugins.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/plugins/animate.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/plugins/box-shadows.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/headers/header-purple.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/headers/header-blue.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/headers/header-green.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/headers/header-grey.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/headers/header-aqua.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/headers/header-pink.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/footers/footer-purple.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/footers/footer-blue.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/footers/footer-green.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/footers/footer-grey.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/footers/footer-aqua.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/footers/footer-pink.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/jquery-steps/css/custom-jquery.steps.css">

	
    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/line-icons/line-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/scrollbar/src/perfect-scrollbar.css">
 
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">
   
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/revolution-slider/rs-plugin/css/settings.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/pages/profile.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/app.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/pages/page_contact.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/flexslider/flexslider.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/noUiSlider/jquery.nouislider.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/plugins.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/parallax-slider/css/parallax-slider.css">
    <!-- CSS Page Style -->    
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/pages/page_log_reg_v2.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/pages/log-reg-v3.css">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/ladda-buttons/css/custom-lada-btn.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/plugins/hover-effect/css/custom-hover-effects.css"> 
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/sky-forms/version-2.0.1/css/custom-sky-forms.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/zoompic/multizoom.css">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/theme-colors/default.css">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/css/custom.css">
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/noUiSlider/jquery.nouislider.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/ionrangeslider/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/ionrangeslider/css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/ionrangeslider/css/ion.rangeSlider.skinModern.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/fancybox/source/jquery.fancybox.css">     

    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/js/share/jquery.share.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/zoome/css/zoome-min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/layerslider/assets/css/doc.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/front/assets/plugins/image-hover/css/img-hover.css">
    
    <script src="<?php echo base_url(); ?>template/front/assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>template/front/assets/js/share/jquery.share.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>template/front/assets/plugins/zoome/zoome.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,700,900' rel='stylesheet' type='text/css'>
	<link href="http://fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,300,400italic,400,600italic,600,700italic,700,800italic,800" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>


</head>
<?php
    $theme_color =  $this->db->get_where('ui_settings',array('type' => 'header_color'))->row()->value;
?>
