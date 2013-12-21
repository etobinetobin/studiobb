<!--  Required external style sheets -->
<link href="<?php echo css_url().'/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url().'/popup.css'; ?>" media="screen" rel="stylesheet" type="text/css" />

<!-- <script src="<?php echo base_url().'js/jquery-1.6.1.min.js'; ?>"> </script> --> 
<!--<script src="<?php echo base_url().'js/jquery.validate.min.js'; ?>"> </script>
<script src="<?php echo base_url().'js/jquery-1.4.2.min.js'; ?>"> </script>-->
<!-- End of style sheet inclusion -->
<?php $this->load->view(THEME_FOLDER.'/includes/dash_header'); ?>

<div id="dashboard_container" class="clearfix">
  <div id="dashboard_left">
    <div class="Box" id="das_user_box">
      <div class="Box_Content">
        <div id="user_pic" onClick="show_ajax_image_box();"> <img id="trigger_id" width="230" alt="" src="<?php 
           if($this->session->userdata('image_url') != '')
		   {
		      $image_url = $this->session->userdata('image_url');
			  
			  echo $image_url;
			  $split = explode('.', $image_url);
		  $url = $split[0].'.'.$split[1].'.'.$split[2];
		  $email = $this->db->where('id',$this->dx_auth->get_user_id())->from('users')->get()->row()->email;
		    $data_tw['src'] = $url;
		    $data_tw['ext'] = '.'.$split[3];
			$data_tw['email'] = $email;
		  $this->db->insert('profile_picture',$data_tw);
		   }
		   else {
			  
		  	 echo $this->Gallery->profilepic($this->dx_auth->get_user_id(),2);
			   
		   } ?>" title=""  /> </div>
        <h1>  <?php 
		 echo $name; ?>  </h1>
        <h3><span><?php echo anchor('users/edit', translate("Edit Profile")); ?></span></h3>
        <!-- middle -->
      </div>
    </div>
    <!-- /user -->
    <div class="Box" id="quick_links">
      <div class="Box_Head msgbg">
        <h2><?php echo translate("Quick Links");?></h2>
      </div>
      <div class="Box_Content">
        <ul>
          <li><a href=<?php echo base_url().'hosting'; ?>> <?php echo translate("View/Edit Listings"); ?></a></li>
          <li><a href="<?php echo site_url('hosting/my_reservation'); ?>"><?php echo translate("Reservations"); ?></a></li>
        </ul>
      </div>
      <div style="clear:both"></div>
    </div>
  </div>
  <!-- /left -->
  <div id="dashboard_main">
    <div class="Box" id="welcome_msg_box">
      <div class="Box_Content">
        <h3><?php echo translate("Welcome to")." ".$this->dx_auth->get_site_title()."!"; ?></h3>
        <p><?php echo translate("This is your Dashboard, the place to manage your rental. Update all your personal information from here..");?></p>
      </div>
    </div>
    <div class="Box" id="Dash_Msg_Small">
      <div class="Box_Head msgbg">
        <h2><?php echo translate("Messages")." "."(".$new_notify_rows ; echo " ".translate("new").")"; ?> </h2>
      </div>
      <div class="Box_Content">
        <div id="Msg_Inbox_Small">
          <ul>
            <?php
             if($new_notify->num_rows() > 0) 
             {
             foreach($new_notify->result() as $row) {
	     	 if($row->contact_id != 0)
			 {
			 $checkin=$this->Common_model->getTableData('contacts',array('id' => $row->contact_id))->row()->checkin;  
             $checkout=$this->Common_model->getTableData('contacts',array('id' => $row->contact_id))->row()->checkout; 
             }
			 else 
			 {				
			 $checkin_res=$this->Common_model->getTableData('reservation',array('id' => $row->reservation_id));  
			 if($checkin_res->num_rows()!=0)
			 {
			 $checkin=$this->Common_model->getTableData('reservation',array('id' => $row->reservation_id))->row()->checkin;
             $checkin=date('m/d/y',$checkin);
             $checkout=$this->Common_model->getTableData('reservation',array('id' => $row->reservation_id))->row()->checkout;
			 $checkout=date('m/d/y',$checkout); 
			 $topay = $this->Common_model->getTableData('reservation',array('id' => $row->reservation_id))->row()->topay; 
			 $currency = $this->Common_model->getTableData('reservation',array('id' => $row->reservation_id))->row()->currency; 
			 }
			 }	
             ?>
            <li class="clearfix" <?php if($row->is_read == 0) echo 'style="background:#FFFFD0; color:#00B0FF"'; ?>>
              <div class="clsMsg_User clsFloatLeft"> <a href="<?php echo site_url('users/profile').'/'.$row->userby; ?>"><img height="50" width="50" alt="" src="<?php echo $this->Gallery->profilepic($row->userby,2); ?>" /></a>
                <p><a href="<?php echo site_url('users/profile').'/'.$row->userby; ?>"><?php echo get_user_by_id($row->userby)->username; ?></a> <br />
                  <!--31 minutes-->
                </p>
              </div>
              <div class="clsMeg_Detail clsFloatLeft">
                
														<?php	
															if($row->conversation_id != 0) $message_id = $row->conversation_id; else $message_id = $row->reservation_id;
															if($message_id==0) $message_id=$row->contact_id;
															if($row->message_type == 6)	{ 
															
$subject = 'Inquiry about '.substr(get_list_by_id($row->list_id)->title,0,17);
																		if($row->is_read == 0) echo '<strong>'; echo anchor(''.$row->url.'/'.$row->conversation_id, $subject, array("onclick" => "javascript:is_read(".$row->id.")")); if($row->is_read == 0) echo '</strong>'; 
																																				
															} 
															else if($row->message_type == 3 || $row->message_type == 2)	{ 
									
															$subject = 'Discuss about '.substr(get_list_by_id($row->list_id)->title,0,10);
														    if($row->is_read == 0) echo '<strong>'; echo anchor(''.$row->url.'/'.$row->conversation_id, $subject, array("onclick" => "javascript:is_read(".$row->id.")")); if($row->is_read == 0) echo '</strong>'; 
																														
																											}
															else if($row->message_type == 9)
															{
																if($row->is_read == 0) echo '<strong>'; echo anchor(''.'trips/conversation/'.$row->conversation_id, $row->message, array("onclick" => "javascript:is_read(".$row->id.")")); if($row->is_read == 0) echo '</strong>';
															}			
															else {      
																																																																																																																									
															if($row->is_read == 0) echo '<strong>'; echo anchor(''.$row->url.'/'.$message_id, $row->message, array("onclick" => "javascript:is_read(".$row->id.")")); if($row->is_read == 0) echo '</strong>'; ?>
															<p><?php echo substr(get_list_by_id($row->list_id)->title,0,10); ?></span> <span>(<?php echo date("F j, Y",strtotime($checkin)).' - '.date("F j, Y",strtotime($checkout)) ?>)</p>
											</div>
													<?php }
															if($row->message_type != 9)
															{
													 ?>
																
              <div class="clsMeg_Off clsFloatRight">
                <p> <span><?php echo $row->name; ?></span> 
																  <?php
																   if(isset($topay)) {
																   	
																   //	$topay = get_currency_value2($currency,$topay);
																   	?>
																		<br>
                  <span><?php echo get_currency_symbol($row->list_id).get_currency_value1($row->list_id,$topay); ?></span> 
																		<?php } ?>
																		</p>
              </div>
              <?php } ?>
            </li>
            <?php } } else { ?>
            <li class="clearfix"> <?php echo translate("Nothing to show you."); ?> </li>
            <?php } ?>
          </ul>
          <p class="Txt_Right_Align"><a class="btn blue gotomsg" href="<?php echo site_url('message/inbox'); ?>"><?php echo translate("Go to all messages"); ?></a></p>
          <div style="clear:both"></div>
        </div>
      </div>
    </div>
    <?php 
    $refer_code = $this->db->select('referral_code')->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_code;
	if($refer_code != '')
	{
    $check_refer_code = $this->db->where('trips_referral_code',$refer_code)->or_where('list_referral_code',$refer_code)->get('users');
	if($check_refer_code->num_rows() == 0)
	{
		$refer_amount = $this->db->select('referral_amount')->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_amount;
		if($refer_amount == 0)
		{
    ?>
		<div class="Box_dash">
			<h2><?php echo translate("Invite your friends, earn");?> <?php echo get_currency_symbol1().get_currency_value(100);?>  <?php echo translate("travel credit!"); ?>
	            <a href="<?php echo base_url().'referrals';?>" class="invite_now_green"><?php echo translate('Invite now');?></a>
            </h2>
		</div>
<?php }
		else {
		$referral_amount = $this->db->select('referral_amount')->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_amount;
		 ?>
        <div id="share" class="rounded_more silver_box">
          <div id="title_box">
            <h2><?php echo translate('Referrals');?></h2>
          </div>
          <div id="stats" class="clearfix">
            <div id="earned" class="stat_box">
              <span class="stat_title"><?php echo translate('Travel Credit Available');?></span>
              <div class="stat_number"><?php echo get_currency_symbol1().get_currency_value($referral_amount);?></div>
            </div>
            <div id="possible" class="stat_box">
              <span class="stat_title"><?php echo translate('Travel Credit Possible');?></span>
              <?php
              $trip_refer = $this->db->where('trips_referral_code',$refer_code)->get('users');
			  if($trip_refer->num_rows()!=0)
			  {
			  	$trip_amt = 25*$trip_refer->num_rows();
			  }
			   $list_refer = $this->db->where('list_referral_code',$refer_code)->get('users');
			  if($list_refer->num_rows()!=0)
			  {
			  	$list_amt = 75*$list_refer->num_rows();
			  }
			  
			  if($check_refer_code->num_rows() != 0)
			  {
			  	$final_ref_amt = $check_refer_code->num_rows().'00';
			  }
			  else {
				  $final_ref_amt = 0;
			  }
              
              if(isset($trip_amt) && isset($list_amt))
              {
              	$final_amt = $trip_amt+$list_amt;
              }
			  else if(!isset($trip_amt) && !isset($list_amt))
			  {
			  	$final_amt = $final_ref_amt;
			  }
			  else if(isset($trip_amt) && !isset($list_amt))
              {
              	$final_amt = $trip_amt+0;
              }
			  else if(!isset($trip_amt) && isset($list_amt))
              {
              	$final_amt = 0+$list_amt;
              }
              ?>
              <div class="stat_number"><?php echo get_currency_symbol1().get_currency_value($final_amt);?></div>
            </div>
            <div class="stat_box" id="invite_box">
              <a href="<?php echo base_url().'referrals';?>" id="invite_more" class="btn green large">
                <?php echo translate('Invite More');?>
              </a>
            </div>
          </div>
        
    <div id="blast_box">
      <label class="share_link_text"><?php echo translate('Share Link');?>:</label>
      <input id="unique_link" class="share_link_box" value="<?php echo base_url().'users/signup?airef='.$referral_code; ?>" readonly="true">
        <i class="fbshare" onClick="fb_share();"></i>
        <a class="twshare" onClick="window.open (this.href, 'child', 'height=300,width=500'); return false" href="http://twitter.com/intent/tweet?text=I've been using <?php echo $this->dx_auth->get_site_title(); ?> and love it! Save $25 on your next trip if you sign up now: <?php echo base_url().'users/signup?airef='.$referral_code;; ?>&via=<?php echo $this->dx_auth->get_site_title(); ?>" target="_blank">
  </a>
    </div>
		</div>
    <?php } 
	}
	else {
		$referral_amount = $this->db->select('referral_amount')->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_amount;
		 ?>
        <div id="share" class="rounded_more silver_box">
          <div id="title_box">
            <h2><?php echo translate('Referrals');?></h2>
          </div>
          <div id="stats" class="clearfix">
            <div id="earned" class="stat_box">
              <span class="stat_title"><?php echo translate('Travel Credit Available');?></span>
              <div class="stat_number"><?php echo get_currency_symbol1().get_currency_value($referral_amount);?></div>
            </div>
            <div id="possible" class="stat_box">
              <span class="stat_title"><?php echo translate('Travel Credit Possible');?></span>
              <?php
              $trip_refer = $this->db->where('trips_referral_code',$refer_code)->get('users');
			  if($trip_refer->num_rows()!=0)
			  {
			  	$trip_amt = 25*$trip_refer->num_rows();
			  }
			   $list_refer = $this->db->where('list_referral_code',$refer_code)->get('users');
			  if($list_refer->num_rows()!=0)
			  {
			  	$list_amt = 75*$list_refer->num_rows();
			  }
			  $final_ref_amt = $check_refer_code->num_rows().'00';
              
              if(isset($trip_amt) && isset($list_amt))
              {
              	$final_amt = $trip_amt+$list_amt;
              }
			  else if(!isset($trip_amt) && !isset($list_amt))
			  {
			  	$final_amt = $final_ref_amt;
			  }
			  else if(isset($trip_amt) && !isset($list_amt))
              {
              	$final_amt = $trip_amt+0;
              }
			  else if(!isset($trip_amt) && isset($list_amt))
              {
              	$final_amt = 0+$list_amt;
              }
              ?>
              <div class="stat_number"><?php echo get_currency_symbol1().get_currency_value($final_amt);?></div>
            </div>
            <div class="stat_box" id="invite_box">
              <a href="<?php echo base_url().'referrals';?>" id="invite_more" class="btn green large">
               <?php echo translate('Invite More');?>
              </a>
            </div>
          </div>
        
    <div id="blast_box">
      <label class="share_link_text"><?php echo translate('Share Link');?>:</label>
      <input id="unique_link" class="share_link_box" value="<?php echo base_url().'users/signup?airef='.$referral_code; ?>" readonly="true">
        <i class="fbshare" onClick="fb_share();"></i>
        <a class="twshare" onClick="window.open (this.href, 'child', 'height=300,width=500'); return false" href="http://twitter.com/intent/tweet?text=I've been using <?php echo $this->dx_auth->get_site_title(); ?> and love it! Save $25 on your next trip if you sign up now: <?php echo base_url().'users/signup?airef='.$referral_code;; ?>&via=<?php echo $this->dx_auth->get_site_title(); ?>" target="_blank">
  </a>
    </div>
		</div>
    <?php } 
    }
else {
	?>
	<div class="Box_dash">
			<h2><?php echo translate("Invite your friends, earn");?> <?php echo get_currency_symbol1().get_currency_value(100);?>  <?php echo translate("travel credit!"); ?>
	            <a href="<?php echo base_url().'referrals';?>" class="invite_now_green">Invite now</a>
            </h2>
		</div>
	<?php
}
    ?>
		</div>
	</div> 
</body>
<script src="<?php echo base_url(); ?>js/facebook_invite.js"></script>
<script>
FB.init({ 
       appId:'<?php echo $fb_app_id; ?>', 
       frictionlessRequests: true
     });
function fb_share()
      {
      	FB.ui(
  {
    method: 'feed',
    name: 'Take a trip!',
    link: '<?php echo base_url()."users/signup?airef=".$referral_code;?>',
    picture: '<?php echo base_url()."logo/logo.png";?>',
    caption: "We'll help you pay for it",
    description: 'Discover and book unique spaces around the world with <?php echo $this->dx_auth->get_site_title();?>. Join now and save $25 off your first trip of $75 or more!'
  },
  function(response) {
    
  }
);
      }
      
	</script>