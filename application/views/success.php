    <?php $this->load->view('header'); ?>
    <?php $ci =& get_instance();
    // load language helper
    // if ($siteLang == 'arabic') {  } else { }
    // $this->lang->line('themes_Responsive_themes');
    $ci->load->helper('language');
    $siteLang = $ci->session->userdata('site_lang');
    if ($siteLang) {
    } else {
        $siteLang = 'english';
    }?>
        <div class="content1a">
            <div class="row" style="text-align: center;">
                <div class="col-sm-12">
                    <div class="section background-opacity page-titlen set-height-top">
                        <div class="container  cont-sub">
                            <div class="page-title-wrapper"><!--.page-title-content--><h2 class="captions"><?php echo $this->lang->line('checkout');?></h2>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo base_url() ?>"><?php echo $this->lang->line('home');?></a></li>
                                    <li ><a href="#"><?php echo $this->lang->line('checkout');?></a></li>
                                    <li class="active"><a href="#"><?php echo $this->lang->line('success');?></a></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div id="content-wrapper">
                        <?php
                            if(!empty($_GET)) {
                                if(isset($_GET['item_number'])) {
                                    $product_no = $_GET['item_number'];
                                } else { 
                                    $product_no = '';
                                }
                                if(isset($_GET['tx'])) {
                                    $product_transaction = $_GET['tx'];
                                } else { 
                                    $product_transaction = '';
                                }
                                if(isset($_GET['amt'])) {
                                    $product_price = $_GET['amt'];
                                } else { 
                                    $product_price = '';
                                }
                                if(isset($_GET['cc'])) {
                                    $product_currency = $_GET['cc'];
                                } else { 
                                    $product_currency = '';
                                }
                                if(isset($_GET['st'])) {
                                    $product_status = $_GET['st'];
                                } else { 
                                    $product_status = '';
                                }
                                if(isset($_GET['cm'])) {
                                    $custom = explode('&', $_GET['cm']);
                                } else { 
                                    // User id
                                    $custom[0] = '';
                                    // Packageid
                                    $custom[1] = '';
                                    // Package name
                                    $custom[2] = '';
                                    // Duration in month
                                    $custom[3] = '';
                                }
                                if(isset($_GET['sig'])) {
                                    $sig = $_GET['sig'];
                                } else { 
                                    $sig = '';
                                }
                                //Rechecking the product price and currency details
                                if ($_REQUEST['st'] == 'Completed') {
                                    $userdata = $this->common_model->get_single_user_info($custom[0]);
                                    if($userdata->user_membership == 0 || empty($userdata->user_membership)) {
                                        $d = new DateTime( "+".$custom[3]." month" );
                                        $expirydate = $d->format( 'm/d/Y' );
                                        $packagenumber = $custom[1];
                                        $newmemberpack = '';
                                        $newpackdate = '';
                                    } else { 
                                        $d = new DateTime( $userdata->user_mem_expire );
                                        $d->modify( "+".$custom[3]." month" );
                                        $expirydate = $d->format( 'm/d/Y' );
                                        $packagenumber = $custom[1];
                                        if(empty($userdata->newmemberpack) || $userdata->newmemberpack == 0) {
                                            $newmemberpack = $custom[0];
                                        } else {
                                            $newmemberpack = $custom[0].",".$userdata->newmemberpack;
                                        }
                                        $newpackdate = $d->format( 'm/d/Y' ).",".$userdata->newpackdate;
                                    }
                                    $data = array(
                                        'user_membership' => $packagenumber,
                                        'user_mem_expire' => $expirydate,
                                        'newmemberpack' => $newmemberpack,
                                        'newpackdate' => $newpackdate
                                    );
                                    $this->common_model->edit_option($data, $custom[0], 'user', 'id');

                                    $packagedetail = 'Package name :'.$custom[2].'Price :'.$product_price.'Duration:'.$custom[3];
                                    //Code to send email...
                                    $completemail = str_replace("{{package-detail}}", $packagedetail,$gethtmlmail->newslettermail);
                                    $this->load->library('email'); 
                                    $this->email->from('storecreator.io@gmail.com', 'Storecreator');
                                    $this->email->to($ci->session->userdata('email'),'Recipient Name');
                                    $this->email->subject($gethtmlmail->newslettersubject);
                                    $this->email->message($completemail); 
                                    try{
                                    $this->email->send();
                                    }catch(Exception $e){
                                    echo $e->getMessage();
                                    }

                                    $data = array(
                                        'memshipuser' => $custom[0],
                                        'memshippackage' => $custom[1],
                                        'memduration' => $custom[3],
                                        'memname' => $custom[2],
                                        'transaction' => $product_transaction,
                                        'mstatus' => $product_status,
                                        'price' => $product_price,
                                        'currency' => $product_currency,
                                        'sig' => $sig,
                                        'datetime' => current_datetime()
                                    );
                                    $insert_transaction = $this->common_model->insert($data, 'code_membership');

                                    echo "<h3 id='success'>Payment SuccessFul</h3>";
                                    echo "<P>Transaction Status - " . $product_status . "</P>";
                                    echo "<P>Transaction Id - " . $product_transaction . "</P>";
                                } elseif ($_REQUEST['st'] == 'Pending') {

                                    $data = array(
                                        'memshipuser' => $custom[0],
                                        'memshippackage' => $custom[1],
                                        'memduration' => $custom[3],
                                        'memname' => $custom[2],
                                        'transaction' => $product_transaction,
                                        'mstatus' => $product_status,
                                        'price' => $product_price,
                                        'currency' => $product_currency,
                                        'sig' => $sig,
                                        'datetime' => current_datetime()

                                    );
                                    $insert_transaction = $this->common_model->insert($data, 'code_membership');

                                    echo "<h3 id='Pending'>Payment Pending</h3>";
                                    echo "<P>Transaction Status - Pending</P>";
                                    echo "<P>Transaction Id - " . $product_transaction . "</P>";
                                } else {
                                    echo "<h3 id='fail'>Payment Failed</h3>";
                                    echo "<P>Transaction Status - Unompleted</P>";
                                    echo "<P>Transaction Id - " . $product_transaction . "</P>";
                                }?>
                                <h1><?php echo $this->lang->line('your_order_has_been_placed_successfully');?></h1>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<?php $this->load->view('footer'); ?>