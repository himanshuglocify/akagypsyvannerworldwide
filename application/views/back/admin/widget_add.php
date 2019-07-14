<div class="row">
    <div class="col-md-12">
        <?php
            echo form_open(base_url() . 'index.php/admin/widget/do_add/', array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'widget_add',
                'enctype' => 'multipart/form-data'
            ));
        ?>
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                           <?php echo translate('widget_details'); ?>
                        </li>
                        
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                    
                <div class="tab-base">
        
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('widget_title');?></label>
                                <div class="col-sm-6">
                                    <input type="text" name="widget_title" id="demo-hor-1" placeholder="<?php echo translate('widget_title');?>" class="form-control required">
                                </div>
                            </div>
                            
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-6"><?php echo translate('widget_content');?></label>
                                <div class="col-sm-6">
                                <div class="abstract">
                                    <textarea rows="9"  class="summernotes" data-height="400" data-name="widget_content" name="widget_content"></textarea>
                                   </div> 
                                </div>
                            </div>
                            
                                
                </div>

               
        
            </div>
    
            <div class="panel-footer">
                <div class="row">
                    <div class="col-md-11">
                        <span class="btn btn-purple btn-labeled fa fa-refresh pro_list_btn pull-right" 
                            onclick="ajax_set_full('add','<?php echo translate('add_widget'); ?>','<?php echo translate('successfully_added!'); ?>','widget_add',''); "><?php echo translate('reset');?>
                        </span>
                    </div>
                    
                    <div class="col-md-1">
                        <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right" onclick="form_submit('widget_add','<?php echo translate('widget_has_been_uploaded!'); ?>');proceed('to_add');" ><?php echo translate('upload');?></span>
                    </div>
                    
                </div>
            </div>
    
        </form>
    </div>
</div>

<input type="hidden" id="nums" value='1' />
<script src="<?php echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js">
</script>

<script>
    window.preview = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImg").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }

    function other_forms(){}
    
    function set_summer(){
        $('.summernotes').each(function() {
            var now = $(this);
            var h = now.data('height');
            var n = now.data('name');
            if(now.closest('.abstract').find('.val').length){
            } else {
                now.closest('.abstract').append('<input type="hidden" class="val" name="'+n+'">');
                now.summernote({
                    height: h,
                    onChange: function() {
                        now.closest('.abstract').find('.val').val(now.code());
                    }
                });
                now.closest('.abstract').find('.val').val(now.code());
            }
        });
    }
    
    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        set_summer();
    });
   
    
   
    
   
    


    $(document).ready(function() {
        $("form").submit(function(e){
            return false;
        });
    });
    
</script>

<style>
.btm_border{
  border-bottom: 1px solid #ebebeb;
  padding-bottom: 15px; 
}
.remove{
    color:#FFF !important;
    margin-right:5px !important;
    font-size:20px !important;
    transition: all .4s ease-in-out;    
}
.remove:hover{
    color:#003376 !important;   
}
</style>