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
                            Edit Application Parameter
                        </h3>
                    </div>
                    <!--begin::Form-->
                    <form class="form" id="dynamic_form" action="<?php echo e(route('storeappparameter')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo e($id); ?>">
                        <div class="card-body">
                            <!-- Parameters Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Name</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_name" value="<?php echo e($namedata->X_Left ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_name" value="<?php echo e($namedata->Y_Top ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_name" value="<?php echo e($namedata->font_size ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_name" value="<?php echo e($namedata->font_color ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst" value="<?php echo e($namedata->monst ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_name" value="<?php echo e($namedata->letter ?? ''); ?>" />
                                    
                                </div>
                            </div>
                            
                            <!-- Similarly for Email Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Email</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_email" value="<?php echo e($emaildata->X_Left ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_email" value="<?php echo e($emaildata->Y_Top ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_email" value="<?php echo e($emaildata->font_size ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_email" value="<?php echo e($emaildata->font_color ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_email" value="<?php echo e($emaildata->monst ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_email" value="<?php echo e($emaildata->letter ?? ''); ?>" />
                                </div>
                            </div>

                            <!-- Similarly for Website Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Website</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_website" value="<?php echo e($websitedata->X_Left ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_website" value="<?php echo e($websitedata->Y_Top ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_website" value="<?php echo e($websitedata->font_size ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_website" value="<?php echo e($websitedata->font_color ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_website" value="<?php echo e($websitedata->monst ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_website" value="<?php echo e($websitedata->letter ?? ''); ?>" />
                                </div>
                            </div>

                            <!-- Similarly for Mobile Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Mobile</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_mobile" value="<?php echo e($mobiledata->X_Left ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_mobile" value="<?php echo e($mobiledata->Y_Top ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_mobile" value="<?php echo e($mobiledata->font_size ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_mobile" value="<?php echo e($mobiledata->font_color ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_mobile" value="<?php echo e($mobiledata->monst ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_mobile" value="<?php echo e($mobiledata->letter ?? ''); ?>" />
                                </div>
                            </div>

                            <!-- Similarly for Address Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Address</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_address" value="<?php echo e($addressdata->X_Left ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_address" value="<?php echo e($addressdata->Y_Top ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_address" value="<?php echo e($addressdata->font_size ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_address" value="<?php echo e($addressdata->font_color ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_address" value="<?php echo e($addressdata->monst ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_address" value="<?php echo e($addressdata->letter ?? ''); ?>" />
                                </div>
                            </div>

                            <!-- Similarly for Company Section -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <h5>Details about Company</h5>
                                    <input type="text" class="form-control" placeholder="Enter X left" name="x_left_company" value="<?php echo e($companydata->X_Left ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Y left" name="y_left_company" value="<?php echo e($companydata->Y_Top ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Font Size" name="font_size_company" value="<?php echo e($companydata->font_size ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Color Code" name="color_code_company" value="<?php echo e($companydata->font_color ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Monst" name="monst_company" value="<?php echo e($companydata->monst ?? ''); ?>" />
                                    <input type="text" class="form-control" placeholder="Enter Letter" name="letter_company" value="<?php echo e($companydata->letter ?? ''); ?>" />
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
    </div>
    <!--end::Container-->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u273329571/domains/bestdevelopmentteam.com/public_html/postermaker/resources/views/admin/appparamter.blade.php ENDPATH**/ ?>