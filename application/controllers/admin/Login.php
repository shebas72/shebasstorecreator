<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('login_model');
    }


    public function index(){
        check_login_user_or_no();
        $data = array();
        $data['page'] = 'Login';
        $this->load->view('admin/login', $data);
    }


    public function log(){
        check_login_user_or_no();

        if($_POST){ 
            $query = $this->login_model->validate_admin();
            
            //-- if valid
            if($query){
                $data = array();
                foreach($query as $row){
                    $data = array(
                        'id' => $row->id,
                        'name' => $row->first_name,
                        'email' =>$row->email,
                        'mobile' =>$row->mobile,
                        'role' =>$row->role,
                        'membership' =>$row->user_membership,
                        'expiremembership' =>$row->user_mem_expire,
                        'avatar' =>$row->avatar,
                        'is_login' => TRUE
                    );
                    $this->session->set_userdata($data);
                    $url = base_url('admin/dashboard');
                }
                echo json_encode(array('st'=>1,'url'=> $url)); //--success
            }else{
                echo json_encode(array('st'=>0)); //-- error
            }
            
        }else{
            $data = array();
            $data['page'] = 'Login';
            $this->load->view('admin/login',$data);
        }
    }


    
    function logout(){
        $this->session->sess_destroy();
        $data = array();
        $data['page'] = 'logout';
        $this->load->view('admin/login', $data);
    }

}