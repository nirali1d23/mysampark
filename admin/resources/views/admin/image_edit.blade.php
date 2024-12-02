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
                    <form class="form" id="myform" enctype="multipart/form-data" action="{{ url('/updateimage/' . $image->id ) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Category name:</label>
                                    <input type="text" class="form-control" placeholder="Enter category name" name="name" value="{{$image->name}}" />
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-left">Upload Category Image:</label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="image-input image-input-outline" id="hero_image_input_container">
                                        <div id="hero_image_preview_container" class="d-flex flex-wrap">
                                            <img src="{{url("images/" . $image->image) }}" id="hero_image_preview" alt="Hero Image" style="max-height: 300px;
                                                max-width: 120px;" class="img-fluid">
                                        </div>
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="Change hero image">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input id="hero_image_input" type="file" name="cat_images" accept=".png, .jpg, .jpeg" onchange="displayImage(event, 'hero_image_preview')" />
                                        </label>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel hero image">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>
                                    </div>
                                    <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label text-left">Upload images:</label>
                                <div class=" " id="gallary_images">
                                    <div class="d-flex flex-wrap position-relative" style="gap: 20px">
                                        <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="Add new image">
                                            <i class="fa fa-pen icon-sm text-muted"></i>
                                            <input type="hidden" name="">
                                            <input id="newImageInput" type="file" name="image[]" accept=".png, .jpg, .jpeg" multiple onchange="displayNewImage(event)" style="display: none;" />
                                        </label>
                                    </div>
                                    @foreach($displayimage as $key => $image)
                                    <div class="image-input image-input-outline" id="kt_image_{{$key+1}}">
                                        <div id="imagePreviewContainer{{$key+1}}" class="d-flex flex-wrap position-relative">
                                          
                                            <img src="{{ url('images/' . $image->image) }}" alt="Old Image" style="max-height: 300px; max-width: 120px;" class="img-fluid">
                                            <span class="remove-image-btn" onclick="removeImage({{$key+1}})">
                                                <i class="fas fa-times"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div> --}}
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function removeImage(key) {
        var imageContainer = document.getElementById('kt_image_' + key);
        imageContainer.parentNode.removeChild(imageContainer);
    }

</script>
<script>
    function displayNewImage(event) {
        var newImageInput = event.target;
        var newImagePreviewContainer = newImageInput.closest('.d-flex.flex-wrap.position-relative');
        for (var i = 0; i < newImageInput.files.length; i++) {
            var file = newImageInput.files[i];
            var reader = new FileReader();
            reader.onload = (function(file) {
                return function(e) {
                    var imgElement = document.createElement('img');
                    imgElement.classList.add('image-input-wrapper');
                    imgElement.src = e.target.result;
                    imgElement.alt = 'Preview Image';
                    var imageContainer = document.createElement('div');
                    imageContainer.classList.add('image-input', 'image-input-outline', 'position-relative');
                    imageContainer.appendChild(imgElement);
                    var removeBtn = document.createElement('span');
                    removeBtn.classList.add('remove-image-btn');
                    removeBtn.onclick = function() {
                        imageContainer.remove();
                    };
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    imageContainer.appendChild(removeBtn);
                    newImagePreviewContainer.appendChild(imageContainer);
                };
            })(file);
            reader.readAsDataURL(file);
        }
    }

    function displayImage(event, previewId) {
        var imageInput = event.target;
        var previewContainer = document.getElementById(previewId);
        if (!previewContainer) {
            console.error("Image preview container not found");
            return;
        }
        previewContainer.innerHTML = '';
        var file = imageInput.files[0];
        console.log("Selected file: ", file);
        var reader = new FileReader();
        reader.onload = function(e) {
            console.log("File read successfully");
            var imgElement = document.createElement('img');
            imgElement.classList.add('image-input-wrapper');
            imgElement.src = e.target.result;
            imgElement.alt = 'Preview Image';
            previewContainer.appendChild(imgElement);
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    }

</script>
<script>
    $('.add-award').on('click', function() {
        var emptyAwardTemplate = $('#custom_repeater_item [data-repeater-item]:last').clone();
        emptyAwardTemplate.find('input[type="text"]').val('');
        emptyAwardTemplate.find('select').val('');
        emptyAwardTemplate.find('.image-input-wrapper').remove();
        emptyAwardTemplate.find('input[type="file"]').val('');
        $('#custom_repeater_item [data-repeater-list]').append(emptyAwardTemplate);

    });


    $(document).on('change', '.award-image-input', function(event) {
        var previewId = $(this).closest('.image-input').attr('id') + '_preview';
        displayImage(event, previewId);
    });
    $('[data-repeater-list]').on('click', '[data-custom-repeater-delete]', function() {
        var list = $(this).closest('[data-repeater-list]');
        if (list.find('[data-repeater-item]').length > 1) {
            $(this).closest('[data-repeater-item]').remove();
        } else {
            alert("At least one award must be present.");
        }
    });
            $('.add-model').on('click', function() {
        var newItem = $('#kt_repeater_item [data-repeater-item]:first').clone();
        newItem.find('input[type="text"]').val('');
        $('#kt_repeater_item [data-repeater-list]').append(newItem);
    });
    $('[data-repeater-list]').on('click', '[data-repeater-delete]', function() {
var list = $(this).closest('[data-repeater-list]');
if (list.find('[data-repeater-item]').length > 1) {
    $(this).closest('[data-repeater-item]').remove();
} else {
    alert("At least one model must be present.");
}
});


    document.getElementById('hero_image_input').addEventListener('change', function(event) {
        displayImage(event, 'hero_image_preview_container');
    });
  
    function displayImage(event, previewId) {
    var file = event.target.files[0];
    var reader = new FileReader();
    
    reader.onload = function(e) {
        var preview = document.getElementById(previewId);
        var img = preview.querySelector('#hero_image_preview');
        img.src = e.target.result;
    }
    
    reader.readAsDataURL(file);
}

      

</script>

@endsection
