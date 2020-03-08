<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
    }


    public function index()
    {

        check_login_user_or_no();
        $data = array();
        $data['page_title'] = 'Signup';
        $this->load->view('signup', $data);
        if ($_POST) {
            $verifylink = md5($_POST['password']).time();
            $d = new DateTime("14 day");
            $expirydate = $d->format( 'm/d/Y' );
            $data = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => md5($_POST['password']),
                'status' => 1,
                'role' => 'user',
                'verifylink' => $verifylink,
                'user_membership' => '1',
                'user_mem_expire' => $expirydate,
                'verify' => '1',
                'suspend' => '1',
                'created_at' => current_datetime()
            );

            $data = $this->security->xss_clean($data);
            
            //-- check duplicate email
            $email = $this->common_model->check_email($_POST['email']);

            if (empty($email)) {
                $user_id = $this->common_model->insert($data, 'user');
            
                if ($this->input->post('role') == "user") {
                    $actions = $this->input->post('role_action');
                    foreach ($actions as $value) {
                        $role_data = array(
                            'user_id' => $user_id,
                            'action' => $value
                        ); 
                       $role_data = $this->security->xss_clean($role_data);
                       $this->common_model->insert($role_data, 'user_role');
                    }
                }
                // Admin send mail notificaiton for new user

                //Code to send email...
                $gethtmlmail = $this->common_model->get_signup_mail("adminnewuseralert");
                $completemail = str_replace(
                    array("{{email}}","{{name}}"),
                    array($_POST['email'], $_POST['first_name']." ".$_POST['last_name']),
                    $gethtmlmail->newslettermail
                );
                $this->load->library('email'); 
                $this->email->from('noreply@storecreator.io', 'Storecreator');
                $this->email->to('storecreator.io@gmail.com','Recipient Name');
                $this->email->subject($gethtmlmail->newslettersubject);
                $this->email->message($completemail); 
                try{
                $this->email->send();
                }catch(Exception $e){
                echo $e->getMessage();
                }
                $verifylinkhtml = "<a href='https://storecreator.io/signup/verify/".$verifylink."'>https://storecreator.io/signup/verify/".$verifylink."</a>";

                //Verify user
                $gethtmlmail = $this->common_model->get_signup_mail("verifyuser");
                $completemail = str_replace(
                    array("{{verifylink}}"),
                    array($verifylinkhtml),
                    $gethtmlmail->newslettermail
                );
                $this->load->library('email'); 
                $this->email->from('storecreator.io@gmail.com', 'Storecreator');
                $this->email->to($_POST['email'],'Recipient Name');
                $this->email->subject($gethtmlmail->newslettersubject);
                $this->email->message($completemail); 
                try{
                    $this->email->send();
                }catch(Exception $e){
                    echo $e->getMessage();
                }
                

                $this->session->set_flashdata('msg', 'User added Successfully');
                redirect(base_url('login'));

            } else {
                $this->session->set_flashdata('error_msg', 'Email already exist, try another email');
                redirect(base_url('signup'));
            }
            

        }
    }
    public function verify($id){
        $checkverifylink = $this->common_model->check_verify_id($id);
        if(is_array($checkverifylink)) {
            if($checkverifylink[0]->verify == '1') {
                $data = array(
                    'verify' => '2'
                );
                $data = $this->security->xss_clean($data);
                $this->common_model->edit_option($data, $checkverifylink[0]->id, 'user');

                //Code to send email...
                $gethtmlmail = $this->common_model->get_signup_mail("signup");
                $completemail = str_replace(
                    array("{{email}}","{{name}}"),
                    array($checkverifylink[0]->email, $checkverifylink[0]->first_name." ".$checkverifylink[0]->last_name),
                    $gethtmlmail->newslettermail
                );
                $this->load->library('email'); 
                $this->email->from('storecreator.io@gmail.com', 'Storecreator');
                $this->email->to($checkverifylink[0]->email,'Recipient Name');
                $this->email->subject($gethtmlmail->newslettersubject);
                $this->email->message($completemail); 
                try{
                    $this->email->send();
                }catch(Exception $e){
                    echo $e->getMessage();
                }
                /*****************************/   
                $this->session->set_flashdata('msg', 'Verify Successfully! ');
                redirect(base_url('login'));
            } else {
                $this->session->set_flashdata('error_msg', 'Sorry, user is already verify.');
                redirect(base_url('login'));
            }
        } else {
            $this->session->set_flashdata('error_msg', 'Sorry you are on wrong page.');
            redirect(base_url('signup'));
        }
    }
	
    public function subscribe(){
		 if ($_POST) {
				
            $data = array(
                'subscriberemail' => $_POST['subs_email'],
            );
			
			$data = $this->security->xss_clean($data);
			$email = $this->common_model->check_subscriber_email($_POST['subs_email']);
			 if (empty($email)) {
				$this->common_model->insert($data, 'code_subscriber');
				$this->session->set_flashdata('msg', 'Subscribed Successfully');
                redirect(base_url('home'));
			}else{
				$this->session->set_flashdata('error_msg', 'Email already subscribed, try another email');
                redirect(base_url('home'));
			}
		}else{
			$this->session->set_flashdata('error_msg', 'Please input your email address for subscription');
             redirect(base_url('home'));
		}
	}
}