<link href="<?php echo css_url().'/common.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo css_url().'/help.css'; ?>" media="screen" rel="stylesheet" type="text/css" />
<div class="need_top_part"> <b><?php echo translate('Help Center');?></b>
	 <a href="<?php echo base_url().'home/help/'.$page_refer ;?>"><?php echo translate('Home');?></a>
	  <a href="<?php echo base_url().'home/help/2' ;?>"><?php echo translate('Guide');?></a>
	  <a href="<?php echo base_url().'home/help/3' ;?>"><?php echo translate('Dashboard');?></a> 
	  <a href="<?php echo base_url().'home/help/7' ;?>"><?php echo translate('Account');?></a> 
      <div style="clear:both;"></div>
<!---      <div class="container">
		<div class="search_help"><input type="text" class="help_searchbox" value="Search the help center" /></div>
		<div class="search_help_dropdown">
			<ul>
            	<li><a href="#">Why was my listing deactivated?</a></li>
                <li><a href="#">Content</a></li>
                <li><a href="#">How do I edit my listing?</a></li>
                <li><a href="#">How much should I charge for my listing?</a></li>
                <li><a href="#">How do I add and reorder my listings photos?</a></li>
            </ul>
        </div>
      </div>--->
  <div class="need_top_part_b_whole">
    <div class="need_top_part_breadcrumb"><?php echo translate('Help Center');?> > <span><?php echo $page_refer;?></span> </div>
  </div>
</div>

<div class="middle_part_whole">
		<div class="middle_part_mid">
        		<div class="mid_left">
                	<ul class="need_back">
                    	<li><?php echo translate('Questions');?></li>
                    	
                     
                   <?php  
                
					  if($result->num_rows()!=0)
					  {
                       foreach($result->result() as $row)
						{
						 $stat = $row->status;
						 
						 $help_question=$row->question;
						 $help_id= $row->id;
						//if($row->page_refer != 'guide')
							//{
						 ?>
						<li><a href="<?php echo base_url().'home/help/'.$row->id; ?>" class="unselect"> <?php echo "$help_question";?> <?php //} ?></a></li>
                       
                   <?php  }                    
  						}
                  else
                   { ?>
                <li><a href="<?php echo base_url().'home/help/'.$row->id; ?>" class="unselect"> <?php echo "$question";?> </a></li>
                
                   	 <?php
                   	
				   }?>
                      
                    </ul>
                </div>
        		<div class="mid_right">
                		<h2><?php 
                		if($question)
						{
                		echo $question; 
						}
						else {
							echo translate('No Helps');
						}
                		?></h2>
                       <div class="steps"> <div class="steps_l">
               
                            <p> <?php echo $description;?> </p>

                          </div>
                       
                        <div class="clear"> <?php 
                       if(!$description)
                		{
                       
                        echo translate('No Results Found');}?>
                        </div>  
                </div>
                <div class="clear"></div>
        </div>
</div>
