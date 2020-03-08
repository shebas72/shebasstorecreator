

<!-- Container fluid  -->

<div class="container-fluid">
    
    <!-- Bread crumb and right sidebar toggle -->
    
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0"><?php echo $this->lang->line('category');?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $this->lang->line('home');?></a></li>
                <li class="breadcrumb-item active"><?php echo $this->lang->line('all_category');?></li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            
        </div>
    </div>
    
    <!-- End Bread crumb and right sidebar toggle -->
    

    
    <!-- Start Page Content -->

    <div class="row">
        <div class="col-12">

            <?php $msg = $this->session->flashdata('msg'); ?>
            <?php if (isset($msg)): ?>
                <div class="alert alert-success delete_msg pull" style="width: 100%"> <i class="fa fa-check-circle"></i> <?php echo $msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>

            <?php $error_msg = $this->session->flashdata('error_msg'); ?>
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger delete_msg pull" style="width: 100%"> <i class="fa fa-times"></i> <?php echo $error_msg; ?> &nbsp;
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                </div>
            <?php endif ?>

            <div class="card">

                <div class="card-body">

                <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <a href="<?php echo base_url('admin/domain/category') ?>" class="btn btn-info pull-right"><i class="fa fa-plus"></i> <?php echo $this->lang->line('add_new_category');?></a> &nbsp;

                <?php endif ?>
                

                    <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('category_name');?></th>
                                    <th><?php echo $this->lang->line('category_name_arabic');?></th>
                                    <th><?php echo $this->lang->line('action');?></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th><?php echo $this->lang->line('category_name');?></th>
                                    <th><?php echo $this->lang->line('category_name_arabic');?></th>
                                    <th><?php echo $this->lang->line('action');?></th>
                                </tr>
                            </tfoot>
                            
                            <tbody>
                            <?php foreach ($categories as $category): ?>
                                
                                <tr>

                                    <td><?php echo $category['domaincatname']; ?></td>
                                    <td><?php echo $category['domaincatnamearb']; ?></td>
                                    <td class="text-nowrap">

                                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                                            <a href="<?php echo base_url('admin/domain/categoryupdate/'.$category['domaincatid']) ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-success m-r-10"></i> </a>

                                            <a id="delete" data-toggle="modal" data-target="#confirm_delete_<?php echo $category['domaincatid'];?>" href="#"  data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash text-danger m-r-10"></i> </a>

                                        <?php endif ?>

                                    </td>
                                </tr>

                            <?php endforeach ?>

                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- End Page Content -->

</div>



<?php foreach ($categories as $category): ?>
 
<div class="modal fade" id="confirm_delete_<?php echo $category['domaincatid'];?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
       
            <div class="form-body">
                
                <?php echo $this->lang->line('are_you_sure_want_to_delete_?');?> <br> <hr>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $this->lang->line('cancel');?></button>
                <a href="<?php echo base_url('admin/domain/categorydelete/'.$category['domaincatid']) ?>" class="btn btn-danger"> <?php echo $this->lang->line('delete');?></a>
                
            </div>

      </div>


    </div>
  </div>
</div>


<?php endforeach ?>