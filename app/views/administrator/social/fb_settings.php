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


<div id="Fb_Settings">
<div class="clsTitle">
 <h3><?php echo translate_admin('Facebook Connect Settings'); ?></h3>
</div>
<form action="<?php echo admin_url('social/fb_settings'); ?>" method="post" onsubmit="return AIM.submit(this, {'onStart' : startCallback, 'onComplete' : completeCallback})">
<table class="table" cellpadding="2" cellspacing="0">
 <tr>
  <td class="clsName"><?php echo translate_admin('FB Application ID'); ?><span class="clsRed">*</span></td>
  <td><input type="text" name="fb_api_id" value="<?php if(isset($fb_api_id)) echo $fb_api_id; ?>"></td>
 </tr>
 <tr>
  <td class="clsName"><?php echo translate_admin('FB Application Secret'); ?><span class="clsRed">*</span></td>
  <td><input type="text" size="55" name="fb_api_secret" value="<?php if(isset($fb_api_secret)) echo $fb_api_secret; ?>"></td>
 </tr>
 <tr>
  <td></td>
  <td><div class="clearfix"> <span style="float:left; margin:0 10px 0 0;">
    <input class="clsSubmitBt1" type="submit" name="update" value="<?php echo translate_admin('Update'); ?>" style="width:90px;" />
    </span> <span style="float:left;">
    <div id="message"></div>
    </span> </div></td>
 </tr>
</table>
</form>
</div>

