
<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">User Details</h3>
                </div>
            </div>

            <div class="card-body">
                <!-- User Information Section -->
                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-3">User Information</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> <?php echo e($user->name); ?></li>
                        <li class="list-group-item"><strong>Email:</strong> <?php echo e($user->email); ?></li>
                        <li class="list-group-item"><strong>Mobile Number:</strong> <?php echo e($user->mobileno); ?></li>
                    </ul>
                </div>
                
                <!-- Business/Personal Details Section -->
                <div class="mb-4">
                    <h5 class="text-dark font-weight-bold mb-3">Details</h5>
                    
                    <?php if($user->businesses->isNotEmpty()): ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $user->businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($business->logo_image): ?>
                                            <img src="<?php echo e(asset('images/' . $business->logo_image)); ?>" alt="Logo" style="width: 50px; height: auto;">
                                        <?php else: ?>
                                            <span>No Logo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($business->business_name); ?></td>
                                    <td><?php echo e($business->email); ?></td>
                                    <td><?php echo e($business->mobile_no); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    <?php elseif($user->personal): ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php if($user->personal->logo): ?>
                                            <img src="<?php echo e(asset('images/' . $user->personal->logo)); ?>" alt="Logo" style="width: 50px; height: auto;">
                                        <?php else: ?>
                                            <span>No Logo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($user->personal->name); ?></td>
                                    <td><?php echo e($user->personal->email_id); ?></td>
                                    <td><?php echo e($user->personal->mobile_number); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No additional details available for this user.</p>
                    <?php endif; ?>
                </div>
            </div>
                
        </div>
    </div>
    <!--end::Container-->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u273329571/domains/bestdevelopmentteam.com/public_html/postermaker/resources/views/admin/userview.blade.php ENDPATH**/ ?>