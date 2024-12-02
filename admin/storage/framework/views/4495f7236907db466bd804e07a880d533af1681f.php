<!DOCTYPE html>

<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>Poster Maker</title>
    <meta name="description" content="Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets." />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <link href="<?php echo e(asset('assets/plugins/custom/datatables/datatables.bundle.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.8/css/jquery.dataTables.min.css">






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




    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>


    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="assets/media/logos/Layer_x0020_1.png" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">



    <?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->yieldContent('script'); ?>
    <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        var KTAppSettings = {
            "breakpoints": {
                "sm": 576
                , "md": 768
                , "lg": 992
                , "xl": 1200
                , "xxl": 1400
            }
            , "colors": {
                "theme": {
                    "base": {
                        "white": "#ffffff"
                        , "primary": "#3699FF"
                        , "secondary": "#E5EAEE"
                        , "success": "#1BC5BD"
                        , "info": "#8950FC"
                        , "warning": "#FFA800"
                        , "danger": "#F64E60"
                        , "light": "#E4E6EF"
                        , "dark": "#181C32"
                    }
                    , "light": {
                        "white": "#ffffff"
                        , "primary": "#E1F0FF"
                        , "secondary": "#EBEDF3"
                        , "success": "#C9F7F5"
                        , "info": "#EEE5FF"
                        , "warning": "#FFF4DE"
                        , "danger": "#FFE2E5"
                        , "light": "#F3F6F9"
                        , "dark": "#D6D6E0"
                    }
                    , "inverse": {
                        "white": "#ffffff"
                        , "primary": "#ffffff"
                        , "secondary": "#3F4254"
                        , "success": "#ffffff"
                        , "info": "#ffffff"
                        , "warning": "#ffffff"
                        , "danger": "#ffffff"
                        , "light": "#464E5F"
                        , "dark": "#ffffff"
                    }
                }
                , "gray": {
                    "gray-100": "#F3F6F9"
                    , "gray-200": "#EBEDF3"
                    , "gray-300": "#E4E6EF"
                    , "gray-400": "#D1D3E0"
                    , "gray-500": "#B5B5C3"
                    , "gray-600": "#7E8299"
                    , "gray-700": "#5E6278"
                    , "gray-800": "#3F4254"
                    , "gray-900": "#181C32"
                }
            }
            , "font-family": "Poppins"
        };

    </script>

    <script src="<?php echo e(asset('assets/plugins/global/plugins.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/sweetalert.js')); ?>"></script>



    <script src="<?php echo e(asset('assets/plugins/custom/prismjs/prismjs.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/scripts.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/widgets.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/crud/file-upload/dropzonejs.js')); ?>"></script>




    <script>
        <?php if(session('status')): ?>
        Swal.fire
        ({
                title: '<?php echo e(session('status')); ?>',
             icon: '<?php echo e(session('code')); ?>',
            button: "done"
        });
        <?php endif; ?>
    </script>


</body>
<!--end::Body-->

</html>
<?php /**PATH C:\laravel\postermaker\postermaker\resources\views/Admin/layouts/app.blade.php ENDPATH**/ ?>