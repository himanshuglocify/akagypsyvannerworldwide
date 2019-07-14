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
                <div class="col-md-10 col-md-offset-1 why-title md-space">                  
                    <div class="breeding-text">
                        <span class="inner-breeding"><?php echo $page_title; ?></span> 
                    </div>          
                </div>              
            </div> 
            <div class="row md-space">                              
                <div class="col-md-10">
				<?php
					if($info_msg =='')
					{
				echo form_open('home/remaining_amount'); ?>
				 <div class="form-group">
					<div class="col-md-3">Amount :</div> 
					 <div class="col-md-9"><?php echo currency().$this->cart->format_number($result->amount); ?></div>
				</div>
				<div class="form-group">
					<div class="col-md-3">User Email :</div> 
					 <div class="col-md-9"><?php echo $result->user_email; ?></div>
				</div>
				<div class="form-group">
					<div class="col-md-3">&nbsp;</div> 
					 <div class="col-md-9"><input type="submit" value="Pay" name="sub_pay" /></div>
				</div>
					<?php echo form_close(); } else {?>
					<p style="color:red;"><?php echo $info_msg; ?></p>
					<?php } ?>
				</div>
            </div>
        </div>
    </section>          
    <!-- Breeding Ends -->
    