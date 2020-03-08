<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
        parent::__construct();
        check_login_user_admin();
       $this->load->model('common_model');
       $this->load->model('login_model');
        $this->load->library('upload');
       $this->load->library('session');
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'User';
        $data['country'] = $this->common_model->select('country');
        $data['main_content'] = $this->load->view('admin/user/add', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- add new user by admin
    public function add()
    {   
        if ($_POST) {

            $data = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => md5($_POST['password']),
                'mobile' => $_POST['mobile'],
                'country' => $_POST['country'],
                'status' => $_POST['status'],
                'role' => $_POST['role'],
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
                $this->session->set_flashdata('msg', 'User added Successfully');
                redirect(base_url('admin/user/all_user_list'));
            } else {
                $this->session->set_flashdata('error_msg', 'Email already exist, try another email');
                redirect(base_url('admin/user'));
            }
            
            
            

        }
    }

    public function all_user_list()
    {
        $data['users'] = $this->common_model->get_all_user();
        $data['country'] = $this->common_model->select('country');
        $data['count'] = $this->common_model->get_user_total();
        $data['main_content'] = $this->load->view('admin/user/users', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //-- update users info
    public function update($id)
    {
        if ($_POST) {

            if(!empty($_FILES['avatar']['name'])){

                $imageData = $this->common_model->upload_image('92000','avatar');
                $data = array(
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'mobile' => $_POST['mobile'],
                    'country' => $_POST['country'],
                    'user_membership' => $_POST['package'],
                    'user_mem_expire' => $_POST['packageexpiry'],
                    'country' => $_POST['country'],
                    'avatar' => $imageData['images'],
                    'suspend' => $_POST['suspend'],
                    'verify' => $_POST['verify']
                );


            } else {
                $data = array(
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'mobile' => $_POST['mobile'],
                    'country' => $_POST['country'],
                    'user_membership' => $_POST['package'],
                    'user_mem_expire' => $_POST['packageexpiry'],
                    'country' => $_POST['country'],
                    'suspend' => $_POST['suspend'],
                    'verify' => $_POST['verify']
                );
            }
            $data = $this->security->xss_clean($data);

            $this->common_model->edit_option($data, $id, 'user');
            $this->session->set_flashdata('msg', 'Information Updated Successfully');
            redirect(base_url('admin/user/all_user_list'));

        }

        $data['user'] = $this->common_model->get_single_user_info($id);
        $data['country'] = $this->common_model->select('country');
        $data['packagelists'] = $this->common_model->get_all_packages();
        $data['main_content'] = $this->load->view('admin/user/edit_user', $data, TRUE);
        $this->load->view('admin/index', $data);
        
    }

    
    //-- active user
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'user');
        $this->session->set_flashdata('msg', 'User active Successfully');
        redirect(base_url('admin/user/all_user_list'));
    }

    //-- deactive user
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'user');
        $this->session->set_flashdata('msg', 'User deactive Successfully');
        redirect(base_url('admin/user/all_user_list'));
    }

    //-- delete user
    public function delete($id)
    {
        $this->common_model->delete($id,'user'); 
        $this->session->set_flashdata('msg', 'User deleted Successfully');
        redirect(base_url('admin/user/all_user_list'));
    }

    //-- Edit profile
    public function profile(){
        $id = $this->session->userdata('id');
        $data['user'] = $this->common_model->get_single_user_info($id);
        //$data['user_role'] = $this->common_model->get_user_role($id);
        $data['country'] = $this->common_model->select('country');
        $data['main_content'] = $this->load->view('admin/user/edit_user', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

}