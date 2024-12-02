@extends('admin.layouts.app')
@section('content')
<div class="d-flex flex-column-fluid">
<!--begin::Container-->
<div class="container">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <span class="card-icon">
                        <i class="flaticon2-supermarket text-primary"></i>
                    </span>
                    <h3 class="card-label">User  List</h3>
                </div>
            </div>
    <div class="card-body">
                <!--begin: Datatable-->
    <table class="table table-bordered table-hover table-checkable text-center" id="kt_datatable"
                    style="margin-top: 13px !important">
      <thead>                  
        <tr class="text-center fw-bolder">
            <th>ID</th>
            <th class="text-center">Name</th>
            <th class="text-center">Email</th>     
            <th class="text-center">Mobileno</th>
            <th class="text-center">Action</th>
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
$(function() 
{
    jQuery.noConflict()
    $('#kt_datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url:  "{{ route('userlist') }}",
           
            type: "get",
            data: { _token: "{{ csrf_token() }}" }
        },
        columns: [
                { data: "id" },
                { data: "name" },
                { data: "email" },
                { data: "mobileno" },
                {
                    data: null,
                    orderable: false,
                    render: function (data) {
                        return `
                         
                            <button class="btn btn-outline-success" onclick="viewItem(${data.id})">View</button>
                            <button class="btn btn-outline-primary" onclick="editItem(${data.id})">Edit</button>
                        `;
                    }
                }
            ]
    });
});
function deleteItem(deleteid) 
{
    if(confirm("Are you sure you want to delete this?")) {
        $.ajax({
            url: "deleteiamgecategory/" + deleteid,
            type: 'delete',
            data: { _token: "{{ csrf_token() }}" },
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
function editItem(editid) 
{
    window.location.href = "{{ url('edituser') }}/"+ editid;
}
function viewItem(editid) 
{
    window.location.href = "{{ url('viewuser') }}/"+ editid;
}
</script>
@endsection