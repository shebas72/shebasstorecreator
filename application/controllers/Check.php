<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
     public function __construct(){
        parent::__construct();
       check_login_user();
       $this->load->model('common_model');
       $this->load->model('login_model');
       $this->load->database();
    }

    
    public function index()
    {

        $this->load->view('check');
    }
       

    public function package($id){
        if(!$id){
            redirect(base_url("pricing"));
        }
        $data['id'] = $id;
        $data['selected_packages'] =  $this->db->get_where('code_packages', array('packageid' => $id))->result_array();
        $data['packages'] = $this->common_model->get_all_packages();
        $data['country'] = $this->common_model->get_countryName();

        $this->load->view('check',$data);
    }
    public function confirmOrder(){
        $paymentType = $this->input->post('payment_type');      
    }
    public function paypalipn(){
            $data = array(
                'first_name' => "Paypal"
            );
            $user_id = $this->common_model->insert($data, 'user');
        $this->load->view('paypalipn');
    }
    public function cancel(){
        $this->load->view('cancel');
    }
     public function success()
    {
        $data = array();

        $ci =& get_instance();
        $data['currenctexpiry'] =  $this->db->get_where('user', array('id' => $ci->session->userdata('id')))->result_array();
        
        $data['gethtmlmail'] = $this->common_model->get_signup_mail("membership");
        $this->load->view('success', $data);
    }
    public function verify_payment($refId){
    }
}
