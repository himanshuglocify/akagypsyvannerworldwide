<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_payment_receiving_settings');?></h1>
    </div>
    <div class="tab-base">
        <div class="tab-base tab-stacked-left">
            <?php
                $paypal    = $this->db->get_where('vendor', array(
                    'vendor_id' => $this->session->userdata('vendor_id')
                ))->row()->paypal_email;
            ?>
            <div class="col-sm-12">
            <div class="panel panel-bordered-grey">
                <?php
                    echo form_open(base_url() . 'index.php/vendor/business_settings/set/', array(
                        'class'     => 'form-horizontal',
                        'method'    => 'post',
                        'id'        => 'gen_set',
                        'enctype'   => 'multipart/form-data'
                    ));
                ?>
                    <div class="panel-body">
						<div class="form-group">
							<div class="col-sm-3"></div>
							<div class="col-sm-6">
								<?php if($this->input->get('msg') && $this->input->get('msg')==1){ 
									echo '<span style="color:red;">Please setup you paypal payment method first.<span>'; 
								} ?>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo translate('paypal_email');?></label>
                            <div class="col-sm-6">
                                <input type="text" name="paypal_email" value="<?php echo $paypal; ?>" class="form-control required">
                            </div>
                        </div>
                    
                    <div class="panel-footer text-right">
						<input type="submit" class="btn btn-info submitter" value="<?php echo translate('save');?>">
                        <!--<span class="btn btn-info submitter" 
                            data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>' >
                                <?php echo translate('save');?>
                        </span>-->
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

</div>
<div style="display:none;" id="business"></div>
<script>
	var base_url = '<?php echo base_url(); ?>';
	var user_type = 'vendor';
	var module = 'logo_settings';
	var list_cont_func = 'show_all';
	var dlt_cont_func = 'delete_logo';

    function get_membership_info(id){
        $('#mem_info').load('<?php echo base_url(); ?>index.php/vendor/business_settings/membership_info/'+id);
    }

</script>
<script src="<?php echo base_url(); ?>template/back/js/custom/business.js"></script>
