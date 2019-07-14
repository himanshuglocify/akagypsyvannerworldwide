
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
            <?php $data_attr = array('id'=>'dna_payment','class'=>'dna_pay_cls');?>
           <?php echo form_open('dna/DnaTermSubmit',$data_attr); ?>
            <div class="row md-space">
                 <?php echo $terms_conditions =  $this->db->get_where('general_settings',array('type' => 'terms_conditions_dna'))->row()->value; ?>                         
                <div class="col-md-10 col-md-offset-1 col-sm-10 col-xs-10 md-space" style="padding-top:30px;">              
				<p class="notificationerror" style="color:red;"></p>	
                    <input type="checkbox" class="term-check required tccheck" name="agree" />I accept with above terms and conditions.
                    <input type="submit" value="Submit" name="name_agr" disabled class="term-button subbtn">
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
				$('.subbtn').prop('disabled', false);
				jQuery('.notificationerror').html('');
			}
			else
			{
				$('.subbtn').prop('disabled', true);
				jQuery('.notificationerror').html('This field is requried.');
			}
			
		});
		
	});
	
	</script>