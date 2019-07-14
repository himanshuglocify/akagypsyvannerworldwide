
 <!-- Header -->     
    <header class="inner-page-bg">
        <div class="container">
            <div class="inner-title">
                <span><?php echo $page_title; ?></span>
            </div>
        </div>
    </header>
    
    	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="f-logo text-right"><img src="<?php echo base_url(); ?>uploads/desgin/f-logo.png" alt="" class="img-responsive" /></div>
				<div class="text-right form-add">
					William James House, Cowley Road, Cambridge CB4 0WX<br>
					www.animalDNAdiagnostics.co.uk<br>
					info@animalDNAdiagnostics.co.uk<br>
					T: 01223 395577<br>
				</div>
			</div>
		</div>
		<?php $attr = array('id'=>'dna_1','class'=>'dna_1_cls');?>
		<?php echo form_open('dna/dna_submit',$attr); ?>
		<div class="row form-add">
			<div class="col-md-8 col-md-offset-2">
				<div class="row form-add">
					<div class="col-md-6">
						<div class="col-md-2 text-left">
							<span class="form-title">Title:</span>
						</div>
						<div class="col-md-10">
							<input type="text" name="title" value="" class="order-form-input form-control required" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-2 text-left">
							<span class="form-title">Name:</span>
						</div>
						<div class="col-md-10">
							<input type="text" name="dna_name" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				
				<div class="row form-add">
					<div class="col-md-6">
						<div class="col-md-3 text-left">
							<span class="form-title">Address:</span>
						</div>
						<div class="col-md-9">
							<input type="text" name="address" value="" class="order-form-input form-control required" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3 text-left">
							<span class="form-title">Postcode:</span>
						</div>
						<div class="col-md-9">
							<input type="text" name="postcode" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				
				<div class="row form-add">
					<div class="col-md-6">
						<div class="col-md-3 text-left">
							<span class="form-title">Telephone:</span>
						</div>
						<div class="col-md-9">
							<input type="text" name="telephone" value="" class="order-form-input form-control required" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="col-md-3 text-left">
							<span class="form-title">Mobile:</span>
						</div>
						<div class="col-md-9">
							<input type="text" name="mobile" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-1 text-left">
							<span class="form-title">Email:</span>
						</div>
						<div class="col-md-11 text-left">
							<input type="text" name="email" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-12 text-left">
							<span class="form-title">Registered Name (or provisional reference name, term or number):</span>
						</div>
						<div class="col-md-12">
							<input type="text" name="reg_name" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-12 text-left">
							<span class="form-title">Breed: Gypsy Cob/Vanner</span>
						</div>
						<div class="col-md-12 text-left">
							<input type="text" name="breed" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-3 text-left">
							<span class="form-title">Test required:</span>
						</div>
						<div class="col-md-9 text-left">
							<!-- <input type="text" name="test_required" value="" class="order-form-input form-control required" /> -->
							<select name="test_required" class="order-form-input form-control required">
							<option value="">Please select option</option>
							<option value="Verified DNA">Verified DNA</option>
							</select>
						</div>
					</div>
				</div>
				
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-12 text-left">
							<span class="form-title">AKA Gypsy Vanner Worldwide registration number:</span>
						</div>
						<div class="col-md-12 text-left">
							<input type="text" name="kc_isds_reg_num" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-4 text-left">
							<span class="form-title">Microchip/tattoo number:</span>
						</div>
						<div class="col-md-8 text-left">
							<input type="text" name="micro_tatto_num" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-4 text-left">
							<span class="form-title">Sex (please select) : Male/</span>
						</div>
						<div class="col-md-8 text-left">
							<select name="sex" class="order-form-input form-control required" >
								<option value="male">MALE</option>
								<option value="female">FEMALE</option>
							</select>
							
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-4 text-left">
							<span class="form-title">Date of Birth (DD/MM/YYYY):</span>
						</div>
						<div class="col-md-8 text-left">							
							<input type="text" name="dob" value="" id="dob_id" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-6 text-left">
							<span class="form-title">*Sire Registered name (if available):</span>
						</div>
						<div class="col-md-6 text-left">
							<input type="text" name="sire_reg_name" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-6 text-left">
							<span class="form-title">*Sire Registration number (if available):</span>
						</div>
						<div class="col-md-6 text-left">
							<input type="text" name="sire_reg_num" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-6 text-left">
							<span class="form-title">*Dam Registered name (if available):</span>
						</div>
						<div class="col-md-6 text-left">
							<input type="text" name="dam_reg_name" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-6 text-left">
							<span class="form-title">*Dam Registration number (if available):</span>
						</div>
						<div class="col-md-6 text-left">
							<input type="text" name="dam_reg_num" value="" class="order-form-input form-control required" />
						</div>
					</div>
				</div>
			
				<div class="row form-add">
					<div class="col-md-12">
						<div class="col-md-12 text-left">
							<input id="submit_dna" class="input-button" type="submit" name="dna_submit" value="ORDER">
						</div>						
					</div>
				</div>
			</div>
		</div>		
		<?php echo form_close(); ?>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function(event) {
	// make the error function if the error occur this one called 
	function DnaError(e){notify(e,'warning','bottom','right');}

	// make css changes if error occur
	function errorBorder(b){jQuery(b).css('border', '1px solid red');}

	// checking the email validate here 
	function checkMail(t) {
	var a = jQuery('input[name="email"]');
	var testEmail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(testEmail.test(t)){return true;}else{DnaError('Enter a valid Email id !');errorBorder(a);return false;} 
	}

	// validate the form here and return the response 
	function validateDnaform() {
	 var a = jQuery('input[name="email"]');	
	 if(a.val()){if(checkMail(a.val()) == true){return true;}else{return false;}	 	
	 }else{DnaError('Email not be empty!');errorBorder(a);return false;}

	 var b = jQuery('input[name="sire_reg_name"]');
	 if(b.val()){}else{DnaError('Not be empty!');errorBorder(b);return false;}

	 var c = jQuery('input[name="sire_reg_num"]');
	 if(c.val()){}else{DnaError('Not be empty!');errorBorder(c);return false;}

	 var d = jQuery('input[name="dam_reg_name"]');
	 if(d.val()){}else{DnaError('Not be empty!');errorBorder(d);return false;}

	 var e = jQuery('input[name="dam_reg_num"]');
	 if(e.val()){}else{DnaError('Not be empty!');errorBorder(e);return false;}
	 return true;
	} // end of the function validateDnaform here
			
	jQuery('#submit_dna').click(function(event) {
		console.log('clicked');
		if(validateDnaform() == true){
		jQuery('#dna_1').submit();
		}else{
		return false;
		}		
	});	

	
	jQuery('body').on('focus','input[name="dob"]', function(){
		    jQuery(this).datepicker({
				dateFormat: 'yy/mm/dd',
				changeMonth: true,
      			changeYear: true,
      			yearRange: "1975:2020"
			});
		});
	
	
	});
	
		
	
	
	</script>