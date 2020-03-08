<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
        $this->load->model('login_model');
    }


    public function index(){
        check_login_user_or_no();
        $data = array();
        $data['page'] = 'Login';
        $this->load->view('login', $data);
    }


    public function log(){

        if($_POST){ 
            $query = $this->login_model->validate_user();
            
            //-- if valid
            if($query){
                $data = array();
                foreach($query as $row){
                    $data = array(
                        'id' => $row->id,
                        'name' => $row->first_name,
                        'email' =>$row->email,
                        'role' =>$row->role,
                        'mobile' =>$row->mobile,
                        'membership' =>$row->user_membership,
                        'expiremembership' =>$row->user_mem_expire,
                        'is_login' => TRUE
                    );
                    $this->session->set_userdata($data);
                    $url = base_url('signup');
                }
                $this->session->set_flashdata('msg', 'Login Successfully');
                redirect(base_url('admin/dashboard'));
            }else{
                $this->session->set_flashdata('error_msg', 'Sorry Username or password is wrong or Please verify account.'.$this->input->post('user_name').'/'.md5($this->input->post('password')));
                redirect(base_url('login'));
            }
            
        }else{
            $data = array();
            $data['page'] = 'Login';
            $this->load->view('login',$data);
        }
    }

    
    function logout(){
        $this->session->sess_destroy();
        $data = array();
        $data['page'] = 'logout';
        $this->load->view('login', $data);
    }
    function reset($id){
        check_login_user_or_no();
        $dbdate = $this->common_model->check_reset_expire($id)[0]->resettime;
        $current = time();
        $tomorrow = date('Y-m-d H:i:s', strtotime($dbdate . ' +1 day'));
        $tomorrowstring = strtotime($tomorrow);
        if ($current > $tomorrowstring) {
            $this->session->set_flashdata('error_msg', 'Sorry! Reset link is expired.');
            redirect(base_url('login'));
        } else {
            if(isset($_POST['resetpassword'])) {

              $data = array(
                'password' => md5($_POST['password']),
                'resetnumber' => '',
                'resettime' => ''
              );
              $this->common_model->edit_option($data, $id, 'user', 'resetnumber');
                $this->session->set_flashdata('msg', 'Your password is updated Successfully!');
                redirect(base_url('login'));
            }
            $data = array();
            $data['getid'] = $id;
            $data['page'] = 'Reset Password';
            $this->load->view('reset', $data);
        }
    }
    
    function forget(){
        // check_login_user_no_developer();
        $data = array();
        if(isset($_POST['resetpass'])){ 
            
            $this->load->library('form_validation'); 
            $this->form_validation->set_error_delimiters('', '');       
            $this->form_validation->set_rules('forgetemail', 'Email', 'required');


            if ($this->form_validation->run() == TRUE)
            {

                $email = $this->common_model->check_email($_POST['forgetemail']);
                if (empty($email)) {

                    $this->session->set_flashdata('error_msg', 'Sorry! Email is not register with us.');
                    redirect(base_url('login'));
                } else {

                    $gethtmlmail = $this->common_model->get_signup_mail("reset");
                    $resetnumber = $email[0]->password.time();
                    $resettime = date("Y-m-d h:I",time());

                    $data = array(
                        'resetnumber' => $resetnumber,
                        'resettime' => $resettime
                    );
                    $data = $this->security->xss_clean($data);
                    $this->common_model->edit_option($data, $email[0]->id, 'user');

                    $reseturl = 'https://storecreator.io/login/reset/'.$resetnumber;
                    $completemail = str_replace("{{reseturl}}",$reseturl,$gethtmlmail->newslettermail);
                    $this->load->library('email'); 
                    $this->email->from('storecreator.io@gmail.com', 'Storecreator');
                    $this->email->to($_POST['forgetemail'],'Recipient Name');
                    $this->email->subject($gethtmlmail->newslettersubject);
                    $this->email->message($completemail); 
                    try{
                    $this->email->send();
                    }catch(Exception $e){
                    }

                    $this->session->set_flashdata('msg', 'Please check your mail.');
                    redirect(base_url('login'));
                }
                    
            } else {
                $this->session->set_flashdata('error_msg', validation_errors());
                redirect(base_url('login'));
            }

        }
    }


}