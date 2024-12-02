@extends('admin.layouts.app')
<style>
    /* Full Image Container */
    #fullImageContainer {
        position: relative;
        display: inline-block; /* Centers the container content */
    }

    /* Main Image Styling */
    #fullImage {
        max-width: 100%; /* Set main image width to 40% */
        display: block;
    }

    /* Frame Image Styling */
    .frame-image {
        position: absolute;
        bottom: 0; /* Aligns the frame image's bottom with the main image */
        left: 0;
        width: 100%; /* Set frame image width to 40% */
    }

    /* Grid Styling */
    .frame-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); 
        gap: 10px; 
        justify-items: center; 
    }
</style>

@section('content')
<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-custom gutter-b example example-compact" id="formContainer">
                    <div class="card-header">
                        <h3 class="card-title">Image Create</h3>
                    </div>
                    <form class="form" id="dynamic_form" action="{{ route('storeimage') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleSelect1">Select Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="exampleSelect1" name="category_id">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleSelect1">Select Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="exampleSelect1" name="type">
                                    <option value="post">Post</option>
                                    <option value="story">Story</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Main Images: <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="images[]" id="main_image" accept="image/*" multiple />
                            </div>
                            
                            <div class="row">
                                <div class="col-lg-2">
                                    <label>Name Colour: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_colour" id="name_colour" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Mobile Colour: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="mobile_colour" id="mobile_colour" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Address Colour: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address_colour" id="address_colour" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Email Colour: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email_colour" id="email_colour" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Website Colour: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="website_colour" id="website_colour" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Company Colour: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="company_colour" id="company_colour" />
                                </div>
                               
                            </div>
                            <div class="row">
                              <div class="col-lg-3">
                                        <label>Address Icon Colour: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="address_icon_color" id="address_icon_color" placeholder="Enter address icon color" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Mobile Icon Colour: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="mobile_icon_color" id="mobile_icon_color" placeholder="Enter mobile icon color" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Email Icon Colour: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email_icon_color" id="email_icon_color" placeholder="Enter email icon color" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label>Website Icon Colour: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="website_icon_color" id="website_icon_color" placeholder="Enter website icon color" />
                                    </div>
                          
                            </div>
                           
                            <div class="form-group">
                                <label>Date: <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date" id="date" />
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" id="viewButton" class="btn btn-success mr-2">View</button>
                                    <button type="submit" class="btn btn-primary mr-2">Save</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Full-page Image Container -->
                <div id="fullImageContainer" class="d-none text-center">
                    <div class="frame-grid">
                        <div style="position: relative;">
                            <img id="fullImage" class="img-fluid" />
                            <img id="frameImage" class="frame-image" />
                        </div>
                    </div>
                    <br>
                    <button type="button" id="backButton" class="btn btn-secondary mt-3">Back</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Eliminate gap between images */
    #fullImageContainer img {
        margin: 0;
        padding: 0;
        display: block;
    }
</style>

<script>
// Pass the PHP $frameImages array to JavaScript
const frameImages = @json($frameImages);

console.log(frameImages);

// View button to show the main image with all frame images
document.getElementById('viewButton').addEventListener('click', function () {
    const mainImageFile = document.getElementById('main_image').files[0];
    const fullImageContainer = document.getElementById('fullImageContainer');
    const formContainer = document.getElementById('formContainer');
    const fullImage = document.getElementById('fullImage');
    
    if (mainImageFile) {
        const reader = new FileReader();
        reader.onload = function (e) {
            fullImage.src = e.target.result;

            // Log frameImages to check if it's still an array at this point
            console.log(frameImages); // Check if it's an array here

            // Clear previous frame images
            const frameGrid = document.querySelector('.frame-grid');
            frameGrid.innerHTML = ''; // Reset grid

            // Display each frame with the main image
            frameImages.forEach((frame) => {
                const frameDiv = document.createElement('div');
                frameDiv.style.position = 'relative';
                
                const frameImage = document.createElement('img');
                frameImage.src = `/frames/${frame}`;
                frameImage.classList.add('frame-image');
                frameImage.style.maxWidth = '100%'; // Set frame image width to 40%
                frameImage.alt = "Frame Image";
                
                // Append both images to the grid
                frameDiv.appendChild(fullImage.cloneNode());
                frameDiv.appendChild(frameImage);
                frameGrid.appendChild(frameDiv);
            });

            formContainer.classList.add('d-none'); // Hide the form
            fullImageContainer.classList.remove('d-none'); // Show the full image container
        };
        reader.readAsDataURL(mainImageFile);
    }
});


// Back button to return to the form view
document.getElementById('backButton').addEventListener('click', function () {
    const fullImageContainer = document.getElementById('fullImageContainer');
    const formContainer = document.getElementById('formContainer');

    formContainer.classList.remove('d-none'); // Show the form
    fullImageContainer.classList.add('d-none'); // Hide the full image container
});
</script>

@endsection
