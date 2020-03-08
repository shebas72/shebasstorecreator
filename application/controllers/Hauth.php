<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hauth Controller Class
 */
class Hauth extends CI_Controller {

  /**
   * {@inheritdoc}
   */
  public function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
    $this->load->library('hybridauth');
    $this->load->model('common_model');
    $this->load->model('login_model');
  }

  /**
   * {@inheritdoc}
   */
  public function index()
  {
    // Build a list of enabled providers.
    $providers = array();
    foreach ($this->hybridauth->HA->getProviders() as $provider_id => $params)
    {
      $providers[] = anchor("hauth/window/{$provider_id}", $provider_id);
    }

    $this->load->view('hauth/login_widget', array(
      'providers' => $providers,
    ));
  }

  /**
   * Try to authenticate the user with a given provider
   *
   * @param string $provider_id Define provider to login
   */
  public function window($provider_id)
  {
    $params = array(
      'hauth_return_to' => site_url("hauth/window/{$provider_id}"),
    );
    if (isset($_REQUEST['openid_identifier']))
    {
      $params['openid_identifier'] = $_REQUEST['openid_identifier'];
    }
    try
    {
      $adapter = $this->hybridauth->HA->authenticate($provider_id, $params);
      $profile = $adapter->getUserProfile();

      $data = array(
          'first_name' => $profile->firstName,
          'last_name' => $profile->lastName,
          'email' => $profile->email,
          'password' => md5($profile->identifier),
          'status' => 1,
          'role' => 'user',
          'avatar' => $profile->photoURL,
          'created_at' => current_datetime()
      );

      $data = $this->security->xss_clean($data);
      
      //-- check duplicate email
      $email = $this->common_model->check_email($profile->email);

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
          redirect(base_url('login'));
      }
      else {
        $_POST['user_name'] = $profile->email;
        $_POST['password'] = $profile->identifier;
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
                    'is_login' => TRUE
                );
                $this->session->set_userdata($data);
                $url = base_url('signup');
            }
            $this->session->set_flashdata('msg', 'Login Successfully');
            redirect(base_url('admin/dashboard'));
        }
      }

      // $this->load->view('hauth/done', array(
      //   'profile' => $profile,
      // ));
    }
    catch (Exception $e)
    {
      show_error($e->getMessage());
    }
  }

  /**
   * Handle the OpenID and OAuth endpoint
   */
  public function endpoint()
  {
    $this->hybridauth->process();
  }

}
