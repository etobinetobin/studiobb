<?php
/**
 * DROPinn Payments Controller Class
 *
 * Helps to control payment functionality
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Profiles
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 */

class Payments extends CI_Controller {

	function Payments()
	{
		parent::__construct();
		
		$this->load->helper('url');
			
		$this->load->library('Paypal_Lib');
		$this->load->library('Twoco_Lib');
		$this->load->library('email');
		
		$this->load->model('Users_model');
		$this->load->model('Referrals_model');
		$this->load->model('Email_model');
		$this->load->model('Message_model');
		$this->load->model('Contacts_model');
		$this->load->model('Trips_model');
		$trackingId='4568246565'; 
		$this->facebook_lib->enable_debug(TRUE);
	}
	
	function index($param = '')
	{
		$this->session->set_userdata('cnumber_error','');
	$this->session->set_userdata('cname_error','');
	$this->session->set_userdata('ctype_error','');	
	$this->session->set_userdata('expire_error','');
	
	  if($param == '')
			{
			  redirect('info/deny');
			}
			
		$result                 = $this->Common_model->getTableData('list', array('id' => $param) );
		if($result->num_rows() == 0)
		{
		  redirect('info/deny');
		}
		$check = $this->db->where('id',$param)->where('user_id',$this->dx_auth->get_user_id())->get('list');
		if($check->num_rows() != 0)
		{
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error',"Host can't book their list."));
			redirect('rooms/'.$param);
		}
			if( (!$this->dx_auth->is_logged_in()) && (!$this->facebook_lib->logged_in()) )
			{
				if($this->input->get())
				{
						//contact me	
						$contact=$this->input->get('contact');	
						if($this->input->get('contact'))
						$redirect_to = 'payments/index/'.$param.'?contact='.$contact;
						else	
						$redirect_to = 'payments/index/'.$param;
						
						$newdata = array(
						        'list_id'                 => $param,
														'Lcheckin'                => $this->input->get('checkin'),
														'Lcheckout'               => $this->input->get('checkout'),
														'number_of_guests'		  => $this->input->get('guest'),
														'redirect_to'             => $redirect_to,
														'formCheckout'            => TRUE
										);
      $this->session->set_userdata($newdata);
							
					 redirect('users/signin','refresh');
			}
				else {
					$contact=$this->input->get('contact');	
						if($this->input->get('contact'))
						$redirect_to = 'payments/index/'.$param.'?contact='.$contact;
						else	
						$redirect_to = 'payments/index/'.$param;
						
						$newdata = array(
						        'list_id'                 => $param,
														'Lcheckin'                => $this->input->post('checkin'),
														'Lcheckout'               => $this->input->post('checkout'),
														'number_of_guests'		  => $this->input->post('number_of_guests'),
														'redirect_to'             => $redirect_to,
														'formCheckout'            => TRUE
										);
      $this->session->set_userdata($newdata);
							
					 redirect('users/signin','refresh');
				}
			} 
			
			/*Include Get option*/		
			
			 if($this->input->post('checkin') || $this->session->userdata('Lcheckin') || $this->input->get('checkin'))
				{
if($this->input->post('SignUp')!=NULL)
{
				//echo 'got it';
						//$this->guest_signup();
						
						
	if($this->input->post()||$this->input->get())
	{
	$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|xss_clean');
	$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|xss_clean');
	$this->form_validation->set_rules('username','Username','required|trim|xss_clean|callback__check_user_name');
	$this->form_validation->set_rules('email','Email','required|trim|valid_email|xss_clean|callback__check_user_email');
	$this->form_validation->set_rules('password','Password','required|trim|min_length[5]|max_length[16]|xss_clean|matches[confirmpassword]');
	$this->form_validation->set_rules('confirmpassword','Confirm Password','required|trim|min_length[5]|max_length[16]|xss_clean');
	
		if($this->form_validation->run())
		{	
		//Get the post values
		$first_name        = $this->input->post('first_name');
		$last_name         = $this->input->post('last_name');
		$username          = $this->input->post('username');
		$email             = $this->input->post('email');
		$password          = $this->input->post('password');
		$confirmpassword   = $this->input->post('confirmpassword');
		$newsletter   	   = $this->input->post('news_letter');
		
		$data = $this->dx_auth->register($username, $password, $email);
		
		$this->dx_auth->login($username, $password, 'TRUE');
			
		//To check user come by reference
		if($this->session->userdata('ref_id'))
		$ref_id      = $this->session->userdata('ref_id');
		else
		$ref_id      = "";
		
		if(!empty($ref_id))
		{
		$details     = $this->Referrals_model->get_user_by_refId($ref_id);
		$invite_from = $details->row()->id;
		
						$insertData                    = array();
						$insertData['invite_from']     = $invite_from;
						$insertData['invite_to']       = $this->dx_auth->get_user_id();
						$insertData['join_date']       = local_to_gmt();
						
						$this->Referrals_model->insertReferrals($insertData);
						
   			$this->session->unset_userdata('ref_id');
			}
						
			$notification                     = array();
			$notification['user_id']										= $this->dx_auth->get_user_id();
			$notification['new_review ']						= 1;
			$notification['leave_review']				 = 1;
			$this->Common_model->insertData('user_notification', $notification);
			
			//Need to add this data to user profile too 
			$add['Fname']    = $first_name;
			$add['Lname']    = $last_name;
			$add['id']       = $this->dx_auth->get_user_id();
			$add['email']    = $email;
			$this->Common_model->insertData('profiles', $add);
			//End of adding it
			 $this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Registered successfully.'));
			
		}
		}

			}
else if($this->input->post('SignIn')!=NULL)
{
	
	if($this->input->post()||$this->input->get())
		{
					if ( !$this->dx_auth->is_logged_in())
					{
						// Set form validation rules
						$this->form_validation->set_rules('username1', 'Username or Email', 'required|trim|xss_clean');
						$this->form_validation->set_rules('password1', 'password', 'required|trim|xss_clean');
					//	$this->form_validation->set_rules('remember', 'Remember me', 'integer');
						
						if($this->form_validation->run())
						{
								$username = $this->input->post("username1");
								$password = $this->input->post("password1");
								
								if ($this->dx_auth->login($username, $password, $this->form_validation->set_value('TRUE')))
								{
									// Redirect to homepage
									$newdata = array(
																					'user'      => $this->dx_auth->get_user_id(),
																					'username'  => $this->dx_auth->get_username(),
																					'logged_in' => TRUE
																				);
									$this->session->set_userdata($newdata);
									$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Logged in successfully.'));
								}
						}
									
					}							
		}
}	
		  $this->form($param);
	
				}
				else
				{
				  redirect('rooms/'.$param, "refresh");
				}

	}
	
	function contact () {
	
	if( (!$this->dx_auth->is_logged_in()) && (!$this->facebook_lib->logged_in()) )
			{
			
			$data['status'] = "error";	
			//Store the values in session to redirect this page after login
			$newdata = array(
						        
						        						'Lid'                	  => $this->input->post('id'),
														'Lcheckin'                => $this->input->post('checkin'),
														'Lcheckout'               => $this->input->post('checkout'),
														'number_of_guests'		  => $this->input->post('guests'),
														'Lmessage'                => $this->input->post('message'),
														'redirect_to'             => 'rooms/'.$this->input->post('id'),
														'formCheckout'            => TRUE
										);
      		$this->session->set_userdata($newdata);
			
			}
			else
			{
			$status=1;
			if($this->session->userdata('formCheckout'))
			{
		 		$id				= $this->session->userdata('Lid');	
		 		$checkin        = $this->session->userdata('Lcheckin');
  		 		$checkout       = $this->session->userdata('Lcheckout');
	  	 		$data['guests'] = $this->session->userdata('number_of_guests');
				$message		= $this->session->userdata('Lmessage');
			}	
			else
			{	
		    $id 			= $this->input->post('id');
			$checkin        = $this->input->post('checkin');
			$checkout       = $this->input->post('checkout');
			$data['guests'] = $this->input->post('guests');
			$message=$this->input->post('message');
			}
			//Check the rooms availability
				$checkin_time=$checkin; 
				$checkin_time=get_gmt_time(strtotime($checkin_time));
				$checkout_time=$checkout; 
				$checkout_time=get_gmt_time(strtotime($checkout_time));
				$sql="select checkin,checkout from contacts where list_id='".$id."' and status!=1";
				$query=$this->db->query($sql);
				$res=$query->result_array();
				if($query->num_rows()>0)
				{
				foreach($res as $time)
				{
					$start_date=$time['checkin'];
					$end_date=$time['checkout'];	
					$start=get_gmt_time(strtotime($start_date));
					$end=get_gmt_time(strtotime($end_date));		
					if(($checkin_time >= $start && $checkin_time <= $end) || ($checkout_time >= $start && $checkout_time <= $end))
					{
						$status=0;
					}
				}
				}
			$daysexist = $this->db->query("SELECT id,list_id,booked_days FROM `calendar` WHERE `list_id` = '".$id."' AND (`booked_days` >= '".get_gmt_time(strtotime($checkin))."' AND `booked_days` <= '".get_gmt_time(strtotime($checkout))."') GROUP BY `id`");
			$rowsexist = $daysexist->num_rows();

			if($rowsexist > 0)
			{
				$status=0;
			} 	
			if($status==0)
			{
				$data['status'] = "not_available";
			}	
			else 
			{
			$data['status'] = "success";	
			$list['list_id']=$id;
			$list['checkin']=$checkin;
			$list['checkout']=$checkout;
			$list['no_quest']=$data['guests'];
			$list['currency']=get_currency_code();
			
		//calculate price for the checkin and checkout dates
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
							$data['Mprice']        = $Fprice * 30;
						}
						else
						{
							$data['Wprice']        = $Wprice;
							$data['Mprice']        = $Fprice + $Mprice;
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
							$data['Mprice']  = $Fprice * 30;
						}
						else
						{
							$data['Wprice']  = $Wprice;
							$data['Mprice']  = $Fprice + $Mprice;
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
					
			$list['price']=$data['price'];
			$list['admin_commission']=$data['commission'];
			$list['send_date']=local_to_gmt();
			$list['status']=1;
			$query_list		= $this->Common_model->getTableData( 'list',array('id' => $id) )->row();
			$list['userto'] = $query_list->user_id;
			$list['userby'] = $this->dx_auth->get_user_id();
			$key=substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789',5)),0,9);
			$list['contact_key']=$key;
			$query_user 	= $this->Common_model->getTableData('users',array('id' => $list['userby']))->row();
			$username 		= $query_user->username;
			$this->Common_model->insertData('contacts', $list);		
			$contact_id = $this->db->insert_id();	
			$query_name  = $this->Users_model->get_user_by_id($list['userby'])->row();
			$buyer_name  = $query_name->username;
			$link = base_url().'contacts/request/'.$contact_id;
			//Send Message Notification
			$insertData = array(
				'list_id'         => $list['list_id'],
				'contact_id'  	  => $contact_id,
				'userby'          => $list['userby'],
				'userto'          => $list['userto'],
				'message'         => '<b>You have a new contact request from '.ucfirst($username).'</b><br><br>'.$message,
				'created'         => local_to_gmt(),
				'message_type'    => 7
				);
			
			$this->Message_model->sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $query_list->title, $contact_id);
			
			//Send mail to host
			$query        = $this->Common_model->getTableData( 'list',array('id' => $id) )->row();
			$host_id        = $query->user_id;
			$list_email		= $this->Common_model->getTableData('users',array('id' => $host_id))->row()->email; 
			$query2 = $this->Common_model->getTableData('users',array('id' => $this->dx_auth->get_user_id()))->row();
		  	$user_email   =	$query2->email;					
			$emailsubject = "Contact Request";
			
		$this->load->library('email');
		$config['mailtype'] = 'html';
		$config['wordwrap'] = TRUE;
		//$encrypted_user_email = $this->hide_email($user_email);
		$this->email->from($user_email, $this->dx_auth->get_site_title());
		$this->email->to($list_email);
		$this->email->subject('Contact Request');
		$message = '<table cellspacing="0" cellpadding="0" width="678" style="border:1px solid #e6e6e6; background:#fff;  font-family:Arial, Helvetica, sans-serif; -moz-border-radius: 16px; -webkit-border-radius:16px; -khtml-border-radius: 16px; border-radius: 16px; -moz-box-shadow: 0 0 4px #888888; -webkit-box-shadow:0 0 4px #888888; box-shadow:0 0 4px #888888;">
		<tr>
		<td>
		<table background="'.base_url().'images/email/head_bg.png" width="676" height="156" cellspacing="0" cellpadding="0">
		<tr>
		<td style="vertical-align:top;">
		<img src="'.base_url().'logo/logo.png" alt="'.$this->dx_auth->get_site_title().'" style=" margin:10px 0 0 20px;" />
		</td>
		<td style="text-transform:uppercase; font-weight:bold; color:#0271b8; width:290px; padding:0 10px 0 0; line-height:28px;">																																				
		</td>
		</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td style="padding:0 10px; font-size:14px;">
		
		Please click on the following link to contact the user : '.$link.'<br /><br />
				
		Room : '.$query->title.'<br /><br />
		
		Checkin Date : '.$checkin.'<br /><br />
		
		Checkout Date : '.$checkout.'<br /><br />
		
		Guests : '.$data['guests'].'<br /><br />
		
		Message       : '.$message.'<br /><br /></td>
		</tr>
		<tr>
		<td>
		<table cellpadding="0" cellspacing="0" background="'.base_url().'images/email/footer.png" width="676" height="58" style="text-align:center;">
		<tr>
		<td style="font-size:13px; padding:6px 0 0 0; color:#333333;">Copyright 2012 - 2013 <span style="color:#0271b8;">'.$this->dx_auth->get_site_title().'.</span> All Rights Reserved.</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>';
										
		$this->email->message($message);
		$this->email->set_mailtype("html");	
		$this->email->send();
			}
			}		  
			echo json_encode($data);
	}
	
	function hide_email($email) { $character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz'; $key = str_shuffle($character_set); $cipher_text = ''; $id = 'e'.rand(1,999999999); for ($i=0;$i<strlen($email);$i+=1) $cipher_text.= $key[strpos($character_set,$email[$i])]; $script = 'var a="'.$key.'";var b=a.split("").sort().join("");var c="'.$cipher_text.'";var d="";'; $script.= 'for(var e=0;e<c.length;e++)d+=b.charAt(a.indexOf(c.charAt(e)));'; $script.= 'document.getElementById("'.$id.'").innerHTML="<a href=\\"mailto:"+d+"\\">"+d+"</a>"'; $script = "eval(\"".str_replace(array("\\",'"'),array("\\\\",'\"'), $script)."\")"; $script = '<script type="text/javascript">/*<![CDATA[*/'.$script.'/*]]>*/</script>'; return '<span id="'.$id.'">[javascript protected email address]</span>'.$script; }
	
	function form($param = '')
	{
		if($this->input->get('contact'))
		{		
		 $contact_key=$this->input->get('contact');
		 $contact_result=$this->Common_model->getTableData('contacts',array('contact_key' => $contact_key))->row();
		 if($contact_result->status== 10)
		 {
		 	$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/'.$param, "refresh");	
		 }
		 $checkin        = $contact_result->checkin;
  		 $checkout       = $contact_result->checkout;
	  	 $data['guests'] = $contact_result->no_quest;
		 $data['contact_key'] = $contact_result->contact_key;
		}
		else if($this->session->userdata('formCheckout'))
		{
		 $checkin        = $this->session->userdata('Lcheckin');
  		 $checkout       = $this->session->userdata('Lcheckout');
	  	$data['guests'] = $this->session->userdata('number_of_guests');
		}
  		else if($this->input->get())
{
	$checkin         = $this->input->get('checkin');
		$checkout        = $this->input->get('checkout');
		$data['guests']  = $this->input->get('guest');
}
  else
		{
		$checkin         = $this->input->post('checkin');
		$checkout        = $this->input->post('checkout');
		$data['guests']  = $this->input->post('number_of_guests');
		}
		
		$data['checkin']  = $checkin;
		$data['checkout'] = $checkout;

		$ckin             = explode('/', $checkin);
		$ckout            = explode('/', $checkout);
		$pay              = $this->Common_model->getTableData('paywhom',array('id' => 1));
		$paywhom          = $pay->result();
		$paywhom          = $paywhom[0]->whom;
		$id               = $param;
		
		if($ckin[0]  == "mm")
		{ 
			//$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/'.$id, "refresh");
		} 
		if($ckout[0] == "mm") 
		{ 
		//	$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/'.$id, "refresh");
		}
		

        $xprice         = $this->Common_model->getTableData( 'price', array('id' => $param) )->row();
		
	     if($this->input->get())
		{
			$price = $this->input->get('subtotal');	
		}
       else {
		$price          = $xprice->night;
		}
		$placeid        = $xprice->id;
		
		$guests         = $xprice->guests;
		
	 if(isset($xprice->cleaning))
		$cleaning       = $xprice->cleaning;
		else
		$cleaning       = 0;
		
		if(isset($xprice->week))
		$Wprice         = $xprice->week;	
		else
		$Wprice         = 0;
		
		if(isset($xprice->month))
		$Mprice         = $xprice->month;	
		else
		$Mprice         = 0;
		
		
		if($paywhom)
		{
			$query        = $this->Common_model->getTableData( 'list',array('id' => $id) )->row();
			$email        = $query->email; 	
		} 
		else
		{
			$query        = $this->Common_model->getTableData( 'users',array('role_id' => 2) )->row();
			$email        = $query->email;
		}
		
		$query                = $this->Common_model->getTableData('list',array('id' => $id));
		$list                 =	$query->row();
		$data['address']      = $list->address;
		$data['room_type']    = $list->room_type;
		$data['total_guests'] = $list->capacity;
		$data['tit']          = $list->title;
		$data['manual']       = $list->manual;
		
		
		$diff                 = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
		$days                 = ceil($diff/(3600*24));
		
		/*$amt = $price * $days * $data['guests'];*/
		if($data['guests'] > $guests)
		{
				$diff_days          = $data['guests'] - $guests;
				$amt                = ($price * $days) + ($days * $xprice->addguests * $diff_days);
		}  
		else
		{
				$amt                = $price * $days;
		}

		
		//Entering it into data variables
		$data['id']           = $id;
		$data['price']        = $xprice->night;
		$data['days']         = $days;
		$data['full_cretids'] = 'off';
		
		$data['commission']   = 0;
		
			if($days >= 7 && $days < 30)
			{
			 if(!empty($Wprice))
				{
				  $finalAmount     = $Wprice;
						$differNights    = $days - 7;
						$perDay          = $Wprice / 7;
						$per_night       = $price = round($perDay, 2);
						if($differNights > 0)
						{
						  $addAmount     = $differNights * $per_night;
								$finalAmount   = $Wprice + $addAmount;
						}
						$amt             = $finalAmount;
				}
			}
			
			
			if($days >= 30)
			{
			 if(!empty($Mprice))
				{
				  $finalAmount     = $Mprice;
						$differNights    = $days - 30;
						$perDay          = $Mprice / 30;
						$per_night       = $price = round($perDay, 2);
						if($differNights > 0)
						{
						  $addAmount     = $differNights * $per_night;
								$finalAmount   = $Mprice + $addAmount;
						}
						$amt             = $finalAmount;
				}
			}	
			
		//Update the daily price
	 $data['price']        = $xprice->night;
			
	 //Cleaning fee
		if($cleaning != 0)
		{
			$amt                = $amt + $cleaning;
		}
		else
		{
			$amt                = $amt;
		}
		$session_coupon			= $this->session->userdata("coupon"); 
		if($this->input->get('contact'))
		{
		$amt=$contact_result->price;
		$this->session->set_userdata("total_price_'".$id."'_'".$this->dx_auth->get_user_id()."'",$amt);
		}
		else
		{
			//$amt=$this->session->userdata("total_price_'".$id."'_'".$this->dx_auth->get_user_id()."'");
		}
		
		//Coupon Starts
		if($this->input->post('apply_coupon'))
		{
			$is_coupon=0;
			//Get All coupons
			$query 			= $this->Common_model->get_coupon();
			$row   			=	$query->result_array();
			
			$list_id 		= $this->input->post('hosting_id');
			$coupon_code 	= $this->input->post('coupon_code');
			$user_id 		= $this->dx_auth->get_user_id();
					
			if($coupon_code != "")
			{
				$is_list_already	= $this->Common_model->getTableData('coupon_users', array( 'list_id' => $list_id,'user_id' => $user_id));
				$is_coupon_already	= $this->Common_model->getTableData('coupon_users', array( 'used_coupon_code' => $coupon_code,'user_id' => $user_id));
				//Check the list is already access with the coupon by the host or not
				if($is_list_already->num_rows() > 0)
				{
					$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! You cannot use coupons for this list'));	
					redirect('rooms/'.$list_id, "refresh");
				}
				//Check the host already used the coupon or not
				else if($is_coupon_already->num_rows() > 0)
				{
					$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Your coupon is invalid'));	
					redirect('rooms/'.$list_id, "refresh");
				}
				else 
				{
				//Coupon Discount calculation	
				foreach($row as $code)
				{
					if($coupon_code == $code['couponcode'])
					{
						//Currecy coversion
						$is_coupon			= 1;
						$current_currency	= get_currency_code();
						$coupon_currency	= $code['currency'];
						if($current_currency == $coupon_currency) 
						$Coupon_amt = $code['coupon_price'];
						else
						$Coupon_amt = get_currency_value_coupon($code['coupon_price'],$coupon_currency); 
					}
				}
				if($is_coupon == 1)
				{
					if($Coupon_amt == 0)
					{
						$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! There is no money in your coupon.'));	
					  	redirect('rooms/'.$list_id, "refresh");				
					}
					else
					{
						//Get the result amount & store the coupon informations		
						$amt 				= $amt - $Coupon_amt;
						$insertData         = array(
						'list_id'			=> $list_id,
						'used_coupon_code'  => $coupon_code,
						'user_id'			=> $user_id,
						'status'			=> 0 
						);
						$this->Common_model->inserTableData('coupon_users',$insertData);
						$this->session->set_userdata("total_price_'".$list_id."'_'".$user_id."'",$amt);
					}
				}
				else 
				{
					  $this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Your coupon does not match.'));	
					  redirect('rooms/'.$list_id, "refresh");
				}
				
				}	
			}
			else 
			{
					$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Your coupon does not match.'));	
					redirect('rooms/'.$list_id, "refresh");
			}
		}
		//Coupon Ends
		
		
		
		$data['subtotal']    = $amt;
		
		//if($this->session->userdata("total_price_'".$id."'_'".$this->dx_auth->get_user_id()."'") == "")
		//{ echo 'total';exit;
			//redirect('rooms/'.$param, "refresh");
		//	$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Please! Try Again'));
		//}
		//check admin premium condition and apply so for
		$query                = $this->Common_model->getTableData('paymode', array( 'id' => 2));
		$row                  = $query->row();
		if($row->is_premium == 1)
		{
		  if($row->is_fixed == 1)
				{
				   $fix                = $row->fixed_amount; 
				   $amt                = $amt + $fix;
							$data['commission'] = $fix;
				}
				else
				{  
				   $per                = $row->percentage_amount; 
				   $camt               = floatval(($amt * $per) / 100);
							$amt                = $amt + $camt;
							$data['commission'] = $camt;
				}
		}
		else
		{
		$amt  = $amt;
		}
				
		// Coupon Code Starts
		//print_r($amt);exit;
		if($amt > 110)
		{
		if($this->db->select('referral_amount')->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_amount !=0 )
		{
		   $data['amt']    = $amt;
		   $data['referral_amount'] = $this->db->select('referral_amount')->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_amount;
		 }
        else
	    {
		 $data['amt'] = $amt;
	    }
		}
		else {
			$data['amt'] = $amt;
		}
		//echo $data['amt'];exit;
		if($amt < 10)
		{
						$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Your payment should be greater than 10.'));	
						redirect('rooms/'.$id, "refresh");
		}
		
		$data['result']    = $this->Common_model->getTableData('payments')->result();
		
		$array_items = array(
							'list_id'           => '',
							'Lcheckin'          => '',
							'Lcheckout'         => '',
							'number_of_guests'	=> '',
							'formCheckout'      => ''
							);
  		$this->session->unset_userdata($array_items);
		
		    //$id = $list_id;
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
				{	$xprice         = $this->Common_model->getTableData( 'price', array('id' => $id ) )->row();
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
			//$data['commission'] = 0;			
		}
		if($is_seasonal==1)
		{	
			//Total days
			$days 			= $total_nights;
			//Final price	
			$data['subtotal'] 	= $total_price;	
			$data['avg_price'] = $total_price/($days-1);
			//echo $data['avg_price'];exit;
			$amt = $data['subtotal'];
			
			$query                = $this->Common_model->getTableData('paymode', array( 'id' => 2));
		$row                  = $query->row();
		if($row->is_premium == 1)
		{
		  if($row->is_fixed == 1)
				{
				   $fix                = $row->fixed_amount; 
				   $amt                = $amt + $fix;
							$data['commission'] = $fix;
				}
				else
				{  
				   $per                = $row->percentage_amount; 
				   $camt               = floatval(($amt * $per) / 100);
							$amt                = $amt + $camt;
							$data['commission'] = $camt;
				}
		}
		else
		{
		$amt  = $amt;
		}
				$data['amt'] = $amt;
				$this->session->set_userdata('topay',$amt);
		}
		 
		//echo $data['price'];exit;
			
  		$data['countries']			  = $this->Common_model->getCountries()->result();
		$data['title']                = get_meta_details('Confirm_your_booking','title');
		$data["meta_keyword"]         = get_meta_details('Confirm_your_booking','meta_keyword');
		$data["meta_description"]     = get_meta_details('Confirm_your_booking','meta_description');
		
		$data['message_element']      = "payments/view_booking";
		$this->load->view('template',$data);
	}
	
	
	public function payment($param = "")
	{

			if($this->input->post('agrees_to_terms') != 'on')
			{
					$newdata = array(
										'list_id'                 => $param,
										'Lcheckin'                => $this->input->post('checkin'),
										'Lcheckout'               => $this->input->post('checkout'),
										'number_of_guests'					   => $this->input->post('number_of_guests'),
										'formCheckout'            => TRUE
						);
					$this->session->set_userdata($newdata);
					$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','You must agree to the Cancellation Policy and House Rules!'));	
		  	redirect('payments/index/'.$param,'refresh');
			}
			 
			$contact_key=$this->input->post('contact_key');
			$updateKey      		  = array('contact_key' => $contact_key);
			$updateData               = array();
			$updateData['status']    = 10;
			$this->Contacts_model->update_contact($updateKey,$updateData);
			
		/*	if($this->session->userdata("total_price_'".$param."'_'".$this->dx_auth->get_user_id()."'") == "")
			{
				redirect('rooms/'.$param, "refresh");
				$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Please! Try Again'));
		
             }*/
	  if($this->input->post('payment_method') == 'cc')
			{
			   $this->submissionCC($param);
			}
			else if($this->input->post('payment_method') == 'paypal')
			{
			  
			   $this->submission($param,$contact_key);
			
			}
			else if($this->input->post('payment_method') == '2c')
			{
						$this->submissionTwoc($param);	
			}
			else
			{
			   redirect('info');	
			}
	
	}
	
	
	public function submissionCC($param)
	{
	 $this->load->helper('CallerService');
	
		$checkin          = $this->input->post('checkin');
		$checkout         = $this->input->post('checkout');
		$number_of_guests = $this->input->post('number_of_guests');
		
		$firstName  						=	urlencode( $this->input->post('firstName') );
		$lastName 								=	urlencode( $this->input->post('lastName') );
		$creditCardType 		=	urlencode( $this->input->post('creditCardType') );
		$creditCardNumber = urlencode( $this->input->post('creditCardNumber') );
		$expDateMonth 				=	urlencode( $this->input->post('expDateMonth') );
		
		// Month must be padded with leading zero
		$padDateMonth 				= str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
		
		$expDateYear 					=	urlencode( $this->input->post('expDateYear') );
		$cvv2Number 						= urlencode( $this->input->post('cvv2Number') );
		$address1 								= urlencode( $this->input->post('address1') );
		$address2 								= urlencode( $this->input->post('address2') );
		$city 												= urlencode( $this->input->post('city') );
		$state 											=	urlencode( $this->input->post('state') );
		$country 									=	urlencode( $this->input->post('country') );
		$zip 													= urlencode( $this->input->post('zip') );
		$currencyCode 				= get_currency_code();
		$paymentType						=	urlencode('Sale');
		
		$ckin             = explode('/', $checkin);
		$ckout            = explode('/', $checkout);
		$pay              = $this->Common_model->getTableData('paywhom',array('id' => 1));
		$paywhom          = $pay->result();
		$paywhom          = $paywhom[0]->whom;
		$id               = $param;
		
		if($creditCardType == "" || $creditCardNumber == "")
		{
		$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
		redirect('rooms/'.$id, "refresh");
		}
		
		if($ckin[0] == "mm")
		{
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/'.$id, "refresh");
		} 
		if($ckout[0] == "mm") 
		{
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/'.$id, "refresh");
		}
		
		$xprice      = $this->Common_model->getTableData('price',array('id' => $this->uri->segment(3)))->row();
		$price       = $xprice->night;
		$placeid     = $xprice->id;
		
		$guests      = $xprice->guests;
		
		if(isset($xprice->cleaning))
		$cleaning    = $xprice->cleaning;
		else
		$cleaning    = 0;
		
		if(isset($xprice->week))
		$Wprice         = $xprice->week;	
		else
		$Wprice         = 0;
		
		if(isset($xprice->month))
		$Mprice         = $xprice->month;	
		else
		$Mprice         = 0;

		if($paywhom)
		{
			$query        = $this->Common_model->getTableData( 'list',array('id' => $id) )->row();
			$email        = $query->email; 	
		} 
		else
		{
			$query        = $this->Common_model->getTableData( 'users',array('role_id' => 2) )->row();
			$email        = $query->email;
		}
		
		$query         = $this->Common_model->getTableData('list',array('id' => $id));
		$q             =	$query->result();

		$diff          = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
		$days          = ceil($diff/(3600*24));
		
		$user_travel_cretids     = 0;
		if($this->session->userdata('travel_cretids'))
		{
		   $amt                  = $this->session->userdata('travel_cretids');
					$user_travel_cretids  = $this->session->userdata('user_travel_cretids');
					$is_travelCretids     = md5('Yes Travel Cretids');
		}
		else
		{
					if($number_of_guests  > $guests)
					{
							$diff_days = $number_of_guests  - $guests;
							$amt       = ($price * $days) + ($days * $xprice->addguests * $diff_days);
					}
					else
					{
							$amt       = $price * $days;
					}
					
					
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
							$amt             = $finalAmount;
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
							$amt             = $finalAmount;
					}
				}	
				
			//Cleaning fee
			if($cleaning != 0)
			{
				$amt                = $amt + $cleaning;
			}
			else
			{
				$amt                = $amt;
			}					
					
					$to_pay            = 0;
					$admin_commission  = 0;
					//Amount from session 
					$amt=$this->session->userdata("total_price_'".$id."'_'".$this->dx_auth->get_user_id()."'");
					//commission calculation
					$query       = $this->Common_model->getTableData('paymode', array( 'id' => 2));
					$row         = $query->row();
					if($row->is_premium == 1)
					{
							if($row->is_fixed == 1)
							{
							   $to_pay           = $amt;
										$fix              = $row->fixed_amount; 
										$amt              = $amt + $fix;
										$admin_commission = $fix;
							}
							else
							{  
							   $to_pay           = $amt;
										$per              = $row->percentage_amount; 
										$camt             = floatval(($amt * $per) / 100);
										$amt              = $amt + $camt;
										$admin_commission = $camt;
							}
					}
					else
					{
					//$amt = $this->session->userdata('topay');
					$to_pay                = $amt;
					}
					
					$is_travelCretids = md5('No Travel Cretids');
		}
	$nvpstr			=	"&PAYMENTACTION=$paymentType&AMT=$amt&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyCode";
	
	$resArray	=	hash_call("doDirectPayment",$nvpstr);

	$ack 					= strtoupper($resArray["ACK"]);
	
	if($ack	!=	"SUCCESS")
	{
		$_SESSION['reshash']						=	$resArray;
		$data['title']            = 'The card has returned an error';
		$data["meta_keyword"]     = '';
		$data["meta_description"] = '';
		
		$data['message_element']  = "payments/view_ccerror";
		$this->load->view('template', $data);
	}
	else
	{
		$list['list_id']       				= $id;
		$list['userby']        				= $this->dx_auth->get_user_id();
		
		$query1      														= $this->Common_model->getTableData('list', array('id' => $list['list_id']));
		$buyer_id    														= $query1->row()->user_id;
		
		$list['userto']            = $buyer_id;
		$list['checkin']           = get_gmt_time(strtotime($checkin));
		$list['checkout']          = get_gmt_time(strtotime($checkout));
		$list['no_quest']          = $number_of_guests;
		$list['price']             = $amt;
		$list['currency']          = get_currency_code();
		
		$list['credit_type']       = 1;
		$list['payment_id']        = 1;
		$list['transaction_id']    = $resArray["CORRELATIONID"];
		
		$list['topay']             = $to_pay;
		$list['admin_commission']  = $admin_commission;
		//mail('rameshr@cogzidel.com','Test-done',$list['from'].'Coming3'.$list['to'].'vvv'.$data[2].'bbb'.$data[3]);
		

		$list['status'] = 1;

			if($list['price'] > 75)
			{
			$user_id = $list['userby'];
			$details = $this->Referrals_model->get_details_by_Iid($user_id);
			$row     = $details->row();
			$count   = $details->num_rows();
			if($count > 0)
			{
									$details1 = $this->Referrals_model->get_details_refamount($row->invite_from);
									if($details1->num_rows() == 0)
									{ 						
									$insertData                  = array();
									$insertData['user_id']       = $row->invite_from;
									$insertData['count_trip']    = 1;
									$insertData['amount']        = 25;
									$this->Referrals_model->insertReferralsAmount($insertData);
									}
									else
									{
									$count_trip                  = $details1->row()->count_trip;
									$amount                      = $details1->row()->amount;
									$updateKey                   = array('id' => $row->id);
									$updateData                  = array();
									$updateData['count_trip']    = $count_trip + 1;
									$updateData['amount']        = $amount + 25;
									$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
									}
				}
			}
			
			$q        =	$query1->result();
			$row_list = $query1->row();
		    $iUser_id = $q[0]->user_id;
			$details2 = $this->Referrals_model->get_details_by_Iid($iUser_id);
			$row      = $details2->row();
			$count    = $details2->num_rows();
				if($count > 0)
				{
				 $details3 = $this->Referrals_model->get_details_refamount($row->invite_from);
									if($details3->num_rows() == 0)
									{ 							
									$insertData                  = array();
									$insertData['user_id']       = $row->invite_from;
									$insertData['count_book']    = 1;
									$insertData['amount']        = 75;
									$this->Referrals_model->insertReferralsAmount($insertData);
									}
									else
									{
									$count_book   = $details3->row()->count_book;
									$amount       = $details3->row()->amount;
									$updateKey                   = array('id' => $row->id);
									$updateData                  = array();
									$updateData['count_trip']    = $count_book + 1;
									$updateData['amount']        = $amount + 75;
									$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
									}
				}
				
			$admin_email = $this->dx_auth->get_site_sadmin();
			$admin_name  = $this->dx_auth->get_site_title();
			
			$query3      = $this->Common_model->getTableData('users',array('id' => $list['userby']));
			$rows        =	$query3->row();
				
			$username    = $rows->username;
			$user_id     = $rows->id;
			$email_id    = $rows->email;
			
			$query4      = $this->Users_model->get_user_by_id($buyer_id);
			$buyer_name  = $query4->row()->username;
			$buyer_email = $query4->row()->email;
			
			//Check md5('No Travel Cretids') || md5('Yes Travel Cretids')
			if($is_travelCretids == '7c4f08a53f4454ea2a9fdd94ad0c2eeb')
			{			
					  	$query5      = $this->Referrals_model->get_details_refamount($user_id);
		     	$amount      = $query5->row()->amount;			
																
								$updateKey                   = array('user_id ' => $user_id);
								$updateData                  = array();
								$updateData['amount']        = $amount -	$user_travel_cretids;
								$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
								
								$list['credit_type']         = 2;
								$list['ref_amount']          = $user_travel_cretids;

							
							$row = $query4->row();
							
								//sent mail to administrator
							$email_name = 'tc_book_to_admin';
							$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $user_travel_cretids+$list['price'], "{payed_amount}" => $list['price'],"{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
							//Send Mail
							$this->Email_model->sendMail($admin_email,$email_id,ucfirst($username),$email_name,$splVars);
							

								//sent mail to buyer
							$email_name = 'tc_book_to_host';
							$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $list['price']);
							//Send Mail
							$this->Email_model->sendMail($buyer_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);

			}
			
		 $list['book_date']           = local_to_gmt();
					
			//Actual insertion into the database
			$this->Common_model->insertData('reservation', $list);		
			$reservation_id = $this->db->insert_id();
			
			//Send Message Notification
			$insertData = array(
				'list_id'         => $list['list_id'],
				'reservation_id'  => $reservation_id,
				'userby'          => $list['userby'],
				'userto'          => $list['userto'],
				'message'         => 'You have a new reservation request from '.ucfirst($username),
				'created'         => local_to_gmt(),
				'message_type'    => 1
				);
			$this->Message_model->sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list->title, $reservation_id);
			$message_id     = $this->db->insert_id();
			
			$actionurl = site_url('trips/request/'.$message_id);
				
   //Reservation Notification To Host
			$email_name = 'host_reservation_notification';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $list['price'], "{action_url}" => $actionurl);
			//Send Mail
			$this->Email_model->sendMail($buyer_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			
		 //Reservation Notification To Traveller
			$email_name = 'traveller_reservation_notification';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username));
			//Send Mail
			$this->Email_model->sendMail($email_id,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			
				//Reservation Notification To Administrator
				$email_name = 'admin_reservation_notification';
				$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $user_travel_cretids+$list['price'], "{payed_amount}" => $list['price'],"{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
				//Send Mail
				$this->Email_model->sendMail($admin_email,$email_id,ucfirst($username),$email_name,$splVars);
				
				$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Your payment completed successfully.'));
				redirect('rooms/'.$id, "refresh");
	}
		
	}
	
	
	function submission_paypaladaptive($param = "")
	{
	//var_dump($param);  exit;
	
	 	require_once ("paypalplatform.php"); 
		
		$host=$this->Users_model->hostmail($param);
		$data['checkin']      = $this->input->post('checkin');
		$data['checkout']     = $this->input->post('checkout');
		$data['subtotal']     = $this->input->post('subtotal');
		$data['commission']   = $this->input->post('commission');
		$data['roomtotal']    = $this->input->post('roomtotal');
		$data['number_of_guests'] = $this->input->post('number_of_guests');
		$data['payment_method'] =   $this->input->post('payment_method');
		$data['id']             =  $param;
		$data['hostuserid']     = $host['hostuserid'];
		$data['userid'] = $this->dx_auth->get_user_id();
		
		 $roomtotal = $this->input->post('roomtotal');
		$admincommission = $this->input->post('commission');
		$adminpaypal     = $this->Common_model->getTableData('payment_details', array('code' => 'PAYPAL_ID'))->row();
		$adminpaypalmail=$adminpaypal->value;

		$hostmailid=$host['email'];

		 $paytoadmin=$admincommission; 
		$actionType            = "PAY"; 
		

		$cancelUrl            = site_url('payments/paypal_cancel');    // TODO - If you are not executing the Pay call for a preapproval, 
														//        then you must set a valid cancelUrl for the web approval flow 
														//        that immediately follows this Pay call 

		$returnUrl            = site_url('payments/paypal_success');    // TODO - If you are not executing the Pay call for a preapproval, 
														//        then you must set a valid returnUrl for the web approval flow 
														//        that immediately follows this Pay call 
		$currency = $this->db->where('user_id',$this->dx_auth->get_user_id())->where('is_default',1)->get('payout_preferences');
		if($currency->num_rows()!=0)
		{
			$currencyCode = $currency->row()->currency;
		}
		else {
			$currencyCode = "USD"; 
		}
		
		$receiverEmailArray    = array($adminpaypalmail,$hostmailid);
		
		$receiverAmountArray = array($paytoadmin,$roomtotal); 
		$receiverPrimaryArray = array(); 

		$receiverInvoiceIdArray = array($paytoadmin,$roomtotal); 
		$senderEmail                    = "";        // TODO - If you are executing the Pay call against a preapprovalKey, you should set senderEmail 
		// It is not required if the web approval flow immediately follows this Pay call 
		$feesPayer                        = ""; 
		$ipnNotificationUrl                = site_url('payments/paypal_ipn'); 
		$memo                            = "Thanks For Booking the property";        // maxlength is 1000 characters 
		$pin                            = "";        // TODO - If you are executing the Pay call against an existing preapproval 
													// the requires a pin, then you must set this 
		$preapprovalKey                    = "";        // TODO - If you are executing the Pay call against an existing preapproval, set the preapprovalKey here 
		$reverseAllParallelPaymentsOnError    = "true";    // TODO - Set this to "true" if you would like each parallel payment to be reversed if an error occurs 
		//        defaults to "false" if you don't specify 
		$trackingId                        = generateTrackingID();    // generateTrackingID function is found in paypalplatform.php 
	
		
		
		$resArray = CallPay ($actionType, $cancelUrl, $returnUrl, $currencyCode, $receiverEmailArray, 
								$receiverAmountArray, $receiverPrimaryArray, $receiverInvoiceIdArray, 
								$feesPayer, $ipnNotificationUrl, $memo, $pin, $preapprovalKey, 
								$reverseAllParallelPaymentsOnError, $senderEmail, $trackingId); 
			
		$ack = strtoupper($resArray["responseEnvelope.ack"]); 

		if($ack=="SUCCESS") 
		{ 
		
		$data['payKey'] = urldecode($resArray["payKey"]);
		$this->session->set_userdata($data);
			if ("" == $preapprovalKey) 
			{ 
				// redirect for web approval flow 
				$cmd = "cmd=_ap-payment&paykey=" . urldecode($resArray["payKey"]); 
				RedirectToPayPal ( $cmd ); 
		
			} 
			else 
			{ 
				// payKey is the key that you can use to identify the result from this Pay call 
				$payKey = urldecode($resArray["payKey"]); 
				// paymentExecStatus is the status of the payment 
				$paymentExecStatus = urldecode($resArray["paymentExecStatus"]); 
			} 
		}  
		else   
		{ 
			//Display a user friendly Error on the page using any of the following error information returned by PayPal 
			//TODO - There can be more than 1 error, so check for "error(1).errorId", then "error(2).errorId", and so on until you find no more errors. 
			$ErrorCode = urldecode($resArray["error(0).errorId"]); 
			$ErrorMsg = urldecode($resArray["error(0).message"]); 
			$ErrorDomain = urldecode($resArray["error(0).domain"]); 
			$ErrorSeverity = urldecode($resArray["error(0).severity"]); 
			$ErrorCategory = urldecode($resArray["error(0).category"]); 
			 
			echo "Preapproval API call failed. "; 
			echo "Detailed Error Message: " . $ErrorMsg; 
			echo "Error Code: " . $ErrorCode; 
			echo "Error Severity: " . $ErrorSeverity; 
			echo "Error Domain: " . $ErrorDomain; 
			echo "Error Category: " . $ErrorCategory; 
		}	
		
	
	}
	
	function submission($param='',$contact_key)
	{
		
		$checkin          = $this->input->post('checkin');
		$checkout         = $this->input->post('checkout');
		$number_of_guests = $this->input->post('number_of_guests');
		$ckin             = explode('/', $checkin);
		$ckout            = explode('/', $checkout);
		$pay              = $this->Common_model->getTableData('paywhom',array('id' => 1));
		$paywhom          = $pay->result();
		$paywhom          = $paywhom[0]->whom;
		$id               = $this->uri->segment(3);
		
		if($ckin[0] == "mm")
		{
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/'.$id, "refresh");
		} 
		if($ckout[0] == "mm") 
		{
			$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
			redirect('rooms/'.$id, "refresh");
		}
		
		$xprice      		= $this->Common_model->getTableData('price',array('id' => $this->uri->segment(3)))->row();
		
	
		$price          = $xprice->night;
	
		//$price      		 = $xprice->night;
		$placeid     		= $xprice->id;
		
		$guests      		= $xprice->guests;
		
		if(isset($xprice->cleaning))
		$cleaning   		 = $xprice->cleaning;
		else
		$cleaning   		 = 0;
		
		if(isset($xprice->week))
		$Wprice         = $xprice->week;	
		else
		$Wprice         = 0;
		
		if(isset($xprice->month))
		$Mprice         = $xprice->month;	
		else
		$Mprice         = 0;
		
		
		if($paywhom)
		{
			$query        = $this->Common_model->getTableData( 'list',array('id' => $id) )->row();
			$email        = $query->email; 	
		} 
		else
		{
			$query        = $this->Common_model->getTableData( 'users',array('role_id' => 2) )->row();
			$email        = $query->email;
		}
		
		$query         = $this->Common_model->getTableData('list',array('id' => $id));
		$q             =	$query->result();

		$diff          = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
		$days          = ceil($diff/(3600*24));
		
		$user_travel_cretids     = 0;
		if($this->session->userdata('travel_cretids'))
		{
		   $amt                  = $this->session->userdata('travel_cretids');
					$user_travel_cretids  = $this->session->userdata('user_travel_cretids');
					$is_travelCretids     = md5('Yes Travel Cretids');
		}
		else
		{
					if($number_of_guests  > $guests)
					{
							$diff_days = $number_of_guests  - $guests;
							$amt       = ($price * $days) + ($days * $xprice->addguests * $diff_days);
					}
					else
					{
							$amt       = $price * $days;
					}
					
					
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
							$amt             = $finalAmount;
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
							$amt             = $finalAmount;
					}
				}	
				
			//Cleaning fee
			if($cleaning != 0)
			{
				$amt                = $amt + $cleaning;
			}
			else
			{
				$amt                = $amt;
			}		
					
					
					$to_pay            = 0;
					$admin_commission  = 0;
					//Amount from session 
				//	$amt=$this->session->userdata("total_price_'".$id."'_'".$this->dx_auth->get_user_id()."'");
					//commission calculation
					$query       = $this->Common_model->getTableData('paymode', array( 'id' => 2));
					$row         = $query->row();
					if($row->is_premium == 1)
					{
							if($row->is_fixed == 1)
							{
							   $to_pay           = $amt;
										$fix              = $row->fixed_amount; 
										$amt              = $amt + $fix;
										//$amt = $this->session->userdata('topay');
										$admin_commission = $fix;
							}
							else
							{  
							   $to_pay           = $amt;
										$per              = $row->percentage_amount; 
										$camt             = floatval(($amt * $per) / 100);
										$amt              = $amt + $camt;
										$amt   = $amt;
										$admin_commission = $camt;
							}
					}
					else
					{
					$amt                   = $amt;
					$to_pay                = $amt;
					}
					
					$is_travelCretids = md5('No Travel Cretids');
		}
		//echo $amt;exit;
		
		if($contact_key != '')
		{
			$contact_result = $this->db->where('contact_key',$contact_key)->get('contacts')->row();
			$amt = $contact_result->price+$contact_result->admin_commission;
		}
		
		if($amt > 110)
		{
		if($this->db->select('referral_amount')->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_amount !=0 )
		{
          $referral_amount = $this->db->select('referral_amount')->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_amount;
		  
		   if($referral_amount > 100)
		{
			$final_amt = get_currency_value1($id,$amt)-get_currency_value(100);
		}
		else
			{
				$final_amt = $amt-$referral_amount;
				
			}
	  	$amt = $final_amt; 
		}
        else
	    {
		 $amt = $amt;
	    }
		
		}
		else {
			$amt = $amt;
		}
		
		if($contact_key == "")
		$contact_key="None";
		//Entering it into data variables
		$row     = $this->Common_model->getTableData('payment_details', array('code' => 'PAYPAL_ID'))->row();
		$paymode = $this->db->where('payment_name','Paypal')->get('payments')->row()->is_live;
		
					//$this->session->userdata('final_amount');
		$this->paypal_lib->add_field('business', $row->value);
	    $this->paypal_lib->add_field('return', site_url('payments/paypal_success'));
	    $this->paypal_lib->add_field('cancel_return', site_url('payments/paypal_cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('payments/paypal_ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', $id.'@'.$this->dx_auth->get_user_id().'@'.get_gmt_time(strtotime($checkin)).'@'.get_gmt_time(strtotime($checkout)).'@'.$number_of_guests.'@'.$is_travelCretids.'@'.$user_travel_cretids.'@'.get_currency_value1($id,$to_pay).'@'.get_currency_value1($id,$admin_commission).'@'.$contact_key);
		
		$custom = $id.'@'.$this->dx_auth->get_user_id().'@'.get_gmt_time(strtotime($checkin)).'@'.get_gmt_time(strtotime($checkout)).'@'.$number_of_guests.'@'.$is_travelCretids.'@'.$user_travel_cretids.'@'.get_currency_value1($id,$to_pay).'@'.get_currency_value1($id,$admin_commission).'@'.$contact_key;	
		
		$this->session->set_userdata('custom',$custom);	
			
					// Verify return
	    $this->paypal_lib->add_field('currency_code', get_currency_code());
		$this->paypal_lib->add_field('item_name', $this->dx_auth->get_site_title().' Transaction');
	    $this->paypal_lib->add_field('item_number', $placeid );
		$this->paypal_lib->add_field('item_number', $placeid );
		$this->paypal_lib->add_field('paymode', $paymode );
		
		$api_user     = $this->Common_model->getTableData('payment_details', array('code' => 'CC_USER'))->row()->value;
		$api_pwd     = $this->Common_model->getTableData('payment_details', array('code' => 'CC_PASSWORD'))->row()->value;
		$api_key     = $this->Common_model->getTableData('payment_details', array('code' => 'CC_SIGNATURE'))->row()->value;
		
		$this->paypal_lib->add_field('api_user', $api_user );
		$this->paypal_lib->add_field('api_pwd', $api_pwd );
		$this->paypal_lib->add_field('api_key', $api_key );
		
		if($this->session->userdata('final_amount') != '')
		{
	    $this->paypal_lib->add_field('amount', $this->session->userdata('final_amount'));
		$this->session->unset_userdata('final_amount');
		}
		else {
			$this->paypal_lib->add_field('amount', get_currency_value1($id,$amt));
		}
		$this->paypal_lib->image('button_03.gif');
		

	   $data['paypal_form'] = $this->paypal_lib->paypal_form();
	

		  $this->paypal_lib->paypal_auto_form();
	}
	
	
	function paypal_cancel()
	{
		$data['title']           = "Payment Failed";
		$data["meta_keyword"]    = "";
		$data["meta_description"]= "";
			
		$data['message_element']      = "payments/paypal_cancel";
		$this->load->view('template',$data);
	}
	
	/*function paypal_success()
	{
	
			$data['title']="Payment Success !";
			$data['message_element']      = "payments/paypal_success";
			$this->load->view('template',$data);
		
		}*/
	
	function paypal_success()
	{
		if(isset($_GET["token"]) && isset($_GET["PayerID"]))
	{
		$token = $_GET["token"];
		$playerid = $_GET["PayerID"];
		
		//get session variables
		$ItemPrice 		= $_SESSION['itemprice'];
		$ItemTotalPrice = $_SESSION['totalamount'];
		$ItemName 		= $_SESSION['itemName'];
		$ItemNumber 	= $_SESSION['itemNo'];
		$ItemQTY 		= $_SESSION['itemQTY'];
		
		$padata = 	'&TOKEN='.urlencode($token).
							'&PAYERID='.urlencode($playerid).
							'&PAYMENTACTION='.urlencode("SALE").
							'&AMT='.urlencode($ItemTotalPrice).
							'&CURRENCYCODE='.urlencode($PayPalCurrencyCode);
		
		//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
		//$paypal= new MyPayPal();
		
		$api_user     = $this->Common_model->getTableData('payment_details', array('code' => 'CC_USER'))->row()->value;
		$api_pwd     = $this->Common_model->getTableData('payment_details', array('code' => 'CC_PASSWORD'))->row()->value;
		$api_key     = $this->Common_model->getTableData('payment_details', array('code' => 'CC_SIGNATURE'))->row()->value;
		
		$paymode = $this->db->where('payment_name','Paypal')->get('payments')->row()->is_live;
		
		if($paymode==0){
			
				$PayPalMode 			= 'sandbox'; // sandbox or live
				
			}
			if($paymode==1){
				
				$PayPalMode 			= 'live'; // sandbox or live
			}
		
		
		$httpParsedResponseAr = $this->PPHttpPost('GetExpressCheckoutDetails', $padata, $api_user, $api_pwd, $api_key, $PayPalMode);
// print_r($httpParsedResponseAr['ACK']);exit;
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
		//if($_REQUEST['payment_status'] == 'Completed')
		{
			//print_r($_REQUEST['ItemName']);exit;
			//echo "<script> alert(''success');</script>";
		$custom = $this->session->userdata('custom');
		$data   = array();
		$list   = array();
		$data   = explode('@',$custom); 
		
		$contact_key	= $data[9];

		$list['list_id']       = $data[0];
		$list['userby']        = $data[1];
		
		$query1      = $this->Common_model->getTableData('list', array('id' => $list['list_id']));
		$buyer_id    = $query1->row()->user_id;
		
		$list['userto']            = $buyer_id;
		$list['checkin']           = $data[2];
		$list['checkout']          = $data[3];
		$list['no_quest']          = $data[4];
		
		$amt = explode('%',$httpParsedResponseAr['AMT']);
		
		$list['price']             = $amt[0];
		$currency                  = $httpParsedResponseAr['CURRENCYCODE'];
		
		$list['payment_id']        = 2;
		$list['credit_type']       = 1;
		$list['transaction_id']    = 0;
  
		$is_travelCretids          = $data[5];
		$user_travel_cretids       = $data[6];
		
		$list['topay']             = get_currency_value2($currency,$query1->row()->currency,$data[7]);
		$list['currency']          = $query1->row()->currency;
		$list['admin_commission']  = $data[8];
		
		//Entering into it
		if(strtoupper($httpParsedResponseAr["ACK"]) == 'SUCCESS')
		{
		   	if($contact_key != "None")
			{
			$list['status'] = 3;
			$this->db->select_max('group_id');
				$group_id                   = $this->db->get('calendar')->row()->group_id;
				
				if(empty($group_id)) echo $countJ = 0; else $countJ = $group_id;
				
				$insertData['list_id']      = $list['list_id'];
				$insertData['group_id']     = $countJ + 1;
				$insertData['availability'] = 'Booked';
				$insertData['booked_using'] = 'Other';
				
					$checkin  = date('m/d/Y', $list['checkin']);
					$checkout = date('m/d/Y', $list['checkout']);
					
					$days     = getDaysInBetween($checkin, $checkout);
		
					$count = count($days);
					$i = 1;
					foreach ($days as $val)
					{
						if($count == 1)
						{
							$insertData['style'] = 'single';
						}
						else if($count > 1)
						{
							if($i == 1)
							{
							$insertData['style'] = 'left';
							}
							else if($count == $i)
							{
							$insertData['notes'] = '';
							$insertData['style'] = 'right';
							}
							else
							{
							$insertData['notes'] = '';
							$insertData['style'] = 'both';
							}
						}	
					$insertData['booked_days'] = $val;
					$this->Trips_model->insert_calendar($insertData);				
					$i++;
					}
			}
			else	
		   	$list['status'] = 1;
		}
		else
		{
		   	$list['status'] = 0;
		}
			
			if($list['price'] > 75)
			{
			$user_id = $list['userby'];
			$details = $this->Referrals_model->get_details_by_Iid($user_id);
			$row     = $details->row();
			$count   = $details->num_rows();
			if($count > 0)
			{
									$details1 = $this->Referrals_model->get_details_refamount($row->invite_from);
									if($details1->num_rows() == 0)
									{ 						
									$insertData                  = array();
									$insertData['user_id']       = $row->invite_from;
									$insertData['count_trip']    = 1;
									$insertData['amount']        = 25;
									$this->Referrals_model->insertReferralsAmount($insertData);
									}
									else
									{
									$count_trip                  = $details1->row()->count_trip;
									$amount                      = $details1->row()->amount;
									$updateKey                   = array('id' => $row->id);
									$updateData                  = array();
									$updateData['count_trip']    = $count_trip + 1;
									$updateData['amount']        = $amount + 25;
									$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
									}
				}
			}
			
			$q        =	$query1->result();
			$row_list = $query1->row();
		 $iUser_id = $q[0]->user_id;
			$details2 = $this->Referrals_model->get_details_by_Iid($iUser_id);
			$row      = $details2->row();
			$count    = $details2->num_rows();
				if($count > 0)
				{
				 $details3 = $this->Referrals_model->get_details_refamount($row->invite_from);
									if($details3->num_rows() == 0)
									{ 							
									$insertData                  = array();
									$insertData['user_id']       = $row->invite_from;
									$insertData['count_book']    = 1;
									$insertData['amount']        = 75;
									$this->Referrals_model->insertReferralsAmount($insertData);
									}
									else
									{
									$count_book   = $details3->row()->count_book;
									$amount       = $details3->row()->amount;
									$updateKey                   = array('id' => $row->id);
									$updateData                  = array();
									$updateData['count_trip']    = $count_book + 1;
									$updateData['amount']        = $amount + 75;
									$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
									}
				}
				
			$admin_email = $this->dx_auth->get_site_sadmin();
			$admin_name  = $this->dx_auth->get_site_title();
			
			$query3      = $this->Common_model->getTableData('users',array('id' => $list['userby']));
			$rows        =	$query3->row();
				
			$username    = $rows->username;
			$user_id     = $rows->id;
			$email_id    = $rows->email;
			
			$query4      = $this->Users_model->get_user_by_id($buyer_id);
			$buyer_name  = $query4->row()->username;
			$buyer_email = $query4->row()->email;
			
			//Check md5('No Travel Cretids') || md5('Yes Travel Cretids')
			if($is_travelCretids == '7c4f08a53f4454ea2a9fdd94ad0c2eeb')
			{			
					  	$query5      = $this->Referrals_model->get_details_refamount($user_id);
		     	$amount      = $query5->row()->amount;			
																
								$updateKey                   = array('user_id ' => $user_id);
								$updateData                  = array();
								$updateData['amount']        = $amount -	$user_travel_cretids;
								$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
								
								$list['credit_type']         = 2;
								$list['ref_amount']          = $user_travel_cretids;

							
							$row = $query4->row();
							
								//sent mail to administrator
							$email_name = 'tc_book_to_admin';
							$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y',$list['checkin']), "{checkout}" => date('d-m-Y',$list['checkout']), "{market_price}" => $user_travel_cretids+$list['price'], "{payed_amount}" => $list['price'],"{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
							//Send Mail
							$this->Email_model->sendMail($admin_email,$email_id,ucfirst($username),$email_name,$splVars);
							

								//sent mail to buyer
							$email_name = 'tc_book_to_host';
							$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => date('d-m-Y',$list['checkin']), "{checkout}" => date('d-m-Y',$list['checkout']), "{market_price}" => $list['price']);
							//Send Mail
							if($buyer_email!='0')
			{
							$this->Email_model->sendMail($buyer_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			}
			}
			
		 $list['book_date']           = local_to_gmt();
					
			//Actual insertion into the database
			$this->Common_model->insertData('reservation', $list);		
			$reservation_id = $this->db->insert_id();
			
			//Send Message Notification
			$insertData = array(
				'list_id'         => $list['list_id'],
				'reservation_id'  => $reservation_id,
				'userby'          => $list['userby'],
				'userto'          => $list['userto'],
				'message'         => 'You have a new reservation request from '.ucfirst($username),
				'created'         => local_to_gmt(),
				'message_type'    => 1
				);
			$this->Message_model->sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list->title, $reservation_id);
			$message_id     = $this->db->insert_id();
			
			$actionurl = site_url('trips/request/'.$message_id);
				
   //Reservation Notification To Host
			$email_name = 'host_reservation_notification';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" =>  date('d-m-Y',$list['checkin']), "{checkout}" => date('d-m-Y',$list['checkout']), "{market_price}" => $list['price'], "{action_url}" => $actionurl);
			//Send Mail
			//
			if($buyer_email!='0')
			{
			$this->Email_model->sendMail($buyer_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			}
		 //Reservation Notification To Traveller
			$email_name = 'traveller_reservation_notification';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username));
			//Send Mail
			$this->Email_model->sendMail($email_id,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			
				//Reservation Notification To Administrator
				$email_name = 'admin_reservation_notification';
				$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_time}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" =>  date('d-m-Y',$list['checkin']), "{checkout}" => date('d-m-Y',$list['checkout']), "{market_price}" => $user_travel_cretids+$list['price'], "{payed_amount}" => $list['price'],"{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
				//Send Mail
				$this->Email_model->sendMail($admin_email,$email_id,ucfirst($username),$email_name,$splVars);
				
			//	if($is_block == 'on')
	//	{
				$this->db->select_max('group_id');
				$group_id                   = $this->db->get('calendar')->row()->group_id;
				
				if(empty($group_id)) echo $countJ = 0; else $countJ = $group_id;
				
				$insertData1['list_id']      = $list['list_id'];
				//$insertData['reservation_id'] = $reservation_id;
				$insertData1['group_id']     = $countJ + 1;
				$insertData1['availability'] = 'Not Available';
				$insertData1['booked_using'] = 'Other';
				
					$checkin  = date('m/d/Y', $list['checkin']);
					$checkout = date('m/d/Y', $list['checkout']);
					$days     = getDaysInBetween($checkin, $checkout);
		
					$count = count($days);
					$i = 1;
					foreach ($days as $val)
					{
						if($count == 1)
						{
							$insertData1['style'] = 'single';
						}
						else if($count > 1)
						{
							if($i == 1)
							{
							$insertData1['style'] = 'left';
							}
							else if($count == $i)
							{
							$insertData1['notes'] = '';
							$insertData1['style'] = 'right';
							}
							else
							{
							$insertData1['notes'] = '';
							$insertData1['style'] = 'both';
							}
						}	
					$insertData1['booked_days'] = $val;
					$this->Trips_model->insert_calendar($insertData1);				
					$i++;
					}
			}
			
		}
            $referral_amount = $this->db->where('id',$this->dx_auth->get_user_id())->get('users')->row()->referral_amount;
            if($referral_amount > 100)
			{
				$this->db->set('referral_amount',$referral_amount-100)->where('id',$this->dx_auth->get_user_id())->update('users');
			}
            else
	        {
		 $this->db->set('referral_amount',0)->where('id',$this->dx_auth->get_user_id())->update('users');
	        }
           
            $data['title']="Payment Success !";
			$data['message_element']      = "payments/paypal_success";
			$this->load->view('template',$data);
	}

	function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode){
	$API_UserName = urlencode($PayPalApiUsername);
			$API_Password = urlencode($PayPalApiPassword);
			$API_Signature = urlencode($PayPalApiSignature);
			
			if($PayPalMode=='sandbox')
			{
				$paypalmode 	=	'.sandbox';
			}
			else
			{
				$paypalmode 	=	'';
			}
	
			$API_Endpoint = "https://api-3t".$paypalmode.".paypal.com/nvp";
			$version = urlencode('76.0');
		
			// Set the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
			curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
			// Turn off the server and peer verification (TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
		
			// Set the API operation, version, and API signature in the request.
			$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
		
			// Set the request as a POST FIELD for curl.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		
			// Get response from the server.
			$httpResponse = curl_exec($ch);
		
			if(!$httpResponse) {
				exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
			}
		
			// Extract the response details.
			$httpResponseAr = explode("&", $httpResponse);
		
			$httpParsedResponseAr = array();
			foreach ($httpResponseAr as $i => $value) {
				$tmpAr = explode("=", $value);
				if(sizeof($tmpAr) > 1) {
					$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
				}
			}
		
			if((0 == sizeof($httpParsedResponseAr))) {
				exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
			}
		
		return $httpParsedResponseAr;
	
}
	
	function submissionTwoc()
	{
		$checkin          = $this->input->post('checkin');
		$checkout         = $this->input->post('checkout');
		$number_of_guests = $this->input->post('number_of_guests');
		$ckin             = explode('/', $checkin);
		$ckout            = explode('/', $checkout);
		$pay              = $this->Common_model->getTableData('paywhom',array('id' => 1));
		$paywhom          = $pay->result();
		$paywhom          = $paywhom[0]->whom;
		$id               = $this->uri->segment(3);
		
		if($ckin[0] == "mm")
		{
			//echo "Sorry not a valid date";
			redirect('rooms/'.$id, "refresh");
		} 
		if($ckout[0] == "mm") 
		{
			//echo "Sorry not a valid date";
			redirect('rooms/'.$id, "refresh");
		}
		
		$xprice          = $this->Common_model->getTableData( 'price', array('id' => $this->uri->segment(3)) )->row();
		$price           = $xprice->night;
		$placeid         = $xprice->id;
		
		$guests          = $xprice->guests;
		
		if(isset($xprice->cleaning))
		$cleaning        = $xprice->cleaning;
		else
		$cleaning        = 0;
		
		if(isset($xprice->week))
		$Wprice         = $xprice->week;	
		else
		$Wprice         = 0;
		
		if(isset($xprice->month))
		$Mprice         = $xprice->month;	
		else
		$Mprice         = 0;
		
		
		if($paywhom)
		{
			$query        = $this->Common_model->getTableData( 'list', array('id' => $id) )->row();
			$email        = $query->email; 	
		} 
		else
		{
			$query        = $this->Common_model->getTableData( 'users', array('role_id' => 2) )->row();
			$email        = $query->email;
		}
		
		$query         = $this->Common_model->getTableData('list', array('id' => $id));
		$q             =	$query->result();
		
		$diff = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
		$days = ceil($diff/(3600*24));
		
		$user_travel_cretids     = 0;
		if($this->session->userdata('travel_cretids'))
		{
		   $amt                  = $this->session->userdata('travel_cretids');
					$user_travel_cretids  = $this->session->userdata('user_travel_cretids');
					$is_travelCretids     = 'yes';
		}
		else
		{
					
					if($number_of_guests  > $guests)
					{
							$diff_days = $number_of_guests  - $guests;
							$amt       = ($price * $days) + ($days * $xprice->addguests * $diff_days);
					}
					else
					{
							$amt     = $price * $days;
					}
					
					if($cleaning != 0)
					{
						$amt = $amt + $cleaning;
					}
					else
					{
						$amt = $amt;
					}
					
					
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
							$amt             = $finalAmount;
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
							$amt             = $finalAmount;
					}
				}	
				
			//Cleaning fee
			if($cleaning != 0)
			{
				$amt                = $amt + $cleaning;
			}
			else
			{
				$amt                = $amt;
			}		
					
					//commission calculation
					$to_pay            = 0;
					$admin_commission  = 0;
					//Amount from session 
					$amt=$this->session->userdata("total_price_'".$id."'_'".$this->dx_auth->get_user_id()."'");
					$query       = $this->Common_model->getTableData('paymode', array( 'id' => 2));
					$row         = $query->row();
					if($row->is_premium == 1)
					{
							if($row->is_fixed == 1)
							{
							   $to_pay           = $amt;
										$fix              = $row->fixed_amount; 
										$amt              = $amt + $fix;
										$admin_commission = $fix;
							}
							else
							{  
							   $to_pay           = $amt;
										$per              = $row->percentage_amount; 
										$camt             = floatval(($amt * $per) / 100);
										$amt              = $amt + $camt;
										$admin_commission = $camt;
							}
					}
					else
					{
					$amt       = $amt;
					}
					$is_travelCretids = 'no';
		}
		
		
			 $row     = $this->Common_model->getTableData('payment_details', array('code' => '2C_VENTOR_ID'))->row();
				
				$this->twoco_lib->addField('sid', $row->value);
				// Specify the order information
				$this->twoco_lib->addField('cart_order_id', rand(1, 100));
				$this->twoco_lib->addField('total', get_currency_value1($id,$amt));
				//echo get_currency_value1($id,$amt);
				// Specify the url where authorize.net will send the IPN
				$this->twoco_lib->addField('x_Receipt_Link_URL', site_url('payments/twoC_ipn'));
				$this->twoco_lib->addField('tco_currency', get_currency_code());
				$this->twoco_lib->addField('custom', $id.'@'.$this->dx_auth->get_user_id().'@'.get_gmt_time(strtotime($checkin)).'@'.get_gmt_time(strtotime($checkout)).'@'.$number_of_guests.'@'.$is_travelCretids.'@'.$user_travel_cretids.'@'.get_currency_value($to_pay).'@'.get_currency_value($admin_commission));
				
				// Enable test mode if needed
				$this->twoco_lib->enableTestMode();
			
				// Let's start the train!
				$this->twoco_lib->submitPayment();
	}
	
		public function twoC_ipn()
		{
				foreach ($_REQUEST as $field=>$value)
				{
								$this->ipnData["$field"] = $value;
				}				

		$custom = $this->ipnData["custom"];
		$data   = array();
		$list   = array();
		$data   = explode('@',$custom); 
		
		$list['list_id']       = $data[0];
		$list['userby']        = $data[1];
		
		$query1      = $this->Common_model->getTableData('list', array('id' => $list['list_id']));
		$buyer_id    = $query1->row()->user_id;
		
		$list['userto']            = $buyer_id;
		$list['checkin']           = $data[2];
		$list['checkout']          = $data[3];
		$list['no_quest']          = $data[4];
		$list['price']             = $this->ipnData["total"];
		
		$list['credit_type']       = 1;
		$list['payment_id']        = 3;
		$list['transaction_id']    = $this->ipnData["order_number"];

		$is_travelCretids          = $data[5];
		$user_travel_cretids       = $data[6];
		
		$list['topay']             = $data[7];
		$list['admin_commission']  = $data[8];
		
		//Entering into it
	  if($list['price'] > 75)
			{
			$user_id = $list['userby'];
			$details = $this->Referrals_model->get_details_by_Iid($user_id);
			$row     = $details->row();
			$count   = $details->num_rows();
			if($count > 0)
			{
									$details1 = $this->Referrals_model->get_details_refamount($row->invite_from);
									if($details1->num_rows() == 0)
									{ 						
									$insertData                  = array();
									$insertData['user_id']       = $row->invite_from;
									$insertData['count_trip']    = 1;
									$insertData['amount']        = 25;
									$this->Referrals_model->insertReferralsAmount($insertData);
									}
									else
									{
									$count_trip   = $details1->row()->count_trip;
									$amount       = $details1->row()->amount;
									$updateKey                   = array('id' => $row->id);
									$updateData                  = array();
									$updateData['count_trip']    = $count_trip + 1;
									$updateData['amount']        = $amount + 25;
									$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
									}
				}
			}
			
			$q        =	$query1->result();
			$row_list = $query1->row();
		 $iUser_id = $q[0]->user_id;
			$details2 = $this->Referrals_model->get_details_by_Iid($iUser_id);
			$row      = $details2->row();
			$count    = $details2->num_rows();
				if($count > 0)
				{
				 $details3 = $this->Referrals_model->get_details_refamount($row->invite_from);
									if($details3->num_rows() == 0)
									{ 							
									$insertData                  = array();
									$insertData['user_id']       = $row->invite_from;
									$insertData['count_book']    = 1;
									$insertData['amount']        = 75;
									$this->Referrals_model->insertReferralsAmount($insertData);
									}
									else
									{
									$count_book   = $details3->row()->count_book;
									$amount       = $details3->row()->amount;
									$updateKey                   = array('id' => $row->id);
									$updateData                  = array();
									$updateData['count_trip']    = $count_book + 1;
									$updateData['amount']        = $amount + 75;
									$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
									}
				}
				
			$admin_email = $this->dx_auth->get_site_sadmin();
			$admin_name  = $this->dx_auth->get_site_title();
			
			$query3      = $this->Common_model->getTableData('users', array('id' => $list['userby']));
			$rows        =	$query3->row();
				
			$username    = $rows->username;
			$user_id     = $rows->id;
			$email_id    = $rows->email;
			
			$query4      = $this->Users_model->get_user_by_id($buyer_id);
			$buyer_name  = $query4->row()->username;
			$buyer_email = $query4->row()->email;
			
			//Check md5('No Travel Cretids') || md5('Yes Travel Cretids')
			if($is_travelCretids == '7c4f08a53f4454ea2a9fdd94ad0c2eeb')
			{			
					  	$query5      = $this->Referrals_model->get_details_refamount($user_id);
		     	$amount      = $query5->row()->amount;			
																
								$updateKey                   = array('user_id ' => $user_id);
								$updateData                  = array();
								$updateData['amount']        = $amount -	$user_travel_cretids;
								$this->Referrals_model->updateReferralsAmount($updateKey,$updateData);
								
								$list['credit_type']         = 2;
								$list['ref_amount']          = $user_travel_cretids;

							
							$row = $query4->row();
							
								//sent mail to administrator
							$email_name = 'tc_book_to_admin';
							$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_date}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $user_travel_cretids+$list['price'], "{payed_amount}" => $list['price'],"{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
							//Send Mail
							$this->Email_model->sendMail($admin_email,$email_id,ucfirst($username),$email_name,$splVars);
							

								//sent mail to buyer
							$email_name = 'tc_book_to_host';
							$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_date}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $list['price']);
							//Send Mail
							$this->Email_model->sendMail($buyer_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);

			}
			
		 $list['book_date']           = local_to_gmt();
					
			//Actual insertion into the database
			$this->Common_model->insertData('reservation',$list);		
			$reservation_id = $this->db->insert_id();
			
			//Send Message Notification
			$insertData = array(
				'list_id'         => $list['list_id'],
				'reservation_id'  => $reservation_id,
				'userby'          => $list['userby'],
				'userto'          => $list['userto'],
				'message'         => 'You have a new reservation request from '.ucfirst($username),
				'created'         => local_to_gmt(),
				'message_type'    => 1
				);
			$this->Message_model->sentMessage($insertData, ucfirst($buyer_name), ucfirst($username), $row_list->title, $reservation_id);
			$message_id     = $this->db->insert_id();
			
			$actionurl = site_url('trips/request/'.$message_id);
				
   //Reservation Notification To Host
			$email_name = 'host_reservation_notification';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($buyer_name), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_date}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $list['price'], "{action_url}" => $actionurl);
			//Send Mail
			$this->Email_model->sendMail($buyer_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			
		 //Reservation Notification To Traveller
			$email_name = 'traveller_reservation_notification';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username));
			//Send Mail
			$this->Email_model->sendMail($email_id,$admin_email,ucfirst($admin_name),$email_name,$splVars);
			
				//Reservation Notification To Administrator
				$email_name = 'admin_reservation_notification';
				$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($username), "{list_title}" => $row_list->title, "{book_date}" => date('m/d/Y'), "{book_date}" => date('g:i A'), "{traveler_email_id}" => $email_id, "{checkin}" => $list['checkin'], "{checkout}" => $list['checkout'], "{market_price}" => $user_travel_cretids+$list['price'], "{payed_amount}" => $list['price'],"{travel_credits}" => $user_travel_cretids, "{host_name}" => ucfirst($buyer_name), "{host_email_id}" => $buyer_email);
				//Send Mail
				$this->Email_model->sendMail($admin_email,$email_id,ucfirst($username),$email_name,$splVars);
				
    redirect('rooms/'.$list['list_id'], 'refresh');
			}
		
		public function twoC_success()
		{
				foreach ($_REQUEST as $field=>$value)
				{
								$this->ipnData["$field"] = $value;
				}
				
			$custom = $this->ipnData["vendor_order_id"];
			$data   = explode('@',$custom); 
		
		 $list_id       = $data[0];
	  redirect('rooms/'.$list_id,'refresh');
		}
	
	//Date convert module
	public function dateconvert($date)
	{
		$ckout = explode('/', $date);
		$diff = $ckout[2].'-'.$ckout[0].'-'.$ckout[1];
		return $diff;
	}
}

/* End of file payments.php */
/* Location: ./app/controllers/payments.php */
?>
