<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Frame Swiper</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #F0F0F0;
    }
    .container {
      position: relative;
      overflow: hidden;
      width: 500px;
      height: 700px;
    }
    .static-image img {
      width: 100%;
      height: 100%;
    }
    .frame {
      position: absolute;
      bottom: -3px;
      left: 0;
      width: 100%
    }
    .frame img {
    width: 100%
    }
    .static-details {
      position: absolute;
      display: flex;
      align-items: center;
      padding: 10px;
      border-radius: 5px;
      pointer-events: auto; 
      cursor: move;
    }
    .static-details img {
      width: 24px; /* Adjust icon size */
      height: 24px;
    }
    /* Example positioning adjustments */
    #frame1 .static-details.email {
      bottom: 4.5px;
    left: 57px;
    font-size: 7px;
    margin-left: -23px;
    padding-bottom: 7px;
    color: white;
    }
    #frame1 .static-details.contact {
      top: 25px;
    right: 47px;
    font-size: 19px;
    color: white;
    font-weight: 800;
}
    #frame1 .static-details.website {
      top: 48px;
    left: 167px;
    font-size: 9px;
    color: white;
    }
    #frame1 .static-details.location {
      bottom: 39px;
    right: 382px;
    color: white;
    font-size: 11px;
    }
    #frame2 .static-details.email {
      bottom: 58.3px;
    left: 20px;
    font-size: 11px;
    color: white;
    }
    #frame2 .static-details.contact {
      top: 29px;
    right: 289px;
    font-size: 19px;
    font-weight: 600;
    }
    #frame2 .static-details.website {
      top: -18px;
    left: 155px;
    font-size: 11px;
    color: white;
    }
    #frame2 .static-details.location {
      bottom: 23px;
    right: 73px;
    font-size: 11px;
    color: white;
    max-width: 99px;
    }
#frame3 .static-details.email {
  bottom: 35px;
    left: 282px;
    font-size: 14px;
    font-weight: bold;
}
#frame3 .static-details.contact {
  top: 20px;
    right: 333px;
    font-size: 17px;
    font-weight: 600;
}
#frame3 .static-details.website {
  top: -11px;
    left: 163px;
    font-size: 15px;
    color: white;
}
#frame3 .static-details.location {
  bottom: -2px;
    right: 348px;
    font-size: 14px;
    font-weight: bold;
}
  </style>
</head>
<body>
  
  <div class="container" id="imagesss">
    <div class="static-image">
        
        <img id="main-image" src="http://127.0.0.1:8000/images/user_logo.png" alt="Your Image">
  
      </div>
      <div class="frame" id="frame1">
          <img src="http://127.0.0.1:8000/images/2.png" alt="Frame 1">
          <div class="static-details email">
           <p>  email:hello@gmail.com</p>
          </div>
          <div class="static-details contact">
            <p>  email:hello@gmail.com</p>
          </div>
          <div class="static-details website">
            <p>  email:hello@gmail.com</p>
          </div>
          <div class="static-details location">
            <p>  email:hello@gmail.com</p>
          </div>
      </div>
  </div>
<br>
  <div id="output"></div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.5/dist/html2canvas.min.js">
      </script>
  <script>


document.addEventListener('DOMContentLoaded', function () {
    const frames = document.querySelectorAll('.frame');
    const mainImage = document.getElementById('main-image');
    const container = document.querySelector('.static-image');

    // Function to update the frame size based on the main image size
    function updateFrameSize() {
        const width = mainImage.clientWidth;
        const height = mainImage.clientHeight;
        container.style.width = width + 'px';
        container.style.height = height + 'px';
        frames.forEach(frame => {
            frame.style.width = width + 'px';
            frame.style.height = 'auto';
        });
    }

    mainImage.onload = updateFrameSize;
    window.onresize = updateFrameSize;

    let currentFrameIndex = 0;

    function showFrame(index) {
        frames.forEach((frame, i) => {
            frame.style.display = i === index ? 'block' : 'none';
        });
    }

    function nextFrame() {
        currentFrameIndex = (currentFrameIndex + 1) % frames.length;
        showFrame(currentFrameIndex);
    }

    function previousFrame() {
        currentFrameIndex = (currentFrameIndex - 1 + frames.length) % frames.length;
        showFrame(currentFrameIndex);
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowRight') {
            nextFrame();
        } else if (event.key === 'ArrowLeft') {
            previousFrame();
        }
    });

    showFrame(currentFrameIndex);

    // Drag and Drop functionality
    const detailsElements = document.querySelectorAll('.static-details');
    detailsElements.forEach(element => {
        element.addEventListener('dragstart', (event) => {
            event.dataTransfer.setData('text/plain', event.target.id);
            event.target.classList.add('dragging');
        });
        element.addEventListener('dragend', (event) => {
            event.target.classList.remove('dragging');
        });
    });

    const framesContainer = document.querySelector('.container');
    framesContainer.addEventListener('dragover', (event) => {
        event.preventDefault(); // Prevent default behavior to allow drop
    });

    framesContainer.addEventListener('drop', (event) => {
        event.preventDefault();
        const data = event.dataTransfer.getData('text/plain');
        const draggedElement = document.getElementById(data);
        if (draggedElement) {
            framesContainer.appendChild(draggedElement); // Append to container instead of target
        }
    });

    // Capture and save image using html2canvas
    window.addEventListener('load', function () {
        html2canvas(document.body).then(function(canvas) {
            canvas.toBlob(function(blob) {
                let formData = new FormData();
                formData.append('image', blob, 'snapshot.png');
                fetch('<?php echo e(route("store.snapshot")); ?>', {
                    method: 'POST',
                    body: formData,
                  
                }).then(response => {
                    if (response.ok) {
                        console.log('Snapshot saved successfully!');
                    } else {
                        console.error('Failed to save snapshot');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
});


  // window.onload = function() 
  //   {
  //       takeshot();
  //   };
// function takeshot() 
// {
//     let div = document.getElementById('imagesss');
//     html2canvas(div).then(function(canvas) {
//         let image = canvas.toDataURL("image/png");
//         let downloadLink = document.createElement('a');
//         downloadLink.download = "snapshot.png";
//         downloadLink.href = image;
//         downloadLink.click();
//     });
// }

//2 chatgpt
// function takeshot() {
//     let div = document.getElementById('imagesss');
//     html2canvas(div).then(function (canvas) {
//         let image = canvas.toDataURL('image/png'); // Get base64 image data
//         fetch('/save-snapshot', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({ image: image }) // Send base64 data to the server
//         }).then(response => {
//             if (response.ok) {
//                 alert('Snapshot saved successfully.');
//             } else {
//                 alert('Failed to save snapshot.');
//             }
//         });
//     });
// }

//3 chatgpt



  </script>
</body>
</html><?php /**PATH C:\laravel\postermaker\postermaker\resources\views/admin/test.blade.php ENDPATH**/ ?>