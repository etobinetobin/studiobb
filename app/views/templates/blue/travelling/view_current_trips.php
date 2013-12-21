<!-- Required css stylesheets -->
<script type="text/javascript" src="<?php echo base_url().'js/jquery.fancybox-1.3.4.pack.js'; ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo css_url().'/jquery.fancybox-1.3.4.css' ?>" media="screen" />
<link href="<?php echo css_url().'/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<!-- End of stylesheet inclusion -->
<?php $this->load->view(THEME_FOLDER.'/includes/dash_header'); 

// Print The Reservation List
$content = '';
$content .= '<p style="padding:5px 5px 5px 725px"><a style="color:#38859B;cursor:pointer;" onClick="javascript:window.print();"><strong>'.translate('Print').'</strong></a></p>';
$content .= '<table border="1" width="100%">';
$content .= '<tr>';
$content .= '<th>'.translate("Status").'</th>';
$content .=	'<th>'.translate("Location").'</th>';
$content .= '<th>'.translate("Host").'</th>';
$content .= '<th>'.translate("Dates").'</th>';
$content .=	'</tr>';

foreach($result->result() as $row) {

$content .= '<tr>';
$content .= '<td>'.$row->name.'</td>';
$content .= '<td><p><strong>'.get_list_by_id($row->list_id)->title.'</strong></p><p><em>'.get_list_by_id($row->list_id)->address.'</em></p></td>';
$content .= '<td><p><img height="50" width="50" alt="image" style="float:left; margin:0 10px 10px 0;" src="'.$this->Gallery->profilepic($row->userto, 2).'" />'.ucfirst(get_user_by_id($row->userto)->username).'</p</td>';
$content .= '<td>'.get_user_times($row->checkin, get_user_timezone()).' - '.get_user_times($row->checkout, get_user_timezone()).'</td>';
$content .= '</tr>';

}

$content .= '</table>';

?>
    
<script type="text/javascript">
<?php foreach($result->result() as $row) { ?>
	$(document).ready(function() {
			$("#cancellation_<?php echo $row->id; ?>").fancybox({	});
	});
	<?php } ?>

	$(document).ready(function() {
			$("#checkout").fancybox({	});
	});
	
function print_reservation() {
	var myWindow;
	myWindow=window.open('','_blank','width=800,height=500');
	myWindow.document.write("<p><?php echo addslashes($content); ?></p>");
	myWindow.print();
}
	</script>
	

 <?php $this->load->view(THEME_FOLDER.'/includes/travelling_header'); ?>
 <div id="dashboard_container">   
 <div class="Box" id="View_Currents_Tips">
   <div class="Box_Head msgbg">
      <h2><?php echo translate("Current Trips"); ?><span class="View_MyPrint"> <a href="javascript:void(0);" onclick="javascript:print_reservation();"><?php echo translate("Print this page"); ?></a> </span></h2>
     </div>
     <div style="clear:both"></div>
   <div class="Box_Content">
     
					
					<?php if($result->num_rows() > 0) { ?>
					

			<table class="clsTable_View" width="100%" cellpadding="0" cellspacing="0">
			<tr>
			 <th> <?php echo translate("Status"); ?> </th>
				<th> <?php echo translate("Location"); ?> </th>
				<th> <?php echo translate("Host"); ?> </th>
				<th> <?php echo translate("Dates"); ?> </th>
				<th> <?php echo translate("Options"); ?> </th>
			</tr>
			
	  <?php foreach($result->result() as $row) { ?>
    <tr>
			 <td> <p class="View_my_Accept_Bg"><span><?php echo $row->name; ?></span></p> </td>
				<td>
					<p class="clsBold"> <?php echo anchor('travelling/host_details/'.$row->id, get_list_by_id($row->list_id)->address); ?> </p> 
				</td>
				<td width="24%">
				 <p> <img height="50" width="50" alt="image" style="float:left; margin:0 10px 10px 0;" src="<?php echo $this->Gallery->profilepic($row->userto,2); ?>" />
					<span class="clsBold">
					<a href="<?php echo site_url('users/profile').'/'.$row->userto; ?>"><?php echo ucfirst(get_user_by_id($row->userto)->username); ?></a>
					</span></p>
     <p><a class="clsLink2_Bg" href="<?php echo site_url('trips/send_message/'.$row->userto); ?>"><?php echo translate("View").' / '.translate("Send").' '.translate("Message"); ?></a></p>
				</td>
				<td><?php echo get_user_times($row->checkin, get_user_timezone()).' - '.get_user_times($row->checkout, get_user_timezone()); ?></td>
			 <td width="16%">
				<?php if ( date('m/d/Y', get_user_time($row->checkout, get_user_timezone())) <= date('m/d/Y', get_user_time(local_to_gmt(), get_user_timezone())) ) { ?>
				 <p class="clsBold"><?php echo anchor('travelling/checkout/'.$row->id,translate("Checkout"),array('id' => 'checkout'));  ?></p>
				<?php } ?>
					<p class="clsBold"><?php echo anchor('travelling/billing/'.$row->id,translate("View Billing"));  ?></p>
					<?php if ($row->status < 8 ) { ?>
					<p class="clsBold"><a id="cancellation_<?php echo $row->id; ?>" href="<?php echo site_url('travelling/cancel_travel/'.$row->id.'/'.$row->list_id); ?>"><?php echo translate("Cancel Reservation");  ?></a></p>
					<?php } ?>
			 </td>
			</tr>
   <?php } ?>
			</table>
			<?php }	else	{ ?>
			
      <div id="searching"> 
						<?php echo form_open("search",array('id' => 'search_form')); ?>
       <p><?php echo translate("You have no current trips."); ?> </p>
       <p>
       <input value="Where are you going?" onclick="clear_location(this);" type="text" class="location rounded_left" autocomplete="off" id="location" name="location" />
       <button id="submit_location" class="btn green tripsearch" onclick="if (check_inputs()) {$('#search_form').submit();}return false;" type="button" name="submit_location"><span><span><?php echo translate("Search"); ?></span></span></button></p>
       
       <?php echo form_close(); ?> </div>
      <?php }?>
    <div style="clear:both"></div>
   </div>
 </div>
</div>
 <!-- this tag for Header file -->
<script type="text/javascript">
    function is_not_set_location() { return (!$('#location').val() || ("Where are you going?"== $('#location').val())) }
    
    function clear_location (box) {
        if (is_not_set_location()) box.value = '';
    }
    
    function check_inputs() {
        if (is_not_set_location()) { alert("Please set location"); return false; }
        return true;
    }
</script>