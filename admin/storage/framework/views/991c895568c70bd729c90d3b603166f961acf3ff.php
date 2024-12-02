<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">
                           Image Create 
                       </h3>
                    </div>
                    <!--begin::Form-->
                    <form class="form" id="dynamic_form" action="<?php echo e(route('addimagecategory')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="card-body">
                            <!-- Upload Club Logo -->
                           
                        
                       
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Enter Category: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Category" name="name" />
                                   
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" id="submitbutton" name="submit" class="btn btn-primary mr-2">Save</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
    </div>z`
    <!--end::Container-->
</div>
<script></script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u273329571/domains/bestdevelopmentteam.com/public_html/postermaker/resources/views/admin/imagecategorycreate.blade.php ENDPATH**/ ?>