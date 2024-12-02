

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
                    
                    <h3 class="card-label">Frame  List</h3>
                </div>
               
<!-- Button trigger modal-->
<!-- Modal-->


<div class="card-toolbar">
    <!--begin::Button-->
    <button type="button" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
        <span class="svg-icon svg-icon-md">
            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <rect x="0" y="0" width="24" height="24" />
                    <circle fill="#000000" cx="9" cy="15" r="6" />
                    <path
                        d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                        fill="#000000" opacity="0.3" />
                </g>
            </svg>
            <!--end::Svg Icon-->
        </span>New Image</a>
    <!--end::Button-->
    </div>
<!-- Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="<?php echo e(route('storeframe')); ?>" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
        
            
            <div class="modal-body">
                <label for="name"> Frame:</label>
                <input type="file" id="image" name="image"><br><br>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
            </div>
        </div>
    </div>
    </form>
</div>

<!-- Button trigger modal-->

            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered table-hover table-checkable text-center" id="kt_datatable"
                    style="margin-top: 13px !important">
                    <thead>
                        <tr class="text-center fw-bolder">
                            <th>ID</th>
                            <th class="text-center">Image</th>
            <th class="no-sort text-center">Action</th>
                        </tr>
                    </thead>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<br>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script>
    $(function () {
    jQuery.noConflict()
    $('#kt_datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: 
        {
            url:  "<?php echo e(route('frame')); ?>",
            type: "get",
            data: { _token: "<?php echo e(csrf_token()); ?>" }
        },
        columns: 
            [
                { data: "id" }
                ,
                {
                    data: null,
                    orderable: false,
                    render: function (data) 
                    {
                        return `<img src="/images/Bottom Bar Assets/${data.fram_path}" alt="Image" style="width: 100px; height: 100px;" />`;
                    }
                }
                ,
                {
                    data: null,
                    orderable: false,
                    render: function (data) 
                    {
                        return `
                            <button class="btn btn-primary" onclick="editImage(${data.id})">Edit</button>
                            <button class="btn btn-danger" onclick="deleteImage(${data.id})">Delete</button>
                        `;
                    }
                }
            ]
    });
});
function deleteItem(deleteid) {
    if (confirm("Are you sure you want to delete this?")) {
        $.ajax({
            url: "deleteiamgecategory/" + deleteid,
            type: 'delete',
            data: { _token: "<?php echo e(csrf_token()); ?>" },
            success: function () {
                console.log("Successfully Deleted");
                $('#kt_datatable').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                console.error("Error deleting item:", error);
              
            }
        });
    }
}
function editItem(editid) {
        window.location.href = "<?php echo e(url('edit')); ?>/"+ editid;
    }


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laravel\postermaker\postermaker\resources\views/admin/framedisplay.blade.php ENDPATH**/ ?>