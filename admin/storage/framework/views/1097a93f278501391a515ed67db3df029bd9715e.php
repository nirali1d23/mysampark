<!DOCTYPE html>

<html lang="en">


<head>
    <base href="../../../">
    <meta charset="utf-8" />
    <title>PosterMaker</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="<?php echo e(asset('assets/css/pages/login/login-2.css')); ?>" rel="stylesheet" type="text/css" />

    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="<?php echo e(asset('assets/plugins/global/plugins.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/plugins/custom/prismjs/prismjs.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/style.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="<?php echo e(asset('assets/css/themes/layout/header/base/light.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/themes/layout/header/menu/light.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/themes/layout/brand/dark.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/themes/layout/aside/dark.css')); ?>" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!-- Code injected by Five-server -->

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white"
            id="kt_login">
            <!--begin::Aside-->
            <div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden">
                <!--begin: Aside Container-->
                <div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35">
                    <!--begin::Logo-->
                    
                    <!--end::Logo-->
                    <!--begin::Aside body-->
                    <div class="d-flex flex-column-fluid flex-column flex-center">
                        <!--begin::Signin-->
                        <div class="login-form login-signin py-11">
                            <!--begin::Form-->
                            
                            <form class="form" novalidate="novalidate" action="<?php echo e(route('login')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <!--begin::Title-->

                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h2>

                                </div>

                                <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <li>

                                            <?php echo e($error); ?>

                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </ul>

                                </div>
                                <?php endif; ?>
                                <!--end::Title-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                        type="email"   value="<?php echo e(old('email')); ?>"  placeholder="enter your email" name="email" autocomplete="off" />

                                </div>

                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mt-n5">
                                        <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>

                                    </div>
                                    <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg"
                                        type="password" placeholder="enter your password" name="password"  value="<?php echo e(old('password')); ?>"
                                        autocomplete="off" />

                                </div>
                                <!--end::Form group-->
                                <!--begin::Action-->
                                <div class="text-center pt-2">
                                    <button type="submit"
                                        class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3">Sign
                                        In</button>
                                </div>
                                <!--end::Action-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Signin-->

                        <!--begin::Signup-->




                        <!--end::Signup-->
                        <!--begin::Forgot-->
                        <div class="login-form login-forgot pt-11">
                            <!--begin::Form-->
                            <form class="form" novalidate="novalidate" id="kt_login_forgot_form" method="POST">
                                <!--begin::Title-->
                                <?php echo csrf_field(); ?>

                                <div class="text-center pb-8">
                                    <h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Forgotten
                                        Password ?</h2>
                                    <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your
                                        password</p>
                                </div>
                                <!--end::Title-->
                                <!--begin::Form group-->
                                <div class="form-group">
                                    <input
                                        class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6"
                                        type="email" placeholder="Email" name="email" autocomplete="off" />
                                </div>
                                <!--end::Form group-->
                                <!--begin::Form group-->
                                <div class="form-group d-flex flex-wrap flex-center pb-lg-0 pb-3">
                                    <button type="button" id="kt_login_forgot_submit"
                                        class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Submit</button>
                                    <button type="button" id="kt_login_forgot_cancel"
                                        class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mx-4">Cancel</button>
                                </div>
                                <!--end::Form group-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Forgot-->
                    </div>
                    <!--end::Aside body-->
                    <!--begin: Aside footer for desktop-->
                    
                    <!--end: Aside footer for desktop-->
                </div>
                <!--end: Aside Container-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0" style="background-color: #B1DCED;">
                <!--begin::Title-->
                <div
                    class="d-flex flex-column justify-content-center text-center pt-lg-40 pt-md-5 pt-sm-5 px-lg-0 pt-5 px-7">
                    <h3 class="display4 font-weight-bolder my-7 text-dark" style="color: #986923;"> MY SAMPARK 

                    </h3>
                    <p class="font-weight-bolder font-size-h2-md font-size-lg text-dark opacity-70">User Experience
                        &amp; Interface Design, Product Strategy
                        <br />Web Application SaaS Solutions
                    </p>
                </div>
                <!--end::Title-->
                <!--begin::Image-->
                <div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"
                    style="background-image: url(assets/media/svg/illustrations/login-visual-2.svg);"></div>
                <!--end::Image-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>

    <script src="<?php echo e(asset('assets/plugins/global/plugins.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/custom/prismjs/prismjs.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/scripts.bundle.js')); ?>"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="<?php echo e(asset('assets/js/pages/custom/login/login-general.js')); ?>"></script>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->

</html><?php /**PATH C:\laravel\postermaker\postermaker\resources\views/Auth/login.blade.php ENDPATH**/ ?>