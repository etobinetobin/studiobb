
<link href="<?php echo css_url().'/jquery_colorbox.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url().'/search_result.css'; ?>" media="screen" rel="stylesheet" type="text/css" />

 <style type="text/css">
 body { font: normal 10pt Helvetica, Arial; }
 #map { width: 350px; height: 300px; border: 0px; padding: 0px; }
 </style>
<?php
$this->session->set_userdata('checkin','');
$this->session->set_userdata('checkout','');
$this->session->set_userdata('no_of_guest','');
?>

<?php $zz=0; ?>
<script type="text/javascript">

function show()
{

var location =  document.getElementById('location').value;
		var dataString = "&location=" +location;
			
	
	 b_url = "<?php echo base_url().'search'?>";
		 $.ajax({
		   type: "GET",
		   url: b_url,
		   data: dataString,
		   success: function(data){
		   		$('#neighbor').html(data);
				   }
		 });
	
}


</script>
 <!---Include Validation for the Book it button----->
          <script type="text/javascript">
 $('#book_it_button').live('click',function()
  {
  	
  	var hid = $(this).attr("name");
 var subtotal=$(this).attr("alt");
var checkin = $("#checkin").val();
	var checkout = $("#checkout").val();
	var guest = $("#number_of_guests").val();
			
	var dataString = "checkin=" +checkin +"&checkout="+checkout + "&guest="+guest+"&subtotal=" +subtotal; 
	var c1= encodeURIComponent(checkin);
var c2=encodeURIComponent(checkout);
if($('#checkin').val()=='mm/dd/yy' && $('#checkout').val()=='mm/dd/yy')
{
	alert("Please choose the dates");

	return false;
}   
else
{  
  window.location.href="<?php echo base_url(); ?>payments/index/"+hid+"?"+dataString;
      }
     
    });
    
</script>

<style>
.pac-container {
    width: 450px !important;
}
</style>

<!---- End of script------->
<div id="Search_Main" class="list_view condensed_header_view">
<!-- search_header -->
<div id="Selsearch_params"> 
  <form onsubmit="clean_up_and_submit_search_request(); return false;" id="search_form" style="border:none;">
    <div class="SerPar_Inp_Bg">
       <!-- <label for="location" class="inner_text" id="location_label" style="display:none;"><?php echo translate("City, address, or zip code"); ?></label>
	    <input type="text" autocomplete="off" id="location" name="location" />-->
		<input id="location" class="location" type="text" value="<?php echo translate("Where_do_you_want_to_go"); ?>" name="location" autocomplete="off" onblur="if (this.value == ''){this.value = '<?php echo translate("Where_do_you_want_to_go"); ?>'; }"
   onfocus="if (this.value == '<?php echo translate("Where_do_you_want_to_go"); ?>') {this.value = ''; }" placeholder="<?php echo translate("Where_do_you_want_to_go");?>">
    </div>

    <div class="clsSer_Par_LocButt">
        <input class="btn green search_pagebut" type="submit" id="submit_location" name="submit_location" style="float:right;" value="<?php echo translate("Search");?>" onclick="show();"/>
        <input type="hidden" name="page" id="page" value="<?php echo $page; ?>" />
    </div>
    <div style="clear:both"></div>
  </form>
</div>
<!--Filters -->

<!--Filters End-->	
<!-- search_params -->
<div id="standby_action_area" style="display:none;">
  <div> <b><a id="standby_link" href="/messaging/standby" target="_blank">
    <?php echo translate("Do you need a place <i>pronto</i>? Join our Standby list!"); ?>
    </a></b> </div>
</div>

<!-- search_body -->
<div class="search-main-left">
<div class="Box_Head clearfix">
  		<!-- Left -->   
        <div id="search_type_toggle">
            <div class="search_type_option search_type_option_active" id="search_type_list">
              <span><?php echo translate("List"); ?></span>
            </div>
         	
    </div>
    	<!-- End of Left -->
        <!-- Right -->
        <!-- End of Right -->
          <div class="social_links">
 
  </div>
    </div>
<div style="clear:both"></div>   
<div id="search_body" class="Box">
    <!-- Results header was here initially -->
    <!--  End of results header -->
    <div id="results_filters" style="">
        <div id="filters_text"><?php echo translate("Filters:"); ?></div>
        <ul id="applied_filters">
        </ul>
      </div>
    <ul id="results">
      </ul>
    <!-- results -->
    <div id="results_footer" class="clearfix"style="display:none;">
        <div class="results_count clsFloatLeft"></div>
        <div id="results_pagination" class="clsFloatRight"></div>
      </div>
    <!-- results_footer -->
    <div id="list_view_loading" class="rounded_more" style="display:none;"> <img src="<?php echo base_url(); ?>images/page2_spinner.gif" style="vertical-align: middle;" height="42" width="42" alt="" /> </div>
</div>
</div>
<!--End Of search_body -->
<!-- Contents below this is for the search filters -->
<div id="search_filters_wrapper" class="search-main-right">
	<div id="search_filters">
	<!-- this partial is wrapped in a div class='search_filters' -->
	<!-- Map Container Hidden-->
            <div id="map_options"><input type="checkbox" name="redo_search_in_map" id="redo_search_in_map" /><label for="redo_search_in_map"><?php echo translate("Redo search in map"); ?></label></div>
            <div id="map_wrapper">
            	<div class="Box" id="Mab_Big_Main">
                    <div class="Box_Content">
    				<div id="search_map"></div>
                    </div>
            	</div>
                <div id="map_view_loading" class="rounded_more" style="display:none;"><img src="<?php echo base_url(); ?>images/page2_spinner.gif" style="display:block; float:left; padding:0 12px 0 0;"/><?php echo translate("Loading"); ?>...</div>
                <div id="map_message" style="display:none;"></div>
                <div id="first_time_map_question" style="display:none;">
                    <div id="first_time_map_question_content" class="rounded">
                        <div id="first_time_map_question_arrow"></div>
                        <p><?php echo translate("Check this box to see new search results as you move the map"); ?>.</p>
            
                        <a id="redo_search_in_map_link_on" href="javascript:void(0);"><?php echo translate("Yes, please"); ?></a>
                        <a id="redo_search_in_map_link_off" href="javascript:void(0);"><?php echo translate("No, thanks"); ?></a>
                    </div>
                </div>
            </div>
            
          
<div id="small_map_loading" class="opacity_80 rounded" style="display:none; border:2px solid #989898; -moz-box-shadow:0 0 2px #A8A8A8; -webkit-box-shadow:0 0 2px #A8A8A8;"><img src="<?php echo base_url(); ?>images/page2_spinner.gif" style="width:16px; height:16px; display:block; float:left;"/>
  <?php translate("Loading...",$this->session->userdata('lang'));?>
</div>
<div id="search_filters_toggle" class="search_filters_toggle_on rounded_left"></div>
</div>
</div>
</div>
<!-- v3_search -->

<ul id="blank_state_content" style="display:none;">
  <li id="blank_state">
    <div id="blank_state_molecule"></div>
    <div id="blank_state_text">
      <h3>
        <?php echo translate("Your search was a little too specific."); ?>
      </h3>
      <p style="padding:15px 0 0 5px;">
        <?php echo translate("We suggest unchecking a couple of filters, or searching for a different city."); ?>
      </p>
    </div>
  </li>
</ul>

							

<style type="text/css">
.ac_results { border-color:#a8a8a8; border-style:solid; border-width:1px 2px 2px; margin-left:1px; }
</style>
<script type="text/x-jqote-template" id="badge_template">
    <![CDATA[
        <li class="badge badge_type_<*= this.badge_type *>">
            <span class="badge_image">
                <span class="badge_text"><*= this.badge_text *></span>
            </span>
            <span class="badge_name"><*= this.badge_name *></span>
        </li>
    ]]>
</script>
<script type="text/x-jqote-template" id="list_view_item_template">
    <![CDATA[
        <li id="room_<*= this.hosting_id *>" class="search_result">
            <div class="pop_image_small">
                <div class="map_number"><*= this.result_number *></div>
                <ul class="enlarge"> 
                <a href="<?php echo base_url(); ?>rooms/<*= this.hosting_id *>" class="image_link" title="<*= this.hosting_name *>">
                	<li>
                	<img alt="<*= this.hosting_name *>" class="search_thumbnail" height="426" src="<*= this.hosting_thumbnail_url *>" title="<*= this.hosting_name *>" width="639" />
				<span>
					<?php 
					$id = '<*= this.hosting_id *>';
					$image_url = '<*= this.hosting_thumbnail_url*>';
					$image_url_wm = $image_url.'_watermark.jpg';
					?>
	<img alt="<*= this.hosting_name *>" id="img_wm" class="search_thumbnail_wm" height="230" src="<?php echo $image_url_wm; ?>" title="<*= this.hosting_name *>" width="400" />
		<br /><br /><p class="pricemm"><*= this.hosting_name *></p>
		
</span>

</li>
				</a>
				</ul>
            </div>
                <!-- Add bookit button for all aparments -->
    
<!--<input  name="hosting_id" type="hidden" value="<*= this.hosting_id *>" />
			<a class="btn green bookit_button" href="#" alt="<*=this.price*>" name="<*= this.hosting_id *>" id="book_it_button" style="width:100px !important;">Book it</a>
<!-----End of it------->

            <div class="room_details">
                <h2 class="room_title">
                  <a class="name" href="<?php echo base_url(); ?>rooms/<*= this.hosting_id *>"><*= this.hosting_name *></a>
                 <a href="#" id="star_<*= this.hosting_id *>" title="Add this listing as a 'favorite'" class="star_icon_container"><div class="star_icon"></div></a>
                </h2>
                <* if(this.distance) { *>
                    <p class="address_max_width"><*= this.address *></p>
                    <p class="distance"><*= this.distance *> <*= Translations.distance_away *></p>
                <* } else { *>
                    <p class="address"><*= this.address *></p>
                <* } *>
				<ul class="reputation"> <a href="<?php echo base_url(); ?>rooms/<*= this.hosting_id *>"><img alt="<*= this.user_name *>" height="36" src="<*= this.user_thumbnail_url *>" title="<*= this.user_name *>" width="36" /></a> </ul>
            </div>
            <div class="price">
                <div class="price_data">
                    <sup class="currency_if_required"><*= CogzidelSearch.currencySymbolRight *></sup>
                  <!--  <?php 
                    $xml = '<?xml version="1.0" encoding="UTF-8" ?>
<rss>
    <channel>
        <item>
            <title><![CDATA[<*= this.hosting_id *>]]></title>
        </item>
    </channel>
</rss>';

$xml = simplexml_load_string($xml);
$hosting_id = $xml->channel->item->title;
$hosting_id = (string)$hosting_id;
//$hosting_id = (int)$hosting_id;
var_dump(trim($hosting_id));
//echo get_currency_symbol($hosting_id);
 ?>-->
 
                    <div class='currency_with_sup'><sup><*= this.symbol *></sup><*= this.price *></div>
                </div>
                <div class="price_modifier">
                    Per night
                </div>
            </div>
			<div class="user_thumb">
          </div>
					<table width="90%" cellspacing="0" cellpadding="0" border="0" style="padding:10px 0 0; margin:0;">
  <tbody><tr>
    <td width="65%" valign="middle" align="right" style="float:right; padding-right:10px; padding-top:10px;">
		<div style="float:left; padding:3px 5px; color:#333; margin-left:80px; line-height: 20px;" class="count_badge">
			<*= this.views*></div>
			<div style="float:left;padding:4px 0 0 5px;"><?php echo translate('Views');?></div></td>
		<td width="25%" valign="middle" align="center"> <div class="addshortlist">
    	<* if(this.short_listed == 1) { *>
				<a href="#"><input class="accept_button" type="button" value="<?php echo translate("Saved to Wish List"); ?>" id="my_shortlist" onclick="add_shortlist(<*= this.hosting_id *>,this);"></a>
				<* } else { *>
				<a href="#"><input class="accept_button" type="button" value="<?php echo translate("Save To Wish List"); ?>" id="my_shortlist" onclick="add_shortlist(<*= this.hosting_id *>,this);"></a>
				<* } *>
				</div>
   </td>
    <td width="10%" valign="middle" align="center">
		<a class="btn green bookit_button" href="#" alt="<*=this.price*>" name="<*= this.hosting_id *>" id="book_it_button" style="display: inline-block; padding: 3px 10px; text-align: center; width: 77px; margin:0; line-height:18px;"><?php echo translate('Book it');?></a>
	</td>
  </tr>
</tbody>
</table>
         <!--  <div class="page_viewed_count"><*= this.views *></div><div class="views"> <?php echo translate("Views");?></div>
			<div class="addshortlist">
				<* if(this.short_listed == 1) { *>
				<a href="#"><input class="accept_button" type="button" value="<?php echo translate("Saved to Wish List"); ?>" id="my_shortlist" onclick="add_shortlist(<*= this.hosting_id *>,this);"></a>
				<* } else { *>
				<a href="#"><input class="accept_button" type="button" value="<?php echo translate("Save To Wish List"); ?>" id="my_shortlist" onclick="add_shortlist(<*= this.hosting_id *>,this);"></a>	
				<* } *>
			</div>-->
			<* if (this.connections.length > 0) { *>

			<div class="room-connections-wrapper">
				<span class="room-connections-arrow"></span>
				<div class="room-connections">
					<ul>
						<* for (var k = 0; k < Math.min(this.connections.length, 3); k++) { *>
						<li>
							<img height="28" width="28" alt="" src="<*= this.connections[k].pic_url_small *>" />
							<div class="room-connections-title">
								<div class="room-connections-title-outer">
									<div class="room-connections-title-inner">
										<*= this.connections[k].caption *>
									</div>
								</div>
							</div>
						</li>
						<* } *>
					</ul>
				</div>
			</div>
			<* } *>

        </li>
    ]]>
</script>
<script type="text/x-jqote-template" id="applied_filters_template">
    <![CDATA[
        <li id="applied_filter_<*= this.filter_id *>"><span class="af_text"><*= this.filter_display_name *></span><a class="filter_x_container"><span class="filter_x"></span></a></li>
    ]]>
</script>
<script type="text/x-jqote-template" id="list_view_airtv_template">
    <![CDATA[
        <div id="airtv_promo">
            <img src="/images/page2/v3/airtv_promo_pic.jpg" />
            <h2><*= this.airtv_headline *></h2>
            <h3><*= this.airtv_description *> <b><?php echo translate("Watch Now!");?></b></h3>
        </div>
    ]]>
</script>

<div style="display: none">
  <div id="filters_lightbox">
      <ul id="filters_lightbox_nav" class="Box_Head">
          <li class="filters_lightbox_nav_element" id="lightbox_nav_room_type"><a href="javascript:void(0);"><?php echo translate("Property"); ?></a></li>

          <li class="filters_lightbox_nav_element" id="lightbox_nav_amenities"><a href="javascript:void(0);"><?php echo translate("Amenities"); ?></a></li>
      </ul>

      <ul id="lightbox_filters">
          <li class="lightbox_filter_container" id="lightbox_container_room_type" style="display:none;">
              <div class="lightbox_filters_left_column">

             <h3>Room Type</h3>
                 <ul class="search_filter_content" id="lightbox_filter_content_room_type">
					<li class="clearfix">
					<input type="checkbox" value="Entire home/apt" name="room_types" id="lightbox_room_type_0"> 
					<label for="lightbox_room_type_0"><?php echo translate("Entire home/apt"); ?></label>
					</li>
					<li class="clearfix">
					<input type="checkbox" value="Private room" name="room_types" id="lightbox_room_type_1">
					<label for="lightbox_room_type_1"><?php echo translate("Private room"); ?></label>
					</li>
					<li class="clearfix">
					<input type="checkbox" value="Shared room" name="room_types" id="lightbox_room_type_2">
					<label for="lightbox_room_type_2"><?php echo translate("Shared room"); ?></label>
					</li>
				</ul>
                  <h3><?php echo translate("Size"); ?></h3>
                  <ul id="lightbox_filter_content_size" class="search_filter_content">
                      <li>
                          <label for="min_bedrooms"><?php echo translate("Min Bedrooms"); ?></label>
                          <select class="dropdown" id="min_bedrooms" name="min_bedrooms"><option value=""></option>
						<?php for($i = 1; $i <= 10; $i++) { ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?> bedroom<?php if($i > 1) echo 's'; ?></option>
							<?php } ?>
						</select>
  					</li>

                      <li>
                          <label for="min_bathrooms"><?php echo translate("Min Bathrooms"); ?></label>
                          <select class="dropdown" id="min_bathrooms" name="min_bathrooms"><option value=""></option>
								<?php for($i = 1; $i <= 10; $i++) { ?>
											<option value="<?php echo $i; ?>"><?php echo $i; ?> bathroom<?php if($i > 1) echo 's'; ?></option>
									<?php } ?>
								</select>
                      </li>
                      <li>

                          <label for="min_beds"><?php echo translate("Min Beds"); ?></label>
                          <select class="dropdown" id="min_beds" name="min_beds">
							<option value=""></option>
							<?php for($i = 1; $i <= 16; $i++) { ?>
													<option value="<?php echo $i; ?>"><?php echo $i; if($i == 16) echo '+'; ?> <?php echo translate("bed"); ?></option>
								<?php } ?>
							</select>
                      </li>
                  </ul>
              </div>
              <div class="lightbox_filters_right_column">
                  <h3><?php echo translate("Property Type"); ?></h3>
                 <ul class="search_filter_content" id="lightbox_filter_content_property_type_id">
					 <?php 
					 echo '<li class="clearfix">';
					$property = $this->db->from('property_type')->get();
					foreach($property->result() as $value) {  ?>
					<input type="checkbox" value="<?php echo $value->type;?>" name="property_type_id" id="lightbox_property_type_id_<?php echo $value->type;?>">
					<label for="lightbox_property_type_id_<?php echo $value->type;?>"><?php echo $value->type.'<br>'; ?></label>
					<?php } echo '</li>';?>
					
				</ul> 
              </div>

          </li>
          


          <li class="lightbox_filter_container" id="lightbox_container_amenities" style="display:none;">
										
												<?php 
											 	$tCount = $amnities->num_rows();
												 $j = 1; 
													echo '<ul class="search_filter_content">'; 
													foreach($amnities->result() as $rows) {  ?>
                    <li>
                   <input type="checkbox" name="amenities" id="lightbox_amenity_<?php echo $j; ?>" value="<?php echo $j; ?>">
																						<label for="lightbox_amenity_<?php echo $j; ?>"><?php echo $rows->name; ?></label>
                    </li>
													<?php $j++; }  echo '</ul>'; ?> 
										
          </li>

          <li class="lightbox_filter_container" id="lightbox_container_host" style="display:none;">
              <div class="lightbox_filters_left_column">

                  <h3><?php echo translate("Languages Spoken"); ?></h3>
                  <ul id="lightbox_filter_content_languages" class="search_filter_content"></ul>
              </div>
              <div class="lightbox_filters_right_column">

              </div>

              <ul class="search_filter_content"></ul>
          </li>


      </ul><!-- lightbox_filters -->

      <div id="lightbox_filter_action_area" class="rounded_bottom">
          <a href="javascript:void(0);" onclick="SearchFilters.closeFiltersLightbox();"><?php echo translate("Cancel"); ?></a>

          <button id="lightbox_search_button" name="Search" class="btn blue gotomsg" type="submit"><span><span><?php echo translate("Yes"); ?></span></span></button>
      </div>
  </div><!-- filters_lightbox -->
</div>
<!-- filters_lightbox -->


<script type="text/javascript">

/*if ((navigator.userAgent.indexOf('iPhone') == -1) && (navigator.userAgent.indexOf('iPod') == -1) && (navigator.userAgent.indexOf('iPad') == -1)) {
    jQuery(window).load(function() {
        LazyLoad.js([
			"<?php //echo base_url().'js' ?>/jquery.autocomplete_custom.pack.js",
			"<?php //echo base_url().'js' ?>/ en_autocomplete_data.js"],
			function() {
            	jQuery("#location").autocomplete(autocomplete_terms, {
	                minChars: 1, width: 322, max:20, matchContains: false, autoFill: true,
	                formatItem: function(row, i, max) {
	                    //to show counts, uncomment
	                    return Cogzidel.Utils.decode(row.k);
	                },
	                formatMatch: function(row, i, max) {
	                    return Cogzidel.Utils.decode(row.k);
	                },
	                formatResult: function(row) {
	                    return Cogzidel.Utils.decode(row.k);
	                }
	            });
	        }
		);
    });
}*/
    jQuery(document).ready(function(){
        Cogzidel.Bookmarks.starredIds = [];

        CogzidelSearch.$.bind('finishedrendering', function(){ 
          Cogzidel.Bookmarks.initializeStarIcons(function(e, isStarred){ 
            // hide the listing result from the set of search results when the result is unstarred
            if(!isStarred && CogzidelSearch.isViewingStarred){
              if(CogzidelSearch.currentViewType == 'list')
                $('#room_' + $(e).data('hosting_id')).slideUp(500);
              else if(CogzidelSearch.currentViewType == 'photo')
                $('#room_' + $(e).data('hosting_id')).fadeOut(500);
            }
          }) 
        });

            SearchFilters.amenities.a_11 = ["Smoking Allowed", false];
            SearchFilters.amenities.a_12 = ["Pets Allowed", false];
            SearchFilters.amenities.a_1 = ["TV", false];
            SearchFilters.amenities.a_2 = ["Cable TV", false];
            SearchFilters.amenities.a_3 = ["Internet", false];
            SearchFilters.amenities.a_4 = ["Wireless Internet", false];
            SearchFilters.amenities.a_5 = ["Air Conditioning", false];
            SearchFilters.amenities.a_30 = ["Heating", false];
            SearchFilters.amenities.a_21 = ["Elevator in Building", false];


            SearchFilters.amenities.a_6 = ["Handicap Accessible", false];
            SearchFilters.amenities.a_7 = ["Pool", false];
            SearchFilters.amenities.a_8 = ["Kitchen", false];
            SearchFilters.amenities.a_9 = ["Parking Included", false];
            SearchFilters.amenities.a_13 = ["Washer / Dryer", false];
            SearchFilters.amenities.a_14 = ["Doorman", false];
            SearchFilters.amenities.a_15 = ["Gym", false];
            SearchFilters.amenities.a_25 = ["Hot Tub", false];
            SearchFilters.amenities.a_27 = ["Indoor Fireplace", false];
            SearchFilters.amenities.a_28 = ["Buzzer/Wireless Intercom", false];
            SearchFilters.amenities.a_16 = ["Breakfast", false];
            SearchFilters.amenities.a_31 = ["Family/Kid Friendly", false];
            SearchFilters.amenities.a_32 = ["Suitable for Events", false];

        //CogzidelSearch.currencySymbolLeft = '<?php //echo get_currency_symbol(1); ?>';
        CogzidelSearch.currencySymbolRight = "";
        SearchFilters.minPrice = 10;
        SearchFilters.maxPrice = 10000;
        SearchFilters.minPriceMonthly = 150;
        SearchFilters.maxPriceMonthly = 5000;

        var options = {};

        //Some More Testing needs to be done with this logic - there are still edge cases
        //here, we add ability to hit the back button when the user goes from (page2 saved search)->page3->(browser back button)
        if(CogzidelSearch.searchHasBeenModified()){
            options = {"location":"<?php echo $query; ?>","number_of_guests":"<?php echo $number_of_guests; ?>","action":"ajax_get_results","checkin":"<?php echo $checkin; ?>","guests":"<?php echo $number_of_guests; ?>","checkout":"<?php echo $checkout; ?>","submit_location":"Search","controller":"search"};
        } else {
            options = {"location":"<?php echo $query; ?>","number_of_guests":"<?php echo $number_of_guests; ?>","action":"ajax_get_results","checkin":"<?php echo $checkin; ?>","guests":"<?php echo $number_of_guests; ?>","checkout":"<?php echo $checkout; ?>","submit_location":"Search","controller":"search"};
        }

          CogzidelSearch.isViewingStarred = false;
       

        if(options.search_view) {
            CogzidelSearch.forcedViewType = options.search_view;
        }

        //keep translations first
        Translations.clear_dates = "Clear Dates";
        Translations.entire_place = "Entire Place";
        Translations.friend = "friend";
        Translations.friends = "friends";
        Translations.loading = "Loading";
        Translations.neighborhoods = "Neighborhoods";
        Translations.private_room = "Private Room";
        Translations.review = "review";
        Translations.reviews = "reviews";
        Translations.superhost = "superhost";
        Translations.shared_room = "Shared Room";
        Translations.today = "Today";
        Translations.you_are_here = "You are Here";
        Translations.a_friend = "a friend";
        Translations.distance_away = "away";
        Translations.instant_book = "Instant Book";
        Translations.show_more = "Show More...";
        Translations.learn_more = "Learn More";
        Translations.social_connections = "Social Connections";

        //these are generally for applied filter labels
        Translations.amenities = "Amenities";
        Translations.room_type = "Room Type";
        Translations.price = "Price";
        Translations.keywords = "Keywords";
        Translations.property_type = "Property Type";
        Translations.bedrooms = "Bedrooms";
        Translations.bathrooms = "Bathrooms";
        Translations.beds = "Beds";
        Translations.languages = "Languages";
        Translations.collection = "Collection";

        //zoom in to see more properties message in map view
        Translations.redo_search_in_map_tip = "\"Redo search in map\" must be checked to see new results as you move the map";
        Translations.zoom_in_to_see_more_properties = "Zoom in to see more properties";

        //when map is zoomed in too far
        Translations.your_search_was_too_specific = "Your search was a little too specific.";
        Translations.we_suggest_unchecking_a_couple_filters = "We suggest unchecking a couple filters, zooming out, or searching for a different city.";

        //Tracking Pixel
        //run after localization
        TrackingPixel.params.uuid = "yq0m0k6hjg";
        TrackingPixel.params.user = "";
        TrackingPixel.params.af = "";
        TrackingPixel.params.c = "";
        TrackingPixel.params.pg = '2';

        CogzidelSearch.init(options);

    });
	jQuery(document).ready(function() {
		Cogzidel.init({userLoggedIn: false});
		//My Wish List Button-Add to My Wish List & Remove from My Wish List
		add_shortlist = function(item_id,that) {
		
		var value = $(that).val();
		if(value == "<?php echo translate("Save To Wish List"); ?>")	
		{
		$.ajax({
  				url: "<?php echo site_url('search/add_my_shortlist'); ?>",
  				async: true,
  				type: "POST",
  				data: "list_id="+item_id,
  				success: function(data) {
  				if(data == "error")
  				window.location.replace("<?php echo base_url(); ?>users/signin");
  				else
    			$(that).attr('value', '<?php echo translate("Saved to Wish List"); ?>'); 
  				}
   				});
   		}
   		else
   		{
   		$.ajax({
  				url: "<?php echo site_url('search/remove_my_shortlist'); ?>",
  				async: true,
  				type: "POST",
  				data: "list_id="+item_id,
  				success: function(data) {
  				if(data == "error")
  				window.location.replace("<?php echo base_url(); ?>users/signin");
  				else			
    			$(that).attr('value', '<?php echo translate("Save To Wish List"); ?>'); 
    			  				}
   				});   			
   		}			
    	};
    	//My Wish List Menu-Check whether the user is login or not 
    	view_shortlist =  function(that){
    			var value = $('#short').val();
    			if(value=="short")
    			{
    				$.ajax({
      				url: "<?php echo site_url('search/login_check'); ?>",
      				async: true,
      				success: function(data) {
      				if(data == "error")
      				window.location.replace("<?php echo base_url(); ?>users/signin");
      				else
      				{
      				$('#search_type_short').attr('id','search_type_photo');
      				$('#short').attr('value', 'photo');
      				$("#search_type_photo").trigger("click");
      				}
      				}
      				});
      			}
    	};	
    			
		});
	</script>
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	