<script>
/*$(function()
{

 $("form").submit(function() {
    $(this).submit(function() {
        return false;
    });
    return true;
});
	
});*/
</script>
<div class="Edit_Page">
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}		
	  ?>
	  <?php
	  	//Content of a group
		if(isset($knowledges) and $knowledges->num_rows()>0)
		{
			$knowledge = $knowledges->row();
	  ?>
	 	<div class="clsTitle"><h3><?php echo translate_admin('Edit Knowledge'); ?></h3></div>
			<form method="post" action="<?php echo admin_url('neighbourhoods/editknowledge')?>/<?php echo $knowledge->id;  ?>" enctype="multipart/form-data">
   <table class="table" cellpadding="2" cellspacing="0">

		  <tr>
  <td><label><?php echo translate_admin('Knowledge'); ?><span class="clsRed">*</span></label></td>
		<td>
			<textarea class="clsTextBox" name="knowledge" id="knowledge" style="height: 162px; width: 282px;" ><?php echo $knowledge->knowledge; ?></textarea>
	
				<?php echo form_error('knowledge'); ?>
		</td>
</tr>
<tr>
  <td><label><?php echo translate_admin('City'); ?><span class="clsRed">*</span></label></td>
		<td>
				<input class="clsTextBox" size="30" type="text" name="city" id="city" value="<?php echo $knowledge->city; ?>" readonly/>
		</td>
</tr>		
<tr>
  <td><label><?php echo translate_admin('Place'); ?><span class="clsRed">*</span></label></td>
		<td id="place">
				<input class="clsTextBox" size="30" type="text" name="place" id="place" value="<?php echo $knowledge->place; ?>" readonly/>
		</td>
</tr>
<tr>
		     <td class="clsName"><?php echo translate_admin('Is Shown').'?'; ?></td>
		     <td>
							<select name="is_shown" id="is_shown">
							<option value="0"<?php if($knowledge->shown=="0"){echo "selected";} ?>>  No </option>
							<option value="1"<?php if($knowledge->shown=="1"){echo "selected";} ?>> Yes </option>
							</select>  
							</td>
		  </tr>

		  <tr>
				<td><input type="hidden" name="id"  value="<?php echo $knowledge->id; ?>"/></td>
				<td><input  name="submit" type="submit" value="Submit"></td>
	  	  </tr>  
        
	  </table>
	</form>
	  <?php
	  }
	  ?>
    </div>
