<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * PayPal_Lib Controller Class (Paypal IPN Class)
 *
 * This CI library is based on the Paypal PHP class by Micah Carrick
 * See www.micahcarrick.com for the most recent version of this class
 * along with any applicable sample files and other documentaion.
 *
 * This file provides a neat and simple method to interface with paypal and
 * The paypal Instant Payment Notification (IPN) interface.  This file is
 * NOT intended to make the paypal integration "plug 'n' play". It still
 * requires the developer (that should be you) to understand the paypal
 * process and know the variables you want/need to pass to paypal to
 * achieve what you want.  
 *
 * This class handles the submission of an order to paypal as well as the
 * processing an Instant Payment Notification.
 * This class enables you to mark points and calculate the time difference
 * between them.  Memory consumption can also be displayed.
 *
 * The class requires the use of the PayPal_Lib config file.
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Commerce
 * @author      Ran Aroussi <ran@aroussi.com>
 * @copyright   Copyright (c) 2006, http://aroussi.com/ci/
 *
 */

// ------------------------------------------------------------------------

class Paypal_Lib {

	var $last_error;			// holds the last error encountered
	var $ipn_log;				// bool: log IPN results to text file?

	var $ipn_log_file;			// filename of the IPN log
	var $ipn_response;			// holds the IPN response from paypal	
	var $ipn_data = array();	// array contains the POST values for IPN
	var $fields = array();		// array holds the fields to submit to paypal

	var $submit_btn = '';		// Image/Form button
	var $button_path = '';		// The path of the buttons
	
	var $CI;
	
	function Paypal_Lib()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->helper('form');
		$this->CI->load->config('paypallib_config');
		
		//Check is paypal live?
		$is_live     = $this->CI->db->get_where('payments', array('id' => 2))->row()->is_live;
		
		if($is_live == 1)
		$this->paypal_url = 'https://www.paypal.com/cgi-bin';
		else
		$this->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		
		$this->last_error = '';
		$this->ipn_response = '';

		$this->ipn_log_file = $this->CI->config->item('paypal_lib_ipn_log_file');
		$this->ipn_log = $this->CI->config->item('paypal_lib_ipn_log'); 
		
		$this->button_path = $this->CI->config->item('paypal_lib_button_path');
		
		// populate $fields array with a few default values.  See the paypal
		// documentation for a list of fields and their data types. These defaul
		// values can be overwritten by the calling script.
		$this->add_field('rm','2');			  // Return method = POST
		$this->add_field('cmd','_xclick');

		$this->add_field('currency_code', $this->CI->config->item('paypal_lib_currency_code'));
	    $this->add_field('quantity', '1');
		$this->button('Pay Now!');
	}

	function button($value)
	{
		// changes the default caption of the submit button
		$this->submit_btn = form_submit('pp_submit', $value);
	}

	function image($file)
	{
		$this->submit_btn = '<input type="image" name="add" src="' . site_url($this->button_path .'/'. $file) . '" border="0" />';
	}


	function add_field($field, $value) 
	{
		// adds a key=>value pair to the fields array, which is what will be 
		// sent to paypal as POST variables.  If the value is already in the 
		// array, it will be overwritten.
		$this->fields[$field] = $value;
	}

	function paypal_auto_form() 
	{
		// this function actually generates an entire HTML page consisting of
		// a form with hidden elements which is submitted to paypal via the 
		// BODY element's onLoad attribute.  We do this so that you can validate
		// any POST vars from you custom form before submitting to paypal.  So 
		// basically, you'll have your own form which is submitted to your script
		// to validate the data, which in turn calls this function to create
		// another hidden form and submit to paypal.

		$this->button('Click here if you\'re not automatically redirected...');

		echo '<html>' . "\n";
		echo '<head><title>Processing Payment...</title></head>' . "\n";
		echo '<body onLoad="document.forms[\'paypal_auto_form\'].submit();">' . "\n";
		echo '<p>Please wait, your order is being processed and you will be redirected to the paypal website.</p>' . "\n";
		echo $this->process123('paypal_auto_form');
		echo '</body></html>';
	}

	function paypal_form($form_name='paypal_form') 
	{
		$str = '';
		$str .= '<form method="post" action="'.$this->paypal_url.'" name="'.$form_name.'"/>' . "\n";
		foreach ($this->fields as $name => $value)
			$str .= form_hidden($name, $value) . "\n";
		$str .= '<p>'. $this->submit_btn . '</p>';
		$str .= form_close() . "\n";

		return $str;
	}
	
	function validate_ipn()
	{
		// parse the paypal URL
		$url_parsed = parse_url($this->paypal_url);		  

		// generate the post string from the _POST vars aswell as load the
		// _POST vars into an arry so we can play with them from the calling
		// script.
		$post_string = '';	 
	
	//Changed according to WIKI
		if (isset($_POST))
	        {
            foreach ($_POST as $field=>$value)
            {       // str_replace("\n", "\r\n", $value)
                    // put line feeds back to CR+LF as that's how PayPal sends them out
                    // otherwise multi-line data will be rejected as INVALID

                $value = str_replace("\n", "\r\n", $value);
                $this->ipn_data[$field] = $value;
                $post_string .= $field.'='.urlencode(stripslashes($value)).'&';

            }
        }  
		
		$post_string.="cmd=_notify-validate"; // append ipn command

		// open the connection to paypal
		/*//Changing this portion of code to change 
		$fp = fsockopen($url_parsed['host'],"80",$err_num,$err_str,30);
		*/

		$fp = fsockopen('ssl://www.sandbox.paypal.com',443,$err_num,$err_str,30);
		
		if(!$fp)
		{
			// could not open the connection.  If loggin is on, the error message
			// will be in the log.
			$this->last_error = "fsockopen error no. $errnum: $errstr";
			$this->log_ipn_results(false);		 
			return false;
		} 
		else
		{ 
			// Post the data back to paypal
			fputs($fp, "POST $url_parsed[path] HTTP/1.1\r\n"); 
			fputs($fp, "Host: $url_parsed[host]\r\n"); 
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n"); 
			fputs($fp, "Content-length: ".strlen($post_string)."\r\n"); 
			fputs($fp, "Connection: close\r\n\r\n"); 
			fputs($fp, $post_string . "\r\n\r\n"); 

			// loop through the response from the server and append to variable
			while(!feof($fp))
				$this->ipn_response .= fgets($fp, 1024); 

			fclose($fp); // close connection
		}

		if (eregi("VERIFIED",$this->ipn_response))
		{
			// Valid IPN transaction.
			$this->log_ipn_results(true);
			return true;		 
		} 
		else 
		{
			// Invalid IPN transaction.  Check the log for details.
			$this->last_error = 'IPN Validation Failed.';
			$this->log_ipn_results(false);	
			return false;
		}
	}

	function log_ipn_results($success) 
	{
		if (!$this->ipn_log) return;  // is logging turned off?

		// Timestamp
		$text = '['.date('m/d/Y g:i A').'] - '; 

		// Success or failure being logged?
		if ($success) $text .= "SUCCESS!\n";
		else $text .= 'FAIL: '.$this->last_error."\n";

		// Log the POST variables
		$text .= "IPN POST Vars from Paypal:\n";
		foreach ($this->ipn_data as $key=>$value)
			$text .= "$key=$value, ";

		// Log the response from the paypal server
		$text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;

		//Writing to logs have now been disabled
		/* Write to log
		$fp=fopen($this->ipn_log_file,'a');
		fwrite($fp, $text . "\n\n"); 

		fclose($fp);  // close file*/
	}


	function dump() 
	{
		// Used for debugging, this function will output all the field/value pairs
		// that are currently defined in the instance of the class using the
		// add_field() function.

		ksort($this->fields);
		echo '<h2>ppal->dump() Output:</h2>' . "\n";
		echo '<code style="font: 12px Monaco, \'Courier New\', Verdana, Sans-serif;  background: #f9f9f9; border: 1px solid #D0D0D0; color: #002166; display: block; margin: 14px 0; padding: 12px 10px;">' . "\n";
		foreach ($this->fields as $key => $value) echo '<strong>'. $key .'</strong>:	'. urldecode($value) .'<br/>';
		echo "</code>\n";
	}

public function process123(){
		//if($_POST){
				
			$ItemName = $this->fields['item_name']; //Item Name
			$ItemPrice = $this->fields['amount']; //Item Price
			$ItemNumber = $this->fields['item_number']; //Item Number
			$ItemQty = 1; // Item Quantity
			$ItemTotalPrice = ($ItemPrice*$ItemQty); //(Item Price x Quantity = Total) Get total amount of product; 
			
			$item_cancel= $this->fields['cancel_return'];
			
			$item_return= $this->fields['return'];
			
			$item_business = $this->fields['business'];
			
			$paymode = $this->fields['paymode'];
			
			if($paymode==0){
			
				$PayPalMode 			= 'sandbox'; // sandbox or live
				
			}
			if($paymode==1){
				
				$PayPalMode 			= 'live'; // sandbox or live
			}
			
			
			$PayPalApiUsername 		= $this->fields['api_user']; //PayPal API Username
			
			$PayPalApiPassword 		= $this->fields['api_pwd']; //Paypal API password
			
			$PayPalApiSignature 	= $this->fields['api_key']; //Paypal API Signature
			
			$PayPalCurrencyCode 	= $this->fields['currency_code']; //Paypal Currency Code
			
			$PayPalReturnURL 		= $item_return; //Point to process.php page
			
			$PayPalCancelURL 		= $item_cancel;//Cancel URL if user clicks cancel
		
			//Data to be sent to paypal
			$padata = 	'&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
						'&PAYMENTACTION=Sale'.
						'&ALLOWNOTE=1'.
						'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
						'&PAYMENTREQUEST_0_AMT='.urlencode($ItemTotalPrice).
						'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice). 
						'&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
						'&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
						'&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
						'&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemNumber).
						
						'&L_PAYMENTREQUEST_0_BUSINESS0='.urlencode($item_business).
						'&AMT='.urlencode($ItemTotalPrice).				
						'&RETURNURL='.urlencode($PayPalReturnURL ).
						'&CANCELURL='.urlencode($PayPalCancelURL);	
				
		$httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
				
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
					
				// If successful set some session variable we need later when user is redirected back to page from paypal. 
				$_SESSION['itemprice'] =  $ItemPrice;
				$_SESSION['totalamount'] = $ItemTotalPrice;
				$_SESSION['itemName'] =  $ItemName;
				$_SESSION['itemNo'] =  $ItemNumber;
				$_SESSION['itemQTY'] =  $ItemQty;
				
				if($PayPalMode=='sandbox'){
					$paypalmode 	=	'.sandbox';
				}
				else{
					$paypalmode 	=	'';
				}
				//Redirect user to PayPal store with Token received.
			 	$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
				header('Location: '.$paypalurl);
			 
		}
		else{
			//Show error message
			echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
			echo '<pre>';
			print_r($httpParsedResponseAr);
			echo '</pre>';
		}
	}

public function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode){
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

}

?>