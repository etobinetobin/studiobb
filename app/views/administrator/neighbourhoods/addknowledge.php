<?php
	if($msg = $this->session->flashdata('flash_message'))
				{
					echo $msg;
				}
?>
	<script src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
    <script type="text/javascript"> 
      
    function get_cities(city){
     $.ajax({
     	type: 'GET',
     	data: "city="+city,
         url : "<?php echo base_url().'administrator/neighbourhoods/place_drop'?>",
         success : function($data){
                 $('#place').html($data);

         },	
         error : function ($responseObj){
             alert("Something went wrong while processing your request.\n\nError => "
                 + $responseObj.responseText);
         }
     }); 
    }
    </script>	
    
     <script type="text/javascript">
	$(document).ready(function(){
		$("#knowledge").validate({
			debug: false,
			rules: {
				knowledge: {
          required: true,
          minlength: 6
        },
        city:
        {
        	customvalidation: true
        }
			},
			
			messages: {
		        knowledge:
                    { 
                    	required: "Knowledge Must Be Required",
                    	minlength: "Minimum 6 Characters Required"                       	
                  }
			},
			 
		});
		//alert($('#city').val());
		
		$.validator.addMethod("customvalidation", 
      function(value, element) {
         if(($('#city').val()) != 'none')
         return 'false';
            }, 
         "City Must Be Required"
      );
    /*  $("form").submit(function() {
    $(this).submit(function() {
        return false;
    });
    return true;
});*/
  /* var i = 0;
  
      $('#submit').click(function()
      {
      	if(i != 0)
      	{
      		i = 0;
      		return false;
      		
      	}
      	else
      	{
      		i++;
      	}
      }) */
     
	});
	</script>
				<style>
	label.error { width: 250px; display: inline; color: red;}
	#city_error { width: 250px; display: inline; color: red;}
	</style>
<div id="Add_Email_Template">

				<div class="clsTitle">
				<h3><?php echo translate_admin("Add Neighbourhoods Local Knowledge"); ?></h3>
				</div> 
      <div class="MainTop_Links clearfix">
          <div class="clsNav">
           <ul>
			 <li><a href="<?php echo admin_url('neighbourhoods/viewknowledge'); ?>"><?php echo translate_admin('Manage Local Knowledges'); ?></a></li>
          </ul>
        </div>
		
      </div>
	  <div>
<form method="post" id="knowledge" action="<?php echo admin_url('neighbourhoods/addknowledge')?>" enctype="multipart/form-data">					
<table width="700" class="table">

<tr>
  <td><label><?php echo translate_admin('Knowledge'); ?><span class="clsRed">*</span></label></td>
		<td>
			<textarea class="clsTextBox" name="knowledge" id="knowledge" value="" style="height: 162px; width: 282px;" ></textarea>
				
		</td>
</tr>
<tr>
  <td><label><?php echo translate_admin('City'); ?><span class="clsRed">*</span></label></td>
		<td>
				<select name='city' id="city" style="width:292px" onChange='get_cities(this.value)'>
				<option value='none' selected="selected"><?php echo translate('Select City');?></option>
				<?php 
				foreach($cities->result() as $row)
				{
					echo '<option value="'.$row->city_name.'">'.$row->city_name.'</option>';
				}
				?>
				</select>
				<span id="city_error" style="display: none"> Must Required</span>
		</td>
</tr>		
<tr>
  <td><label><?php echo translate_admin('Place'); ?><span class="clsRed"></span></label></td>
		<td id="place">
				<select name='place' id="place" style="width:292px">
				<option value='none' selected="selected"><?php echo translate('No Place');?></option>	
				</select>
		</td>
</tr>
<tr>
		     <td class="clsName"><?php echo translate_admin('Is Shown').'?'; ?></td>
		     <td>
							<select name="is_shown" id="is_shown">
							<option value="1"> Yes </option>
							<option value="0"> No </option>
							</select>  
							</td>
		  </tr>
<tr>
	<td></td>
	<td>
	<input  name="submit" type="submit" id="submit" value="<?php echo translate_admin('Submit'); ?>">
	</td>
</tr>
		
</table>
</form>	
</div>





            
