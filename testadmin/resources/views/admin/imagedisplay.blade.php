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
                    <h3 class="card-label">Image List</h3>
                </div>
                <!-- Button trigger modal -->
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <a href="{{ url('/createimages') }}" class="btn btn-primary font-weight-bolder">
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
                        </span>New Record</a>
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered table-hover table-checkable text-center" id="kt_datatable"
                    style="margin-top: 13px !important">
                    <thead>
                        <tr class="text-center fw-bolder">
                            <th>ID</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Type</th>
                            <th class="no-sort text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<br>
<!-- Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="exampleSelectd">Select category</label>
                <select class="form-control" id="exampleSelectd" name="category_id">
                    <option value="">Select category</option>
                </select>
            </div>
            <div class="modal-body">
                <label for="name"> image</label>
                <input type="file" id="image" name="image"><br><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary font-weight-bold">Save</button>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script>
    $(function () {
        jQuery.noConflict();
        $('#kt_datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('image') }}",
                type: "GET",
                data: { _token: "{{ csrf_token() }}" }
            },
            columns: [
                { data: "id" },
                {
                    data: "image",
                    orderable: false,
                    render: function (data, type, row) {
                       
                        let imagePath = `/images/${data}`; 

                        return `<img src="${imagePath}" alt="Image" style="width: 50px; height: auto;" />`;
                    }
                },
                {
                    data : "type"
                },
                {
                    data: null,
                    orderable: false,
                    render: function (data) {
                        return `
                         
                            <button class="btn btn-danger" onclick="deleteItem(${data.id})">Delete</button>
                        `;
                    }
                }
            ]
        });
    });
   // <button class="btn btn-primary" onclick="editItem(${data.id})">Edit</button>
    function deleteItem(deleteid) 
    {
        if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
                url: "deleteimage/" + deleteid,
                type: 'DELETE',
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
        window.location.href = "{{ url('editimage') }}/" + editid;
    }

    $(document).ready(function() 
    {
        $('#exampleModal').on('show.bs.modal', function() {
            alert("function called");
            $.ajax({
                url: '/get-categories',
                type: 'GET',
                success: function(response) {
                    $('#exampleSelectd').empty(); // Clear existing options
                    $('#exampleSelectd').append('<option value="">Select category</option>'); // Add a default option
                    $.each(response, function(index, category) {
                        $('#exampleSelectd').append('<option value="' + category.id + '">' + category.name + '</option>');
                    });
                },
                error: function() {
                    alert('Failed to fetch categories. Please try again.');
                }
            });
        });
    });
</script>

@endsection
