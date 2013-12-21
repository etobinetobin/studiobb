<?php
/**
 * DROPinn Admin Payment Controller Class
 *
 * helps to achieve common tasks related to the site like flash message formats,pagination variables.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Admin Payment
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com

 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller
{

	function Payment()
	{
			parent::__construct();
		
		$this->load->library('Table');
		$this->load->library('Pagination');
		$this->load->library('Paypal_Lib');
		$this->load->library('Twoco_Lib');
		
		$this->load->helper('form');
		$this->load->helper('url');
		
			//load validation library
		$this->load->library('form_validation');

		
		$this->load->model('Users_model');	
		$this->load->model('Trips_model');
		$this->load->model('Email_model');
		$this->load->model('Message_model');
		
		// Protect entire controller so only admin, 
		// and users that have granted role in permissions table can access it.
		$this->dx_auth->check_uri_permissions();
	}
	
	function index()
	{

		$this->form_validation->set_error_delimiters('<p>', '</p>');

		if($this->input->post())
		{	
			//Set rules
			$payId        = $this->input->post('name_gate');
			
			$this->form_validation->set_rules('name_gate','Pay Gateway','required|trim|xss_clean');
			if($payId == 1)
			{
			$this->form_validation->set_rules('pe_user','Payment Express Username','required|trim|xss_clean');
			$this->form_validation->set_rules('pe_password','Payment Express Password','required|trim|xss_clean');
			$this->form_validation->set_rules('pe_key','Payment Express Key','required|trim|xss_clean');
			}
			else if($payId == 2)
			{
			$this->form_validation->set_rules('paypal_id','Paypal Address Id','required|trim|xss_clean');
			}
			else {
			$this->form_validation->set_rules('ventor_id','Ventor ID','required|trim|xss_clean');
			$this->form_validation->set_rules('security','Security(2Checkout Username)','required|trim|xss_clean');
				}		
			if($this->form_validation->run())
			{	
			$payId        = $this->input->post('name_gate');
					
			if($payId == 1)
			{		
			$data1['value']    = $this->input->post('pe_user');
			$this->db->where('code', 'PE_USER');
			$this->db->update('payment_details',$data1);
			
			$data2['value']    = $this->input->post('pe_password');
			$this->db->where('code', 'PE_PASSWORD');
			$this->db->update('payment_details',$data2);
			
			$data3['value']    = $this->input->post('pe_key');
			$this->db->where('code', 'PE_KEY');
			$this->db->update('payment_details',$data3);
			}
			else if($payId == 2)
			{
			$data['value']    = $this->input->post('paypal_id');
			$this->db->where('code', 'PAYPAL_ID');
			$this->db->update('payment_details',$data);
			}
			else
			{
			$data1['value']    = $this->input->post('ventor_id');
			$this->db->where('code', '2C_VENTOR_ID');
			$this->db->update('payment_details',$data1);
			
			$data2['value']    = $this->input->post('security');
			$this->db->where('code', '2C_SECURITY');
			$this->db->update('payment_details',$data2);
			}
			
			$update['is_enabled'] = $this->input->post('is_active');
			$this->db->where('id', $payId);
			$this->db->update('payments',$update);
			
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success','Pay gateway added successfully.'));
			redirect_admin('payment/manage_gateway');
			}
	 }
		
	$query                  = $this->db->get_where('payments', array( 'is_enabled !=' => 1));
	$data['result']         = $query->result();
		
	$data['message_element'] = "administrator/payment/add_gateway";
	$this->load->view('administrator/admin_template', $data);
	}
	
	function manage_gateway($id = '')
	{
		$check = $this->input->post('check');
		if($this->input->post('delete'))
		{
				if(empty($check))
				{
					$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error','Sorry, You have select atleast one!'));
					redirect_admin('payment/manage_gateway');
				}
				
				foreach($check as $c)
				{
					$this->db->delete('payments', array('id' => $c));
				}
				
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success','Pay Gateway Deleted Successfully'));	
			redirect_admin('payment/manage_gateway');
		}
		else if($this->input->post('edit'))
		{
				if(empty($check))
				{
				 $this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error','Sorry, You have select atleast one!'));
					redirect_admin('payment/manage_gateway');
				}
				
				if(count($check) == 1)
				{
					$query                  = $this->db->get_where('payments', array( 'id' => $check[0]));
				 $data['result']         = $query->row();
					
					$query1                 = $this->db->get_where('payments');
					$data['payments']       = $query1->result();
					
					$data['pe_user']        = $this->db->get_where('payment_details', array('code' => 'CC_USER'))->row()->value;
					$data['pe_password']    = $this->db->get_where('payment_details', array('code' => 'CC_PASSWORD'))->row()->value;
					$data['pe_key']         = $this->db->get_where('payment_details', array('code' => 'CC_SIGNATURE'))->row()->value;
					
					$data['paypal_id']      = $this->db->get_where('payment_details', array('code' => 'PAYPAL_ID'))->row()->value;
					
					$data['ventor_id']      = $this->db->get_where('payment_details', array('code' => '2C_VENTOR_ID'))->row()->value;
					$data['security']       = $this->db->get_where('payment_details', array('code' => '2C_SECURITY'))->row()->value;
				
				$data['payId']           = $check[0];
				$data['message_element'] = "administrator/payment/edit_gateway";
				$this->load->view('administrator/admin_template', $data);
				}
				else
				{
				$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error','Please select any one Pay Gateway to edit!'));
				redirect_admin('payment/manage_gateway');
				}
		}
		else if($this->input->post('update'))
		{
		
	      $this->form_validation->set_error_delimiters('<p>', '</p>');

		
			//Set rules
			$payId        = $this->input->post('payId');

			if($payId == 1)
			{
			$this->form_validation->set_rules('pe_user','Payment Express Username','required|trim|xss_clean');
			$this->form_validation->set_rules('pe_password','Payment Express Password','required|trim|xss_clean');
			$this->form_validation->set_rules('pe_key','Payment Express Key','required|trim|xss_clean');
			}
			else if($payId == 2)
			{
			$this->form_validation->set_rules('paypal_id','Paypal Address Id','required|trim|xss_clean');
			$this->form_validation->set_rules('pe_user','Payment Express Username','required|trim|xss_clean');
			$this->form_validation->set_rules('pe_password','Payment Express Password','required|trim|xss_clean');
			$this->form_validation->set_rules('pe_key','Payment Express Key','required|trim|xss_clean');
			}
			else {
			$this->form_validation->set_rules('ventor_id','Ventor ID','required|trim|xss_clean');
			$this->form_validation->set_rules('security','Security(2Checkout Username)','required|trim|xss_clean');
				}		
			if($this->form_validation->run())
			{			
		 	$payId = $this->input->post('payId');
			$paypal_id = $this->input->post('paypal_id');
			if($payId == 1)
			{		
			$data1['value']    = $this->input->post('pe_user');
			$this->db->where('code', 'CC_USER');
			$this->db->update('payment_details',$data1);
			
			$data2['value']    = $this->input->post('pe_password');
			$this->db->where('code', 'CC_PASSWORD');
			$this->db->update('payment_details',$data2);
			
			$data3['value']    = $this->input->post('pe_key');
			$this->db->where('code', 'CC_SIGNATURE');
			$this->db->update('payment_details',$data3);		
			
			$updateData['is_enabled'] = $this->input->post('is_active');
			$updateData['is_live']    = $this->input->post('paypal_url');
			$this->db->where('id', 1);
			$this->db->update('payments', $updateData);
			}
			else if($payId == 2)
			{
			$data['value']    = $this->input->post('paypal_id');
			$this->db->where('code', 'PAYPAL_ID');
			$this->db->update('payment_details',$data);
			
			$updateData['is_enabled'] = $this->input->post('is_active');
			$updateData['is_live']    = $this->input->post('paypal_url');
			$this->db->where('id', 2);
			$this->db->update('payments', $updateData);
			
			$data1['value']    = $this->input->post('pe_user');
			$this->db->where('code', 'CC_USER');
			$this->db->update('payment_details',$data1);
			
			$data2['value']    = $this->input->post('pe_password');
			$this->db->where('code', 'CC_PASSWORD');
			$this->db->update('payment_details',$data2);
			
			$data3['value']    = $this->input->post('pe_key');
			$this->db->where('code', 'CC_SIGNATURE');
			$this->db->update('payment_details',$data3);		
			
			$updateData['is_enabled'] = $this->input->post('is_active');
			$updateData['is_live']    = $this->input->post('paypal_url');
			$this->db->where('id', 1);
			$this->db->update('payments', $updateData);
			}
			else
			{
			$data1['value']    = $this->input->post('ventor_id');
			$this->db->where('code', '2C_VENTOR_ID');
			$this->db->update('payment_details',$data1);
			
			$data2['value']    = $this->input->post('security');
			$this->db->where('code', '2C_SECURITY');
			$this->db->update('payment_details',$data2);
			}
			
			$update['is_enabled'] = $this->input->post('is_active');
			$this->db->where('id', $payId);
			$this->db->update('payments',$update);
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('success','Payment changes updated successfully'));
			redirect_admin('payment/manage_gateway');
			} else
			{
			$this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error','Please enter the values to the required fields'));
			redirect_admin('payment/manage_gateway');
			}

		}
		else
		{
				if(isset($id) && $id != '')
				{
							$get = $this->db->get_where('payments', array( 'id' => $id))->row();
							if($get->is_enabled == 1)
							{
									$change = 0;
							}
							else
							{
									$change = 1;
							}
							
							$data['is_live']   = $change;
							$this->db->where('id', $id);
							$this->db->update('payments',$data);
				}
		$data['payments']        = $this->db->get_where('payments', array( 'is_enabled' => 1));
		
		$data['message_element'] = "administrator/payment/manage_gateway";
		$this->load->view('administrator/admin_template', $data);
		}
	}
	
	function paymode($id = '')
	{
		$check = $this->input->post('check');
		if($this->input->post('edit'))
		{
				if(empty($check))
				{
				 $this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error','Sorry, You have select atleast one!'));
					redirect_admin('payment/paymode');
				}
			if(count($check) == 1)
			{
		 	$data['payId'] = $check[0];
					if($check[0] == 1)
					{
					$data['result'] = $this->db->get_where('paymode', array( 'id' => 1))->row();
					$data['message_element'] = "administrator/payment/list_pay";
					$this->load->view('administrator/admin_template', $data);
					}
					else if($check[0] == 2)
					{
					$data['result'] = $this->db->get_where('paymode', array( 'id' => 2))->row();
					$data['message_element'] = "administrator/payment/accommodation_pay";
					$this->load->view('administrator/admin_template', $data);	
					}
					else
					{
					$data['result'] = $this->db->get_where('paymode', array( 'id' => 3))->row();
					$data['message_element'] = "administrator/payment/reservation_request";
					$this->load->view('administrator/admin_template', $data);
					}
			}
			else
			{
			 $this->session->set_flashdata('flash_message', $this->Common_model->admin_flash_message('error','Please select any one pay mode to edit!'));
				redirect_admin('payment/paymode');
			}
		}
		else if($this->input->post('update'))
		{ 
	 	$payId = $this->input->post('payId');
			
			$data['is_premium']        = $this->input->post('is_premium');
			$data['is_fixed']          = $this->input->post('is_fixed');
			$data['fixed_amount']      = $this->input->post('fixed_amount');
			$data['percentage_amount'] = $this->input->post('percentage_amount');
			
			$this->db->where('id', $payId);
			$this->db->update('paymode',$data);
			
		echo "<p>Updated Successfully.</p>";
		}
		else
		{
				if(isset($id) && $id != '')
				{
							$get = $this->db->get_where('paymode', array( 'id' => $id))->row();
							if($get->is_premium == 1)
							{
									$change = 0;
							}
							else
							{
									$change = 1;
							}
							
							$data['is_premium']   = $change;
							$this->db->where('id', $id);
							$this->db->update('paymode',$data);
				}
		$data['payMode'] = $this->db->get('paymode');
	
	 $data['message_element'] = "administrator/payment/paymode";
	 $this->load->view('administrator/admin_template', $data);
		}
	}
	
	function finance()
	{
		$query          = $this->Trips_model->get_reservation();
		
		// Get offset and limit for page viewing
		$start          = (int) $this->uri->segment(4,0);
		
	 // Number of record showing per page
		$row_count      = 10;
		
		if($start > 0)
		   $offset			   = ($start-1) * $row_count;
		else
		   $offset			   =  $start * $row_count; 
		
		// Get all users
		$limits         =  array($row_count, $offset);                
		$data['result'] =  $this->Trips_model->get_reservation(NULL, $limits);
		
		// Pagination config
		$p_config['base_url']    = site_url('administrator/payment/finance');
		$p_config['uri_segment'] = 4;
		$p_config['num_links']   = 5;
		$p_config['total_rows']  = $query->num_rows();
		$p_config['per_page']    = $row_count;
				
		// Init pagination
		$this->pagination->initialize($p_config);		
		// Create pagination links
		$data['pagination'] = $this->pagination->create_links2();
		
		$data['message_element'] = "administrator/payment/reservation_list";
	 $this->load->view('administrator/admin_template', $data);
	}
	
	function details($param = '')
	{
		$result = $this->db->where('reservation.id',$param)->get('reservation');
		
		if($result->num_rows() !=0 )
		{
	 $conditions              = array("reservation.id" => $param);
		$data['result']          = $row = $this->Trips_model->get_reservation($conditions)->row();
		
		$query                   = $this->Users_model->get_user_by_id($row->userby);
		$data['booker_name']     = $query->row()->username;
		
		$query1                  = $this->Users_model->get_user_by_id($row->userto);
	 $data['hotelier_name']   = $query1->row()->username;
		
		$data['message_element'] = "administrator/payment/view_details";
	 $this->load->view('administrator/admin_template', $data);
		}
		else {
	        redirect_admin('payment/finance');
		}
	}
	
	function toPay()
	{
	  if($this->input->post('payviapaypal'))
			{
	    $list_id          = $this->input->post('list_id');
					$reservation_id   = $this->input->post('reservation_id');
					$amount           = $this->input->post('to_pay');
					$business         = $this->input->post('biz_id');
					
			  $this->paypal_lib->add_field('business', $business);
	    $this->paypal_lib->add_field('return', admin_url('payment/paypal_success'));
	    $this->paypal_lib->add_field('cancel_return', admin_url('payment/paypal_cancel'));
	    $this->paypal_lib->add_field('notify_url', admin_url('payment/paypal_ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', $list_id.'@'.$reservation_id.'@'.$business);
					// Verify return

	    $this->paypal_lib->add_field('item_name', $this->dx_auth->get_site_title().' Admin Transaction');
	    $this->paypal_lib->add_field('item_number', $reservation_id );
	    $this->paypal_lib->add_field('amount', $amount);

	    // if you want an image button use this:
		   $this->paypal_lib->image('button_03.gif');

	   $data['paypal_form'] = $this->paypal_lib->paypal_form();

		  $this->paypal_lib->paypal_auto_form();
			}
			else
			{
	  $this->form_validation->set_error_delimiters('<p style="clear:both;color: #FF0000;">', '</p>');
   if($this->input->post('send'))
			{
			$list_id        = $this->input->post('list_id');
			$reservation_id = $this->input->post('reservation_id');
			
			 $this->form_validation->set_rules('comment','Message','required|trim|xss_clean');
				
			if($this->form_validation->run())
			{	
				$insertData = array(
					'list_id'         => $list_id,
					'reservation_id'  => $reservation_id,
					'userby'          => $this->input->post('userby'),
					'userto'          => $this->input->post('userto'),
					'message'         => $this->input->post('comment'),
					'message_type '   => 3
					);			
		
				$this->Message_model->sentMessage($insertData,1);	
				redirect_admin('payment/details/'.$reservation_id);
			}
			$result = $this->db->where('reservation.id',$reservation_id)->get('reservation');
		
		if($result->num_rows() !=0 )
		{
			$conditions              = array("reservation.id" => $reservation_id);
			$data['result']          = $row = $this->Trips_model->get_reservation($conditions)->row();
			
			$query                   = $this->Users_model->get_user_by_id($row->userby);
			$data['booker_name']     = $query->row()->username;
			
			$query1                  = $this->Users_model->get_user_by_id($row->userto);
			$data['hotelier_name']   = $query1->row()->username;
			
			$data['message_element'] = "administrator/payment/view_details";
			$this->load->view('administrator/admin_template', $data);
			}
			
        else {
	        redirect_admin('payment/finance');
		}
		}
		}
	}
	
	function paypal_ipn()
	{
		if($_REQUEST['payment_status'] == 'Completed')
		{
		$custom              = $_REQUEST['custom'];
		$data                = array();
		$list                = array();
		$data                = explode('@', $custom); 
		
		$list_id             = $data[0];
		$reservation_id      = $data[1];
		$email_id            = $data[2];
		
		$price               = $_REQUEST['mc_gross'];
		
		$result              = $this->Common_model->getTableData( 'reservation',array('id' => $list_id) )->row();
		$checkin             = $result->checkin;
		$checkout            = $result->checkout;
		
		$admin_email         = $this->dx_auth->get_site_sadmin();
		$admin_name          = $this->dx_auth->get_site_title();
		
		$query               = $this->Users_model->get_user_by_id($result->userto);
	 $hotelier_name       = $query->row()->username;
		$hotelier_email      = $query->row()->email;
		
		$list['payed_date']  = date('d-m-Y H:i:s');
		$list['is_payed']    = 1;
		
		 //Reservation Notification To Host
			$email_name = 'admin_payment';
			$splVars = array("{site_name}" => $this->dx_auth->get_site_title(), "{username}" => ucfirst($hotelier_name), "{list_title}" => get_list_by_id($list_id)->title, "{payed_date}}" => $list['payed_date'], "{pay_id}" => $email_id, "{checkin}" => $checkin, "{checkout}" => $checkout, "{payed_price}" => $price);
			//Send Mail
			$this->Email_model->sendMail($hotelier_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
		
		$condition = array("id" => $reservation_id);
		$this->Common_model->updateTableData('reservation', NULL, $condition, $list);
		}
	}
	
	
	function paypal_cancel()
	{
		$data['message_element'] = "administrator/payment/paypal_cancel";
	 $this->load->view('administrator/admin_template', $data);
	}
	
	function paypal_success()
	{
		$data['message_element'] = "administrator/payment/paypal_success";
	 $this->load->view('administrator/admin_template', $data);
	}
	
}
?>
