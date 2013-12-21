<?php
/**
 * DROPinn Rooms Controller Class
 *
 * Its have the functionality of rooms display and edit section
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Rooms 
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rooms extends CI_Controller
{

public static $con="false";
 public function Rooms()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('cookie');
		
		$this->load->library('Form_validation');
		$this->load->library('image_lib');

		$this->load->model('Users_model'); 
		$this->load->model('Email_model');
		$this->load->model('Message_model');
		$this->load->model('Trips_model');
		$this->load->model('Rooms_model');
		$this->facebook_lib->enable_debug(TRUE);
		$this->path = realpath(APPPATH . '../images');
		$this->logo = realpath(APPPATH . '../logo');
		$this->font = realpath(APPPATH . '../core');
		}


	public function index($room_id = '')
	{
		  
	 $conditions             = array("id" => $room_id, "list.is_enable" => 1, "list.status" => 1);
	 $result                 = $this->Common_model->getTableData('list', $conditions);
	 
	 
	 				////////////////For viewing page statistics -Update///////////
	 	$today_month=date("F");
		$today_date=date("j");
		$today_year=date("Y");
		$conditions_statistics = array("list_id" => $room_id,"date"=>trim($today_date),"month"=>trim($today_month),"year"=>trim($today_year));
		$result_statistics = $this->Common_model->add_page_statistics($room_id,$conditions_statistics);
	 				//////////////////////////	
		if($result->num_rows() == 0)
		{
		  redirect('info/deny');
		}
		
		$data['list']           = $list = $result->row();
		$title                  = $list->title;
		$page_viewed            = $list->page_viewed;
			 
		$data['page_viewed'] = $this->Trips_model->update_pageViewed($room_id, $page_viewed);
						
		$id                     = $room_id;
		$checkin                = $this->session->userdata('Vcheckin');
		$checkout               = $this->session->userdata('Vcheckout');
		$data['guests']         = $this->session->userdata('Vnumber_of_guests');
	
		$ckin                   = explode('/', $checkin);
		$ckout                  = explode('/', $checkout);
		
		
		
		$xprice                 = $this->Common_model->getTableData( 'price', array('id' => $id ) )->row();
		
		$guests                 = $xprice->guests;
		
		if(isset($xprice->cleaning))
		$data['cleaning']       = $xprice->cleaning;
		else
		$data['cleaning']       = 0;
		
		if(isset($xprice->night))
		$price                  = $xprice->night;
		else
		$price                  = 0;
		
		if(isset($xprice->week))
		$Wprice                 = $xprice->week;	
		else
		$Wprice                 = 0;
		
		if(isset($xprice->month))
		$Mprice                 = $xprice->month;	
		else
		$Mprice                 = 0;
		
		//check admin premium condition and apply so for
		$query                  = $this->Common_model->getTableData( 'paymode', array('id' => 2));
		$row                    = $query->row();	

		
		if(($ckin[0] == "mm" && $ckout[0] == "mm") or ($ckin[0] == "" && $ckout[0] == ""))
		{
   $data['price']         = $price;
			
			if($Wprice == 0 && $Mprice == 0)
			{
				$data['Wprice']       = $price * 7;
				$data['Mprice']       = $price * 30;
			}
			
			else
			{
				$data['Wprice']       = $Wprice;
				$data['Mprice']       = $Mprice;
			}
			 if($row->is_premium == 1)
					{
			    if($row->is_fixed == 1)
							{
										$fix            = $row->fixed_amount; 
										$amt            = $price + $fix;
										$data['commission'] = $fix;
										$Fprice         = $amt;
							}
							else
							{  
										$per            = $row->percentage_amount; 
										$camt           = floatval(($price * $per) / 100);
										$amt            = $price + $camt;
										$data['commission'] = $camt;
										$Fprice         = $amt;
							}
						if($Wprice == 0 && $Mprice == 0)
						{
							$data['Wprice']    = $price * 7;
							//$data['Mprice']    = $Fprice * 30;
							$data['Mprice']    = $price * 30;
						}
						else
						{
							$data['Wprice']    = $Wprice;
							//$data['Mprice']    = $Fprice + $Mprice;
							$data['Mprice']       = $Mprice;
						}
		
		   }
			} 
		else
		{	
			$diff                  = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
			$days                  = ceil($diff/(3600*24));
			
			if($data['guests'] > $guests)
			{
			  $price               = ($price * $days) + ($days * $xprice->addguests);
			}
			else
			{
			  $price               = $price * $days;
			}

			//Entering it into data variables
			$data['price']         = $price;
					
			if($Wprice == 0 && $Mprice == 0)
			{
				$data['Wprice']       = $price * 7;
				$data['Mprice']       = $price * 30;
			}
			else
			{
				$data['Wprice']       = $Wprice;
				$data['Mprice']       = $Mprice;
			}
			
			$data['commission']    = 0;
			
			 if($row->is_premium == 1)
					{
			    if($row->is_fixed == 1)
							{
										$fix             = $row->fixed_amount; 
										$amt             = $price + $fix;
										$data['commission'] = $fix;
										$Fprice          = $amt;
							}
							else
							{  
										$per             = $row->percentage_amount; 
										$camt            = floatval(($price * $per) / 100);
										$amt             = $price + $camt;
										$data['commission'] = $camt;
										$Fprice          = $amt;
							}
							
						if($Wprice == 0 && $Mprice == 0)
						{
							$data['Wprice']     = $price * 7;
							//$data['Mprice']    = $Fprice * 30;
							$data['Mprice']    = $price * 30;
						}
						else
						{
							$data['Wprice']     = $Wprice;
							//$data['Mprice']     = $Fprice + $Mprice;
							$data['Mprice']       = $Mprice;
						}
		
		   }
					}
		
			$conditions              = array('list_id' => $room_id);
			$data['images']          = $this->Gallery->get_imagesG(NULL, $conditions);
			
			$data['amnities']         = $this->Rooms_model->get_amnities();
			
			$conditions    			        = array('list_id' => $room_id, 'userto' => $list->user_id);
			$data['result']			     	  = $this->Trips_model->get_review($conditions);
			
			$conditions    			     	  = array('list_id' => $room_id, 'userto' => $list->user_id);
			$data['stars']			        	= $this->Trips_model->get_review_sum($conditions)->row();
	
			$data['room_id']          = $room_id;

			$price                    = $this->Common_model->getTableData('price', array('id' => $room_id));
  			$data['prices']           = $price->row();
			 
			$data['lat']              = $list->lat;
			$data['long']			  = $list->long;
			 
			$data['title']            = substr($title, 0, 70);
			$data["meta_keyword"]     = "";
			$data["meta_description"] = "";
			$data['fb_app_id'] = $this->db->get_where('settings', array('code' => 'SITE_FB_API_ID'))->row()->string_value;
			$data['message_element']  = "rooms/view_edit_confirm";
			
			$this->load->view('template',$data);
	}
	
	
	public function newlist()
	{
		if( (!$this->dx_auth->is_logged_in()) && (!$this->facebook_lib->logged_in()) )
		{
		$this->session->set_userdata('redirect_to', 'rooms/new');
		redirect('users/signin','refresh');
		}
		
		$data["title"]            = get_meta_details('List_Your_property','title');
		$data["meta_keyword"]     = get_meta_details('List_Your_property','meta_keyword');
		$data["meta_description"] = get_meta_details('List_Your_property','meta_description');
		
		$data["message_element"]  = "rooms/view_add_list";
		$this->load->view('template',$data);
	}
	
	
public function addNewEntry()
	{
	if($this->dx_auth->is_logged_in())
	{
	 if($this->input->post())
		{
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));
		
		$this->form_validation->set_rules('Hname', 'Title', 'trim|xss_clean');
		$this->form_validation->set_rules('desc', 'description', 'trim|xss_clean');
				
		if($this->form_validation->run())
		{	
			
		$data['user_id']     = $this->dx_auth->get_user_id();
		$data['address']     = $this->input->post("formatAddress");
		
		$level = explode(',', $data['address']);
        $keys = array_keys($level);
        $country = $level[end($keys)];
        if(is_numeric($country) || ctype_alnum($country))
        $country = $level[$keys[count($keys)-1]];
        if(is_numeric($country) || ctype_alnum($country))
        $country = $level[$keys[count($keys)-1]];
        $data['country'] = trim($country);
		
		
		$data['exact']       = $this->input->post("exact_address");
		$data['lat']         = $this->input->post("lat");
		$data['long']        = $this->input->post("lng");
		$data['property_id'] = $this->input->post('property_id');
		$data['room_type']   = $this->input->post("room_type");
		$data['bedrooms']    = $this->input->post("bedrooms");
		$data['title']       = $this->input->post("Hname");
	//	$data['desc']        = nl2br($this->input->post("desc"));
	//$descr = str_replace("\n",'^nl;^',$this->input->post("desc"));
	$data['desc']        = $this->input->post("desc");
		$data['capacity']    = $this->input->post('capacity');
		$data['cancellation_policy'] = $this->input->post('cancellation_policy');
		$data['currency'] = $this->input->post('currency');
		$data['price']       = $this->input->post("native_price");
		$data['email']       = $this->input->post("email");
		$data['neighbor']       = $this->input->post("areas");
		$data['phone']       = $this->input->post("phone");
		$data['created']     = local_to_gmt();
		//Redirect to page
		$insert_id           = $this->Common_model->insertData('list', $data);

		$data2['id']         = $insert_id;
		$data2['night']      = $data['price'];
		$data2['currency']   = $data['currency'];
		$this->Common_model->insertData('price', $data2);	
	
		
		$query               = $this->Common_model->getTableData( 'paymode', array( 'id' => 1) );
		$row                 = $query->row();
		
		if($row->is_premium == 1)
		{
					if($row->is_fixed == 1)
					{
								$amount           = $row->fixed_amount;
					}
					else
					{  
								$per              = $row->percentage_amount; 
								$amount           = floatval(($data['price'] * $per) / 100);
					}
					
		$condition           = array('id' => $data2['id']);
		$data4['status']     = 0;
		$this->Common_model->updateTableData('list', NULL, $condition, $data4);
		
	 	$this->session->set_userdata('amount', $amount);
		$this->session->set_userdata('Lid', $data2['id']);
		
		redirect('listpay');
		}
		else
		{
		$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Rooms added successfully.'));
		redirect('rooms/'.$data2['id'], 'refresh');
		}
		
		} // Form Validation if
		}
		}
	}
	
	
	public function edit($param = '')
	{
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
		{
			$room_id                  = $param;
			
			if($room_id == "")
			{
			  redirect('info/deny');
			}
			
			$result                   = $this->Common_model->getTableData('list', array('id' => $room_id));
			if($result->num_rows() == 0 or $result->row()->user_id != $this->dx_auth->get_user_id())
			{
					redirect('info/deny');
			}
			
			$conditions               = array('id' => $param);
			$data['row']              = $this->Rooms_model->get_room($conditions)->row();
			
			$data['amnities']         = $this->Rooms_model->get_amnities();
			
			$data['title']            = get_meta_details('Edit_your_Listing','title');
			$data["meta_keyword"]     = get_meta_details('Edit_your_Listing','meta_keyword');
			$data["meta_description"] = get_meta_details('Edit_your_Listing','meta_description');
		
			$data['message_element']  = "rooms/view_edit_listing";
			$this->load->view('template', $data);
		}
		else
		{
			redirect('users/signin');
		}	
	}
	
	
	public function update($param = '')
	{
		if($param != '')
		{
			// Form Validation
			
			$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));
			
			$this->form_validation->set_rules('hosting_descriptions', 'Title','required|trim|xss_clean');
			$this->form_validation->set_rules('manual', 'manual','trim|xss_clean');
			$this->form_validation->set_rules('desc', 'Description','trim|xss_clean');
			$this->form_validation->set_rules('manual', 'manual','trim|xss_clean');
			$this->form_validation->set_rules('hosting_directions', 'Hosting Directions','trim|xss_clean');
			
			
			$amenity   = $this->input->post('amenities');
			$aCount    = count($amenity);
			
			$amenities = '';	
			if(is_array($amenity))
			{
				if(count($amenity) > 0)
				{
					$i = 1;
					foreach($amenity as $value)
					{
							if($i == $aCount) $comma = ''; else $comma = ',';
							
							$amenities .= $value.$comma;
							$i++;
					}
				}
			}
				//$descr = str_replace("\n",'^nl;^',$this->input->post("desc"));
				$descr = $this->input->post("desc");
			$updateData = array(
							'property_id'  	=> $this->input->post('property_id'),
							'room_type'   	=> $this->input->post('room_type'),
							'title'    		=> $this->input->post('hosting_descriptions'),
							'desc'         	=> $descr,
							'capacity'     	=> $this->input->post('capacity'),
							'cancellation_policy' => $this->input->post('cancellation_policy'),
							'bedrooms'    	=> $this->input->post('bedrooms'),
							'beds'     		=> $this->input->post('beds'),
							'bed_type'     	=> $this->input->post('hosting_bed_type'),
							'bathrooms'     => $this->input->post('hosting_bathrooms'),
							'manual'     	=> $this->input->post('manual'),
							'street_view'   => $this->input->post('street_view'),
							'directions'    => $this->input->post('hosting_directions'),
							'neighbor'		=> $this->input->post('area')
							);
																	
			if(isset($_POST['address']['formatted_address_native']))
			{												
				$address     = $_POST['address']['formatted_address_native'];
				if(!empty($address))
				{
				$address     = urlencode($address);
				$address     = str_replace('+','%20',$address); 
				$geocode     = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');
				$output      = json_decode($geocode);
				
				$updateData['address'] = $_POST['address']['formatted_address_native'];
				
				$level = explode(',', $updateData['address']);
        $keys = array_keys($level);
        $country = $level[end($keys)];
        if(is_numeric($country) || ctype_alnum($country))
        $country = $level[$keys[count($keys)-1]];
        if(is_numeric($country) || ctype_alnum($country))
        $country = $level[$keys[count($keys)-1]];
        $updateData['country'] = trim($country);
				
				
				$updateData['lat'] 				= $output->results[0]->geometry->location->lat;
				$updateData['long'] 			= $output->results[0]->geometry->location->lng;
				}
			}
																
		if($amenities != '')
		{
		$updateData['amenities'] = $amenities;
		}
																
		$updateKey = array('id' => $param);									
		$this->Rooms_model->update_list($updateKey, $updateData);
															
		echo '{"redirect_to":"'.base_url().'rooms/'.$param.'","result":"success"}';
		}
	}
	
	
	public function edit_photo($param  = '')
	{
	
		
	//	if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) || ($this->twitter->is_logged_in()))
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()))
		{
		
			$data['room_id'] = $room_id  = $param;
			
			if($room_id == "")
			{
			  redirect('info/deny');
			}
			
			$result                   = $this->Common_model->getTableData('list', array('id' => $room_id));
			if($result->num_rows() == 0 or $result->row()->user_id != $this->dx_auth->get_user_id())
			{
					redirect('info/deny');
			}
		
	 if($this->input->post())
		{
				$listId           = $param;
				$images           = $this->input->post('image');
		  $is_main          = $this->input->post('is_main');
				
				$fimages = $this->Gallery->get_imagesG($listId);
				if($is_main != '')
				{
				foreach($fimages->result() as $row)
				{
				 if($row->id == $is_main)
				   $this->Common_model->updateTableData('list_photo', $row->id, NULL, array("is_featured" => 1));
					else
					  $this->Common_model->updateTableData('list_photo', $row->id, NULL, array("is_featured" => 0));
				}
				}
				
				if(!empty($images))
				{
					foreach($images as $key=>$value)
					{
					 $image_name = $this->Gallery->get_imagesG(NULL, array('id' => $value))->row()->name;
						unlink($this->path.'/'.$listId.'/'.$image_name);
							
						$conditions = array("id" => $value);
						$this->Common_model->deleteTableData('list_photo', $conditions);
					}
				}
		
					if(isset($_FILES["userfile"]["name"]))
					{
				
			$allowed_ext = array('jpg','jpeg','png','gif');

			$insertData['list_id'] = $listId;
			
			if(!is_dir($this->path.'/'.$listId))
			{
					mkdir($this->path.'/'.$listId, 0777, true);
					$insertData['is_featured'] = 1;
			}
			
		foreach ($_FILES["userfile"]["error"] as $key => $error) {
		  if ($error == UPLOAD_ERR_OK) {
				$tmp_name = $_FILES["userfile"]["tmp_name"][$key];
				$name = md5($_FILES["userfile"]["name"][$key]);
										 
					if( move_uploaded_file($tmp_name, "images/{$listId}/{$name}")){
					///////////////////////
                         	$config['image_library'] = 'gd2';
                          	$config['source_image'] = $this->path.'/'.$listId.'/'.$name;
							$config['encrypt_name'] = TRUE;
							
                          $this->image_lib->initialize($config);
                          $this->image_lib->clear();
						 $this->load->library('upload', $config);
						 ///////////////////////////////
						$insertData['name']       =$name;
						$insertData['created']    = local_to_gmt();
						if($name != '')
						$this->Common_model->insertData('list_photo', $insertData);
						$this->watermark($listId,$name);
				 }
    		  }
		  }
			 		  
					}
					
					$rimages = $this->Gallery->get_imagesG($listId);
					$i = 1;
					$replace = '<ul class="clearfix">';
					foreach ($rimages->result() as $rimage)
					{		
					  if($rimage->is_featured == 1)
							 $checked = 'checked="checked"'; 
							else
							 $checked = ''; 
								
					    $url = base_url().'images/'.$rimage->list_id.'/'.$rimage->name;
									$replace .= '<li><p><label><input type="checkbox" name="image[]" value="'.$rimage->id.'" /></label>';
									$replace .= '<img src="'.$url.'" width="150" height="150" /><input type="radio" '.$checked.' name="is_main" value="'.$rimage->id.'" /></p></li>';
								$i++;
					}
					$replace .= '</ul>';
					
					echo $replace;
		}
		else
		{
		$data['list_images']      = $this->Gallery->get_imagesG($param);
		$data['list']             = $this->Common_model->getTableData('list', array('id' => $param))->row();
		
		$data['title']            = get_meta_details('Add_photo_for_this_listing','title');
		$data["meta_keyword"]     = get_meta_details('Add_photo_for_this_listing','meta_keyword');
		$data["meta_description"] = get_meta_details('Add_photo_for_this_listing','meta_description');
		
		$data['message_element']     = "rooms/view_edit_photo";
		$this->load->view('template',$data);
		}
		}
		else
		{
		  redirect('users/signin');
		}
		
	}

function watermark($list_id,$image_name)
	{
   $image_path =  dirname($_SERVER['SCRIPT_FILENAME']);
  
  $main_imgc		= $image_path."/images/$list_id/$image_name"; // main big photo / picture
  

// using the function to crop an image
$source_image = $main_imgc;
$target_image = $main_imgc.'_crop.jpg';

$this->resize_image($source_image, $target_image); 

$main_img = $main_imgc.'_crop.jpg';
$logo = $this->db->get_where('settings', array('code' => 'SITE_LOGO'))->row()->string_value;
$watermark_img	= $image_path."/images/$logo"; // use GIF or PNG, JPEG has no tranparency support
$padding 		= 3;     // distance to border in pixels for watermark image
$opacity		= 50;	// image opacity for transparent watermark

$watermark 	=     imagecreatefrompng($watermark_img); // create watermark
$image_water 		= imagecreatefromjpeg($main_img); // create main graphic

if(!$image_water || !$watermark) die("Error: main image or watermark could not be loaded!");


$watermark_size 	= getimagesize($watermark_img);
$watermark_width 	= $watermark_size[0];  
$watermark_height 	= $watermark_size[1];  

$image_size 	= getimagesize($main_img);  
$dest_x 		= $image_size[0] - $watermark_width - $padding;  
$dest_y 		= $image_size[1] - $watermark_height - $padding;


// copy watermark on main image
imagecopy($image_water, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);


// print image to screen
//header("content-type: image/jpeg");   
imagejpeg($image_water,$image_path.'/images/'.$list_id.'/'.$image_name.'_watermark.jpg',100);  
//imagejpeg($image_water); 
imagedestroy($image_water);  
imagedestroy($watermark); 
return true;

	 } 

	/**
 * Resize Image
 *
 * Takes the source image and resizes it to the specified width & height or proportionally if crop is off.
 * @access public
 * @author Jay Zawrotny <jayzawrotny@gmail.com>
 * @license Do whatever you want with it.
 * @param string $source_image The location to the original raw image.
 * @param string $destination_filename The location to save the new image.
 * @param int $width The desired width of the new image
 * @param int $height The desired height of the new image.
 * @param int $quality The quality of the JPG to produce 1 - 100
 * @param bool $crop Whether to crop the image or not. It always crops from the center.
 */
function resize_image($source_image, $destination_filename, $width = 400, $height = 350, $quality = 70, $crop = true)
{

        if( ! $image_data = getimagesize( $source_image ) )
        {
                return false;
        }

        switch( $image_data['mime'] )
        {
                case 'image/gif':
                        $get_func = 'imagecreatefromgif';
                        $suffix = ".gif";
                break;
                case 'image/jpeg';
                        $get_func = 'imagecreatefromjpeg';
                        $suffix = ".jpg";
                break;
                case 'image/png':
                        $get_func = 'imagecreatefrompng';
                        $suffix = ".png";
                break;
        }

        $img_original = call_user_func( $get_func, $source_image );
        $old_width = $image_data[0];
        $old_height = $image_data[1];
        $new_width = $width;
        $new_height = $height;
        $src_x = 0;
        $src_y = 0;
        $current_ratio = round( $old_width / $old_height, 2 );
        $desired_ratio_after = round( $width / $height, 2 );
        $desired_ratio_before = round( $height / $width, 2 );

        if( $old_width < $width || $old_height < $height )
        {
                /**
                 * The desired image size is bigger than the original image. 
                 * Best not to do anything at all really.
                 */
                return false;
        }


        /**
         * If the crop option is left on, it will take an image and best fit it
         * so it will always come out the exact specified size.
         */
        if( $crop )
        {
                /**
                 * create empty image of the specified size
                 */
                $new_image = imagecreatetruecolor( $width, $height );

                /**
                 * Landscape Image
                 */
                if( $current_ratio > $desired_ratio_after )
                {
                        $new_width = $old_width * $height / $old_height;
                }

                /**
                 * Nearly square ratio image.
                 */
                if( $current_ratio > $desired_ratio_before && $current_ratio < $desired_ratio_after )
                {
                        if( $old_width > $old_height )
                        {
                                $new_height = max( $width, $height );
                                $new_width = $old_width * $new_height / $old_height;
                        }
                        else
                        {
                                $new_height = $old_height * $width / $old_width;
                        }
                }

                /**
                 * Portrait sized image
                 */
                if( $current_ratio < $desired_ratio_before  )
                {
                        $new_height = $old_height * $width / $old_width;
                }

                /**
                 * Find out the ratio of the original photo to it's new, thumbnail-based size
                 * for both the width and the height. It's used to find out where to crop.
                 */
                $width_ratio = $old_width / $new_width;
                $height_ratio = $old_height / $new_height;

                /**
                 * Calculate where to crop based on the center of the image
                 */
                $src_x = floor( ( ( $new_width - $width ) / 2 ) * $width_ratio );
                $src_y = round( ( ( $new_height - $height ) / 2 ) * $height_ratio );
        }
        /**
         * Don't crop the image, just resize it proportionally
         */
        else
        {
                if( $old_width > $old_height )
                {
                        $ratio = max( $old_width, $old_height ) / max( $width, $height );
                }else{
                        $ratio = max( $old_width, $old_height ) / min( $width, $height );
                }

                $new_width = $old_width / $ratio;
                $new_height = $old_height / $ratio;

                $new_image = imagecreatetruecolor( $new_width, $new_height );
        }

        /**
         * Where all the real magic happens
         */
        imagecopyresampled( $new_image, $img_original, 0, 0, $src_x, $src_y, $new_width, $new_height, $old_width, $old_height );

        /**
         * Save it as a JPG File with our $destination_filename param.
         */
        imagejpeg( $new_image, $destination_filename, $quality  );

        /**
         * Destroy the evidence!
         */
        imagedestroy( $new_image );
        imagedestroy( $img_original );

        /**
         * Return true because it worked and we're happy. Let the dancing commence!
         */
        return true;
} 
	public function edit_price($param = '')
	{
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
		{	
		if($param == "")
		{
		redirect('info/deny');
		}
		
		$conditions             = array("id" => $param, "user_id" => $this->dx_auth->get_user_id());
	 $result                 = $this->Common_model->getTableData('list', $conditions);
		
		if($result->num_rows() == 0)
		{
		  redirect('info/deny');
		}
		
		$data['room_id']  = $param;
		
			$this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;">', '</p>');
	       $default_curr = $this->db->where('default',1)->get('currency')->row()->currency_code;
		 if($this->input->post())
			{
				$this->form_validation->set_rules('nightly','Nightly','required');
					if($this->form_validation->run())
					{	
					if($this->session->userdata('locale_currency') != '')
					{
						if($this->session->userdata('locale_currency') != $result->row()->currency)
					{
					$neight_price_data = array('amount'=>$this->input->post('nightly'),'currFrom'=>$this->session->userdata("locale_currency"),'currInto'=>$result->row()->currency);
					$neigh_price = round(google_convert($neight_price_data));
					
					$weekly_price_data = array('amount'=>$this->input->post('weekly'),'currFrom'=>$this->session->userdata("locale_currency"),'currInto'=>$result->row()->currency);
					$week_price = round(google_convert($weekly_price_data));
					
					$monthly_price_data = array('amount'=>$this->input->post('monthly'),'currFrom'=>$this->session->userdata("locale_currency"),'currInto'=>$result->row()->currency);
					$month_price = round(google_convert($monthly_price_data));
					
					$extra_price_data = array('amount'=>$this->input->post('extra'),'currFrom'=>$this->session->userdata("locale_currency"),'currInto'=>$result->row()->currency);
					$extra_price = round(google_convert($extra_price_data));
					
					$guests_price_data = array('amount'=>$this->input->post('guests'),'currFrom'=>$this->session->userdata("locale_currency"),'currInto'=>$result->row()->currency);
					$guest_price = round(google_convert($guests_price_data));
					
					$security_price_data = array('amount'=>$this->input->post('security'),'currFrom'=>$this->session->userdata("locale_currency"),'currInto'=>$result->row()->currency);
					$security_price = round(google_convert($security_price_data));
					
					$cleaning_price_data = array('amount'=>$this->input->post('cleaning'),'currFrom'=>$this->session->userdata("locale_currency"),'currInto'=>$result->row()->currency);
					$cleaning_price = round(google_convert($cleaning_price_data));
					}
					else
					{
						$neigh_price = $this->input->post('nightly');
						$week_price = $this->input->post('weekly');
						$month_price = $this->input->post('monthly');
						$extra_price = $this->input->post('extra');
						$guest_price = $this->input->post('guests');
						$security_price = $this->input->post('security');
						$cleaning_price = $this->input->post('cleaning');
					}
					}
					elseif($default_curr != $result->row()->currency)
					{
						$neight_price_data = array('amount'=>$this->input->post('nightly'),'currFrom'=>$default_curr,'currInto'=>$result->row()->currency);
						$neigh_price = round(google_convert($neight_price_data));
						
						$weekly_price_data = array('amount'=>$this->input->post('weekly'),'currFrom'=>$default_curr,'currInto'=>$result->row()->currency);
						$week_price = round(google_convert($weekly_price_data));
						
						$monthly_price_data = array('amount'=>$this->input->post('monthly'),'currFrom'=>$default_curr,'currInto'=>$result->row()->currency);
						$month_price = round(google_convert($monthly_price_data));
						
						$extra_price_data = array('amount'=>$this->input->post('extra'),'currFrom'=>$default_curr,'currInto'=>$result->row()->currency);
						$extra_price = round(google_convert($extra_price_data));
						
						$guests_price_data = array('amount'=>$this->input->post('guests'),'currFrom'=>$default_curr,'currInto'=>$result->row()->currency);
						$guest_price = round(google_convert($guests_price_data));
						
						$security_price_data = array('amount'=>$this->input->post('security'),'currFrom'=>$default_curr,'currInto'=>$result->row()->currency);
						$security_price = round(google_convert($security_price_data));
						
						$cleaning_price_data = array('amount'=>$this->input->post('cleaning'),'currFrom'=>$default_curr,'currInto'=>$result->row()->currency);
						$cleaning_price = round(google_convert($cleaning_price_data));
					}
					else
					{
						$neigh_price = $this->input->post('nightly');
						$week_price = $this->input->post('weekly');
						$month_price = $this->input->post('monthly');
						$extra_price = $this->input->post('extra');
						$guest_price = $this->input->post('guests');
						$security_price = $this->input->post('security');
						$cleaning_price = $this->input->post('cleaning');
					}
							$data = array(
							'currency' 	=> $this->input->post('currency'),
							'night' 	=> $neigh_price,
							'week' 		=> $week_price,
							'month' 	=> $month_price,
							'addguests' => $extra_price,
							'guests'    => $guest_price,
							'security' 	=> $security_price,
							'cleaning' 	=> $cleaning_price	,
							'currency'  => $this->input->post('to')
							);
				
						$list_id        = $param;
						$this->Common_model->updateTableData('price', $list_id, NULL, $data);
						
						$data1          = array();
						$data1['price'] = $neigh_price;
						$this->Common_model->updateTableData('list', $list_id, NULL, $data1);
						
						$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Price updated successfully.'));
						redirect('rooms/edit_price/'.$param);
				 }
			}
			
			$data['list']                 = $this->Common_model->getTableData('list', array('id' => $param))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $param))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			$data['message_element']      = 'rooms/view_edit_price';
			$this->load->view('template', $data);
		}
		else
		{
			redirect('users/signin');
		}
	}
	
	
		public function edit_price1($param = '')
	{
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
		{	
		if($param == "")
		{		
		redirect('info/deny');	
		}
		
		$conditions             = array("id" => $param, "user_id" => $this->dx_auth->get_user_id());
	 $result                 = $this->Common_model->getTableData('list', $conditions);
		
		if($result->num_rows() == 0)
		{
		  redirect('info/deny');
		}
		
		$data['room_id']  = $param;
		
			$this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;">', '</p>');
	
		 if($this->input->post())
			{
				$this->form_validation->set_rules('nightly','Nightly','required|is_natural_no_zero');
					if($this->form_validation->run())
					{	
							$data = array(
							'currency' 	=> $this->input->post('currency'),
							'night' 				=> $this->input->post('nightly'),
							'week' 					=> $this->input->post('weekly'),
							'month' 				=> $this->input->post('monthly'),
							'addguests' => $this->input->post('extra'),
							'guests'    => $this->input->post('guests'),
							'security' 	=> $this->input->post('security'),
							'cleaning' 	=> $this->input->post('cleaning')
							);
				
						$list_id        = $param;
						$this->Common_model->updateTableData('price', $list_id, NULL, $data);
						
						$data1          = array();
						$data1['price'] = $this->input->post('nightly');
						$this->Common_model->updateTableData('list', $list_id, NULL, $data1);
						
						$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Price updated successfully.'));
						redirect('rooms/edit_price1/'.$param);
				 }
			}
			
			$data['list']                 = $this->Common_model->getTableData('list', array('id' => $param))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $param))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			$data['message_element']      = 'rooms/view_edit_price1';
			$this->load->view('template', $data);
		}
		else
		{
			redirect('users/signin');
		}
	}
	
		public function edit_price2($param = '')
	{
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
		{	
		if($param == "")
		{
		redirect('info/deny');
		}
		
		$conditions             = array("id" => $param, "user_id" => $this->dx_auth->get_user_id());
	 $result                 = $this->Common_model->getTableData('list', $conditions);
		
		if($result->num_rows() == 0)
		{
		  redirect('info/deny');
		}
		
		$data['room_id']  = $param;
		
			$this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;">', '</p>');
	
		 if($this->input->post())
			{
				$this->form_validation->set_rules('nightly','Nightly','required|is_natural_no_zero');
					if($this->form_validation->run())
					{	
							$data = array(
							'currency' 	=> $this->input->post('currency'),
							'night' 				=> $this->input->post('nightly'),
							'week' 					=> $this->input->post('weekly'),
							'month' 				=> $this->input->post('monthly'),
							'addguests' => $this->input->post('extra'),
							'guests'    => $this->input->post('guests'),
							'security' 	=> $this->input->post('security'),
							'cleaning' 	=> $this->input->post('cleaning')
							);
				
						$list_id        = $param;
						$this->Common_model->updateTableData('price', $list_id, NULL, $data);
						
						$data1          = array();
						$data1['price'] = $this->input->post('nightly');
						$this->Common_model->updateTableData('list', $list_id, NULL, $data1);
						
						$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Price updated successfully.'));
						redirect('rooms/edit_price2/'.$param);
				 }
			}
			
			$data['list']                 = $this->Common_model->getTableData('list', array('id' => $param))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $param))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			$data['message_element']      = 'rooms/view_edit_price2';
			$this->load->view('template', $data);
		}
		else
		{
			redirect('users/signin');
		}
	}
	
	
	
	public function edit_price3($param = '')
	{
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
		{	
		if($param == "")
		{
		redirect('info/deny');
		}
		
		$conditions             = array("id" => $param, "user_id" => $this->dx_auth->get_user_id());
	 $result                 = $this->Common_model->getTableData('list', $conditions);
		
		if($result->num_rows() == 0)
		{
		  redirect('info/deny');
		}
		
		$data['room_id']  = $param;
		
			$this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;">', '</p>');
	
		 if($this->input->post())
			{
				$this->form_validation->set_rules('nightly','Nightly','required|is_natural_no_zero');
					if($this->form_validation->run())
					{	
							$data = array(
							'currency' 	=> $this->input->post('currency'),
							'night' 				=> $this->input->post('nightly'),
							'week' 					=> $this->input->post('weekly'),
							'month' 				=> $this->input->post('monthly'),
							'addguests' => $this->input->post('extra'),
							'guests'    => $this->input->post('guests'),
							'security' 	=> $this->input->post('security'),
							'cleaning' 	=> $this->input->post('cleaning')
							);
				
						$list_id        = $param;
						$this->Common_model->updateTableData('price', $list_id, NULL, $data);
						
						$data1          = array();
						$data1['price'] = $this->input->post('nightly');
						$this->Common_model->updateTableData('list', $list_id, NULL, $data1);
						
						$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Price updated successfully.'));
						redirect('rooms/edit_price3/'.$param);
				 }
			}
			
			$data['list']                 = $this->Common_model->getTableData('list', array('id' => $param))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $param))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			$data['message_element']      = 'rooms/view_edit_price3';
			$this->load->view('template', $data);
		}
		else
		{
			redirect('users/signin');
		}
	}
	
	//delete the daily price table data
	
	public function delete($param)
	{
			$id = $this->uri->segment(4);
		
			$data['room_id']  = $param;
		

	if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
{	
					
			if($param == "")
		{
		redirect('info/deny');
		}
			
	$condition = array("id" => $id);
	$this->Common_model->deleteTableData('daily_pricing', $condition);	
	
		$data['list']                 = $this->Common_model->getTableData('list', array('id' => $param))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $param))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			$data['message_element']      = 'rooms/view_edit_price1';
			$this->load->view('template', $data);
	
			
						
}
else
{
	redirect('users/signin');
}

						
}
	
	
	public function delete1($param)
	{
	
		$id = $this->uri->segment(4);
		
			$data['room_id']  = $param;
		
	if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
{	
					
			if($param == "")
		{
		redirect('info/deny');
		}
			
	$condition = array("id" => $id);
	$this->Common_model->deleteTableData('weekly_pricing', $condition);	
	
		$data['list']                 = $this->Common_model->getTableData('list', array('id' => $param))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $param))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			$data['message_element']      = 'rooms/view_edit_price2';
			$this->load->view('template', $data);
	
			
						
}
else
{
	redirect('users/signin');
}

						
}
	
	//daily price
	
	public function daily_price($param = '')
	{
	
	
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
		{	
		if($param == "")
		{
		redirect('info/deny');
		}
		
		$conditions             = array("id" => $param, "user_id" => $this->dx_auth->get_user_id());
		 $result                 = $this->Common_model->getTableData('list', $conditions);
		 	$p=0;
		
		$data['room_id']  = $param;
		$room1=$param;
		$status="Available";
		
			$this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;">', '</p>');
	
	 
			
		 if($this->input->post())
			{

$train= $this->db->query("SELECT * FROM `daily_pricing` WHERE `room_id` = '".$room1."'");

$results=$train->result_array();


 $curr_symbol=$this->session->userdata('sess_currsymbol');
 if($curr_symbol=='')
 {
 $curr_symbol="$";
 }
 

if($train->num_rows()==0)
		{			
							$data = array(
							'id' =>NULL,
							'room_id' => $param,
							'from_date' 		  => $this->input->post('from_date_show'),
							'to_date' 		  => $this->input->post('through_date_show'),
							'cost' => $this->input->post('daily_price'),
							'currency' 	=> $curr_symbol,
							'status' => $status
							);
							
							$this->Common_model->insertData('daily_pricing', $data);
							
		}
		else
		{
		
		

		$this->form_validation->set_rules('daily_price','Daily Price','required|is_natural_no_zero');
					if($this->form_validation->run())
					{	
							$data = array(
							'id' =>NULL,
							'room_id' => $param,
							'from_date' 		  => $this->input->post('from_date_show'),
							'to_date' 		  => $this->input->post('through_date_show'),
							'cost' => $this->input->post('daily_price'),
							'currency' 	=> $curr_symbol,
							'status' => $status
							);
							
						
					$this->session->set_userdata($data);
					$value = 0;
											
					foreach ($results as $arrival)
					{
					$from_date = $arrival['from_date'];
					$from_date1=strtotime($from_date);
					$to_date = $arrival['to_date'];
					$to_date1=strtotime($to_date);
					$cost = $arrival['cost'];
					
					
					
					$from=$this->input->post('from_date_show');
					$through=$this->input->post('through_date_show');

                      



//       1)	                  //from date is before db date and to_date is inbetween db dates   --done
				if(strtotime($from) <= $from_date1 && strtotime($through) < $to_date1 && strtotime($through) >= $from_date1)             
				{
				$value = 1;
				$q=1;
				$this->load->view('dailyprice_confirmation');
			
				
				}
				else
				{
				$q=0;
				}
				//	2)					//from date is inbetween two db dates and to_date is after db date.-------done
				if(strtotime($through) >= $to_date1 && strtotime($from) > $from_date1 && strtotime($from) <= $to_date1)             
				{
				$i=1; $value = 1;
		$this->load->view('dailyprice_confirmation');		
				
				}
				else
				{
				$i=0;
				}
						
//     3)					//start for gven date check in between 2 db dates --done
						if(strtotime($from)>$from_date1 && strtotime($through)<$to_date1)
						{
						$j=1; $value = 1;
						$this->load->view('dailyprice_confirmation');
						
			}
							else
							{
							$j=0;
							}
						
//      4)          //start for db dates is inbetween of two given dates--done
						if(strtotime($from) <= $from_date1 && strtotime($through) >= $to_date1)
						{	
						$p=1; $value = 1;
					$this->load->view('dailyprice_confirmation');

}
						else
						{
						$p=0;
						}
					   
//     5)		   //start for given dates front of the db dates or end of the db dates  --done
					    if((strtotime($from)<$from_date1 && strtotime($through)<$from_date1) || ( strtotime($from)>$to_date1 && strtotime($through)>$to_date1))
						{
							                                 //$list_id        = $param;
															 $k=1;
						}
						else
						{
						$k=0;
						}
						
						
}
if($k==1)
{
if ($value != 1) {
$this->Common_model->insertData('daily_pricing', $data);
}
}
}
						
				 }
			}
			
			$data['list']                 = $this->Common_model->getTableData('list', array('id' => $param))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $param))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			$data['message_element']      = 'rooms/view_edit_price1';
			$this->load->view('template', $data);
		
		}
		else
		{
			redirect('users/signin');
		}	
	}


public function dailyprice_confirm()
{

$room_id = $this->session->userdata('room_id');  
$from_date_form = $this->session->userdata('from_date');  
$to_date_form = $this->session->userdata('to_date');  
$cost = $this->session->userdata('cost');  
$currency = $this->session->userdata('currency');  
$status = $this->session->userdata('status');  

$data = array(
							'id' =>NULL,
							'room_id' => $room_id,
							'from_date' 		  => $from_date_form,
							'to_date' 		  => $to_date_form,
							'cost' => $cost,
							'currency' 	=> $currency,
							'status' => $status
							);

$train= $this->db->query("SELECT * FROM `daily_pricing` WHERE `room_id` = '".$room_id."'");

$results=$train->result_array();
foreach ($results as $arrival)
{
 $from_date = $arrival['from_date'];
 $from_date1=strtotime($from_date);
 $to_date = $arrival['to_date'];
 $to_date1=strtotime($to_date);
 $cost = $arrival['cost'];



$from=$from_date_form;
$through=$to_date_form;
			
			if(strtotime($from) <= $from_date1 && strtotime($through) < $to_date1 && strtotime($through) >= $from_date1)             
			{
			//which is big date is checking									
			
			$ghi =  $through;
			$adddate = strtotime ( '+1 day' , strtotime ( $ghi ) ) ;
			$adddate=date("m/d/Y", $adddate);
			
			$data4 = array(
			'from_date' => $adddate
			);
			
			$condition = array("from_date" => $from_date);
			
			$this->Common_model->updateTableData('daily_pricing', NULL, $condition, $data4);
			
			$q=1;
	
			}
			else
			{
			$q=0;
			}
			if(strtotime($through) >= $to_date1 && strtotime($from) > $from_date1 && strtotime($from) <= $to_date1)             
			{
			
			$ghi =  $from;
			$adddate = strtotime ( '-1 day' , strtotime ( $ghi ) ) ;
			$adddate=date("m/d/Y", $adddate);
			
			$data5 = array(
			'to_date' => $adddate
			);
			
			$condition = array("to_date" => $to_date);
			
			$this->Common_model->updateTableData('daily_pricing', NULL, $condition, $data5);
			
			$i=1;
			
			}
			else
			{
			$i=0;
			}
			
			if(strtotime($from)>$from_date1 && strtotime($through)<$to_date1)
			{
			$j=1;
			
			}
			else
			{
			$j=0;
			}
			
			if(strtotime($from) <= $from_date1 && strtotime($through) >= $to_date1)
			{	
			$condition = array("from_date" => $from_date, "to_date" => $to_date);
			$this->Common_model->deleteTableData('daily_pricing', $condition);	
			$p=1;
			
			}
			
			else
			{
			$p=0;
			}
			
			if((strtotime($from)<$from_date1 && strtotime($through)<$from_date1) || ( strtotime($from)>$to_date1 && strtotime($through)>$to_date1))
			{
			
			$k=1;
			
			}
			else
			{
			$k=0;
			}

			}
			
			if($p==1)
			{
			$this->Common_model->insertData('daily_pricing', $data);
			}
			
			if($q==1)
			{
			$this->Common_model->insertData('daily_pricing', $data);
			}
			if($k==1)
			{
			$this->Common_model->insertData('daily_pricing', $data);
			}
			if($i==1)
			{
			$this->Common_model->insertData('daily_pricing', $data);
			}
			if($j==1)
			{
			$abc =  $from_date_form;
			$newdate = strtotime ( '-1 day' , strtotime ( $abc ) ) ;
			$newdate=date("m/d/Y", $newdate);
			
			$data2 = array(
			'to_date' => $newdate
			);
			
			$condition = array("to_date" => $to_date);
			
			$this->Common_model->updateTableData('daily_pricing', NULL, $condition, $data2);
	
			$this->Common_model->insertData('daily_pricing', $data);
			
			$def=$to_date_form;
			$newdate1=strtotime ( '+1 day' , strtotime ( $def ) ) ;
			$newdate1=date("m/d/Y", $newdate1);
			
			$data3 = array(
			'id' =>NULL,
			'room_id' => $room_id ,
			'from_date' 		  => $newdate1,
			'to_date' 		  => $to_date,
			'cost' => $cost,
			'currency' 	=> $currency,
			'status' => $status
			);
			
			$this->Common_model->insertData('daily_pricing', $data3);
			
			}
			$data['list']                 = $this->Common_model->getTableData('list', array('id' => $room_id ))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $room_id ))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			redirect('rooms/edit_price1/'.$room_id);
			}

	public function weekly_price($param = '')
	{
	
	
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
		{	
		if($param == "")
		{
		redirect('info/deny');
		}
		
		$conditions             = array("id" => $param, "user_id" => $this->dx_auth->get_user_id());
		 $result                 = $this->Common_model->getTableData('list', $conditions);
		 	$p=0;

		$data['room_id']  = $param;
		$room1=$param;
		$status="Available";
		
			$this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;">', '</p>');

		 if($this->input->post())
			{

$train= $this->db->query("SELECT * FROM `weekly_pricing` WHERE `room_id` = '".$room1."'");

$results=$train->result_array();

 $curr_symbol=$this->session->userdata('sess_currsymbol');
 if($curr_symbol=='')
 {
 $curr_symbol="$";
 }
 
 
if($train->num_rows()==0)
		{			
							$data = array(
							'id' =>NULL,
							'room_id' => $param,
							'from_date' 		  => $this->input->post('from_date_show'),
							'to_date' 		  => $this->input->post('through_date_show'),
							'cost' => $this->input->post('daily_price'),
							'currency' 	=> $curr_symbol,
							'status' => $status
							);
							
							$this->Common_model->insertData('weekly_pricing', $data);
							
		}
		else
		{
		
		

		$this->form_validation->set_rules('daily_price','Daily Price','required|is_natural_no_zero');
					if($this->form_validation->run())
					{	
							$data = array(
							'id' =>NULL,
							'room_id' => $param,
							'from_date' 		  => $this->input->post('from_date_show'),
							'to_date' 		  => $this->input->post('through_date_show'),
							'cost' => $this->input->post('daily_price'),
							'currency' 	=> $curr_symbol,
							'status' => $status
							);
							
						
					$this->session->set_userdata($data);
					$value = 0;
											
					foreach ($results as $arrival)
					{
					$from_date = $arrival['from_date'];
					$from_date1=strtotime($from_date);
					$to_date = $arrival['to_date'];
					$to_date1=strtotime($to_date);
					$cost = $arrival['cost'];
					
					
					
					$from=$this->input->post('from_date_show');
					$through=$this->input->post('through_date_show');

//       1)	                  //from date is before db date and to_date is inbetween db dates   --done
				if(strtotime($from) <= $from_date1 && strtotime($through) < $to_date1 && strtotime($through) >= $from_date1)             
				{
				$q=1;
				$value =1;
				$this->load->view('weeklyprice_confirmation');
			
				
				}
				else
				{
				$q=0;
				}
				//	2)					//from date is inbetween two db dates and to_date is after db date.-------done
				if(strtotime($through) >= $to_date1 && strtotime($from) > $from_date1 && strtotime($from) <= $to_date1)             
				{
				$i=1;
				$value =1;
		$this->load->view('weeklyprice_confirmation');		
				
				}
				else
				{
				$i=0;
				}
						
//     3)					//start for gven date check in between 2 db dates --done
						if(strtotime($from)>$from_date1 && strtotime($through)<$to_date1)
						{
						$j=1; $value =1;
						$this->load->view('weeklyprice_confirmation');
						
			}
							else
							{
							$j=0;
							}
						
//      4)          //start for db dates is inbetween of two given dates--done
						if(strtotime($from) <= $from_date1 && strtotime($through) >= $to_date1)
						{	
						$p=1;
						$value =1;
					$this->load->view('weeklyprice_confirmation');

}
						else
						{
						$p=0;
						}
					   
//     5)		   //start for given dates front of the db dates or end of the db dates  --done
					    if((strtotime($from)<$from_date1 && strtotime($through)<$from_date1) || ( strtotime($from)>$to_date1 && strtotime($through)>$to_date1))
						{
							                                 //$list_id        = $param;
															 $k=1;
						}
						else
						{
						$k=0;
						}
						
						
}
if($k==1)
{

if ($value != 1) {
$this->Common_model->insertData('weekly_pricing', $data);

}
}
}
						
				 }
			}
			
			$data['list']                 = $this->Common_model->getTableData('list', array('id' => $param))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $param))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			
			
			$data['message_element']      = 'rooms/view_edit_price2';
			$this->load->view('template', $data);
		
		}
		else
		{
			redirect('users/signin');
		}	
	}
	
	public function weeklyprice_confirm ()
	{
$room_id = $this->session->userdata('room_id');  
$from_date_form = $this->session->userdata('from_date');  
$to_date_form = $this->session->userdata('to_date');  
$cost = $this->session->userdata('cost');  
$currency = $this->session->userdata('currency');  
$status = $this->session->userdata('status');  

$data = array(
							'id' =>NULL,
							'room_id' => $room_id,
							'from_date' 		  => $from_date_form,
							'to_date' 		  => $to_date_form,
							'cost' => $cost,
							'currency' 	=> $currency,
							'status' => $status
							);

$train= $this->db->query("SELECT * FROM `weekly_pricing` WHERE `room_id` = '".$room_id."'");

$results=$train->result_array();
foreach ($results as $arrival)
{
 $from_date = $arrival['from_date'];
 $from_date1=strtotime($from_date);
 $to_date = $arrival['to_date'];
 $to_date1=strtotime($to_date);
 $cost = $arrival['cost'];



$from=$from_date_form;
$through=$to_date_form;
			
			if(strtotime($from) <= $from_date1 && strtotime($through) < $to_date1 && strtotime($through) >= $from_date1)             
			{
			//which is big date is checking									
			
			$ghi =  $through;
			$adddate = strtotime ( '+1 day' , strtotime ( $ghi ) ) ;
			$adddate=date("m/d/Y", $adddate);
			
			$data4 = array(
			'from_date' => $adddate
			);
			
			$condition = array("from_date" => $from_date);
			
			$this->Common_model->updateTableData('weekly_pricing', NULL, $condition, $data4);
			
			$q=1;
			
			
			}
			else
			{
			$q=0;
			}
			if(strtotime($through) >= $to_date1 && strtotime($from) > $from_date1 && strtotime($from) <= $to_date1)             
			{
			
			$ghi =  $from;
			$adddate = strtotime ( '-1 day' , strtotime ( $ghi ) ) ;
			$adddate=date("m/d/Y", $adddate);
			
			$data5 = array(
			'to_date' => $adddate
			);
			
			$condition = array("to_date" => $to_date);
			
			$this->Common_model->updateTableData('weekly_pricing', NULL, $condition, $data5);
			
			$i=1;
			
			}
			else
			{
			$i=0;
			}
			
			if(strtotime($from)>$from_date1 && strtotime($through)<$to_date1)
			{
			$j=1;
			
			}
			else
			{
			$j=0;
			}
			
			if(strtotime($from) <= $from_date1 && strtotime($through) >= $to_date1)
			{	
			$condition = array("from_date" => $from_date, "to_date" => $to_date);
			$this->Common_model->deleteTableData('weekly_pricing', $condition);	
			$p=1;
			
			}
			
			else
			{
			$p=0;
			}
			
			if((strtotime($from)<$from_date1 && strtotime($through)<$from_date1) || ( strtotime($from)>$to_date1 && strtotime($through)>$to_date1))
			{
			
			$k=1;
			
			}
			else
			{
			$k=0;
			}
			
			}
			
			if($p==1)
			{
			$this->Common_model->insertData('weekly_pricing', $data);
			}
			
			if($q==1)
			{
			$this->Common_model->insertData('weekly_pricing', $data);
			}
			if($k==1)
			{
			$this->Common_model->insertData('weekly_pricing', $data);
			}
			if($i==1)
			{
			$this->Common_model->insertData('weekly_pricing', $data);
			}
			if($j==1)
			{
			$abc =  $from_date_form;
			$newdate = strtotime ( '-1 day' , strtotime ( $abc ) ) ;
			$newdate=date("m/d/Y", $newdate);
			
			$data2 = array(
			'to_date' => $newdate
			);
			
			$condition = array("to_date" => $to_date);
			
			$this->Common_model->updateTableData('weekly_pricing', NULL, $condition, $data2);

			$this->Common_model->insertData('weekly_pricing', $data);
			
			$def=$to_date_form;
			$newdate1=strtotime ( '+1 day' , strtotime ( $def ) ) ;
			$newdate1=date("m/d/Y", $newdate1);
			
			$data3 = array(
			'id' =>NULL,
			'room_id' => $room_id ,
			'from_date' 		  => $newdate1,
			'to_date' 		  => $to_date,
			'cost' => $cost,
			'currency' 	=> $currency,
			'status' => $status
			);
			
			$this->Common_model->insertData('weekly_pricing', $data3);
			
			}

			
			$data['list']                 = $this->Common_model->getTableData('list', array('id' => $room_id ))->row();
			$data['list_price']           = $this->Common_model->getTableData('price', array('id' => $room_id ))->row();
			
			$data['title']					           = get_meta_details('Edit_the_price_information_for_your_site','title');		
			$data["meta_keyword"]			      = get_meta_details('Edit_the_price_information_for_your_site','meta_keyword');
			$data["meta_description"]    	= get_meta_details('Edit_the_price_information_for_your_site','meta_description');			

			redirect('rooms/edit_price2/'.$room_id);
			
	
	
	}

	//Ajax Page
	public function calendar_tab_inner($param = '')
	{
	  if($param == '')
			{
			 exit('Access denied');
			}
			
			$day     = 1;
			$month   = $this->input->post('cal_month', TRUE);
			$year    = $this->input->post('cal_year', TRUE);
			
			$data['list_id']  = $param;
			$data['day']      = $day;
			$data['month']    = $month;
			$data['year']     = $year;
			
			$conditions       = array('list_id' => $param);
			$data['result']   = $this->Trips_model->get_calendar($conditions)->result();
	  $this->load->view(THEME_FOLDER.'/rooms/view_calendar_tab',$data);
	}
	
		
	public function change_status()
	{
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook_lib->logged_in()) )
		{
			$sow_hide = $this->input->get('stat'); 
			$row_id   = $this->input->get('rid');
			
			if($sow_hide == 1)
			{
			 $condition      = array("id" => $row_id);
				$data['status'] = 0;
			 $this->Common_model->updateTableData('list', NULL, $condition, $data); 
    
				$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Status change successfully.'));
				redirect('hosting');
			}
			else
			{
			 $condition            = array("id" => $row_id);
				$data['show_or_hide'] = 1;
				$this->Common_model->updateTableData('list', NULL, $condition, $data); 
				
				$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Status change successfully.'));
				redirect('hosting');
			}
			
			$data['title']               = get_meta_details('Manage_Listings','title');
			$data["meta_keyword"]        = get_meta_details('Manage_Listings','meta_keyword');
			$data["meta_description"]    = get_meta_details('Manage_Listings','meta_description');
			
			$data['message_element']     = "hosting/view_hosting";
			$this->load->view('template',$data);
			
		}
		else
		{
		redirect('users/signin');
		}
 }

	public function change_availability($param = '')
	{
	if($param != '')
	{ 
	 $is_available = $this->input->post('is_available');
	 if($is_available == 0)
		{
  	echo 	'{"result":"unavailable","message":"Your listing will be hidden from public search results.","available":false,"prompt":"Your listing can now be activated!"}';
		}
		else
		{	
   echo	'{"result":"available","message":"Your listing will now appear in public search results.","available":true,"prompt":"Your listing is active."}';
		}
	}
		
	}
	
	public function deletelisting()
	{
		if( ($this->dx_auth->is_logged_in()) || ($this->facebook->logged_in()) )
		{
		$id = $this->uri->segment(3);
		$this->db->delete('list', array('id' => $id)); 
		$this->db->delete('price', array('id' => $id)); 
		$this->db->delete('amnities', array('id' => $id)); 
		$this->db->delete('messages',array('list_id'=>$id));
		$this->db->delete('contacts',array('list_id'=>$id));
		$this->db->delete('reservation',array('list_id'=>$id));
		$this->db->delete('list_photo',array('list_id'=>$id));
		
		$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Rooms deleted successfully.'));
		redirect('hosting/','refresh');
		}
		else
		{
			redirect('home/signin');
		}
	}

	public function ajax_refresh_subtotal()
	{	
	  $id             = $this->input->get('hosting_id');
	  $this->session->unset_userdata("total_price_'".$id."'_'".$this->dx_auth->get_user_id()."'");
	  $checkin        = $this->input->get('checkin');
	  $checkout       = $this->input->get('checkout');
	  $data['guests'] = $this->input->get('number_of_guests');
	  $capacity		= $this->Common_model->getTableData( 'list', array('id' => $id ) )->row()->capacity;	
		
		$ckin           = explode('/', $checkin);
		$ckout          = explode('/', $checkout);
	
		$xprice         = $this->Common_model->getTableData( 'price', array('id' => $id ) )->row();
		
		
		$guests         = $xprice->guests;
		$per_night      = $xprice->night;
		
		if(isset($xprice->cleaning))
		$cleaning       = $xprice->cleaning;
		else
		$cleaning       = 0;
		
		if(isset($xprice->night))
		$price          = $xprice->night;
		else
		$price          = 0;
		
		if(isset($xprice->week))
		$Wprice         = $xprice->week;	
		else
		$Wprice         = 0;
		
		if(isset($xprice->month))
		$Mprice         = $xprice->month;	
		else
		$Mprice         = 0;
		
		//check admin premium condition and apply so for
		$query         = $this->Common_model->getTableData( 'paymode', array('id' => 2) );
		$row           = $query->row();	
		
		//Seasonal Price
		//1. Store all the dates between checkin and checkout in an array		
			$checkin_time		= get_gmt_time(strtotime($checkin));
			$checkout_time		= get_gmt_time(strtotime($checkout));
			$travel_dates		= array();
			$seasonal_prices 	= array();		
			$total_nights		= 1;
			$total_price		= 0;
			$is_seasonal		= 0;
			$i					= $checkin_time;
			while($i<$checkout_time)
			{
				$checkin_date					= date('m/d/Y',$i);
				$checkin_date					= explode('/', $checkin_date);
				$travel_dates[$total_nights]	= $checkin_date[1].$checkin_date[0].$checkin_date[2];
				$i								= get_gmt_time(strtotime('+1 day',$i));
				$total_nights++; 
			}
			for($i=1;$i<$total_nights;$i++)
			{
				$seasonal_prices[$travel_dates[$i]]="";
			}
		//Store seasonal price of a list in an array
		$seasonal_query	= $this->Common_model->getTableData('seasonalprice',array('list_id' => $id));
		$seasonal_result= $seasonal_query->result_array();
		if($seasonal_query->num_rows()>0)
		{
			foreach($seasonal_result as $time)
			{
			
				//Get Seasonal price
				$seasonalprice_query	= $this->Common_model->getTableData('seasonalprice',array('list_id' => $id,'start_date' => $time['start_date'],'end_date' => $time['end_date']));
				$seasonalprice 			= $seasonalprice_query->row()->price;	
				//Days between start date and end date -> seasonal price	
				$start_time	= $time['start_date'];
				$end_time	= $time['end_date'];
				$i			= $start_time;
				while($i<=$end_time)
				{	
					$start_date					= date('m/d/Y',$i);
					$s_date						= explode('/',$start_date);	
					$s_date						= $s_date[1].$s_date[0].$s_date[2];
					$seasonal_prices[$s_date]	= $seasonalprice;
					$i							= get_gmt_time(strtotime('+1 day',$i));			
				}				
				
			}
			//Total Price
			for($i=1;$i<$total_nights;$i++)
			{
				if($seasonal_prices[$travel_dates[$i]] == "")	
				{	
					$total_price=$total_price+$xprice->night;
				}
				else 
				{
					$total_price= $total_price+$seasonal_prices[$travel_dates[$i]];
					$is_seasonal= 1;
				} 		
			}
			//Additional Guests
			if($data['guests'] > $guests)
			{
			  $days = $total_nights-1;		
			  $diff_guests = $data['guests'] - $guests;
			  $total_price = $total_price + ($days * $xprice->addguests * $diff_guests);
			}
			//Cleaning
			if($cleaning != 0)
			{
				$total_price = $total_price + $cleaning;
			}
			//Admin Commission
			$data['commission'] = 0;
			if($row->is_premium == 1)
			{
			   if($row->is_fixed == 1)
				{
					$fix                = $row->fixed_amount; 
					$amt                = $total_price + $fix;
					$data['commission'] = $fix;
				}
				else
				{  
					$per                = $row->percentage_amount; 
					$camt               = floatval(($total_price * $per) / 100);
					$amt                = $total_price + $camt;
					$data['commission'] = $camt;	
				}
			}
			
		}
		if($is_seasonal==1)
		{	
			//Total days
			$days 			= $total_nights;
			//Final price	
			$data['price'] 	= $total_price;						
		}	
	else
		{		
		if(($ckin[0] == "mm" && $ckout[0] == "mm") or ($ckin[0] == "" && $ckout[0] == ""))
		{
		 	$days = 0;
			
   			$data['price']   = $price;
			
			if($Wprice == 0 && $Mprice == 0)
			{
				$data['Wprice']  = $price * 7;
				$data['Mprice']  = $price * 30;
			}
			else
			{
				$data['Wprice']  = $Wprice;
				$data['Mprice']  = $Mprice;
			}
			
			$data['commission'] = 0;
			
			 if($row->is_premium == 1)
					{
			    if($row->is_fixed == 1)
							{
										$fix                = $row->fixed_amount; 
										$amt                = $price + $fix;
										$data['commission'] = $fix;
										$Fprice             = $amt;
							}
							else
							{  
										$per                = $row->percentage_amount; 
										$camt               = floatval(($price * $per) / 100);
										$amt                = $price + $camt;
										$data['commission'] = $camt;
										$Fprice             = $amt;
							}
							
						if($Wprice == 0 && $Mprice == 0)
						{
							$data['Wprice']        = $price * 7;
							//$data['Mprice']        = $Fprice * 30;
							$data['Mprice']  = $price * 30;
						}
						else
						{
							$data['Wprice']        = $Wprice;
							//$data['Mprice']        = $Fprice + $Mprice;
							$data['Mprice']  = $Mprice;
						}
		
		   }
			} 
		else
		{	
			$diff = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
			$days = ceil($diff/(3600*24));
			
			$price = $price * $days;
			//Additional guests
			if($data['guests'] > $guests)
			{
			  	$diff_days = $data['guests'] - $guests;
			  	$price     = $price + ($days * $xprice->addguests * $diff_days);
			}
				
					
			if($Wprice == 0 && $Mprice == 0)
			{
				$data['Wprice']  = $price * 7;
				$data['Mprice']  = $price * 30;
			}
			else
			{
				$data['Wprice']  = $Wprice;
				$data['Mprice']  = $Mprice;
			}
			$data['commission'] = 0;
			
			
			if($days >= 7 && $days < 30)
			{
			 if(!empty($Wprice))
				{
				  $finalAmount     = $Wprice;
						$differNights    = $days - 7;
						$perDay          = $Wprice / 7;
						$per_night       = round($perDay, 2);
						if($differNights > 0)
						{
						  $addAmount     = $differNights * $per_night;
								$finalAmount   = $Wprice + $addAmount;
						}
						$price           = $finalAmount;
						//Additional guests
						if($data['guests'] > $guests)
						{
			  				$diff_days = $data['guests'] - $guests;
			  				$price     = $price + ($days * $xprice->addguests * $diff_days);
						}
				}
			}
			
			
			if($days >= 30)
			{
			 if(!empty($Mprice))
				{
				  $finalAmount     = $Mprice;
						$differNights    = $days - 30;
						$perDay          = $Mprice / 30;
						$per_night       = round($perDay, 2);
						if($differNights > 0)
						{
						  $addAmount     = $differNights * $per_night;
								$finalAmount   = $Mprice + $addAmount;
						}
						$price           = $finalAmount;
						//Additional guests
						if($data['guests'] > $guests)
						{
			  				$diff_days = $data['guests'] - $guests;
			  				$price     = $price + ($days * $xprice->addguests * $diff_days);
						}
				}
			}	
			
			 if($row->is_premium == 1)
					{
			    if($row->is_fixed == 1)
							{
										$fix                = $row->fixed_amount; 
										$amt                = $price + $fix;
										$data['commission'] = $fix;
										$Fprice             = $amt;
							}
							else
							{  
										$per                = $row->percentage_amount; 
										$camt               = floatval(($price * $per) / 100);
										$amt                = $price + $camt;
										$data['commission'] = $camt;
										$Fprice             = $amt;
							}
							
						if($Wprice == 0 && $Mprice == 0)
						{
							$data['Wprice']  = $price * 7;
							//$data['Mprice']  = $Fprice * 30;
							$data['Mprice']  = $price * 30;
						}
						else
						{
							$data['Wprice']  = $Wprice;
							//$data['Mprice']  = $Fprice + $Mprice;
							$data['Mprice']  = $Mprice;
						}
		
		   }
			
			
					
					$xprice         = $this->Common_model->getTableData( 'list', array('id' => $id ) )->row();
		
			
					if($cleaning != 0)
					{
					$price = $price + $cleaning;
					}	
			  			$data['price']    = $price;
					}
		}
		
			$query = $this->db->query("SELECT id,list_id FROM `calendar` WHERE `list_id` = '".$id."' AND (`booked_days` = '".get_gmt_time(strtotime($checkin))."' OR `booked_days` = '".get_gmt_time(strtotime($checkout))."') GROUP BY `list_id`");
			$rows  = $query->num_rows();
			$daysexist = $this->db->query("SELECT id,list_id,booked_days FROM `calendar` WHERE `list_id` = '".$id."' AND (`booked_days` >= '".get_gmt_time(strtotime($checkin))."' AND `booked_days` <= '".get_gmt_time(strtotime($checkout))."') GROUP BY `list_id`");
			
			$rowsexist = $daysexist->num_rows();

			if($rowsexist > 0)
			{
			  echo '{"available":false,"total_price":'.$data['price'].',"reason_message":"Those dates are not available"}';
			}
			else if ($data['guests'] > $capacity)
			{
			  echo '{"available":false,"total_price":'.$data['price'].',"reason_message":"'.$capacity.' guest(s) only allowed"}';	
			}
			else
			{
			  $this->session->set_userdata("total_price_'".$id."'_'".$this->dx_auth->get_user_id()."'",$data['price']);
			  $staggered_price = "";
					if($days >= 30)
					$staggered_price = ',"staggered_price":"'.get_currency_symbol($id).get_currency_value1($id,$data['price']).'","staggered":false';
					
			  echo '{"service_fee":"'.get_currency_symbol($id).get_currency_value1($id,$data['commission']).'","reason_message":"","price_per_night":"'.get_currency_symbol($id).get_currency_value1($id,$per_night).'","nights":'.$days.',"available":true,"can_instant_book":false,"total_price":"'.get_currency_symbol($id).get_currency_value1($id,$data['price']).'"'.$staggered_price.'}';
			}
	}
	
	public function sublet_available()
	{
	
	}
	
	public function ajax_contact()
	{
		$room_id       = $this->input->post('room_id');
		$message       = $this->input->post('message');
		
			//Send Message Notification To Host
			$insertData = array(
				'list_id'         => $room_id,
				'userby'          => $this->dx_auth->get_user_id(),
				'userto'          => get_list_by_id($room_id)->user_id,
				'message'         => $message,
				'created'         => local_to_gmt(),
				'message_type'    => 6
				);
				
			$this->Message_model->sentMessage($insertData, 1);
			
			echo 'Message send successfully';
	}
	
	public function upgrade_photo()
	{
			$this->path             = realpath(APPPATH . '../images');
			$this->gallery_path_url = base_url().'images/';
			$this->logopath         = realpath(APPPATH . '../');
			
			$result                 = $this->Common_model->getTableData('list');
			
			foreach($result->result() as $row)
			{
			 $id     = $row->id;
				if(is_dir($this->path.'/'.$id))
				{
					$files = scandir($this->path.'/'.$id);
					$files = array_diff($files, array('.','..'));
					
							$flag = 'true';
							foreach($files as $file)
							{
									if($file != 'Thumbs.db')
									{
										if($flag == 'true')
										{
										$insertData['is_featured'] = 1;
										}
										else
										{
										$insertData['is_featured'] = 0;
										}
										
										$insertData['list_id']    = $id;
										$insertData['name']       = $file;
										$insertData['created']    = local_to_gmt();
										$this->Common_model->insertData('list_photo', $insertData);
										$flag = 'false';
									}
							}
				}
			}
			
			echo "<p style='text-decoration:blink; font-size:18px; color:#339966;'> List photo's upgraded successfully. </p>";
			exit;			
	}
	



	
	public function convert()
	{
		
		 $amount = $this->input->post('amount');
		 $to = $this->input->post('to');
		 
		$id=$this->input->post('list_id');
		
		$price_table= $this->db->query("SELECT `currency` FROM `price` WHERE `id` = '".$id."'");
		$results=$price_table->result_array();
		foreach ($results as $curr)
		{
		 $currency = $curr['currency'];
		}
		$from=$currency;
		
		$ci =& get_instance();
		
		$string = "1".$from."=?".$to;
		
		$google_url = "http://www.google.com/ig/calculator?hl=en&q=".$string;
		
		$result = file_get_contents($google_url);
		
		$result = explode('"', $result);
		
		$converted_amount = explode(' ', $result[3]);
		$conversion = $converted_amount[0];
		$conversion = $conversion * $amount;
		$conversion = round($conversion, 2);
		
		$rhs_text = ucwords(str_replace($converted_amount[0],"",$result[3]));
		
		$rhs1=$conversion;
		
		
		$rhs = $conversion.$rhs_text;
		
		$google_lhs = explode(' ', $result[1]);
		$from_amount = $google_lhs[0];
		
		$from_text = ucwords(str_replace($from_amount,"",$result[1]));
		$lhs = $amount." ".$from_text;
		echo round($rhs1);
	}


	public function add_neighbor()
	{
			$id=$this->input->post('list_id');
			
			$price_table= $this->db->query("SELECT `neighbor` FROM `list` WHERE `id` = '".$id."'");
			$results=$price_table->result_array();
			foreach ($results as $neighbors)
			{
			 	$neighbor = $neighbors['neighbor'];
			}
			if($neighbor=="nothing select" || $neighbor=="No neighbor")
			{
			
				echo "please select neighbor place";
			
			}
			else
			{
				echo $neighbor;
			}
	}


	public function neighbor()
	{
		$add=$this->input->post('add');
			
		$address = explode(",", $add);
		$count=count($address);
		$add=trim($address[$count-1]);
		
		$area= $this->db->query("SELECT * FROM `neighbor_city` WHERE `state` = '".$add."' or `country` = '".$add."'");
		$results=$area->result_array();
		$xx='';

		if($area->num_rows() != 0)
		{
		
		foreach ($results as $area1)
			{
		$city_id=$area1['id'];
		
		
		
		$neighbor_area= $this->db->query("SELECT * FROM `neighbor_area` WHERE `city_id` = '".$city_id."'");
		
		
		$result=$neighbor_area->result_array();
		
		
		if($neighbor_area->num_rows() != 0)
		{
		foreach ($result as $area2)
		{
		$zz = $area2['area']; 
		$xx=$zz.','.$xx;
		}
		}
			}
		
		}
		
		echo $xx;
	}

	public function area()
	{
		$lat=$this->input->post('lat');
		$lng=$this->input->post('lng');
		
		$geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=false');
		
		$output= json_decode($geocode);

			for($j=0;$j<count($output->results[0]->address_components);$j++)
			{
			if($output->results[0]->address_components[$j]->types[0]=='locality')
			{
			$city=$output->results[0]->address_components[$j]->long_name;           
			 }
				if($output->results[0]->address_components[$j]->types[0]=='country')
			{
			$country=$output->results[0]->address_components[$j]->long_name;
						
			 }
			 
			 }
					
				
		$area= $this->db->query("SELECT * FROM `neighbor_city` WHERE `city` = '".$city."' AND `country` = '".$country."'");
		$results=$area->result_array();
		$xx='';
		
		if($area->num_rows() != 0)
		{
		
		foreach ($results as $area1)
		{
		$city_id=$area1['id'];
		}
		
		
		$neighbor_area= $this->db->query("SELECT * FROM `neighbor_area` WHERE `city_id` = '".$city_id."'");
		
		
		$result=$neighbor_area->result_array();
		
		
		if($neighbor_area->num_rows() != 0)
		{
			foreach ($result as $area2)
			{
				$zz = $area2['area']; 
				$xx=$zz.','.$xx;
			}
		}
		
		}
		
		 echo $xx;
		
		
	}

	function entity_decode($string, $quote_style = ENT_COMPAT, $charset = "UTF-8") 
	{    
			 $string = html_entity_decode($string, $quote_style, $charset);
		
			 $string = preg_replace_callback('~&#x([0-9a-fA-F]+);~i', "chr_utf8_callback", $string);
			 $string = preg_replace('~&#([0-9]+);~e', 'chr_utf8("\\1")', $string);

			 return $string; 
	}

	function get_currency()
	{
	
		 $ci =& get_instance();
		 $currency_code=$this->input->post('currency');
		 
		 $currency_symbol= $ci->Common_model->getTableData('currency', array('currency_code' => $currency_code))->row()->currency_symbol;
		 $currency_symbol1=	 html_entity_decode($currency_symbol, ENT_COMPAT, 'UTF-8');
		 return $currency_symbol1;
		 
	}
	
	public function change_currency()
	{
	 	$string_value  = $this->input->post('currency_code');
		$this->session->set_userdata('locale_currency',$string_value);
	}
	
function getDistanceBetweenPointsNew($latitude1, $longitude1,
$latitude2, $longitude2, $unit = 'Mi')
{
   $theta = $longitude1 - $longitude2;
   $distance = (sin(deg2rad($latitude1)) *
   sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) *
   cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
   $distance = acos($distance);
   $distance = rad2deg($distance);
   $distance = $distance * 60 * 1.1515;
   switch($unit)
   {
      case 'Mi': break;
      case 'Km' : $distance = $distance *1.609344;
   }
   return (round($distance,2));
}
public function fb_friends_id($room_id)
{
	$fb_app_id = $this->db->get_where('settings', array('code' => 'SITE_FB_API_ID'))->row()->string_value;
	$fb_app_secret = $this->db->get_where('settings', array('code' => 'SITE_FB_API_SECRET'))->row()->string_value;
	   $facebook = array(
            'appId'  => $fb_app_id,
            'secret' => $fb_app_secret,
            'cookie' => true
        );
        $this->load->library('facebook',$facebook);
		$user_id = $this->db->where('id',$room_id)->from('list')->get()->row()->user_id;
		$user = $this->db->where('id',$user_id)->from('users')->get()->row()->fb_id;
 // $user = '100006468578281';
 //return $user;exit;
if($user){
	try{
		//get the facebook friends list
	  $user_friends = $this->facebook->api('/'.$user.'/friends');
	  if($user_friends)
	  {
	  foreach($user_friends['data'] as $user_friend)
	{
	//echo $user_friend['id'];
	$result = $this->db->where('fb_id',$user_friend['id'])->from('users')->get();
	if($result->num_rows() != 0)
	{
		$fb_friends_id[] = $result->row()->id.',';
		//$friends = $this->db->where('fb_id',$user)->from('users')->get()->row()->friends;
		//$this->db->where('fb_id',$user)->set('friends',$friends.$result->row()->id)->update('users');
	}
    }
	if(isset($fb_friends_id))
	return $fb_friends_id;	
	else
	return false;
	}
	}
   catch(FacebookApiException $e){
		error_log($e);
		$user = NULL;
	}	
}
else {
	return false;
}

}

}	

/* End of file rooms.php */
/* Location: ./app/controllers/rooms.php */ 
?>
