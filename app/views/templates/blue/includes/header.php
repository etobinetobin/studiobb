<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- Meta Content from user -->
<meta http-equiv="X-UA-Compatible" content="IE=9">
<meta name="title" content="<?php if(isset($title)) echo $title; else echo ""; ?>" />
<meta name="keywords" content="<?php if(isset($meta_keyword)) echo $meta_keyword; else echo ""; ?>" />
<meta name="description" content="<?php if(isset($meta_description)) echo $meta_description; else echo ""; ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?>
<?php
$this->load->helper('gzip');
$mainpath =  dirname($_SERVER['SCRIPT_FILENAME']);
?>

<script src="<?php echo base_url().'js/cufon-yui_2.js'; ?>" ></script>
<!-- End of meta content -->
<title><?php echo $title ?></title>
<link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="Cogzidel" />
<link href="<?php echo css_url(); ?>/common.css" media="screen" rel="stylesheet" type="text/css" />
<!--<style>
<?php 
$sPath = $mainpath.'/css/templates/blue/common.css';
$sOutFile = $sPath.'.gz';
echo gzip($sPath, $sOutFile);
?>
</style>-->
<link rel="stylesheet" href="<?php echo css_url(); ?>/responsiveslides.css">
<link rel="stylesheet" href="<?php echo css_url(); ?>/demo.css">

<?php $this->load->view(THEME_FOLDER.'/includes/map'); ?>
<script>var NREUMQ=[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);(function(){var d=document;var e=d.createElement("script");e.type="text/javascript";e.async=true;e.src="<?php echo base_url(); ?>js/rum.js";var s=d.getElementsByTagName("script")[0];s.parentNode.insertBefore(e,s);})()</script>
<script type="text/javascript">
				var base_url = '<?php echo base_url(); ?>';
				var default_value = '<?php echo translate("Where are you going?"); ?>';
				</script>

<script src="<?php echo base_url(); ?>js/common.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url().'js/jquery.validate.js'; ?>"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>

<?php if($this->uri->segment(2) == 'searchbydate' || $this->uri->segment(1) == 'search') { ?>
<script src="<?php echo base_url(); ?>js/page2.js" type="text/javascript"></script>
<?php } else if($this->uri->segment(2) == 'editConfirm' || $this->uri->segment(1) == 'rooms') { ?>
<script src="<?php echo base_url(); ?>js/page3.js" type="text/javascript"></script>
<?php  } else { ?>
<script src="<?php echo base_url(); ?>js/home.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/home_new.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/page1.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/page1_new.js" type="text/javascript"></script>
<?php if($this->uri->segment(1) != 'rooms' && $this->uri->segment(1) != 'calendar') { ?>
<!-- Slider Kit scripts -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.easing.1.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.sliderkit.1.8.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/sliderkit.delaycaptions.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.leanModal.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/js/responsiveslides.min.js"> </script>
<!--<script type="text/javascript" src="jquery.js"></script>-->
<?php }
  } ?>
</head>
<body>
<div id="fb-root"></div>
<?php
   			$logo         = $this->Common_model->getTableData('settings',array('code' => 'SITE_LOGO'))->row()->string_value;
			$query        = $this->Common_model->getTableData('settings', array('code' => 'FRONTEND_LANGUAGE'));
			$trans_lang   = $query->row()->int_value;
			$default_lang = $query->row()->string_value;
			$user_lang    = $this->session->userdata('locale');
			
			if($user_lang == '')
			{
			  $locale = $default_lang;
			}
			else
			{
			  $locale = $user_lang;
			}
			
			$currency_code     = $this->session->userdata('locale_currency');
			$new_currency      = $this->Common_model->getTableData('currency', array('default' => 1))->row();
			if($currency_code == '')
			{
			  $currency_code   = $new_currency->currency_code;
					$currency_symbol = $new_currency->currency_symbol;
			}
			else
			{
			$currency_code     = $this->session->userdata('locale_currency');
			$currency_symbol   = $this->Common_model->getTableData('currency', array('currency_code' => $currency_code))->row()->currency_symbol;
			}
			
			
			if($this->dx_auth->is_logged_in())
			{
				
				if($this->dx_auth->get_username() == "")
				{
				$query          = $this->Common_model->getTableData( 'profiles',array('id' => $this->dx_auth->get_user_id()) )->row();
				$name           = $query->Fname.' '.$query->Lname;
				}
				else
				{
				$name           = $this->dx_auth->get_username();
				}
			}
			else
			{
			$name = '';
			}
  ?>
  <?php if($this->uri->segment(1) != 'payments' && $this->uri->segment(1) != 'listpay')
  {
  if($this->uri->segment(2) != 'edit')
  {
  	if($this->uri->segment(1)!='calendar')
	{
   ?>
  <script type="text/javascript">
 
//create a function that accepts an input variable (which key was key pressed)
function disableEnterKey(e){
	
//create a variable to hold the number of the key that was pressed     
var key;
 
    //if the users browser is internet explorer
    if(window.event){
      
    //store the key code (Key number) of the pressed key
    key = window.event.keyCode;
      
    //otherwise, it is firefox
    } else {
      
    //store the key code (Key number) of the pressed key
    key = e.which;     
    }
      
    //if key 13 is pressed (the enter key)
    if(key == 13){
      
    //do nothing
    
    return false;
      
    //otherwise
    } else {
      
    //continue as normal (allow the key press for keys other than "enter")
    return true;
    }
      
//and don't forget to close the function    
}
</script> 
<script type="text/javascript">
function getSelectedText() {
        if (window.getSelection) {
            return window.getSelection().toString();
        } else if (document.selection) {
            return document.selection.createRange().text;
        }
        return '';
    }
	$(function() {
				
       var date = new Date();
var currentMonth = date.getMonth();
var currentDate = date.getDate();
var currentYear = date.getFullYear();

	   $( "#checkoutdate2" ).datepicker({
                minDate: 0,
                maxDate: "+2Y",
                nextText: "",
                prevText: "",
                numberOfMonths: 1,
                // closeText: "Clear Dates",
                currentText: Translations.today,
                showButtonPanel: true,
                onClose: function(dateText, inst) { 
                	
	 	<?php if($this->uri->segment(1)=='0')
		{  ?>
	 	$('.advanced_search').show();
          <?php } else { ?>
       $('.advanced_search_rooms').show();   
       <?php } ?>    
        
     } 
	    });
	  
	    $( "#checkindate2" ).datepicker({
			    minDate: date,
                maxDate: "+2Y",
                nextText: "",
                prevText: "",
                numberOfMonths: 1,
                currentText: Translations.today,
                showButtonPanel: true,
	 onClose: function(dateText, inst) { 
	 	 
	 	<?php if($this->uri->segment(1)=='0')
		{  ?>
			
	 	$('.advanced_search').show();
          <?php } else { ?>
          	
       $('.advanced_search_rooms').show();   
       <?php } ?>
        
          d = $('#checkindate2').datepicker('getDate');
         if(!d)
         {
         	var d = new Date();
         	 d.setDate(d.getDate()+1); // add int nights to int date
		$("#checkoutdate2").datepicker("option", "minDate", d);
         }
         else
         {
         	d.setDate(d.getDate()+1); // add int nights to int date
		$("#checkoutdate2").datepicker("option", "minDate", d);
         }
		  
		setTimeout(function () 
		{
			
                                }, 0)           
     } 
	   });
    });
 
$(document).ready(function(){
	$("#close_search1").click(function(){
		<?php if($this->uri->segment(1)=='')
		{  ?>
	 $("#advanced_search").fadeOut();
          <?php } else { ?>
      $("#advanced_search_rooms").fadeOut();  
       <?php } ?> 
	
});
$("#close_search").click(function(){
		<?php if($this->uri->segment(1)=='')
		{  ?>
	 $("#advanced_search").fadeOut();
          <?php } else { ?>
      $("#advanced_search_rooms").fadeOut();  
       <?php } ?> 
	
});
});
</script>
<?php
} 
}
}?>
    
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>

   <script type="text/javascript">

$(document).ready(function () {
	
      var input = document.getElementById('searchTextField');
    autocomplete = new google.maps.places.Autocomplete(input);    
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        <?php if($this->uri->segment(1)=='0')
		{  ?>
	 	$('.advanced_search').show();
          <?php } elseif($this->uri->segment(2)=='edit') { ?>
       $('.advanced_search_rooms').hide();   
       <?php }
else 
 	{ ?>
		  $('.advanced_search_rooms').show();  
	<?php } ?> 
            
// now call it automaitically on page load
$('#checkindate2').trigger('click');
    });
    
});


</script>
 <style>
.pac-item-query{
	color:#0F92CD;
	cursor: pointer;
	font-size: 16px;
}
.pac-item{
	color:#0F92CD;
	cursor: pointer;
	font-size: 16px;
	padding-left: 10px;
}
/*.pac-container .pac-item:hover, .pac-container .pac-item.pac-selected{
background: url("https://a0.muscache.com/airbnb/static/landing_pages/home_v2/search-option-highlight-bg-fdcbf17186af2f120363d76c8b768954.jpg") repeat-x scroll 0px 0px rgb(19, 132, 179) !important;
color: white;
}*/
.pac-icon
{
	width:0px;
}
.pac-container
{
	border: black;
}/*
.pac-item-query:hover {
	background: url(../../../../../images/advanced_search_bg.png) repeat scroll 0 0 rgb(19, 132, 179) !important;
	color: #FFFFFF;
	font-weight: bold;
}
.pac-item:hover {
	background: url(../../../../../images/advanced_search_bg.png) repeat scroll 0 0 rgb(19, 132, 179) !important;
	color: #FFFFFF;
	font-weight: bold;
}*/
</style>


<!--Header-->
<div id="header" class="clearfix">
  <div class="headerleft">
    <div class="logo">
      <a href="<?php echo base_url(); ?>"> <img title="Airbnb-clone" src="<?php echo base_url().'logo/'.$logo; ?>"> </a> </div>
       <?php if($this->uri->segment(1) == 'search') { ?>
       	<div class="search" style="display: none">
       	<?php } else {?>
    <div class="search">
    	<?php } ?>
      <form id="search_form1" action="<?php echo site_url('search'); ?>" method ="post" class="searchform_head">
      <input type="text" id="searchTextField" name="searchbox" class="searchbox" value="<?php echo translate("Where are you going?");?>" onblur="if (this.value == ''){this.value = '<?php echo translate("Where are you going?");?>'; }"
   onfocus="if (this.value == '<?php echo translate("Where are you going?");?>') {this.value = ''; }" onKeyPress="return disableEnterKey(event)" placeholder="<?php echo translate("Where are you going?"); ?>"/>
  <div id="map-canvas"></div>
   <?php  if($this->uri->segment(1) == '0')
		{ 	$img_path=base_url().'images/close_red.png'; ?>
        <div class='advanced_search' id="advanced_search" style='display: none; position: absolute;
        z-index: 2147483647; background:#FCFCFC; border: 1px solid #CCCCCC; padding: 10px; opacity: 1;width: 260px;top:39px;'>     
    <label class="checkin_search">
	<?php echo translate('Check in'); ?>
		<div id="checkinWrapper" class="input-wrapper">
		<input id="checkindate2" class="check_wrap checkin search-option ui-datepicker-target" type="text" placeholder="Check in" name="checkin" onblur="if (this.value == ''){this.value = 'Check in'; }" onfocus="if (this.value == 'Check in') {this.value = ''; }" autocomplete="off" >
		</div>
	</label>
	<label class="checkout-detail_search">
		<?php echo translate('Check out'); ?>
		<div id="checkoutWrapper" class="input-wrapper">
		<input id="checkoutdate2" class="check_wrap checkout search-option ui-datepicker-target" type="text" placeholder="Check out" name="checkout" onblur="if (this.value == ''){this.value = 'Check out'; }" onfocus="if (this.value == 'Check out') {this.value = ''; }" autocomplete="off" >
	</div>
    </label>
	<label class="guest-detail_search">
		<div class="guests_section">
        <div class="heading">
          <?php echo translate("Guests"); ?>
        </div>
        <select id="number_of_guests" name="number_of_guests" placeholder="Guests" class="guest-detail-section" style="margin-top: 5px;padding: 4px;">
          <option placeholder="1">1</option>
          <option placeholder="2">2</option>
          <option placeholder="3">3</option>
          <option placeholder="4">4</option>
          <option placeholder="5">5</option>
          <option placeholder="6">6</option>
          <option placeholder="7">7</option>
          <option placeholder="8">8</option>
          <option placeholder="9">9</option>
          <option placeholder="10">10</option>
          <option placeholder="11">11</option>
          <option placeholder="12">12</option>
          <option placeholder="13">13</option>
          <option placeholder="14">14</option>
          <option placeholder="15">15</option>
          <option placeholder="16">16+</option>
        </select>
		</div>
	</label>
                    <div style="clear:both"></div>
                         <p class="filter_header"><?php echo translate("Room type"); ?></p>
                  	 <!-- Search filter content is below this -->
                    <div style="clear:both"></div>
                    <ul class="search_filter_content">
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter" type="checkbox" value="Entire home/apt" name="room_types" id="room_type_0">
	                        <label class="checkbox_list" for="room_type_0"> <?php echo translate("Entire home/apt"); ?></label>
                        </li>
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter" type="checkbox" value="Private room" name="room_types" id="room_type_1">
	                        <label class="checkbox_list" for="room_type_1"> <?php echo translate("Private room"); ?></label>
                        </li>
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter" type="checkbox" value="Shared room" name="room_types" id="room_type_2">
                            <label class="checkbox_list" for="room_type_2"><?php echo translate("Shared room"); ?></label>
                        </li>
                    </ul>
                    <div style="clear:both"></div>
		<button id="submit_location" class="find-btn" type="submit" value="Search" name="Submit" >
		<i class="icon icon-search"></i>
		<img src="<?php echo base_url(); ?>/css/templates/blue/images/search_icon1.png" />
		<?php echo translate("Find A Place"); ?>
		</button>
		<label class='find-btn-close' id="close_search">
			<?php echo translate("Close"); ?>
			</label>
	</div>
<?php }
else { ?>
		<div class='advanced_search_rooms' id='advanced_search_rooms' style='display: none; position: absolute;
     background:#FCFCFC; border: 1px solid #CCCCCC; padding: 10px; opacity: 1; width: 260px; top:39px; z-index: 2147483647; '>
    <label class="checkin_search" style="margin-right:5px">
	<?php echo translate('Check in'); ?>
		<div id="checkinWrapper" class="input-wrapper">
		<input id="checkindate2" class="check_wrap checkin search-option ui-datepicker-target" type="text" placeholder="Check in" name="checkin" onblur="if (this.value == ''){this.value = 'Check in'; }" onfocus="if (this.value == 'Check in') {this.value = ''; }" autocomplete="off">

		</div>
	</label>
	<label class="checkout-detail_search" style="margin-right:5px">
		<?php echo translate('Check out'); ?>
		<div id="checkoutWrapper" class="input-wrapper">
		<input id="checkoutdate2" class="check_wrap checkout search-option ui-datepicker-target" type="text" placeholder="Check out" name="checkout" onblur="if (this.value == ''){this.value = 'Check out'; }" onfocus="if (this.value == 'Check out') {this.value = ''; }" autocomplete="off">

	</div>
    </label>
		<label class="guest-detail_search" for="number_of_guests">
			<?php echo translate("Guests"); ?><br />
                <select id="number_of_guest" name="number_of_guest" class="guest-detail-section" style="margin-top: 5px;padding: 4px;">
                  		<?php for($i = 1; $i <= 16; $i++) { ?>
							<option placeholder="<?php echo $i; ?>"><?php echo $i; if($i == 16) echo '+'; ?> </option>
														       <?php } ?>
                </select>
		</label>
				<div style="clear:both"></div>
					<p class="filter_header"><?php echo translate("Room type"); ?></p>
				<div style="clear:both"></div>
                  	 <!-- Search filter content is below this -->
                    <ul class="search_filter_content">
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter" type="checkbox" value="Entire home/apt" name="room_types" id="room_type_0">
	                        <label class="checkbox_list" for="room_type_0"> <?php echo translate("Entire home/apt"); ?> </label>
                        </li>
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter" type="checkbox" value="Private room" name="room_types" id="room_type_1">
                        <label class="checkbox_list" for="room_type_1"> <?php echo translate("Private room"); ?> </label>
                        </li>
                        <li class="clearfix checkbox">
                            <input class="checkbox_filter" type="checkbox" value="Shared room" name="room_types" id="room_type_2">
                            <label class="checkbox_list" for="room_type_2"><?php echo translate("Shared room"); ?></label>
                        </li>
                    </ul>
                    <div style="clear:both"></div>
		<button id="submit_location" class="find-btn blue" type="submit" value="Search" name="Submit" >
		<i class="icon icon-search"></i>
		<img class="search_icon_checkinout" src="<?php echo base_url(); ?>/css/templates/blue/images/search_icon1.png" />
	<?php echo translate("Find A Place"); ?>
		</button>
        <label class='find-btn-close blue' id="close_search1">
			<?php echo translate("Close"); ?>
			</label>
	</div>
	<?php } ?>
	</form>
    </div>
  </div>
  
  <div style="float:left;margin-left:20px;margin-top:0px;">
    <ul id="navigation">
      <li id="subnavigation">
        <ul class="menu">
          <li><a class="menu-browse" href="#"><?php echo translate("Browse")?> </a>
				<img class="browse_downarrow" src="<?php echo base_url(); ?>/images/down_arrow.png" />
            <ul>
              <li class="bya"><a href="<?php echo base_url().'home/popular/'?>"><i class="icon-popular"> </i> <?php echo translate("Popular"); ?></a></li>
              <li><a href="<?php echo base_url().'home/friends/'?>"><i class="icon-friends"> </i> <?php echo translate("Friends"); ?></a></li>
              <li><a href="<?php echo base_url().'home/neighborhoods/'?>"><i class="icon-neighborhoods"> </i> <?php echo translate("Neighborhoods"); ?></a></li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </div>

  <div class="headerright">
    <ul class="clearfix clsFloatRight header_content">

		      <?php if(0):  
		      	if($this->session->userdata('image_url') != '')
				   {
				      $src = $this->session->userdata('image_url');
				   }
				   else {
					   
				  	 $src = $this->Gallery->profilepic($this->dx_auth->get_user_id(),2);
					   
				   }
		      	?>
      <li class="help"><a href="#"><?php echo /*translate("Hello").*/'&nbsp&nbsp'.
	      "<img src='".$src."'width='30' height='30'/>"
	      .'&nbsp&nbsp'.$name; ?></a>
			  <ul class="sub-help">
			      <li><?php echo anchor('home/dashboard', translate("Dashboard")); ?></li>
			      <li><?php echo anchor('hosting', translate("Your Listings")); ?></li>
			      <li><?php echo anchor('travelling/current_trip', translate("Your Trips")); ?></li>
			       <li><?php echo anchor('account/mywishlist', translate("Wishlists")); ?></li>
			       <li><?php echo anchor('users/edit', translate("Edit Profile")); ?></li>
			       <li><?php echo anchor('account', translate("Account")); ?></li>
			       <?php if($this->dx_auth->is_admin()): ?>
			      <li><?php echo anchor('administrator', translate("Admin Panel"),array("target"=>"_blank")); ?></li>
			      <?php endif; ?>
			      <li><?php echo anchor('users/logout', translate("Logout")); ?></li>
			   </ul>
		
      </li>
    </ul>
    </div>
      <?php elseif(!($this->dx_auth->is_logged_in())): ?>
      	
      <li><?php echo anchor('users/signup', translate("Sign Up")); ?></li>
      <li><?php echo anchor('users/signin', translate("Sign In")); ?></li>
      <?php else: 
      	if($this->session->userdata('image_url') != '')
		   {
		      $src = $this->session->userdata('image_url');
		   }
		   else {
			   
		  	 $src = $this->Gallery->profilepic($this->dx_auth->get_user_id(),2);
			   
		   }
      	?>

      <li class="help"><span><?php echo '&nbsp&nbsp'.
      "<img src='".$src."'width='30' height='30'/>"
      .'&nbsp&nbsp'.$name; ?></span>
          <ul class="sub-help">
              <li><?php echo anchor('home/dashboard', translate("Dashboard")); ?></li>
              <li><?php echo anchor('hosting', translate("Your Listings")); ?></li>
              <li><?php echo anchor('travelling/current_trip', translate("Your Trips")); ?></li>
              <li><?php echo anchor('account/mywishlist', translate("Wishlists")); ?></li>
              <li><?php echo anchor('users/edit', translate("Edit Profile")); ?></li>
              <li><?php echo anchor('account', translate("Account")); ?></li>
              <?php if($this->dx_auth->is_admin()): ?>
              <li><?php echo anchor('administrator', translate("Admin Panel"),array("target"=>"_blank")); ?></li>
              <?php endif; ?>
              <li><?php echo anchor('users/logout', translate("Logout")); ?></li>
              <?php endif; ?>
          </ul>
      </li>
<?php 
        	$segment =$this->uri->segment(2);
        	if($segment == 'help')
				  {  ?>
				  	<script>
				  	$(document).ready(function(){
				  	$('#view_help').hide();
				  	})
                   </script>	
				 <?php  }
				  ?>
                   <?php  
				 $u_agent = $_SERVER['HTTP_USER_AGENT']; 
				  if(preg_match('/MSIE/i',$u_agent))
    {
       
      echo "<li id='view_help' style='float:left;width:85px;padding:0px;'>"; 
    }
	else
	{
	echo "<div id='view_help' style='float:left;'>";
	}
	
  ?>
       
    <ul id="navigation">
      <li id="subnavigation">
      	<ul class="menu_help">
      	<?php 
        	$segment =$this->uri->segment(2);
        	if($segment == 'help')
				  {
				  	
				  } else
				  {
				  	?>
	    <li class="hel_in"><a href="#"><?php echo translate("Help") ?> </a>
        <img class="hel_downarrow" src="<?php echo base_url(); ?>/images/down_arrow.png" />
	    	<?php }?>
	     <ul>
	     	<?php	
	     	$static_que = $this->db->where('page_refer','guide')->where('status',0)->from('help')->get();
	     	if($static_que->num_rows()!=0)
			{ 
				foreach($static_que->result() as $row_status)
				{ $row_status->id;
					?>
					<li class="guide"><a href="<?php echo base_url().'home/help/'.$row_status->id;?>"><?php echo $row_status->question.'</a>';?></li>
				<?php 
				
				} }
	     	?>
	     	<?php
	     	
					$id_segment =$this->uri->segment(1);
				    $segment =$this->uri->segment(2);
					if(!$id_segment)
					{
						 $sql=$this->db->where('id','1')->get('help');
						 if($sql->num_rows()==0)
						 {
						 	
						 }
					}
					else {
						
					if($id_segment && !$segment)
					{
					 $sql=$this->db->where('page_refer',$id_segment)->get('help');
					
					}
					else {
						$id_segment =$this->uri->segment(2,0);
						 $sql=$this->db->where('page_refer',$id_segment)->get('help');
						
					}
					}
                  		  
					  
						foreach($sql->result() as $row)
						{
							 $my_id=$row->id;
						$segment=$row->page_refer;
						 $stat = $row->status;
							if($stat !=1)
							{ 
						 ?>
					 <?php echo '<li class="pop_help">';?><a href="<?php echo base_url().'home/help/'.$row->id; ?>"> <?php echo "$row->question";?> <?php } ?></a>
                       
					
				<?php echo'</li>';
				 } 
                ?>
              </li>
              
              
 
          </ul>

        </li>

      </ul>
      <?php  
				 $u_agent = $_SERVER['HTTP_USER_AGENT']; 
				  if(preg_match('/MSIE/i',$u_agent))
    {
       
      echo '</li>';
    }
	else
	{
	echo '</div>';
	}
	
  ?>
<li style="margin-top: 12px; float:left; margin-right: 20px;padding:0;"> <a class="yellow btn" href="<?php echo site_url('rooms/new');?>"><span><?php echo translate('List Your Space'); ?></span></a> </li>
    </ul>

    </li>

    </ul>

  </div>					
</div>
 
<!--Header Ends-->
