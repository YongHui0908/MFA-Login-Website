    // Regular expression to validate password
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    const passwordField = document.getElementById('psw');
    const confirmPasswordField = document.getElementById('cpsw');
    const passwordHelp = document.getElementById('passwordHelpInline');

    // Validate password on input
    passwordField.addEventListener('input', () => {
        if (passwordRegex.test(passwordField.value)) {
            passwordHelp.textContent = ' * Password is strong.';
            passwordHelp.style.color = 'green';
        } else {
            passwordHelp.textContent = ' * Password is weak';
            passwordHelp.style.color = 'red';
        }
    });

    // Validate confirm password
    confirmPasswordField.addEventListener('input', () => {
        if (passwordField.value === confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity('');
        } else {
            confirmPasswordField.setCustomValidity('Passwords do not match.');
        }
    });

    const camera = document.getElementById('camera');
    const canvas = document.getElementById('canvas');
    const previewContainer = document.getElementById('previewContainer');
    const captureButton = document.getElementById('capture');
    const retakeButton = document.getElementById('retake');
    const imageDataInput = document.getElementById('imageData');

    // Access the user's camera
    navigator.mediaDevices.getUserMedia({ video: true })
        .then((stream) => {
            camera.srcObject = stream;
        })
        .catch((err) => console.error('Camera access denied:', err));

    // Capture image on button click
    captureButton.addEventListener('click', () => {
        const context = canvas.getContext('2d');
        canvas.width = camera.videoWidth;
        canvas.height = camera.videoHeight;
        context.drawImage(camera, 0, 0, canvas.width, canvas.height);

        // Convert to base64 and display the image
        const capturedImage = canvas.toDataURL('image/jpeg');
        const imgPreview = document.createElement('img');
        imgPreview.src = capturedImage;
        imgPreview.width = 320;
        imgPreview.height = 240;

        // Clear the preview container and append the new image
        previewContainer.innerHTML = '';
        previewContainer.appendChild(imgPreview);

        // Hide the camera and capture button, show the retake button
        camera.style.display = 'none';
        captureButton.style.display = 'none';
        retakeButton.style.display = 'inline';

        // Set the image data for submission
        // console.log('Captured Image:', capturedImage);
        imageDataInput.value = capturedImage;
    });

    // Retake button functionality
    retakeButton.addEventListener('click', () => {
        // Clear the preview container
        previewContainer.innerHTML = '';

        // Show the camera and capture button, hide the retake button
        camera.style.display = 'block';
        captureButton.style.display = 'inline';
        retakeButton.style.display = 'none';

        // Clear the image data
        imageDataInput.value = '';
    });

    // Submit the captured image
    // submitButton.addEventListener('click', () => {
    //         document.getElementById('uploadForm').submit();
    //     });
// JavaScript remains unchanged except adding `disableSubmit` to prevent duplicate submission
    function disableSubmit(button) {
        button.disabled = true;
        button.form.submit();
    }


    // Preloader functionality
    window.addEventListener("load", function () {
        const loader = document.getElementById("preloader");
        if (loader) {
            loader.style.display = "none";
        }
    });


    function captureImage(video, canvas) {
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        return canvas.toDataURL('image/jpeg');
    }
    
    function cropFace(image, faceBoundingBox, canvas) {
        const ctx = canvas.getContext('2d');
        const { left, top, width, height } = faceBoundingBox;
    
        const imageElement = new Image();
        imageElement.src = image;
    
        imageElement.onload = () => {
            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(
                imageElement,
                left, top, width, height,
                0, 0, width, height
            );
        };
    
        return canvas.toDataURL('image/jpeg');
    }
    

