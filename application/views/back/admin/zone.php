<div id="content-container">
	<div id="page-title">
		<h1 class="page-header text-overflow"><?php echo translate('manage_zones');?></h1>
	</div>
	<div class="tab-base">
		<div class="panel">
			<div class="panel-body">
				<div class="tab-content">
					 <div class="col-md-12" style="border-bottom: 1px solid #ebebeb;padding: 5px;">
                            <button class="btn btn-primary btn-labeled fa fa-plus-circle add_pro_btn pull-right" 
                                onclick="ajax_set_full('add','<?php echo translate('add_zone'); ?>','<?php echo translate('successfully_added!'); ?>','zone_add',''); proceed('to_list');"><?php echo translate('create_zone');?>
                            </button>
                         
                         
                            <button class="btn btn-primary btn-labeled fa fa-plus-circle add_pro_btn pull-right" 
                                onclick="ajax_set_full('manage','<?php echo translate('manage_zone'); ?>','<?php echo translate('successfully_added!'); ?>','manage_zone',''); proceed('to_list');"><?php echo translate('manage_zone');?>
                            </button>
                         
                         
                            <button class="btn btn-info btn-labeled fa fa-step-backward pull-right pro_list_btn" 
                                style="display:none;"  onclick="ajax_set_list();  proceed('to_add');"><?php echo translate('back_to_list');?>
                            </button>
                        </div>
					<br>
                    <!-- LIST -->
                    <div class="tab-pane fade active in" id="list" style="border:1px solid #ebebeb; border-radius:4px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	var base_url = '<?php echo base_url(); ?>'
	var user_type = 'admin';
	var module = 'zone';
	var list_cont_func = 'list';
	var dlt_cont_func = 'delete';
	
		function proceed(type){
		if(type == 'to_list'){
			$(".pro_list_btn").show();
			$(".add_pro_btn").hide();
		} else if(type == 'to_add'){
			$(".add_pro_btn").show();
			$(".pro_list_btn").hide();
		}
	}
	$(document).ready(function() {
	$(document).on('change', '.s_country input:checkbox[value="230"].t_country:checked', function(){
		 //console.log('checked');
		 $('.mang_state').show();
		 var base_url = "<?php echo $this->config->item('base_url'); ?>index.php/admin/get_states/";
		 var zoneid = $('#zone').val();
         var coun_name = $(this).next('span').html();
         var coun_id = this.value;
         var postData = {
			 zone_id: zoneid,
			 country_id: coun_id,
			 <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash();?>'           
        }; 
                    
	   $.ajax({
		  url: base_url, // form action url
		  cache: false,
		  dataType: "json",
		  type: "POST",
		  data: postData,
		   beforeSend: function() {
			  $("#r_state").html('');
		  }, 
		  success: function(data) {
			   var html = '';
			  var opts = '';
			  $.each(data, function(i, v) {
				   if(v.flag == 0) {
					  html += '<option value="'+coun_id+'_'+v.id+'">'+v.name+'</option>';
				  }
				  
				  else {
					  if(v.flag == 1) {
						  html += '<option value="'+coun_id+'_'+v.id+'" selected="selected">'+v.name+'</option>';
					  } 
					 
					  else {
						  html += '<option value="'+coun_id+'_'+v.id+'" disabled="disabled">'+v.name+'</option>';
					  }
					  
				  } 
				  
			  });
			  $("#r_state").append(html);
			  //$("#r_state").addClass('required');
			  $("#r_state").multipleSelect({
					multiple: true,
					multipleWidth: 130,
					width: '100%'
			  }); 
		  }  
		   
	   }); 
});
	$(document).on('change', '.s_country input:checkbox[value="230"].t_country:not(:checked)', function(){
		 //console.log('unchecked');
		 $("#r_state").html('');
		 //$("#r_state").removeClass('required');
		 $('.mang_state').hide();		 
  });
});
</script>
