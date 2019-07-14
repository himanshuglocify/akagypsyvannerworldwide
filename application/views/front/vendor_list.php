   <!-- Header -->
    <header class="inner-page-bg">
        <div class="container">
            <div class="inner-title">
                <p><?php echo $page_title; ?></p>
            </div>
        </div>
    </header>

    <section class="section-03">
        <div class="container">
			<div class="row">
			<?php foreach($vendorlist as $vendor){ 
					$file = base_url().'uploads/vendor_image/vendor_'.$vendor['vendor_id'].'_thumb.jpg';
					$file_headers = @get_headers($file);
					if($file_headers[0] == 'HTTP/1.1 404 Not Found'){
						$file = base_url()."template/front/assets/img/avtar.png";
					}
			?>  
					<div class="col-md-3 col-sm-3 col-xs-12 vendor-list">
					<a href="<?php echo base_url().'index.php/home/vendor_detail/'.$vendor['vendor_id']; ?>">
						<ul class="demo-2 effect">
							<li>
							   <h2 class="zero"><?php echo $vendor['username'].' '.$vendor['surname']; ?></h2>
							</li>
							<li><div class="vendor_img top" style="background: url(<?php echo $file; ?>) no-repeat scroll center center / cover; height:200px; width: 100%; height: 100%; margin: 0px;">
												</div></li>
						</ul>
					</a>
						<!--<div class="vendor_img" style="background: url(<?php echo $file; ?>) no-repeat scroll center center / cover; height:200px; ">
						</div>
						<div class="vendor_details" style="height:100px;">
						
						</div>-->
					</div>
			<?php } ?>
			</div>
        </div>
    </section>    

<style>
.demo-2.effect {
    list-style: outside none none;
}
.demo-2 {
    position:relative;
    width:100%;
    height:220px;
    overflow:hidden;
    float:left;
    margin-right:20px;
    background-color:rgba(30, 42, 65, 0.9)
}
.demo-2 p,.demo-2 h2 {
    color:#fff;
    padding:10px;
    left:-20px;
    top:20px;
    position:relative
}
.demo-2 p {
    font-family:'Lato';
    font-size:12px;
    line-height:18px;
    margin:0
}
.demo-2 h2 {
    font-size:20px;
    line-height:24px;
    margin:0;
    font-family:'Lato'
}
.effect .vendor_img {
    position:absolute;
    left:0;
    bottom:0;
    cursor:pointer;
    margin:-12px 0;
    -webkit-transition:bottom .3s ease-in-out;
    -moz-transition:bottom .3s ease-in-out;
    -o-transition:bottom .3s ease-in-out;
    transition:bottom .3s ease-in-out
}
.effect .vendor_img.top:hover {
    bottom:-60px;
    padding-top:65px
}
h2.zero,p.zero {
    margin:0;
    padding:0
}
</style>	