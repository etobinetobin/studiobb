
    <div id="View_Pages">
      <?php
		//Show Flash Message
		if($msg = $this->session->flashdata('flash_message'))
		{
			echo $msg;
		}
	  ?>
    

      <div class="MainTop_Links clearfix">
          <div class="clsNav">
           <ul>
			<li class="clsNoBorder"><a href="<?php echo admin_url('property_type/view_property')?>"><?php echo translate_admin('Add Property type'); ?></a></li>
			
          </ul>
        </div>
		<div class="clsTitle">
          <h3><?php echo translate_admin("Manage property"); ?></h3>
										</div>
      </div>

	
	<form action="<?php echo admin_url('property_type/delete_property') ?>" name="managepage" method="post">
  <table class="table" cellpadding="2" cellspacing="0">
		 								<th></th>
											<th><?php echo translate_admin('Sl.No'); ?></th>
											<th><?php echo translate_admin('property Type'); ?></th>
											<th><?php echo translate_admin('Action'); ?></th>
        
					<?php $i=1;
						if(isset($property) and $property->num_rows()>0)
						{  
							foreach($property->result() as $property)
							{
					?>
					
			 <tr>
			  <td><input type="checkbox" class="clsNoborder" name="propertylist[]" id="propertylist[]" value="<?php echo $property->id; ?>"  /> </td>
			  <td><?php echo $i++; ?></td>
			  <td><?php echo $property->type; ?></td>	
			
			  <td><a href="<?php echo admin_url('property_type/editproperty/'.$property->id)?>">
                <img src="<?php echo base_url()?>images/edit-new.png" alt="Edit" title="Edit" /></a>
				
			 <a href="<?php echo admin_url('property_type/delete_property/'.$property->id)?>" onclick="return confirm('Are you sure want to delete??');"><img src="<?php echo base_url()?>images/Delete.png" alt="Delete" title="Delete" /></a>
			  </td>
        	</tr>
			
   <?php
				}//Foreach End
			}//If End
			else
			{
			echo '<tr><td colspan="5">'.translate_admin('No property type Found').'</td></tr>'; 
			}
		?>
		</table>
		<br />
		<p style="text-align:left">
			<?php
				$data = array(
    'name' => 'delete',
    'class' => 'Blck_Butt',
    'value' => translate_admin('Delete List'),
    );
		echo form_submit($data);?></p>
		</form> 
    </div>


