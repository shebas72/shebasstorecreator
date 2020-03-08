<?php
class Common_model extends CI_Model {

    // insert function
    public function insert($data,$table){
        $this->db->insert($table,$data);        
        return $this->db->insert_id();
    }

    // edit function
    function edit_option($action, $id, $table,$idnum = 'id'){
        $this->db->where($idnum,$id);
        $this->db->update($table,$action);
        return;
    } 

    // update function
    function update($action, $id, $table, $customfield = 'id'){
        $this->db->where($customfield,$id);
        $this->db->update($table,$action);
        return;
    } 

    // delete function
    function delete($id,$table,$idnum = 'id'){
        $this->db->delete($table, array($idnum => $id));
        return;
    }

    // user role delete function
    function delete_user_role($id,$table){
        $this->db->delete($table, array('user_id' => $id));
        return;
    }


    // select function
    function select($table){
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // select by id
    function select_option($id,$table){
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    public function check_email($email){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email); 
        $this->db->where('role', 'user'); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }
    public function check_verify_id($id){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('verifylink', $id); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }
    public function check_reset_expire($id){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('resetnumber', $id); 
        $this->db->where('role', 'user'); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }

    public function check_email_developer($email){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email); 
        $this->db->where('role', 'developer'); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }

     public function check_subscriber_email($email){
        $this->db->select('*');
        $this->db->from('code_subscriber');
        $this->db->where('subscriberemail', $email); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }
    // get logged user info
    function get_user_info(){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.id',$this->session->userdata('id'));
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // get single user info
    function get_single_user_info($id){
        $this->db->select('*');
        $this->db->from('user u');
        $this->db->join('code_packages b','b.packageid = u.user_membership','LEFT');
        $this->db->where('u.id',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get single user info
    function get_single_sale_record($id){
        $this->db->select('*');
        $this->db->from('code_membership m');
        $this->db->join('user u','u.id = m.memshipuser','LEFT');
        $this->db->join('code_packages p','p.packageid = m.memshippackage','LEFT');
        $this->db->where('m.memshipid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    
    // Blog
    // get single user info
    function get_single_blog_info($id){
        $this->db->select('b.*');
        $this->db->from('code_blog b');
        $this->db->where('b.blogid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get all users with type 2
    function get_all_blog(){
        $this->db->select('b.*');
        $this->db->from('code_blog b');
        $this->db->order_by('b.blogid','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }


    // get all users with type 2
    function get_all_post_comment($id){
        $this->db->select('*');
        $this->db->from('code_comment b');
        $this->db->join('user u','u.id = b.commentuser','LEFT');
        $this->db->where('b.commentpost',$id);
        $this->db->order_by('b.commentid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_all_app_comment($id){
        $this->db->select('*');
        $this->db->from('code_app_comment b');
        $this->db->join('user u','u.id = b.app_com_user','LEFT');
        $this->db->where('b.app_com_appid',$id);
        $this->db->order_by('b.app_com_id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_overall_app_comment(){
        $this->db->select('*');
        $this->db->from('code_app_comment b');
        $this->db->join('user u','u.id = b.app_com_user','LEFT');
        $this->db->join('code_app ca','ca.appid = b.app_com_appid','LEFT');
        $this->db->order_by('b.app_com_id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }


    //Menu
    //- get single menu info 
     function get_single_menu_info($id){
        $this->db->select('m.*');
        $this->db->from('code_menu m');
        $this->db->where('m.menuid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }
    
    
    //- get all menu list
    function get_all_menus(){
        $this->db->select('m.*');
        $this->db->from('code_menu m');
        $this->db->order_by('m.menuid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    
    //Menu Inners
    //- get single menu info 
    function get_single_menu_inner_info($id){
        $this->db->select('mi.*');
        $this->db->from('code_menuinner mi');
        $this->db->where('mi.menuinnerid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }
    
    //- get all menu list
    function get_all_menu_inners(){
        $this->db->select('mi.*');
        $this->db->from('code_menuinner mi');
        $this->db->order_by('mi.menuinnerid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    

    
    // comment
    // get single user info
    function get_single_comment_info($id){
        $this->db->select('b.*');
        $this->db->from('code_comment b');
        $this->db->where('b.commentid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get all users with type 2
    function get_all_comment(){
        $this->db->select('*');
        $this->db->from('code_comment c');
        $this->db->join('code_blog b','b.blogid = c.commentpost','LEFT');
        $this->db->join('user u','u.id = c.commentuser','LEFT');
        $this->db->order_by('c.commentid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }


    // subscriber
    // get single user info
    function get_single_subscriber_info($id){
        $this->db->select('b.*');
        $this->db->from('code_subscriber b');
        $this->db->where('b.subscriberid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get all users with type 2
    function get_all_subscriber(){
        $this->db->select('b.*');
        $this->db->from('code_subscriber b');
        $this->db->order_by('b.subscriberid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    // contact
    // get single user info
    function get_single_contact_info($id){
        $this->db->select('b.*');
        $this->db->from('code_contact b');
        $this->db->where('b.contactid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get all users with type 2
    function get_all_contact(){
        $this->db->select('b.*');
        $this->db->from('code_contact b');
        $this->db->order_by('b.contactid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // packages
    // get single user info
    function get_single_packages_info($id){
        $this->db->select('b.*');
        $this->db->from('code_packages b');
        $this->db->where('b.packageid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get all users with type 2
    function get_all_packages(){
        $this->db->select('b.*');
        $this->db->from('code_packages b');
        $this->db->order_by('b.packageorder','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // custompages
    // get single user info
    function get_single_custompages_info($id){
        $this->db->select('b.*');
        $this->db->from('code_pages b');
        $this->db->where('b.pageslug',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get all users with type 2
    function get_all_custompages(){
        $this->db->select('b.*');
        $this->db->from('code_pages b');
        $this->db->order_by('b.pageslug','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // showcase
    // get single user info
    function get_single_showcase_info($id){
        $this->db->select('b.*');
        $this->db->from('code_showcase b');
        $this->db->where('b.showcaseid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get all users with type 2
    function get_all_showcase(){
        $this->db->select('b.*');
        $this->db->from('code_showcase b');
        $this->db->order_by('b.showcaseid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // get all users with type 2
    function get_all_showcase_group(){
        $this->db->select('b.*');
        $this->db->from('code_showcase b');
        $this->db->order_by('b.showcaseid','DESC');
        $this->db->group_by('b.showcasetype');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // theme
    // get single user info
    function get_single_theme_info($id){
        $this->db->select('b.*');
        $this->db->from('code_theme b');
        $this->db->where('b.themeid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get all users with type 2
    function get_all_theme(){
        $this->db->select('b.*');
        $this->db->from('code_theme b');
        $this->db->order_by('b.themeid','DESC');
        $this->db->where('themeactive','2');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    // get all users with type 2
    function get_all_theme_admin(){
        $this->db->select('b.*');
        $this->db->from('code_theme b');
        $this->db->order_by('b.themeid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // get all users with type 2
    function get_all_theme_group(){
        $this->db->select('b.*');
        $this->db->from('code_theme b');
        $this->db->order_by('b.themeid','DESC');
        $this->db->group_by('b.themetype');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }


    // get all users with type 2
    function get_all_user(){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('role', 'user'); 
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_all_user_developer(){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('role', 'developer'); 
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }


    // count active, inactive and total user
    function get_user_total(){
        $this->db->select('*');
        $this->db->select('count(*) as total');
        $this->db->select('(SELECT count(user.id)
                            FROM user 
                            WHERE (user.status = 1)
                            )
                            AS active_user',TRUE);

        $this->db->select('(SELECT count(user.id)
                            FROM user 
                            WHERE (user.status = 0)
                            )
                            AS inactive_user',TRUE);

        $this->db->select('(SELECT count(user.id)
                            FROM user 
                            WHERE (user.role = "admin")
                            )
                            AS admin',TRUE);

        $this->db->from('user');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // image upload function with resize option
    function upload_image($max_size,$inputName = 'photo',$fileallow = 'gif|jpg|png|jpeg',$foldername = 'upload'){
            
            // set upload path 
            $timestamp = time(); 
            $config['upload_path']  = $_SERVER['DOCUMENT_ROOT'].$foldername."/";
            $config['allowed_types']= $fileallow;
            $config['max_size']     = '9200000';
            $config['max_width']    = '9200000';
            $config['max_height']   = '9200000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload($inputName)) {

                
                $data = $this->upload->data();

                // set upload path
                $source             = "./upload/".$data['file_name'] ;
                $destination_thumb  = "./upload/thumbnail/" ;
                $destination_medium = "./upload/medium/" ;
                $main_img = $data['file_name'];
                // Permission Configuration
                chmod($source, 0777) ;

                /* Resizing Processing */
                // Configuration Of Image Manipulation :: Static
                $this->load->library('image_lib') ;
                $img['image_library'] = 'GD2';
                $img['create_thumb']  = TRUE;
                $img['maintain_ratio']= TRUE;

                /// Limit Width Resize
                $limit_medium   = $max_size ;
                $limit_thumb    = 200 ;

                // Size Image Limit was using (LIMIT TOP)
                $limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;

                // Percentase Resize
                if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
                    $percent_medium = $limit_medium/$limit_use ;
                    $percent_thumb  = $limit_thumb/$limit_use ;
                }

                //// Making THUMBNAIL ///////
                $img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
                $img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_thumb-'.floor($img['width']).'x'.floor($img['height']) ;
                $img['quality']      = ' 100%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_thumb ;

                $thumb_nail = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;

                ////// Making MEDIUM /////////////
                $img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
                $img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_medium-'.floor($img['width']).'x'.floor($img['height']).$timestamp ;
                $img['quality']      = '100%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_medium ;

                $mid = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;

                // set upload path
                $images = 'upload/medium/'.$mid;
                $thumb  = 'upload/thumbnail/'.$thumb_nail;
                unlink($source) ;

                return array(
                    'imagename' => $data['raw_name'],
                    'images' => $images,
                    'thumb' => $thumb
                );
                
            }
            else {
                echo "Failed! to upload image" ;
            }
            
    }


    // get all users with type 2
    function get_blog_custompages(){
        $this->db->select('b.*');
        $this->db->from('code_pages b');
        $this->db->where('pageslug','our-blog');
        $this->db->order_by('b.pageslug','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_all_blog_search($query){
        $this->db->select('b.*');
        $this->db->from('code_blog b');
        $this->db->like('blogtitle',$query);
        $this->db->or_like('blogtitlearb',$query);
        $this->db->or_like('blogcontent',$query);
        $this->db->or_like('blogcontentarb',$query);
        $this->db->order_by('b.blogid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_all_blog_latest(){
        $this->db->select('b.*');
        $this->db->from('code_blog b');
        $this->db->order_by('b.blogid','DESC');
        $this->db->limit(2);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // get all app category
    function get_all_app_category(){
        $this->db->select('apc.*');
        $this->db->from('code_app_categories apc');
        $this->db->order_by('apc.app_cat_id','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    
    function get_single_app_category_info($id){
        $this->db->select('b.*');
        $this->db->from('code_app_categories b');
        $this->db->where('b.app_cat_id',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }
    
    function get_single_app_comment_info($id){
        $this->db->select('b.*');
        $this->db->from('code_app_comment b');
        $this->db->where('b.app_com_id',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }
    
    function get_single_app_slider_info($id){
        $this->db->select('b.*');
        $this->db->from('code_appslider b');
        $this->db->where('b.appsliderid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    function get_single_app_info($id){
        $this->db->select('*');
        $this->db->from('code_app b');
        $this->db->join('code_app_categories cc','cc.app_cat_id = b.appcat_array','LEFT');
        $this->db->where('b.appid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    function get_all_app_slider(){
        $this->db->select('*');
        $this->db->from('code_appslider b');
        $this->db->order_by('b.appsliderid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_single_app_slider($id){
        $this->db->select('b.*');
        $this->db->from('code_appslider b');
        $this->db->where('b.appparent',$id);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_all_app_admin(){
        $this->db->select('*');
        $this->db->from('code_app b');
        $this->db->join('code_app_categories cc','cc.app_cat_id = b.appcat_array','LEFT');
        $this->db->order_by('b.appid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_all_app(){
        $this->db->select('*');
        $this->db->from('code_app b');
        $this->db->join('code_app_categories cc','cc.app_cat_id = b.appcat_array','LEFT');
        $this->db->where('b.appactive','2');
        $this->db->order_by('b.appid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_all_app_search($query){

        $this->db->select('b.*');
        $this->db->from('code_app b');
        $this->db->like('apptitle',$query);
        $this->db->or_like('appabout',$query);
        $this->db->or_like('apptitlearb',$query);
        $this->db->or_like('appaboutarb',$query);
        $this->db->where('b.appactive','2');
        $this->db->order_by('b.appid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }


    function get_single_domain_info($id){
        $this->db->select('b.*');
        $this->db->from('code_domain b');
        $this->db->where('b.domainid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    function get_all_domain(){
        $this->db->select('*');
        $this->db->from('code_domain b');
        $this->db->order_by('b.domainid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function get_all_domain_to_create(){
        $this->db->select('*');
        $this->db->from('domaintocreate b');
        $this->db->where('b.status','2');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function get_all_domain_user($id){
        $this->db->select('*');
        $this->db->from('code_domain b');
        $this->db->where('b.domainuser',$id);
        $this->db->order_by('b.domainid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function get_all_domain_user_pagination($id, $pagination = '2', $offset = '0'){
        $this->db->select('*');
        $this->db->from('code_domain b');
        $this->db->where('b.domainuser',$id); 
        $this->db->limit($pagination);
        $this->db->offset($offset);
        $this->db->order_by('b.domainid','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function get_single_domain_category_info($id){
        $this->db->select('b.*');
        $this->db->from('code_domain_category b');
        $this->db->where('b.domaincatid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    function get_all_domain_category(){
        $this->db->select('*');
        $this->db->from('code_domain_category b');
        $this->db->order_by('b.domaincatid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function get_single_domain_redirect_info($id){
        $this->db->select('b.*');
        $this->db->from('code_domain_redirect b');
        $this->db->where('b.domainredid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    function get_all_domain_redirect(){
        $this->db->select('*');
        $this->db->from('code_domain_redirect b');
        $this->db->order_by('b.domainredid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
        function get_all_product(){
        $this->db->select('*');
        $this->db->from('code_product b');
        $this->db->order_by('b.prodid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_single_product_info($id){
        $this->db->select('b.*');
        $this->db->from('code_product b');
        $this->db->where('b.prodid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    function get_all_product_category(){
        $this->db->select('*');
        $this->db->from('code_product_category b');
        $this->db->order_by('b.cateid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_single_product_category_info($id){
        $this->db->select('b.*');
        $this->db->from('code_product_category b');
        $this->db->where('b.cateid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    function get_all_product_attributes(){
        $this->db->select('*');
        $this->db->from('code_product_attributes b');
        $this->db->order_by('b.productattid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_single_product_attributes_info($id){
        $this->db->select('b.*');
        $this->db->from('code_product_attributes b');
        $this->db->where('b.productattid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    function get_all_product_attributes_sets(){
        $this->db->select('*');
        $this->db->from('code_product_attributes_sets b');
        $this->db->order_by('b.productattsetsid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_single_product_attributes_sets_info($id){
        $this->db->select('b.*');
        $this->db->from('code_product_attributes_sets b');
        $this->db->where('b.productattsetsid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }    
    function get_all_customer(){
        $this->db->select('*');
        $this->db->from('code_customer b');
        $this->db->order_by('b.customerid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_single_customer_info($id){
        $this->db->select('b.*');
        $this->db->from('code_customer b');
        $this->db->where('b.customerid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }    
    function get_all_order(){
        $this->db->select('*');
        $this->db->from('code_sale b');
        $this->db->order_by('b.saleid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function get_all_membership(){
        $this->db->select('*');
        $this->db->from('code_membership m');
        $this->db->join('user u','u.id = m.memshipuser','LEFT');
        $this->db->join('code_packages p','p.packageid = m.memshippackage','LEFT');
        $this->db->order_by('m.memshipid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function get_all_newsletter(){
        $this->db->select('*');
        $this->db->from('code_newsletter b');
        $this->db->order_by('b.newsletterid','DESC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function get_single_newsletter_info($id){
        $this->db->select('b.*');
        $this->db->from('code_newsletter b');
        $this->db->where('b.newsletterid',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }   

    function get_signup_mail($id){
        $this->db->select('b.*');
        $this->db->from('code_newsletter b');
        $this->db->where('b.newsletterevent',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }    

    function get_countryName_by_id($id){
        $this->db->select('b.name');
        $this->db->from('country b');
        $this->db->where('b.id',$id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }
    function get_countryName(){
        $this->db->select('b.*');
        $this->db->from('country b');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function create_sub_domain($domainname, $domainfolder){
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost-subdomain create ".$domainname);
        // $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost create ".$domainname);
        // $outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/certbot -d ".$domainname." --no-redirect");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S cp -R /var/www/storecreator.io/script/* /var/www/".$domainfolder."/");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S chmod -R 0777 /var/www/".$domainfolder."/*");

    }

    function create_sub_domain_script2($domainname, $domainfolder){
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost-subdomain create ".$domainname);
        // $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost create ".$domainname);
        // $outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/certbot -d ".$domainname." --no-redirect");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S cp -R /var/www/storecreator.io/script2/* /var/www/".$domainfolder."/");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S chmod -R 0777 /var/www/".$domainfolder."/*");

    }

    function create_domain($domainname, $domainfolder){
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/domaindns create ".$domainname);

        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost create ".$domainname);
        $outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/certbot -d ".$domainname." --no-redirect");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S cp -R /var/www/storecreator.io/script/* /var/www/".$domainfolder."/");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S chmod -R 0777 /var/www/".$domainfolder."/*");

    }
    

    function create_domain_script2($domainname, $domainfolder){
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/domaindns create ".$domainname);

        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost create ".$domainname);
        $outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/certbot -d ".$domainname." --no-redirect");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S cp -R /var/www/storecreator.io/script2/* /var/www/".$domainfolder."/");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S chmod -R 0777 /var/www/".$domainfolder."/*");

    }
    

    function delete_domain($domainname, $domainfolder, $sqlsentax){
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S rm -rf /var/www/".$domainfolder."/*");
        // $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost delete ".$domainname." --y");

        $servername = "localhost";
        $username = "root";
        $password = "New@Store5000New@New";
        // Create connection_aborted()
        $conn = new mysqli($servername, $username, $password);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "DROP DATABASE ".$sqlsentax.";";
        $conn->query($sql);
    }

    function get_email($id){
        $this->db->select('email');
        $this->db->from('user');
        $this->db->where('id', $id); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }


    function create_table_wp_mysql($sqlsentax,$domainname){
        $servername = "localhost";
        $username = "root";
        $password = "New@Store5000New@New";
        // Create connection
        $conn = new mysqli($servername, $username, $password);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "CREATE DATABASE ".$sqlsentax.";";
        $conn->query($sql);

    }
    function empty_table_wp_mysql($sqlsentax,$domainname,$email){
        $servername = "localhost";
        $username = "root";
        $password = "New@Store5000New@New";
        // Create connection
        $conn = new mysqli($servername, $username, $password);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "DROP DATABASE ".$sqlsentax.";";
        $conn->query($sql);
        $sql = "CREATE DATABASE ".$sqlsentax.";";
        $conn->query($sql);
    }
    function insert_into_table_wp_mysql($sqlsentax,$domainname,$email){
        // Name of the file
        $filename = '/var/www/storecreator.io/script/wordpress.sql';
        $mysql_host = 'localhost';
        $mysql_username = 'root';
        $mysql_password = 'New@Store5000New@New';
        $mysql_database = $sqlsentax;
        $con = @new mysqli($mysql_host,$mysql_username,$mysql_password,$mysql_database);
        $templine = '';
        $lines = file($filename);
        ;

        foreach ($lines as $line) {
            $strline = str_replace(
                array("storecreator.io/script","saad_sinpk@yahoo.com"),
                array($domainname, $email),
                $line
            );
            if (substr($strline, 0, 2) == '--' || $line == '')
                continue;
            $templine .= $strline;
            if (substr(trim($strline), -1, 1) == ';') {
                // Perform the query
                $con->query($templine);
                // Reset temp variable to empty
                $templine = '';
            }
        }
    }
    function insert_into_table_wp_mysql_script2($sqlsentax,$domainname,$email){
        // Name of the file
        $filename = '/var/www/storecreator.io/script2/wordpress.sql';
        $mysql_host = 'localhost';
        $mysql_username = 'root';
        $mysql_password = 'New@Store5000New@New';
        $mysql_database = $sqlsentax;
        $con = @new mysqli($mysql_host,$mysql_username,$mysql_password,$mysql_database);
        $templine = '';
        $lines = file($filename);
        ;

        foreach ($lines as $line) {
            $strline = str_replace(
                array("storecreator.io/script2","saad_sinpk@yahoo.com"),
                array($domainname, $email),
                $line
            );
            if (substr($strline, 0, 2) == '--' || $line == '')
                continue;
            $templine .= $strline;
            if (substr(trim($strline), -1, 1) == ';') {
                // Perform the query
                $con->query($templine);
                // Reset temp variable to empty
                $templine = '';
            }
        }
    }
    function create_wp_config_file($folderlocation, $sqldb){
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/createconfig ".$folderlocation." ".$sqldb);
    }
    function htaccess_wp_file($folderlocation){
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/createhtaccess ".$folderlocation);
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S chmod 0777 /var/www/".$folderlocation."/.htaccess");
    }

    function check_if_domain($domain){
        $this->db->select('b.*');
        $this->db->from('code_domain b');
        $this->db->where('b.domainlink',$domain);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }
    function total_domain_by_user($userid){
        $this->db->select('*');
        $this->db->from('code_domain b');
        $this->db->where('b.domainuser',$userid);
        $query = $this->db->get();
        $query = $query->num_rows();  
        return $query;
    }
    function update_subscription(){
        // $this->db->select('STR_TO_DATE("21,5,2013","%d,%m,%Y")');
        // $this->db->from('user');
        // $userid = '1000';
        // // $this->db->where(strtotime('user_mem_expire'),$userid);
        // // $this->db->where('UNIX_TIMESTAMP(STR_TO_DATE(user_mem_expire, "%Y-%m-%d")) <= ',$end_date)
        // $query = $this->db->get();              
        // return $query->result();
    }
    function lastdomain_userid($userid){
        $this->db->select('*');
        $this->db->from('code_domain b');
        $this->db->where('b.domainuser',$userid);
        $this->db->limit(1);
        $this->db->order_by('domainid','DESC');
        $query = $this->db->get();              
        return $query->result();
    }

    function copy_files($themezip, $domainfolder, $domainlink, $appzipname, $appactivename){
        $zipname_arr = explode (",", $appzipname);  
        $appname_arr = explode (",", $appactivename);  

        foreach ($zipname_arr as $key => $value) {
            // $appfolder = substr_replace($value ,"",-4);
            $outPut = shell_exec("echo 'New@Store5000New' | sudo -S cp -R /var/www/storecreator.io/plugins/".$value." /var/www/".$domainfolder."/wp-content/plugins/");
            $outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S unzip /var/www/".$domainfolder."/wp-content/plugins/".$value." -d /var/www/".$domainfolder."/wp-content/plugins");

            file_get_contents("https://".$domainlink."/active-plugin.php?pluginfilename=".$appname_arr[$key]."&password=New@Store5000New");
        }

        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S cp -R /var/www/storecreator.io/zip/".$themezip." /var/www/".$domainfolder."/wp-content/themes/");
        $outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S unzip /var/www/".$domainfolder."/wp-content/themes/".$themezip." -d /var/www/".$domainfolder."/wp-content/themes/");
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S chmod -R 0777 /var/www/".$domainfolder."/wp-content/themes/".$themezip."/*");
    }

    function copy_plugin_files($appzip, $domainfolder, $domainlink, $activeplugin){

        $appfolder = substr_replace($appzip ,"",-4);
        $outPut = shell_exec("echo 'New@Store5000New' | sudo -S cp -R /var/www/storecreator.io/plugins/".$appzip." /var/www/".$domainfolder."/wp-content/plugins/");
        $outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S unzip /var/www/".$domainfolder."/wp-content/plugins/".$appzip." -d /var/www/".$domainfolder."/wp-content/plugins/".$appfolder);

        echo file_get_contents("https://".$domainlink."/active-plugin.php?pluginfilename=".$activeplugin."&password=New@Store5000New");
    }
    
}