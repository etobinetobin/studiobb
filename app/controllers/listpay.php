<?php
/**
 * DROPinn Payment List Controller Class
 *
 * helps to achieve payment functionality while adding the list.
 *
 * @package		DROPinn
 * @subpackage	Controllers
 * @category	Pay List
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listpay extends CI_Controller {

	public function Listpay()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('form');
	  
		 
        $this->load->library('Form_validation');
		$this->load->library('email');		
		$this->load->library('form_validation');
		$this->load->library('Paypal_Lib');
		$this->load->library('Twoco_Lib');
		
		$this->load->model('Users_model');
	}
	
	public function index()
 {
	
		$this->form_validation->set_error_delimiters('<p>', '</p>');
		
		if($this->input->post('book_it_button'))
		{
				if($this->input->post('payment_method') == 'cc')
				{
						 $this->submissionCC();
				}
				else if($this->input->post('payment_method') == 'paypal')
				{
				   $this->submission();	
				}
				else if($this->input->post('payment_method') == '2c')
				{
				   $this->submissionTwoc();	
				}
				else
				{
					 	redirect('info');		
				}
		}
		
		$data['id']               = $this->session->userdata('Lid');
		$data['amt']              = $this->session->userdata('amount');
		$data['full_cretids'] = 'off';
		
		$data['result']           = $this->Common_model->getTableData('payments')->result();
		
		$data['title']            = get_meta_details('Payment_Option','title');
		$data["meta_keyword"]     = get_meta_details('Payment_Option','meta_keyword');
		$data["meta_description"] = get_meta_details('Payment_Option','meta_description');
		
		$data['message_element']  = "payments/view_listPay";
		
		$this->load->view('template',$data);
	}
	
	public function submission($param)
	{
	    $list_id = $param;
					
					$row     = $this->Common_model->getTableData('payment_details', array('code' => 'PAYPAL_ID'))->row();
				 
			  $this->paypal_lib->add_field('business', $row->value);
	    $this->paypal_lib->add_field('return', site_url('listpay/list_success/'.$list_id));
	    $this->paypal_lib->add_field('cancel_return', site_url('listpay/list_cancel'));
	    $this->paypal_lib->add_field('notify_url', site_url('listpay/list_ipn')); // <-- IPN url
	    $this->paypal_lib->add_field('custom', $list_id);
					// Verify return
	    $this->paypal_lib->add_field('item_name', $this->dx_auth->get_site_title().' Transaction');
	    $this->paypal_lib->add_field('item_number', $list_id );
					$this->paypal_lib->add_field('currency_code', get_currency_code());
	    $this->paypal_lib->add_field('amount', get_currency_value($this->session->userdata('amount')));

					$this->paypal_lib->image('button_03.gif');
			
					$data['paypal_form'] = $this->paypal_lib->paypal_form();
				
					$this->paypal_lib->paypal_auto_form();		
		
			
	}
	
	public function list_cancel()
	{
	 // redirect('home/addlist','refresh');
	   redirect('rooms/new','refresh');
	}
	
	public function list_ipn()
	{
		if($_REQUEST['payment_status'] == 'Completed')
		{
			
			$data   = explode('@',$custom); 
			$listId         = $data[0];
			$data['status'] = 1;
			$this->db->where('id', $listId);
			$this->db->update('list', $data);
		$query        = $this->Common_model->getTableData( 'list',array('id' => $listId) )->row();
			$list_email        = $query->email; 
			$data['status'] = $list_email;
			$query2 = $this->Common_model->getTableData('users',array('id' => $this->dx_auth->get_user_id()))->row();
		  	$user_email   =	$query2->email;
			$data['status'] = $user_email;					
			$emailsubject = "Host Listing Confirmation";
			$headers = "";
						$headers .= "From: Dropinn Host Listing <gokulnath@cogzidel.com>\r\n";
						$headers .= "MIME-Version: 1.0\n";
						$headers .= "Content-Type: multipart/related; type=\"multipart/alternative\"; boundary=\"----=MIME_BOUNDRY_main_message\"\n"; 
						$headers .= "X-Sender: from_name<" . $user_email . ">\n";
						$headers .= "X-Mailer: PHP4\n";
						$headers .= "X-Priority: 3\n"; //1 = Urgent, 3 = Normal
						$headers .= "Return-Path: <" .$user_email . ">\n"; 
						$emsg = 'You have finished the payment for your listing ';
						mail($list_email, $emailsubject, $emsg,$headers); 		
		
		
		}
	}
	public function payment($param='')
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
	
	  if($this->input->post('payment_method') == 'cc')
			{
			   $this->submissionCC($param);
			}
			else if($this->input->post('payment_method') == 'paypal')
			{
			   
			   $this->submission($param);
			
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
	public function list_success()
	{
	//echo $payment_status 	= $this->input->post('payment_status',true);
		
		//exit;
		
		if($this->input->post('payment_status',true) == 'Completed')
		{
		 $listId         = $this->input->post('custom',true);
		
		$condition           = array('id' => $listId);
		$data['status']     = 1;
		$this->Common_model->updateTableData('list', NULL, $condition,$data);
		//redirect('rooms/edit/'.$listId, 'refresh');
		$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Rooms added successfully.'));
		redirect('rooms/'.$listId, 'refresh');
		}
		else if($this->input->post('payment_status',true) == '')
		{
		 $listId         = $this->uri->segment('3');
	
		$condition           = array('id' => $listId);
		$data['status']     = 1;
		$this->Common_model->updateTableData('list', NULL, $condition,$data);
		//redirect('rooms/edit/'.$listId, 'refresh');
		$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Rooms added successfully.'));
		redirect('rooms/'.$listId, 'refresh');	
		}
		else
		{
			//echo $this->input->post('payment_status',true);
			//exit;
		 //redirect('home/addlist','refresh');
		 redirect('rooms/new','refresh');
		}
	} 
	
	
		public function submissionTwoc($param)
		{
				$list_id = $param;
						
				$row     = $this->Common_model->getTableData('payment_details', array('code' => '2C_VENTOR_ID'))->row();
				
				$this->twoco_lib->addField('sid', $row->value);
				// Specify the order information
				$this->twoco_lib->addField('cart_order_id', rand(1, 100));
				$this->twoco_lib->addField('total', get_currency_value($this->session->userdata('amount')));
				// Specify the url where authorize.net will send the IPN
				$this->twoco_lib->addField('x_Receipt_Link_URL', site_url('listpay/twoC_ipn'));
				$this->twoco_lib->addField('return_url', site_url('listpay/twoC_success'));
				$this->twoco_lib->addField('tco_currency', get_currency_code());
				$this->twoco_lib->addField('merchant_order_id', $list_id);
				
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
				
				$listId         = $this->ipnData['merchant_order_id'];			
				
				$data['status'] = 1;
				$this->db->where('id', $listId);
				$this->db->update('list', $data);
		  redirect('rooms/'.$listId, 'refresh');
		}
		
		public function twoC_success()
		{
		  
				foreach ($_REQUEST as $field=>$value)
				{
								$this->ipnData["$field"] = $value;
				}
				
				$listId         = $this->ipnData['merchant_order_id'];
	   //redirect('rooms/edit/'.$list_id,'refresh');
	    redirect('rooms/'.$list_id,'refresh');
		}
	
		public function submissionCC($param)
	{
	 $this->load->helper('CallerService');

	
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
		$zip 													= urlencode( $this->input->post('zip') );
		$currencyCode 				= get_currency_code();
		$paymentType						=	urlencode('Sale');
		
		$id															= $this->session->userdata('Lid');
		
		$amt														= get_currency_value($id,$this->session->userdata('amount'));
		
		if($creditCardType == "" || $creditCardNumber == "")
		{
		$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('error','Sorry! Access denied.'));
		redirect('rooms/new', "refresh");
		}
		
	$nvpstr			=	"&PAYMENTACTION=$paymentType&AMT=$amt&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=".$padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";
	
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
	$data['status'] = 1;
	$this->db->where('id', $id);
	$this->db->update('list', $data);
	
	$this->session->set_flashdata('flash_message', $this->Common_model->flash_message('success','Your payment completed successfully.'));
	redirect('rooms/edit/'.$id, "refresh");
	}
		
	}

}

/* End of file listpay.php */
/* Location: ./app/controllers/listpay.php */
?>