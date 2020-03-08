<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createstore extends CI_Controller {

    public function __construct(){
        parent::__construct();
       $this->load->model('common_model');
        $this->load->model('login_model');
        check_login_user();
        check_if_user_member();
        check_membership();
    }


    public function index()
    {
            $ci =& get_instance();
            $data = array();
            $data['page_title'] = 'Create Store';
            $data['domaincategory'] = $this->common_model->get_all_domain_category();
            $data['totaldomainlist'] = count($this->common_model->get_all_domain_user($ci->session->userdata('id')));
            $data['perpage'] = 10;
            $data['update_subscription'] = $this->common_model->update_subscription();
            $data['domainlist'] = $this->common_model->get_all_domain_user_pagination($ci->session->userdata('id'),$data['perpage']);

            $this->load->view('account', $data);
    }

    public function upgrade($id = NULL){
            $ci =& get_instance();
            $data = array();
            $data['page_title'] = 'Create Store';
            $data['domaincategory'] = $this->common_model->get_all_domain_category();
            $data['totaldomainlist'] = count($this->common_model->get_all_domain_user($ci->session->userdata('id')));
            $data['perpage'] = 10;
            $data['update_subscription'] = $this->common_model->update_subscription();
            $data['domainlist'] = $this->common_model->get_all_domain_user_pagination($ci->session->userdata('id'),$data['perpage']);
            $data['singledomaininfo'] = $this->common_model->get_single_domain_info($id);


            $this->load->view('accountupgrade', $data);
    }

    public function checkdomain($id = NULL){
        if($id != NULL) {
            $domainavailable = $this->common_model->check_if_domain($id.".storecreator.io");
            if(is_object($domainavailable)) {
                echo "<span style='color:red;'>".$id.".storecreator.io is not available</span>";
            } else {
                echo "<span style='color:green;'>".$id.".storecreator.io is available</span>";
            }
        }
        else {
            echo "<span style='color:green;'>Loading</span>";
        }
    }
    public function checkfulldomain($id = NULL){
        $postdomainlinkdomain = strtolower(preg_replace("/[^-.a-z0-9]*/", "", $id));
        $domain = $postdomainlinkdomain;

        //$domain = 'alvinbrownz.com';
        // see GoDaddy API documentation - https://developer.godaddy.com/doc
        // url to check domain availability

        $url = "https://api.godaddy.com/v1/domains/available?domain=".$domain;

        // set your key and secret
        $header = array(
            'Authorization: sso-key 9u9NjPGbgSB_7hXEyfUt9P24cXmDpCHacT:7hXLmLAukgM7iKF4CyU1bq'
        );

        //open connection
        $ch = curl_init();
        $timeout=60;

        //set the url and other options for curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); // Values: GET, POST, PUT, DELETE, PATCH, UPDATE 
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $variable);
        //curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        //execute call and return response data.
        $result = curl_exec($ch);

        //close curl connection
        curl_close($ch);

        // decode the json response
        $dn = json_decode($result, true);
        if(isset($dn['code'])) {
            if($dn['code'] == 'UNSUPPORTED_TLD') {
                echo "<span style='color:red;'>Invalid tld error: No config for ".$id."</span>";
            }
            if($dn['code'] == 'INVALID_BODY') {
                echo "<span style='color:red;'>Please complete the domain name ".$id." is look like incomplete domain name.</span>";
            }
        } elseif (isset($dn['available'])) {
            if($dn['available'] == '1') { 
                echo "<span style='color:green;'>Congratulation! This domain is available.".$id."<br>Please buy domain from <a href='https://pk.godaddy.com/domainsearch/find?domainToCheck=".$id."'>Godaddy</a> and change point nameserver to<br>
                    ns1.storecreator.io<br>
                    ns2.storecreator.io</span>";
            } else {
                echo "<span style='color:green;'>Sorry ".$id." is already purchase.. If you have this domain already than<br>change point nameserver to<br>
                    ns1.storecreator.io<br>
                    ns2.storecreator.io</span>";
            }
        }
        // print_r($dn);
    }
    public function page($id = NULL)
    {
        $ci =& get_instance();
        $data = array();
        $data['page_title'] = 'Create Store';
        $data['domaincategory'] = $this->common_model->get_all_domain_category();
        $data['totaldomainlist'] = count($this->common_model->get_all_domain_user($ci->session->userdata('id')));
        $data['perpage'] = 10;
        $data['pageid'] = $id;
        $data['temp'] =  $data['pageid'] - 1;
        $data['pageoffset'] = $data['temp'] * $data['perpage'];
        $data['domainlist'] = $this->common_model->get_all_domain_user_pagination($ci->session->userdata('id'),$data['perpage'],$data['pageoffset']);
        $this->load->view('account', $data);
    }
    

    // public function edit($id)
    // {
    //     $ci =& get_instance();
    //     $data = array();
    //     $data['page_title'] = 'Edit Store';
    //     $data['domaincategory'] = $this->common_model->get_all_domain_category();
    //     $data['domainlist'] = $this->common_model->get_all_domain_user($ci->session->userdata('id'));
    //     $data['editdomain'] = $this->common_model->get_single_domain_info($id);
    //     $this->load->view('account', $data);
    // }
    public function delete($id = NULL)
    {

        // REMOVE 

        $data['domaininfo'] = $this->common_model->get_single_domain_info($id);


        $domainname = $data['domaininfo']->domainlink;
        $sqlsentex = $data['domaininfo']->sqlsentex;
        $domainfolder = str_replace('.', '', $domainname); 

        if(empty($domainfolder)) {

        } else {
            $res = strtolower(preg_replace("/[_\W]+/", "", $sqlsentex));
            if($data['domaininfo']->subdomain == '1') {
                $deletedomain = $this->common_model->delete_domain($domainname, $domainfolder, $sqlsentex);
            } else {
                $deletedomain = $this->common_model->delete_domain($domainname, $domainfolder, $sqlsentex);
            }
        }

        $this->common_model->delete($id,'code_domain','domainid'); 
        $this->session->set_flashdata('msg', 'Domain Delete Successfully!');
        redirect(base_url('createstore'));
    }
    public function successfully($id = NULL)
    {
        $ci =& get_instance();
        $data = array();
        $data['page_title'] = 'Create Store';
        $data['domaininfo'] = $this->common_model->get_single_domain_info($id);
        $data['themes'] = $this->common_model->get_all_theme();
        $data['parameterid'] = $id;
        $data['themesgroup'] = $this->common_model->get_all_theme_group();
        $userinfo = $this->common_model->get_single_user_info($ci->session->userdata('id'));
        

        $this->load->view('createsuccessfully', $data);
    }
    public function selectheme()
    {

        $ci =& get_instance();
        $data = array();
        $updatedata = array();
        if(isset($_POST['domainid'])) {
            $domainid = $_POST['domainid'];
            $themeid = $_POST['themeid'];
            $data['domaininfo'] = $this->common_model->get_single_domain_info($domainid);
            $data['domainid'] = $domainid;
            $data['themeid'] = $themeid;
            $data['themes'] = $this->common_model->get_single_theme_info($themeid);

            $uploadtheme = $this->common_model->copy_files($data['themes']->themefolder, $data['domaininfo']->domainfolder, $data['domaininfo']->domainlink, $data['domaininfo']->sqlsentex);
            
            $updatedata = array(
              'themeactive' => $themeid
            );
            $this->common_model->edit_option($updatedata, $domainid, 'code_domain', 'domainid');


            $data['app'] = $this->common_model->get_all_app();
            echo "https://storecreator.io/createstore/pluginview/".$domainid."/".$themeid;
        }
    }
    public function pluginview($domainid = NULL, $themeid = NULL)
    {

        $ci =& get_instance();
        $data = array();
        $updatedata = array();
        $data['page_title'] = 'Create Store';
        $data['domaininfo'] = $this->common_model->get_single_domain_info($domainid);
        $data['domainid'] = $domainid;
        $data['themeid'] = $domainid;
        $data['themes'] = $this->common_model->get_single_theme_info($themeid);

        $data['app'] = $this->common_model->get_all_app();
        
        $domaincompleteinfo = $data['domaininfo']->domainlink."<br> <b>Admin Login</b><br>".$data['domaininfo']->domainlink."/wp-admin <br> user: storecreator <br> password : y4u5AlcdEMoO1kMMB00NdMP2";
        //Code to send email...
        $gethtmlmail = $this->common_model->get_signup_mail("domaincreate");

        $findandreplacemail = array("{{informationdomain}}" => $domaincompleteinfo);
        $mailtosend = strtr($gethtmlmail->newslettermail,$findandreplacemail);

        $this->load->library('email'); 
        $this->email->from('storecreator.io@gmail.com', 'Storecreator');
        $this->email->to($ci->session->userdata('email'),'Recipient Name');
        $this->email->subject($gethtmlmail->newslettersubject); // Get this from database also
        $this->email->message($mailtosend); // Getting this from database
        try{
            $this->email->send();
        }catch(Exception $e){
            echo $e->getMessage();
        }
        $this->load->view('selectheme', $data);
    }
    public function installplugin($domainid = NULL, $pluginid = NULL)
    {
        $ci =& get_instance();
        $data = array();
        $data['page_title'] = 'Create Store';
        $data['domaininfo'] = $this->common_model->get_single_domain_info($domainid);
        $data['app'] = $this->common_model->get_single_app_info($pluginid);
        
        $uploadtheme = $this->common_model->copy_plugin_files($data['app']->appfilename, $data['domaininfo']->domainfolder, $data['domaininfo']->domainlink, $data['app']->activeplugin);

        if(empty($data['domaininfo']->appinstalled)) {
            $pluginlist = $pluginid;
        } else {
            $pluginlist = $data['domaininfo']->appinstalled.",".$pluginid;
        }
        $updatedata = array(
          'appinstalled' => $pluginlist
        );
        $this->common_model->edit_option($updatedata, $domainid, 'code_domain', 'domainid');

        
    }

    public function adddomain()
    {
        $ci =& get_instance();
        $domaintitle = $_POST['domainname'];
        $domainurl = $_POST['domainnameurl'];
        $domaindate = $_POST['selectedcate'];
        $domaintype = $_POST['selectedradio'];
        $domainid = $_POST['domainid'];


        if (isset($_POST['domainnameurl'])) {
            $userinfo = $this->common_model->get_single_user_info($ci->session->userdata('id'));
            $totaldomain = $this->common_model->total_domain_by_user($ci->session->userdata('id'));
            if($totaldomain >= $userinfo->pack_domain AND $userinfo->role != 'admin' || $userinfo->user_membership == '1' AND $totaldomain >= '1' AND $userinfo->role != 'admin') {
                // Sorry! You have already reach domain create limit.
                echo "error1";
                // redirect(base_url('createstore'));
            } else {
                $t=time();
                $postdomainlink = $domainurl;
                $subdomain = $domaintype;
                
                if($subdomain == 1) {
                    $res = strtolower(preg_replace("/[_\W]+/", "", $postdomainlink));
                    $tempres2 = strtolower(preg_replace("/[_\W]+/", "", $postdomainlink));
                    $domainname = $res.".storecreator.io";
                    $domainfolder = $res."storecreatorio";
                } else {
            		$t=time();
                    $postdomainlinkdomain = strtolower(preg_replace("/[^-.a-z0-9]*/", "", $postdomainlink));
            		$tempres = str_replace("-",$t,$postdomainlinkdomain);
                    $tempres2 = strtolower(preg_replace("/[_\W]+/", "", $tempres));
            		$res = str_replace($t,"-",$tempres2);
                    $domainname = $postdomainlinkdomain;
                    $domainfolder = $res;


                }

                if(is_object($this->common_model->check_if_domain($domainname))) {
                    // Sorry! Domain already exist.
                    echo "error2";
                    
                } else {
                    if($subdomain != 1) {
                        $dns = dns_get_record($postdomainlink, DNS_NS);
                        $nameservers = [];
                        foreach ($dns as $current) {
                            $nameservers[] = $current['target'];
                        }
                        if($nameservers[0] == 'ns1.storecreator.io' AND $nameservers[1] == 'ns2.storecreator.io') {

                        } elseif ($nameservers[0] == 'ns2.storecreator.io' AND $nameservers[1] == 'ns1.storecreator.io') {

                        }
                        else { 
                            echo "error3";
                            exit();
                        }
                    }

                    if($domainid > 0) {
                        $data['lastdomaininfo'] = $this->common_model->get_single_domain_info($domainid);
                        $themeactiveid = $data['lastdomaininfo']->themeactive;
                        $upgradedomain = $this->common_model->upgrade_domain_new($data['lastdomaininfo']->domainfolder, $data['lastdomaininfo']->sqlsentex, $data['lastdomaininfo']->domainlink, $domainfolder, $domainname, $tempres2);

                        $data = array(
                            'domaintitle' => $domaintitle,
                            'domainlink' => $domainname,
                            //'email' => $_POST['email'],
                            'categoryid' => $domaindate,
                            'subdomain' => $subdomain,
                            'domainfolder' => $domainfolder,
                            'sqlsentex' => $tempres2,
                            'domaintime'   => $t
                        );
                        $this->common_model->edit_option($data, $domainid, 'code_domain', 'domainid');

                        $data = $this->security->xss_clean($data);
                        echo base_url('createstore/pluginview/'.$domainid.'/'.$themeactiveid);
 
                    } else {
                        $this->common_model->create_table_wp_mysql($tempres2,$domainname);

                        if($subdomain == 1) {
                            $createdomain = $this->common_model->create_sub_domain_new($domainname);
                        } else {
                            $createdomain = $this->common_model->create_domain_new($domainname);
                        }

                        $data = array(
                            'domainuser' => $ci->session->userdata('id'),
                            'domaintitle' => $domaintitle,
                            'domainlink' => $domainname,
                            //'email' => $_POST['email'],
                            'categoryid' => $domaindate,
                            'subdomain' => $subdomain,
                            'domainfolder' => $domainfolder,
                            'sqlsentex' => $tempres2,
                            'domaintime'   => $t
                        );


                        $data = $this->security->xss_clean($data);
                        $this->common_model->insert($data, 'code_domain');

                        $lastdomainuserid = $this->common_model->lastdomain_userid($ci->session->userdata('id'));

                        echo base_url('createstore/successfully/').$lastdomainuserid[0]->domainid;

                    }
                }
            }
        }
    }

}