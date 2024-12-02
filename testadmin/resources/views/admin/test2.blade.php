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
  
  <div class="container">
    <div class="static-image">
        {{-- <img id="main-image" src="/images/Artboard 1 4.png" alt="Your Image"> --}}
        <img id="main-image" src="{{ asset('/images/user_logo.png') }}" alt="Your Image">
  
      </div>
      <div class="frame" id="frame1">
          <img src="/images/2.png" alt="Frame 1">
          <div class="static-details email">
              {{-- <p>{{ $business->email }}</p> --}}
              <p>dsfdsaf</p>
          </div>
          <div class="static-details contact">
              {{-- {{ $business->mobile_no }}<br>
              {{ $business->second_mobile_no }} --}}
          </div>
          <div class="static-details website">
              {{-- <p>{{ $business->website }}</p> --}}
              <p>sdfsadf</p>
          </div>
          <div class="static-details location">
              {{-- <p>{{ $business->address }}</p> --}}
              <p>fdsfadsf</p>
          </div>
      </div>
  </div>

  
  </div>
         
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const frames = document.querySelectorAll('.frame');
      const mainImage = document.getElementById('main-image');
      // Function to update the frame size based on the main image size
      function updateFrameSize() {
        const container = document.querySelector('.container');
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
        event.preventDefault();
      });
      framesContainer.addEventListener('drop', (event) => {
        event.preventDefault();
        const data = event.dataTransfer.getData('text/plain');
        const draggedElement = document.getElementById(data);
        if (draggedElement) {
          event.target.appendChild(draggedElement);
        }
      });
      function downloadPhoto() {
        const link = document.createElement('a');
        link.download = 'photo.png';
        link.href = photoCanvas.toDataURL();
        link.click();
    }
    });
  </script>
</body>
</html>