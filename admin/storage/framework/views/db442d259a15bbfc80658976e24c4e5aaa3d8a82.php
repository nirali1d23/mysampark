<?php $__env->startSection('content'); ?>
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
                        <h3 class="card-title">UpdateFrame</h3>
                    </div>
                    <form class="form" id="myform" enctype="multipart/form-data" action="<?php echo e(url('/updateframe/' . $data->id )); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                      
                          <div class="card-body">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label>Enter A new Frame:</label>
                                    <input type="file" class="form-control" placeholder="Enter New Frame" name="image" />
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u273329571/domains/bestdevelopmentteam.com/public_html/postermaker/resources/views/admin/frameedit.blade.php ENDPATH**/ ?>