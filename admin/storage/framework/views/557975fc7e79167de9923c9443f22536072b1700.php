

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
                    <h3 class="card-label">Image Category List</h3>
                </div>
                <button type="button" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                    Add Category
                </button>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form action="<?php echo e(route('addpersonalcategory')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="name">Category Name:</label>
                                    <input type="text" id="name" name="name"><br><br>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered table-hover table-checkable" id="kt_datatable">
                    <thead>
                        <tr class="text-center fw-bolder">
                            <th>ID</th>
                            <th>Name</th>
                            <th class="no-sort">Action</th>
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
        ajax: {
            url:  "<?php echo e(route('personalcategory')); ?>",
            type: "post",
            data: { _token: "<?php echo e(csrf_token()); ?>" }
        },
        columns: [
    { data: "id" },
    { data: "name" },
    {
        data: null,
        orderable: false, 
        render: function (data) {
            return '<button type="button" onClick="editItem(' + data.id + ')" class="btn btn-sm btn-clean btn-icon mr-2">' +
            '<span class="svg-icon svg-icon-md">' +
            '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">' +
            '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
            '<rect x="0" y="0" width="24" height="24"/>' +
            '<path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>' +
            '<rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>' +
            '</g>' +
            '</svg>' +
            '</span>' +
            '</button>' +
            '<button type="button" onClick="deleteItem(' + data.id + ')" class="btn btn-sm btn-clean btn-icon mr-2">' +

            '<span class="svg-icon svg-icon-md">' +
            '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">' +
            '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
            '<rect x="0" y="0" width="24" height="24"/>' +
            '<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>' +
            '<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>' +
            '</g>' +
            '</svg>' +
            '</span>' +
            '</button>'+
            '<button type="button" onClick="vehicleadd(' + data.id + ')" class="btn btn-sm btn-clean" title="View records"><i class="flaticon2-document"></i>Add Category</button>';
           
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
        window.location.href = "<?php echo e(url('personaledit')); ?>/"+ editid;
    }

    function vehicleadd(vehicleid) {
        window.location.href = "<?php echo e(url('peronallist')); ?>/" + vehicleid;
    }


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laravel\postermaker\postermaker\resources\views/admin/personalcategory.blade.php ENDPATH**/ ?>