<script type="text/javascript">
		function startCallback() {
			$("#message").html('<img src="<?php echo base_url().'images/loading.gif' ?>">');
		// make something useful before submit (onStart)
		return true;
	}

	function completeCallback(response) {
		$('#message').show();
		$("#message").html(response);
		$("#message").delay(1800).fadeOut('slow');
	}
</script>


    <div id="google_settings">
		<div class="clsTitle">
	 <h3><?php echo translate_admin('Google Maps Settings'); ?></h3>
	 </div>
		
<form action="<?php echo admin_url('social/google_settings'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">	

<table class="table" cellpadding="2" cellspacing="0">
	
<tr>
			<td class="clsName"><?php echo translate_admin('Google Map Key'); ?><span class="clsRed">*</span></td>
			<td> <input type="text" name="gmap_api_key" size="77" value="<?php if(isset($gmap_api_key)) echo $gmap_api_key; ?>"></td>
</tr>		
	

<tr>
		<td></td>
		<td>
		<div class="clearfix">
		<span style="float:left; margin:0 10px 0 0;"><input class="clsSubmitBt1" type="submit" name="update" value="<?php echo translate_admin('Update'); ?>" style="width:90px;" /></span>
		<span style="float:left;"><div id="message"></div></span>
		</div>
		</td>
</tr>

</table>

<?php echo form_close(); ?>

</div>
