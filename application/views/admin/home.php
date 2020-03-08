

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('dashboard');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('dashboard');?></li>
            </ol>
        </div>
        <!-- <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                        <h4 class="m-t-0 text-info">$58,356</h4></div>
                    <div class="spark-chart">
                        <div id="monthchart"></div>
                    </div>
                </div>
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                        <h4 class="m-t-0 text-primary">$48,356</h4></div>
                    <div class="spark-chart">
                        <div id="lastmonthchart"></div>
                    </div>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
        </div> -->
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    
    <a href="<?php echo base_url('admin/user/all_user_list') ?>">
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="d-flex flex-row">
                    <div class="p-10 bg-info">
                        <h3 class="text-white box m-b-0"><i class="fa fa-users fa-2x"></i></h3></div>
                    <div class="align-self-center m-l-20">
                        <h3 class="m-b-0 text-info"><?php echo $count->total; ?></h3>
                        <h5 class="text-muted m-b-0"><?php echo $this->lang->line('total_user');?></h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="d-flex flex-row">
                    <div class="p-10 bg-success">
                        <h3 class="text-white box m-b-0"><i class="fa fa-user fa-2x"></i></h3></div>
                    <div class="align-self-center m-l-20">
                        <h3 class="m-b-0 text-info"><?php echo $count->active_user; ?></h3>
                        <h5 class="text-muted m-b-0"><?php echo $this->lang->line('active_user');?></h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="d-flex flex-row">
                    <div class="p-10 bg-danger">
                        <h3 class="text-white box m-b-0"><i class="fa fa-user-times fa-2x"></i></h3></div>
                    <div class="align-self-center m-l-20">
                        <h3 class="m-b-0 text-info"><?php echo $count->inactive_user; ?></h3>
                        <h5 class="text-muted m-b-0"><?php echo $this->lang->line('inactive_user');?></h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="d-flex flex-row">
                    <div class="p-10 bg-primary">
                        <h3 class="text-white box m-b-0"><i class="fa fa-user-circle fa-2x"></i></h3></div>
                    <div class="align-self-center m-l-20">
                        <h3 class="m-b-0 text-info"><?php echo $count->admin; ?></h3>
                        <h5 class="text-muted m-b-0"><?php echo $this->lang->line('total_admin');?></h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    </a>

    <!-- Row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $this->lang->line('total_visits');?></h4>
                    <div id="visitfromworld" style="width:100%!important; height:415px"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $this->lang->line('browser_stats');?></h4>
                    <table class="table browser m-t-30 no-border">
                        <tbody>
                            <tr>
                                <td style="width:40px"><img src="<?php echo base_url() ?>assets/admin//images/browser/chrome-logo.png" alt=logo /></td>
                                <td><?php echo $this->lang->line('google_chrome');?></td>
                                <td class="text-right"><span class="label label-light-info">23%</span></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo base_url() ?>assets/admin//images/browser/firefox-logo.png" alt=logo /></td>
                                <td><?php echo $this->lang->line('mozila_firefox');?></td>
                                <td class="text-right"><span class="label label-light-success">15%</span></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo base_url() ?>assets/admin//images/browser/safari-logo.png" alt=logo /></td>
                                <td><?php echo $this->lang->line('apple_safari');?></td>
                                <td class="text-right"><span class="label label-light-primary">07%</span></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo base_url() ?>assets/admin//images/browser/internet-logo.png" alt=logo /></td>
                                <td><?php echo $this->lang->line('internet_explorer');?></td>
                                <td class="text-right"><span class="label label-light-warning">09%</span></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo base_url() ?>assets/admin//images/browser/opera-logo.png" alt=logo /></td>
                                <td><?php echo $this->lang->line('opera_mini');?></td>
                                <td class="text-right"><span class="label label-light-danger">23%</span></td>
                            </tr>
                            <tr>
                                <td><img src="<?php echo base_url() ?>assets/admin//images/browser/internet-logo.png" alt=logo /></td>
                                <td><?php echo $this->lang->line('microsoft_edge');?></td>
                                <td class="text-right"><span class="label label-light-megna">09%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <ul class="list-inline pull-right">
                        <li>
                            <h6 class="text-muted"><i class="fa fa-circle m-r-5" style="color:#51bdff"></i>2015</h6>
                        </li>
                        <li>
                            <h6 class="text-muted"><i class="fa fa-circle m-r-5" style="color:#11a0f8"></i>2016</h6>
                        </li>
                        <li>
                            <h6 class="text-muted"><i class="fa fa-circle m-r-5 text-info"></i>2017</h6>
                        </li>
                    </ul>
                    <h4 class="card-title"><?php echo $this->lang->line('total_revenue');?></h4>
                    <div class="clear"></div>
                    <div class="total-sales" style="height: 365px;"></div>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $this->lang->line('sales_prediction');?></h4>
                            <div class="d-flex flex-row">
                                <div class="align-self-center">
                                    <span class="display-6 text-primary">$3528</span>
                                    <h6 class="text-muted">10% <?php echo $this->lang->line('increased');?></h6>
                                    <h5>(150-165 Sales)</h5>
                                </div>
                                <div class="ml-auto">
                                    <div id="gauge-chart" style=" width:150px; height:150px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $this->lang->line('sales_difference');?></h4>
                            <div class="d-flex flex-row">
                                <div class="align-self-center">
                                    <span class="display-6 text-success">$4316</span>
                                    <h6 class="text-muted">10% <?php echo $this->lang->line('increased');?></h6>
                                    <h5>(150-165 <?php echo $this->lang->line('sales');?>)</h5>
                                </div>
                                <div class="ml-auto">
                                    <div class="ct-chart" style="width:120px; height: 120px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
    
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Right sidebar -->
    <!-- ============================================================== -->
    <!-- .right-sidebar -->
    <!-- ============================================================== -->
    <!-- End Right sidebar -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
            