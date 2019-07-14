
<body>
    <!-- Navigation -->    
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container md-space">
            <div class="col-md-2 md-space"><a class="navbar-brand page-scroll" href="<?php echo base_url(); ?>"></a></div>          
            <div class="col-md-10 md-space">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header page-scroll">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                
					</button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->            
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-left">                   
						<li><a href="<?php echo base_url(); ?>">Home</a></li>
						<li><a href="<?php echo  base_url(); ?>index.php/dna">DNA</a></li>
						<li><a href="<?php echo  base_url(); ?>index.php/home/market">Market</a></li>
						<li><a href="<?php echo  base_url(); ?>index.php/breed">Breeding</a></li>
						<li><a href="http://akagypsyvannerworldwide.com/accessories/">Shopping Mall</a></li>
						<li><a href="<?php echo  base_url(); ?>index.php/home/page/game">Game</a></li>
						<li><a href="<?php echo  base_url(); ?>index.php/home/page/about_us">About</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
					<?php 
						if($this->session->userdata('user_login')!='' && $this->session->userdata('user_login')=='yes')
						{ 
						?>
							<li><a href="<?php echo base_url(); ?>index.php/home/profile/"><?php echo $this->session->userdata('user_name');?></a></li>
							<li><a href="<?php echo base_url(); ?>index.php/home/logout/"><?php echo translate('logout');?></a></li>
						<?php
						}else{
						?><li><a class="no-loginlink">Login</a>
							<ul>
								<li class="user_login"><a data-toggle="modal" data-target="#login" class="point"><?php echo translate('user_login');?></a></li>
								<li><a href="<?php echo  base_url(); ?>index.php/vendor" class="point"><?php echo translate('owner/breeder_login');?></a></li>
							</ul>
							</li>							
							<li><a data-toggle="modal" onclick="scrollregistration();" id="reg_vebdor" class="point"><?php echo translate('registration');?></a></li>
						<?php } ?>
							<li><a class="search"><img alt="" src="<?php echo base_url();?>template/front/assets/img/search-icon.png"></a></li>
					</ul>
				<div class="top-search-div" style="display:none;">
                <form name="home_search" id="search_horse" method="post" action="<?php echo base_url();?>index.php/search/results">
                <input type="text" name="horse_id" value="" placeholder="Search Horse" class="search-tiem" />
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>">
                <input type="submit" class="search-img" id="submit_search" value="" />
                </form>
                </div>					
				</div>
				<!-- /.navbar-collapse --> 
			</div>          
                    
        </div>
      <!-- /.container-fluid -->
    </nav> 