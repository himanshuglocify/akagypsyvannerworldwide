<div id="content-container"> 
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('manage_payment_method');?></h1>
    </div>
    <div class="tab-base">
        <div class="tab-base tab-stacked-left">
            <?php
                $paypal    = $this->db->get_where('business_settings', array(
                    'type' => 'paypal_email'
                ))->row()->value;
                $paypal_set= $this->db->get_where('business_settings', array(
                    'type' => 'paypal_set'
                ))->row()->value;
                $paypal_type= $this->db->get_where('business_settings', array(
                    'type' => 'paypal_type'
                ))->row()->value;
                $curr_name = $this->db->get_where('business_settings', array(
                    'type' => 'currency_name'
                ))->row()->value;
                $curr      = $this->db->get_where('business_settings', array(
                    'type' => 'currency'
                ))->row()->value;
                $exchange  = $this->db->get_where('business_settings', array(
                    'type' => 'exchange'
                ))->row()->value;                
                $faqs = json_decode($this->db->get_where('business_settings', array(
                    'type' => 'faqs'
                ))->row()->value,true);
            ?>
            <div class="col-sm-12">
            <div class="panel panel-bordered-dark">
                <?php
                    echo form_open(base_url() . 'index.php/admin/business_settings/set/', array(
                        'class'     => 'form-horizontal',
                        'method'    => 'post',
                        'id'        => 'gen_set',
                        'enctype'   => 'multipart/form-data'
                    ));
                ?>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="demo-hor-inputemail"><?php echo translate('paypal_payment');?></label>
                            <div class="col-sm-6">
                                <div class="col-sm-">
                                    <input id="paypal_set" disabled class='sw8' data-set='paypal_set' type="checkbox" <?php if($paypal_set == 'ok'){ ?>checked<?php } ?> />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo translate('paypal_email');?></label>
                            <div class="col-sm-6">
                                <input type="text" name="paypal_email" value="<?php echo $paypal; ?>" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="demo-hor-inputemail">
                                <?php echo translate('paypal_account_type');?>
                                    </label>
                            <div class="col-sm-6">
                                <?php
                                    $from = array('sandbox','original');
                                    echo $this->crud_model->select_html($from,'paypal_type','','edit','demo-chosen-select',$paypal_type);
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo translate('currency_name');?></label>
                            <div class="col-sm-6">
                                <input type="text" name="currency_name" id='curr_n_i' value="<?php echo $curr_name; ?>" class="form-control" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><?php echo translate('currency_symbol');?></label>
                            <div class="col-sm-6">
                                <input type="text" name="currency" id='curr_s_i' value="<?php echo $curr; ?>" class="form-control" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">1 U.S Dollar ($) = </label>
                            <div class="col-sm-3">
                                <input type="number" name="exchange" value="<?php echo $exchange; ?>"  class="form-control required" disabled>
                            </div>
                            <label class="col-sm-3 control-label text-left">
                                <span id='curr_n_s'><?php echo $curr_name; ?></span>
                                (<span id='curr_s_s'><?php echo $curr; ?></span>)
                            </label>
                        </div>
                    </div>
                    
                    <div class="panel-footer text-right">
                    <!--    <span class="btn btn-info submitter" 
                        	data-ing='<?php echo translate('saving'); ?>' data-msg='<?php echo translate('settings_updated!'); ?>' >
								<?php echo translate('save');?>
                        </span> -->
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
	var user_type = 'admin';
	var module = 'logo_settings';
	var list_cont_func = 'show_all';
	var dlt_cont_func = 'delete_logo';

    $("#more_btn").click(function(){
        $("#more_additional_fields").append(''
            +'<div class="form-group">'
            +'    <div class="col-sm-4">'
            +'        <input type="text" name="f_q[]" class="form-control"  placeholder="<?php echo translate('question'); ?>">'
            +'    </div>'
            +'    <div class="col-sm-5">'
            +'          <textarea name="f_a[]" class="form-control"  placeholder="<?php echo translate('answer'); ?>"></textarea>'
            +'    </div>'
            +'    <div class="col-sm-2">'
            +'        <span class="remove_it_v rms btn btn-danger btn-icon btn-circle icon-lg fa fa-times" onclick="delete_row(this)"></span>'
            +'    </div>'
            +'</div>'
        );
    });
    function delete_row(e)
    {
        e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
    }   

</script>
<script src="<?php echo base_url(); ?>template/back/js/custom/business.js"></script>
