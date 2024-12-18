@extends('admin.layouts.app')

@section('content')
<style>
    .card-footer {
        border-top: none;
    }

    .add-model {
        margin-top: 20px;
    }

    .add-award {
        margin-top: 20px;
    }
</style>

<div class="d-flex flex-column-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Image</h3>
                    </div>
                    <form class="form" id="myform" enctype="multipart/form-data" action="{{ url('image/'.request()->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Category name:</label>
                                    <input type="text" class="form-control" placeholder="Enter category name" name="name" value="{{ old('name') }}" />
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-left">Enter Category Images:</label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="image-input image-input-outline" id="kt_image_2">
                                        <div id="specialImagePreviewContainer" class="d-flex flex-wrap"></div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="Select Image">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input id="specialImageInput" type="file" name="cat_images[]" accept=".png, .jpg, .jpeg" onchange="displaySingleImage(event, 'specialImagePreviewContainer')" />
                                        </label>
                                    </div>
                                    @error('cat_images')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ request()->id }}">
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-left">Enter Images:</label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="image-input image-input-outline" id="kt_image_1">
                                        <div id="galleryImagePreviewContainer" class="d-flex flex-wrap"></div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="Select Image">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input id="galleryImageInput" type="file" name="images[]" multiple accept=".png, .jpg, .jpeg" onchange="displayImages(event, 'galleryImagePreviewContainer')" required />
                                        </label>
                                    </div>
                                    @error('images')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" name="submit" class="btn btn-primary mr-2">Save</button>
                                    <button type="button" class="btn btn-secondary" onclick="clearForm()">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function displayImages(event, previewContainerId) {
        var imageInput = event.target;
        var imagePreviewContainer = document.getElementById(previewContainerId);
        
        // Clear previous previews
        imagePreviewContainer.innerHTML = '';
        
        // Loop through each selected file
        for (var i = 0; i < imageInput.files.length; i++) {
            var file = imageInput.files[i];
            var reader = new FileReader();
            
            reader.onload = (function(file) {
                return function(e) {
                    // Create preview elements as before
                    var previewDiv = createPreviewElement(e.target.result);
                    imagePreviewContainer.appendChild(previewDiv);
                };
            })(file);
            
            // Read the image file as a data URL
            reader.readAsDataURL(file);
        }
    }
    function displaySingleImage(event, previewContainerId) {
        var imageInput = event.target;
        var imagePreviewContainer = document.getElementById(previewContainerId);
        
        // Clear previous previews if any
        imagePreviewContainer.innerHTML = '';
        
        var file = imageInput.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var previewDiv = createPreviewElement(e.target.result);
            imagePreviewContainer.appendChild(previewDiv);
        };
        // Read the image file as a data URL
        reader.readAsDataURL(file);
    }
    function createPreviewElement(imageUrl) {
        var previewDiv = document.createElement('div');
        previewDiv.classList.add('image-preview');
        var imgElement = document.createElement('img');
        imgElement.src = imageUrl;
        imgElement.alt = 'Preview Image';
        imgElement.style.maxWidth = '100px'; // Adjust the maximum width of the preview images
        imgElement.style.maxHeight = '100px'; // Adjust the maximum height of the preview images
        
        previewDiv.appendChild(imgElement);
        
        var removeButton = document.createElement('button');
        removeButton.innerHTML = '<i class="ki ki-bold-close icon-xs text-muted"></i>';
        removeButton.classList.add('btn', 'btn-xs', 'btn-icon', 'btn-circle', 'btn-white', 'btn-hover-text-primary', 'btn-shadow', 'remove-button');
        removeButton.onclick = function() {
            previewDiv.remove();
        };
        previewDiv.appendChild(removeButton);
        return previewDiv;
    }
    function clearForm() {
        document.getElementById('myform').reset();
        // Reset image preview containers if needed
        document.getElementById('galleryImagePreviewContainer').innerHTML = '';
        document.getElementById('specialImagePreviewContainer').innerHTML = '';
    }
</script>
@endsection
