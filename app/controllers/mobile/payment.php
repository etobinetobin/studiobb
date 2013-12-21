<?php
/**
 * DROPinn Payment Controller Class
 *
 * helps to achieve common tasks related to the site for mobile app like android and iphone.
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Payment
 * @author		Cogzidel Product Team
 * @version		Version 1.0
 * @link		http://www.cogzidel.com
 
 */
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function Payment()
	{
		parent::__construct();
		
		$this->load->helper('url');
		
		$this->load->library('email');
		$this->load->library('DX_Auth'); 
		$this->load->library('Paypal_Lib');
		 
		$this->load->model('Users_model');
		$this->load->model('Gallery');
		$this->load->model('Referrals_model');
		$this->load->model('Email_model');
		$this->load->model('Message_model');
	}
	
	public function index()
	{
	
	}
	
	public function paypal()
	{
	 $id             = $this->input->get('list_id');
		$checkin        = $this->input->get('checkin');
		$checkout       = $this->input->get('checkout');
		$data['guests'] = $this->input->get('guests');
		
		//check the list_id is in db
		$this->db->where('status !=', 0);
		$this->db->where('user_id !=', 0);
		$this->db->where('address !=', '0');
		$this->db->where('id', $id );
		$query = $this->db->get('list');
		if($query->num_rows() == 0)
		{
		  echo '[{"available":false,"reason_message":"The host id is not available"}]'; exit;
		}
		
		$ckin  = explode('/', $checkin);
		$ckout = explode('/', $checkout);
	
		$x  = $this->db->get_where('price',array('id' => $id ));
		$x1 = $x->result();
		
		$per_night = $x1[0]->night;
		
		$guests    = $x1[0]->guests;
		
		if(isset($x1[0]->cleaning))
		$cleaning  = $x1[0]->cleaning;
		else
		$cleaning  = 0;
		
		if(isset($x1[0]->night))
		$price  = $x1[0]->night;
		else
		$price  = 0;
		
		if(isset($x1[0]->week))
		$Wprice = $x1[0]->week;	
		else
		$Wprice = 0;
		
		if(isset($x1[0]->month))
		$Mprice = $x1[0]->month;	
		else
		$Mprice = 0;
		
		//check admin premium condition and apply so for
		$query       = $this->db->get_where('paymode', array('id' => 2));
		$row         = $query->row();	


	if(($ckin[0] == "mm" && $ckout[0] == "mm") or ($ckin[0] == "" && $ckout[0] == ""))
		{
		 $days = 0;
			
   $data['price']    = $price;
			
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
										$fix  = $row->fixed_amount; 
										$amt  = $price + $fix;
										$data['commission'] = $fix;
										$Fprice             = $amt;
							}
							else
							{  
										$per  = $row->percentage_amount; 
										$camt = floatval(($price * $per) / 100);
										$amt  = $price + $camt;
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
			} 
		else
		{	
			$diff = strtotime($ckout[2].'-'.$ckout[0].'-'.$ckout[1]) - strtotime($ckin[2].'-'.$ckin[0].'-'.$ckin[1]);
			$days = ceil($diff/(3600*24));
			
			if($data['guests'] > $guests)
			{
			  $diff_days = $data['guests'] - $guests;
			  $price     = ($price * $days) + ($days * $x1[0]->addguests * $diff_days);
			}
			else
			{
			  $price = $price * $days;
			}
			
			if($cleaning != 0)
			{
			 $price = $price + $cleaning;
			}	
			
			//Entering it into data variables
			$data['price']    = $price;
					
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
										$fix  = $row->fixed_amount; 
										$amt  = $price + $fix;
										$data['commission'] = $fix;
										$Fprice             = $amt;
							}
							else
							{  
										$per  = $row->percentage_amount; 
										$camt = floatval(($price * $per) / 100);
										$amt  = $price + $camt;
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
					}
					
					
			$query = $this->db->query("SELECT id,list_id FROM `calendar` WHERE `list_id` = '".$id."' AND (`booked_days` = '".$checkin."' OR `booked_days` = '".$checkout."') GROUP BY `list_id`");
			$rows  = $query->num_rows();
			//echo $this->db->last_query();exit;
			
			if($rows > 0)
			{
			  echo '[{"available":false,"total_price":'.$data['price'].',"reason_message":"Those dates are not available"}]';
			}
			else
			{
			  $is_live    = $this->db->get_where('payments', array( 'id' => 2))->row()->is_live;
					
					if($is_live == 1)
					$paypal_url    = '1';
					else
					$paypal_url    = '2';
					
					$paypal_id     = $this->Common_model->getTableData('payment_details', array('code' => 'PAYPAL_ID'))->row()->value;
					
			  echo '[{"available":true,"is_live":"'.$paypal_url.'","paypal_id":"'.$paypal_id.'","service_fee":"$'.$data['commission'].'","cleaning_fee":"$'.$cleaning.'","reason_message":"","price_per_night":"$'.$per_night.'","nights":'.$days.',"total_price":"$'.($data['price']+$data['commission']).'"}]';
			}

	}
	
	public function paypalipn()
	{
	
	 //mail('rameshr@cogzidel.com','Checkiny by me',$_REQUEST['payment_status'].'Coming'.$_REQUEST['mc_gross'].'Coming'.$_REQUEST['custom']);
		if($this->input->get('status') == 'Completed')
		{
		$list   = array();
		
		$list['list_id']       = $this->input->get('list_id');
		$list['userby']        = $this->input->get('userby');
		
		$query1      = $this->db->get_where('list', array('id' => $list['list_id']));
		$buyer_id    = $query1->row()->user_id;
		
		$list['userto']        = $buyer_id;
		$list['checkin']       = $this->input->get('checkin');
		$list['checkout']      = $this->input->get('checkout');
		$list['no_quest']      = $this->input->get('guest');
		$list['price']         = $this->input->get('amount');
		$list['credit_type']   = 1;
  
		$is_travelCretids    = NULL;
		$user_travel_cretids = NULL;
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
			
			$query3      = $this->db->get_where('users',array('id' => $list['userby']));
			$rows        =	$query3->row();
				
			$username    = $rows->username;
			$user_id     = $rows->id;
			$email_id    = $rows->email;
			
			$query4      = $this->users->get_user_by_id($buyer_id);
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
								
								$list['credit_type']   = 2;
								$list['ref_amount']    = $user_travel_cretids;

							
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
			
		//	$list['book_date']           = date('d-m-Y H:i:s');
					
			//Actual insertion into the database
			$this->db->insert('reservation',$list);		
			$reservation_id = $this->db->insert_id();
			
			//Send Message Notification
			$insertData = array(
				'list_id'         => $list['list_id'],
				'reservation_id'  => $reservation_id,
				'userby'          => $list['userby'],
				'userto'          => $list['userto'],
				'message'         => 'You have a new reservation request from '.ucfirst($username),
				'created'         => date('m/d/Y g:i A'),
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
				
				echo '[{"reason_message":"Payment completed successfully."}]'; exit;
				
		}
	
	
	}
	
}

?>