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
                    <h3 class="card-label">Frame List</h3>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#exampleModal">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path d="M8.8,7 C9.8,5.2 11.8,4 14,4 C17.3,4 20,6.7 20,10 C20,12.2 18.8,14.2 17,15.2 C17,10.6 13.4,7 9,7 Z" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                        </span>New Recorde
                    </button>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form action="{{route('testframeadd')}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
        
            {{-- //change --}}
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
            <div class="card-body">
                <table class="table table-bordered table-hover text-center" id="kt_datatable" style="margin-top: 13px !important">
                    <thead>
                        <tr class="text-center fw-bolder">
                            <th>ID</th>
                            <th class="text-center">Image</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach($images as $index => $image)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><img src="{{ asset('frames/' . basename($image)) }}" alt="Frame Image" style="width: 100px; height: 100px;" /></td>
            <td>
               <button class="btn btn-danger btn-sm delete-image" data-image="{{ basename($image) }}" data-id="{{ $index + 1 }}">
                Delete
            </button>
            </td>
           
        </tr>
    @endforeach
</tbody>

                </table>
            </div>
        </div>
        
        <script type="text/javascript">
    $(document).ready(function () {
        // Delete image on button click
        $('.delete-image').click(function () {
            var imageName = $(this).data('image');  // Image filename
            var imageId = $(this).data('id');       // Image ID for deleting from DB if needed
            
            if (confirm("Are you sure you want to delete this image?")) {
                $.ajax({
                    url: '/testframedelete',  // The route to handle deletion
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: imageName,  // Image name to delete
                    },
                    success: function(response) {
                        if (response.success) {
                            // Remove the row from the table
                            $('tr').filter('[data-id="'+ imageId +'"]').remove();
                            alert('Image deleted successfully!');
                        } else {
                            alert('Failed to delete image.');
                        }
                    },
                    error: function () {
                        alert('Error occurred. Please try again.');
                    }
                });
            }
        });
    });
</script>

        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<br>

@endsection
