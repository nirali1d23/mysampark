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
    <form action="{{ route('storeframe') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Frame and Icon Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Frame Upload -->
                    <div class="form-group">
                        <label for="frame">Frame Image:</label>
                        <input type="file" id="frame" name="frame" class="form-control">
                    </div>

                    <!-- Address Icon Details -->
                    <div class="form-group">
                        <h6>Address Icon</h6>
                        <label for="address_icon">Icon Image:</label>
                        <input type="file" id="address_icon" name="address_icon" class="form-control">
                        <label for="address_x" class="mt-2">X Coordinate:</label>
                        <input type="number" id="address_x" name="address_x" class="form-control" placeholder="X">
                        <label for="address_y" class="mt-2">Y Coordinate:</label>
                        <input type="number" id="address_y" name="address_y" class="form-control" placeholder="Y">
                        <label for="address_color" class="mt-2">Color:</label>
                        <input type="text" id="address_color" name="address_color" class="form-control">
                    </div>

                    <!-- Mobile Icon Details -->
                    <div class="form-group">
                        <h6>Mobile Icon</h6>
                        <label for="mobile_icon">Icon Image:</label>
                        <input type="file" id="mobile_icon" name="mobile_icon" class="form-control">
                        <label for="mobile_x" class="mt-2">X Coordinate:</label>
                        <input type="number" id="mobile_x" name="mobile_x" class="form-control" placeholder="X">
                        <label for="mobile_y" class="mt-2">Y Coordinate:</label>
                        <input type="number" id="mobile_y" name="mobile_y" class="form-control" placeholder="Y">
                        <label for="mobile_color" class="mt-2">Color:</label>
                        <input type="text" id="mobile_color" name="mobile_color" class="form-control">
                    </div>

                    <!-- Website Icon Details -->
                    <div class="form-group">
                        <h6>Website Icon</h6>
                        <label for="website_icon">Icon Image:</label>
                        <input type="file" id="website_icon" name="website_icon" class="form-control">
                        <label for="website_x" class="mt-2">X Coordinate:</label>
                        <input type="number" id="website_x" name="website_x" class="form-control" placeholder="X">
                        <label for="website_y" class="mt-2">Y Coordinate:</label>
                        <input type="number" id="website_y" name="website_y" class="form-control" placeholder="Y">
                        <label for="website_color" class="mt-2">Color:</label>
                        <input type="text" id="website_color" name="website_color" class="form-control">
                    </div>

                    <!-- Mail Icon Details -->
                    <div class="form-group">
                        <h6>Mail Icon</h6>
                        <label for="mail_icon">Icon Image:</label>
                        <input type="file" id="mail_icon" name="mail_icon" class="form-control">
                        <label for="mail_x" class="mt-2">X Coordinate:</label>
                        <input type="number" id="mail_x" name="mail_x" class="form-control" placeholder="X">
                        <label for="mail_y" class="mt-2">Y Coordinate:</label>
                        <input type="number" id="mail_y" name="mail_y" class="form-control" placeholder="Y">
                        <label for="mail_color" class="mt-2">Color:</label>
                        <input type="text" id="mail_color" name="mail_color" class="form-control">
                    </div>
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
            url:  "{{ route('frame') }}",
            type: "get",
            data: { _token: "{{ csrf_token() }}" }
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
                          
                             <button class="btn btn-success" onclick="editImage(${data.id})">Edit</button>
                              <button class="btn btn-primary" onclick="appparameter(${data.id})">App Parameter</button>
                            <button class="btn btn-danger" onclick="deleteImage(${data.id})">Delete</button>
                        `;
                    }
                }
            ]
    });
});
function deleteImage(deleteid) {
    if (confirm("Are you sure you want to delete this?")) {
        $.ajax({
            url: "deleteframe/" + deleteid,
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
// <button class="btn btn-success" onclick="editItem(${data.id})">Edit</button>
function editImage(editid) {
        window.location.href = "{{ url('editframe') }}/"+ editid;
    }

    function appparameter(editid) {
        window.location.href = "{{ url('appparamter') }}/"+ editid;
    }


</script>
@endsection