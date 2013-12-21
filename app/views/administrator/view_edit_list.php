	<script type="text/javascript">
				function startCallback() {
				document.getElementById('message').innerHTML = '<img src="<?php echo base_url().'images/loading.gif' ?>">';
				// make something useful before submit (onStart)
				return true;
			}

			function completeCallback(response) {
				document.getElementById('message').innerHTML = response;
			}
			
				function startCallback2() {
				document.getElementById('message2').innerHTML = '<img src="<?php echo base_url().'images/loading.gif' ?>">';
				// make something useful before submit (onStart)
				return true;
			}

			function completeCallback2(response) {
				document.getElementById('message2').innerHTML = response;
			}
			
			function startCallback3() {
				document.getElementById('message3').innerHTML = '<img src="<?php echo base_url().'images/loading.gif' ?>">';
				// make something useful before submit (onStart)
				return true;
			}

			function completeCallback3(response) {
			 var res = response;
				var getSplit = res.split('#'); 
				document.getElementById('galleria_container').innerHTML = getSplit[0];
				document.getElementById('message3').innerHTML           = getSplit[1];
			}
			
			function startCallback4() {
				document.getElementById('message4').innerHTML = '<img src="<?php echo base_url().'images/loading.gif' ?>">';
				// make something useful before submit (onStart)
				return true;
			}

			function completeCallback4(response) {
				document.getElementById('message4').innerHTML = response;
			}
	
	</script>
 

<script type="text/javascript" src="<?php echo base_url() ?>js/webtoolkit.aim.js"></script>
<div id="View_Edit_List">

    <div class="MainTop_Links clearfix">
	     <div class="clsNav">
          <ul>
												<li><a id="priceA" href="javascript:showhide('4');"><b><?php echo translate_admin('Pricing'); ?></b></a></li>
												<li><a id="photoA" href="javascript:showhide('3');"><b><?php echo translate_admin('Photos'); ?></b></a></li>
												<li><a id="aminitiesA" href="javascript:showhide('2');"><b><?php echo translate_admin('Aminities'); ?></b></a></li>
												<li><a id="descriptionA" class="clsNav_Act" href="javascript:showhide('1');"><b><?php echo translate_admin('Description'); ?></b></a></li>
          </ul>
        </div>
		<div class="clsTitle">
	 <h3><?php echo translate_admin('Edit Listing'); ?></h3>
	 </div>
	</div>
<div id="description">
<form action="<?php echo admin_url('lists/managelist'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">
<table class="table">
<tr>
<td><?php echo translate_admin("Property type"); ?></td>
<td>
<select style="width:200px;" class="fixed-width" id="hosting_property_type_id" name="property_id">
			<option value="1">Apartment</option>
			<option value="2">House</option>
			<option value="3">Bed & Breakfast</option>
			<option value="4">Cabin</option>
			<option value="11">Villa</option>
			<option value="5">Castle</option>
			<option value="9">Dorm</option>
			<option value="6">Treehouse</option>
			<option value="8">Boat</option>
			<option value="7">Automobile</option>
			<option value="12">Igloo</option>
			<option value="10">Lighthouse</option>
</select>
</td>
</tr>

<tr>
<td><?php echo translate_admin("Room type"); ?></td>
<td>
<select style="width:200px;" class="fixed-width" id="hosting_room_type" name="room_type">
<option value="Private room">Private room</option>
<option value="Shared room">Shared room</option>
<option value="Entire home/apt">Entire home/apt</option>
</select>
</td>
</tr>

<tr>
<td><?php echo translate_admin("Accommodates");?></td>
<td>
<select style="width:200px;" class="fixed-width" id="hosting_person_capacity" name="capacity">
<?php for($i = 1; $i <= 10; $i++) { ?>
<option value="<?php echo $i; ?>"><?php echo $i; ?> person<?php if($i > 1) echo 's'; ?>
</option>
<?php } ?>
</select>

</td>
</tr>

<tr>
<td><?php echo translate_admin("Bedrooms"); ?></td>
<td>
<select style="width:200px;" class="fixed-width" id="hosting_bedrooms" name="bedrooms">
<option value=""></option>
<?php for($i = 1; $i <= 10; $i++) { ?>
<option value="<?php echo $i; ?>"><?php echo $i; ?> <?php echo translate("bedroom"); ?>
<?php if($i > 1) echo 's'; ?>
</option>
<?php } ?>
</select>
</td>
</tr>


<tr>
<td><?php echo translate_admin("Bed Type"); ?></td>
<td>
<select class="fixed-width" id="hosting_beds" name="beds">
<?php for($i = 1; $i <= 16; $i++) { ?>
<option value="<?php echo $i; ?>"><?php echo $i; if($i == 16) echo '+'; ?> bed</option>
<?php } ?>
</select>
</td>
</tr>

<tr>
<td><?php echo translate_admin("Bed type"); ?></td>
<td>
	<select class="fixed-width" id="hosting_bed_type" name="hosting_bed_type">
	<option value="Airbed">Airbed</option>
	<option value="Futon">Futon</option>
	<option value="Pull-out Sofa">Pull-out Sofa</option>
	<option value="Couch">Couch</option>
	<option value="Real Bed" selected="selected">Real Bed</option>
	</select>
</td>
</tr>

<tr>
<td><?php echo translate_admin("Bathrooms"); ?></td>
<td>
<select name="hosting_bathrooms" id="hosting_bathrooms" class="fixed-width">
<option selected="selected" value=""></option>
<option value="0">0 bathrooms</option>
<option value="0.5">0.5 bathrooms</option>
<option value="1">1 bathroom</option>
<option value="1.5">1.5 bathrooms</option>
<option value="2">2 bathrooms</option>
<option value="2.5">2.5 bathrooms</option>
<option value="3">3 bathrooms</option>
<option value="3.5">3.5 bathrooms</option>
<option value="4">4 bathrooms</option>
<option value="4.5">4.5 bathrooms</option>
<option value="5">5 bathrooms</option>
<option value="5.5">5.5 bathrooms</option>
<option value="6">6 bathrooms</option>
<option value="6.5">6.5 bathrooms</option>
<option value="7">7 bathrooms</option>
<option value="7.5">7.5 bathrooms</option>
<option value="8">8+ bathrooms</option>
</select>
</td>
</tr>


<tr>
<td><?php echo translate_admin("Title"); ?></td>
<td><input type="text" size="28" name="title" value="<?php echo $result->title;  ?>">
</td>
</tr>

<tr>
<td><?php echo translate_admin("Address"); ?></td>
<td><input type="text" size="28" name="address" value="<?php echo $result->address; ?>"></td>
</tr>

<tr>
<td><?php echo translate_admin("Cancellation Policy"); ?></td>
<?php //print_r($result); exit;?>
<td>
	<select name="cancellation_policy" id="cancellation_policy" class="fixed-width">
      <option value="Flexible"<?php if($result->cancellation_policy == "Flexible"){echo "selected";} ?>>Flexible</option>
      <option value="Moderate" <?php if($result->cancellation_policy == "Moderate"){echo "selected";} ?>>Moderate</option>
      <option value="Strict"<?php if($result->cancellation_policy == "Strict"){echo "selected";} ?>>Strict</option>
      <option value="Super Strict"<?php if($result->cancellation_policy == "Super Strict"){echo "selected";} ?>>Super Strict</option>
      <option value="Long Term"<?php if($result->cancellation_policy == "Long Term"){echo "selected";} ?>>Long Term</option> 
    </select>
</td>
</tr>

<tr>
<td><?php echo translate_admin("House Manual"); ?></td>
<td><textarea id="hosting_house_manual" name="manual" size="115"><?php echo $result->manual; ?></textarea></td>
</tr>

<tr>
<td><?php echo translate_admin("Description"); ?></td>
<td><textarea name="desc"><?php echo $result->desc;  ?></textarea></td>
</tr>

<tr>
<td></td>
<td>
<div class="clearfix">
<span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update_desc" value="<?php echo translate_admin("Update"); ?>" style="width:90px;" /></span>
<span style="float:left;"><div id="message"></div></span>
</div>
</td>
</tr>
<input type="hidden" name="list_id" value="<?php echo $result->id;  ?>">

</table> 
</form>
</div>


<div id="aminities" style="display:none;">
<div class="clsFloatLeft" style="width:98%">
<form action="<?php echo admin_url('lists/managelist'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback2, 'onComplete' : completeCallback2})">
<p style="text-align:left; border-top:4px solid #E3E3E3;">&nbsp;</p>
<div class="clearfix">
					<?php 
				$in_arr = explode(',', $result->amenities);
				$tCount = $amnities->num_rows();
				$i = 1; $j = 1; 
				foreach($amnities->result() as $rows) { if($i == 1) echo '<ul class="amenity_column">'; ?>
							<li>
									<input type="checkbox" <?php if(in_array($j, $in_arr)) echo 'checked="checked"'; ?> name="amenities[]" id="amenity_<?php echo $j; ?>" value="<?php echo $j; ?>">
									<label for="amenity_<?php echo $j; ?>"><?php echo $rows->name; ?> <a title="<?php echo $rows->description; ?>" class="tooltip"><img style="width:16px; height:16px;" src="<?php echo base_url(); ?>images/questionmark_hover.png" alt="Questionmark_hover"></a> </label>
							</li>
							<?php if($i == 8) { $i = 0; echo '</ul>'; } else if($j == $tCount) { echo '</ul>'; } $i++; $j++; } ?>


</div>

<input type="hidden" name="list_id" value="<?php echo $result->id;  ?>">
<div style="clear:both"></div>


<div class="clearfix">
<span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update_aminities" value="<?php echo translate_admin("Update"); ?>" style="width:90px;" /></span>
<span style="float:left; padding:20px 0 0 0;"><div id="message2"></div></span>
</div>
</form>
</div>
<div style="clear:both"></div>
</div>

<div id="photo" style="display:none; text-align:left;">
<div class="clsFloatLeft" style="width:98%">
<form enctype="multipart/form-data" action="<?php echo admin_url('lists/managelist'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback3, 'onComplete' : completeCallback3})">
<p style="text-align:left; border-top:4px solid #E3E3E3; padding:10px 0 10px;"><span> <?php echo translate_admin("Choose to delete photo"); ?> </span>

 <?php 
  echo '<div id="galleria_container">'; 
		if(count($list_images) > 0)
		{
			echo '<ul class="clearfix">';
			$i = 1;
			foreach ($list_images->result() as $image)
			{		
				if($image->is_featured == 1)
					$checked = 'checked="checked"'; 
				else
					$checked = ''; 
								
			  $url = base_url().'images/'.$image->list_id.'/'.$image->name;
						echo '<li>';
			   echo '<p><label><input type="checkbox" name="image[]" value="'.$image->id.'" /></label>';
  				echo '<img src="'.$url.'" width="150" height="150" /><input type="radio" '.$checked.' name="is_main" value="'.$image->id.'" /></p>';
						echo '</li>';
						$i++;
			}
			echo '</ul>';
			echo '</div>';
			
		} 
?>

</p>
<input type="hidden" name="list_id" value="<?php echo $result->id;  ?>">
<p> <span style="margin:0 10px 0 0;"> <?php echo translate_admin("Upload new photo"); ?> </span>
<input id="new_photo_image" name="userfile"  size="24" type="file" />
</p>

<div class="clearfix">
<span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update_photo" value="<?php echo translate_admin("Update"); ?>" style="width:90px;" /></span>
<span style="float:left; padding:20px 0 0 0;"><div id="message3"></div></span>
</div>
</form>
</div>
<div style="clear:both"></div>
</div>

<div id="price" style="display:none;">
<form action="<?php echo admin_url('lists/managelist'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback4, 'onComplete' : completeCallback4})">
<table class="table">

<tr>
<td><?php echo translate_admin("Nightly"); ?></td>
<td><input type="text" name="nightly" value="<?php echo $price->night;  ?>"></td>
</tr>

<tr>
<td><?php echo translate_admin("Weekly"); ?></td>
<td><input type="text" name="weekly" value="<?php echo $price->week;  ?>"></td>
</tr>


<tr>
<td><?php echo translate_admin("Monthly"); ?></td>
<td><input type="text" name="monthly" value="<?php echo $price->month;  ?>"></td>
</tr>


<tr>
<td><?php echo translate_admin("Additional Guests"); ?></td>
<td>
<input id="hosting_price_for_extra_person_native" name="extra" size="30" type="text" value=<?php echo $price->addguests; ?> />
&nbsp;<?php echo translate("Per night for each guest after"); ?>                 
<select id="hosting_guests_included" name="guests">
<?php for($i = 1; $i <= 16; $i++) { ?>
<option value="<?php echo $i; ?>"><?php echo $i; if($i == 16) echo '+'; ?> </option>
<?php } ?>
</select>
</td>
</tr>


<tr>
<td><?php echo translate_admin("Cleaning Fees"); ?></td>
<td><input id="hosting_extras_price_native" name="cleaning" size="30" type="text" value="<?php echo $price->cleaning;  ?>"></td>
</tr>

<tr>
<td></td>
<td>
<div class="clearfix">
<span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update_price" value="<?php echo translate_admin("Update"); ?>" style="width:90px;" /></span>
<span style="float:left; padding:0 0 0 0;"><div id="message4"></div></span>
</div>
</td>
</tr>
<input type="hidden" name="list_id" value="<?php echo $result->id;  ?>">

</table> 
</form>
</div>

</div>


<!-- TinyMCE inclusion -->
<script type="text/javascript" src="<?php echo base_url()?>css/tiny_mce/tiny_mce.js" ></script>

<script language="Javascript">

jQuery("#property_id").val('<?php echo $result->property_id; ?>');
jQuery("#room_type").val('<?php echo $result->room_type; ?>');

jQuery("#hosting_person_capacity").val('<?php echo $result->capacity; ?>');
jQuery("#hosting_bedrooms").val('<?php echo $result->bedrooms; ?>');
jQuery("#hosting_beds").val('<?php echo $result->beds; ?>');
jQuery("#hosting_bed_type").val('<?php echo $result->bed_type; ?>');
jQuery("#hosting_bathrooms").val('<?php echo $result->bathrooms; ?>');

jQuery("#hosting_native_currency").val('<?php echo $price->currency; ?>');

jQuery("#hosting_guests_included").val('<?php if(isset($price->guests)) echo $price->guests; else echo '1'; ?>');

tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
});

</script>  
<!-- End of inclusion of files -->
<script type="text/javascript">
function showhide(id)
{
		if(id == 1)
		{
		 document.getElementById("description").style.display = "block";
			document.getElementById("aminities").style.display = "none";
			document.getElementById("photo").style.display = "none";
			document.getElementById("price").style.display = "none";
			
		document.getElementById('descriptionA').className = 'clsNav_Act';
		document.getElementById('aminitiesA').className = '';
		document.getElementById('photoA').className = '';
		document.getElementById('priceA').className = '';
		}
		else if(id == 2)
		{
			document.getElementById("aminities").style.display = "block";
			document.getElementById("description").style.display = "none";
			document.getElementById("photo").style.display = "none";
			document.getElementById("price").style.display = "none";
			
		document.getElementById('descriptionA').className = '';
		document.getElementById('aminitiesA').className = 'clsNav_Act';
		document.getElementById('photoA').className = '';
		document.getElementById('priceA').className = '';
		}
		else if(id == 3)
		{
			document.getElementById("photo").style.display = "block";
			document.getElementById("description").style.display = "none";
			document.getElementById("aminities").style.display = "none";
			document.getElementById("price").style.display = "none";
			
		document.getElementById('descriptionA').className = '';
		document.getElementById('aminitiesA').className = '';
		document.getElementById('photoA').className = 'clsNav_Act';
		document.getElementById('priceA').className = '';
		}
		else
		{
		 document.getElementById("price").style.display = "block";
			document.getElementById("description").style.display = "none";
			document.getElementById("aminities").style.display = "none";
			document.getElementById("photo").style.display = "none";
			
		document.getElementById('descriptionA').className = '';
		document.getElementById('aminitiesA').className = '';
		document.getElementById('photoA').className = '';
		document.getElementById('priceA').className = 'clsNav_Act';
		}
}
</script>