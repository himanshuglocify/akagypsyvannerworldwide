<div class="panel-body" id="demo_s">
    <div class="col-md-12">
		<?php
            echo form_open(base_url() . 'index.php/admin/add_zone_area/', array(
                'class' => 'form-horizontal',
                'method' => 'post',
                'id' => 'manage_zone'
            ));
        ?>
        
        <?php 
          //echo $this->session->flashdata();
        ?>
        
            <!--Panel heading-->
            <div class="panel-heading">
                <div class="panel-control" style="float: left;">
                    <ul class="nav nav-tabs">
                        <li class="active">
                           <?php echo translate('zone_details'); ?>
                        </li>
                        
                    </ul>
                </div>
            </div>
        
        <div class="panel-body">
            <div class="tab-base">
        
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('zone');?></label>
                                <div class="col-sm-6">
                                    <select name="zone" class="form-control required" id="zone">
                                        <option value="">Select Zone</option>
                                        <?php
                                          foreach($all_zones as $zone)
                                          {
                                              echo '<option value="'.$zone['id'].'">'.$zone['zone'].'</option>';
                                          }
                                        ?>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="form-group btm_border">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('Country');?></label>
                                <div class="col-sm-6 s_country">
                                    <select name="country[]" class="form-control" id="country">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                            </div>
                    
                    
                          <div class="form-group btm_border mang_state" style="display:none;">
                                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('State');?></label>
                                <div class="col-sm-6 mang_states">
                                    <select name="state[]" multiple="multiple" class="" id="r_state"></select>
                                </div>
                            </div>
                    
                    </div>

               
        
            </div>
    
            <div class="panel-footer">
			     <div class="row">
                	<div class="col-md-11">
                    </div>
                     <div class="col-md-1">
                     	<span class="btn btn-success btn-md btn-labeled fa fa-wrench pull-right" onclick="form_submit('manage_zone','<?php echo translate('successfully_edited!'); ?>');" ><?php echo translate('update');?></span> 
                        <!--<input type="submit" name="add_area" value="Add Area" class="btn btn-success pull-right" /> -->
						</div>
                </div>
            </div>
    
        </form>
    </div>
</div>

<style type="text/css">
    .ms-drop.bottom span {
         margin-left: 10px;
     }
    
    .optgroup > input {
         margin-right: 10px;
    }
</style>
<?php //echo "<pre>"; print_r($this->security()); die('here'); ?>
<script>
$(document).ready(function() {
       var list = [];
	   var country_url = "<?php echo $this->config->item('base_url'); ?>index.php/admin/get_countries/";
       var zone_id;
       $("#zone").change(function() {
		 $("#r_state").html('');
		 $('.mang_state').hide();
		var z_id = $(this).val();
           zone_id = z_id;
           var postData = {
               zone_id: z_id,
			   <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash();?>'
           };
           var val = [];
		   if(zone_id != ''){
			$.ajax({
                      url: country_url, 
                      cache: false,
                      dataType: "json",
                      type: "POST",
                      data: postData,
                       beforeSend: function() {
                          $(".s_country").html('');
                      }, 
                      success: function(data) {
                          var html = '';
						  var usa = 0;
						  html += '<select name="country[]" multiple="multiple" id="country">';
                          $.each(data, function(i, v) {
                               if(v.flag == 0) {
                                  html += '<option value="'+v.country_id+'">'+v.country_name+'</option>';
                              }
                              
                              else {
                                  if(v.flag == 1) {
                                      html += '<option value="'+v.country_id+'" selected="selected">'+v.country_name+'</option>';
                                  } 
                                 
                                  else {
                                      html += '<option value="'+v.country_id+'" disabled="disabled">'+v.country_name+'</option>';
                                  }
                                  
                              }
                             if(v.country_id == 230 && v.flag==1){ usa=1;} 
                          });
						  html += '</select>';
                          $(".s_country").append(html);
                          
                          $("#country").multipleSelect({
                                multiple: true,
                                multipleWidth: 130,
                                width: '50%'
                          });
						  if(usa==1){$('.s_country input:checkbox[value="230"].t_country').prop('checked', true).change();}
                      }  
                       
                   });
			}else{
				$(".s_country").html('');
				var html = '';
				 html += '<select name="country[]" class="form-control" id="country">';
                 html += '<option value="">Select Country</option>';
				 html += '</select>';
				$(".s_country").append(html);
			}

           
           $(".s_country input.t_country:checked").each(function(i) {
               var c_val = $(this).val();
               var c_name = $(this).next('span').html();
               
               val.push({
                   name: c_name,
                   value: c_val
               });
               
           });
           
           if(val.length > 0) {
                $.each(val, function(i, item) {
                   var c_name = item.name;
                   var c_id = item.value;
                   
                   var postData = {
                        country_id: c_id,
                        zone_id: z_id,

                   };         
               }); 
               
            }  
           
       });
   
       $(".t_country").change(function() {
           var c_val = $(this).val();
           var c_name = $(this).next('span').html();
           
           if(this.checked) {
               list.push({
                   name: c_name,
                   value: c_val
               });
           } else {
               var id = c_val;
               $.each(list, function(i, el){
                     if (this.value == id){
                       list.splice(i, 1);
                     }
               });
           }
          
           if(list.length > 0) {    
               $.each(list, function(i, item) {
                   var country_name = item.name;
                   var country_id = item.value;
                   
                   var postData = {
                        country_id: country_id,
                        zone_id: zone_id,
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
                          html += '<optgroup label="'+country_name+'">';
                          var opts = '';
                          $.each(data, function(i, v) {
                               if(v.flag == 0) {
                                  html += '<option value="'+country_id+'_'+v.id+'">'+v.name+'</option>';
                              } else {
                                  if(v.zone_id == zone_id && v.flag == 1) {
                                      html += '<option value="'+country_id+'_'+v.id+'" selected="selected">'+v.name+'</option>';
                                  } 
                                  
                                  else {
                                      html += '<option value="'+country_id+'_'+v.id+'" disabled="disabled">'+v.name+'</option>';
                                  }
                                  
                              } 
                              
                          });
                          html += '</optgroup>';
                          $("#r_state").append(html);
                          
                          $("#r_state").multipleSelect({
                                multiple: true,
                                multipleWidth: 130,
                                width: '100%'
                          });
                      } 
                       
                   });
                   
                });
               
            } else {
               $(".group").html('');
               $(".multiple").html('');
               $(".ms-no-results").html('');
           }
        
       });
       
   });
   
</script>