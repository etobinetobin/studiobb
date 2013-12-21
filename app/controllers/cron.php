<?php
/**
 * DROPinn Trips Controller Class
 *
 * Helps to control the trips functionality
 *
 * @package		Dropinn
 * @subpackage	Controllers
 * @category	Trips
 * @author		Cogzidel Product Team
 * @version		Version 1.6
 * @link		http://www.cogzidel.com
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function Cron()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('cookie');
		
		$this->load->library('Form_validation');
		
		$this->load->model('Users_model'); 
		$this->load->model('Email_model');
		$this->load->model('Message_model');
		$this->load->model('Trips_model');
		
		$this->facebook_lib->enable_debug(TRUE);
	}
	
	public function expire()
	{
			
			
			$sql="select *from reservation";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			$date=date("F j, Y, g:i a");
			$date=get_gmt_time(strtotime($date));
			
			foreach($res as $reservation)
			{
				$timestamp=$reservation['book_date'];
				$book_date=date("F j, Y, g:i a",$timestamp);
				$book_date=strtotime($book_date);
			    $gmtTime   = get_gmt_time(strtotime('+1 day',$timestamp));
				
				if($gmtTime<=$date && $reservation['status']==1)		
				{
					$reservation_id    = $reservation['id'];
					$admin_email 	   = $this->dx_auth->get_site_sadmin();
	 				$admin_name  						= $this->dx_auth->get_site_title();
					$conditions    				= array('reservation.id' => $reservation_id);
					$row           				= $this->Trips_model->get_reservation($conditions)->row();
					$query1     				= $this->Users_model->get_user_by_id($row->userby);
					$traveler_name 				= $query1->row()->username;
					$traveler_email 			= $query1->row()->email;
		
					$query2     						 = $this->Users_model->get_user_by_id($row->userto);
					$host_name 								= $query2->row()->username;
					$host_email 							= $query2->row()->email;
		
					$list_title        = $this->Common_model->getTableData('list', array('id' => $row->list_id))->row()->title;
				 
					$updateKey      		  = array('id' => $reservation_id);
					$updateData               = array();
					$updateData['status ']    = 2;
					$this->Trips_model->update_reservation($updateKey,$updateData);
					
					//Send Mail To Traveller
					$email_name = 'traveler_reservation_expire';
					$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($traveler_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
		
					//Send Mail To Host
					$email_name = 'host_reservation_expire';
					$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($host_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);		
				
					//Send Mail To Administrator
					$email_name = 'admin_reservation_expire';
					$splVars    = array("{site_name}" => $this->dx_auth->get_site_title(), "{traveler_name}" => ucfirst($traveler_name), "{list_title}" => $list_title,  "{host_name}" => ucfirst($host_name));
					$this->Email_model->sendMail($admin_email,$admin_email,ucfirst($admin_name),$email_name,$splVars);
		
				}
				
			}		
			
	}

	public function unlink_thumb()
	{
			foreach(glob('/opt/lampp/htdocs/dropinn-1.6.6/files/cache/*.*') as $file)
    		if(is_file($file))
        	@unlink($file);	
	}

	
}
