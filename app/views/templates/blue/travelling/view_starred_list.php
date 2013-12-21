<!-- Required css stylesheets -->
<link href="<?php echo css_url().'/dashboard.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<!-- End of stylesheet inclusion -->
<?php $this->load->view(THEME_FOLDER.'/includes/dash_header'); ?>

  <?php $this->load->view(THEME_FOLDER.'/includes/travelling_header'); ?>
<div id="dashboard_container">
  <div class="Box" id="View_Starred_Items">
      <div class="Box_Head msgbg">
        <h2><?php echo translate("Starred Items"); ?></h2>
      </div>
      <div class="Box_Content">
        <?php if(!empty($starred))
                           {
                                        
						   if($this->dx_auth->is_logged_in())
												{
																$id = $this->dx_auth->get_user_id();
																if($starred=='true')
															 $this->db->where('starred',$starred);
																//$this->db->or_where('user_id',$id);
																$query = $this->db->get_where('list');
																if( $query->num_rows > 0 )
																{
																		 foreach($query->result() as $row)
																			{
																							echo '<li class="listing">
																																<div class="thumbnail">';
																							
																							echo '<img alt="Host_pic" src="http://www.cogzidel.com/images/host_pic.gif" /></div>';
																							echo '<div class="listing-info"><h3>';
																																		echo anchor('rooms/'.$row->id,$row->title);
																																		echo '</h3>';
																																		echo '<span class="actions">
																																				<span class="action_button">';
																																		echo anchor('func/editListing/'.$row->id,"Edit Listing",array('class' => 'icon edit'));
																																		echo '</span>
																																				<span class="action_button">';
																																		echo anchor('rooms/'.$row->id,"View Listing",array('class' => 'icon view'));
																																		echo '</span>
																																		<span class="action_button">';
																																		echo anchor('func/deletelisting/'.$row->id,"Delete Listing",array('class' => 'icon view'));
																																		echo '</span>
																																		</div>
																															<div class="clear"></div>
																														</li>';
										}     		
							} 
							}
							}
							else
							{
		?>
        <div id="searching">
                                            <?php echo form_open("search",array('id' => 'search_form')); ?>  
                                            <p><?php echo translate("You have no starred Items."); ?> </p>
                                            <p><input value="Where are you going?" onclick="clear_location(this);" type="text" autocomplete="off" id="location" name="location" />
                                            
                                     
                                         
                                         <button id="submit_location" class="btn blue gotomsg" onclick="if (check_inputs()) {$('#search_form').submit();}return false;" type="button" name="submit_location"><span><span><?php echo translate("Search"); ?></span></span></button></p>
										 <?php echo form_close(); ?>
                            </div>
        <?php echo form_close(); ?>
        <?php } ?>
      </div>
  </div>
</div>
<!-- Footer Scripts -->
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
