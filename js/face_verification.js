const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const captureButton = document.getElementById('capture-btn');
const submitButton = document.getElementById('submit-btn');
const capturedImageInput = document.getElementById('captured_image');

// Start webcam
navigator.mediaDevices
    .getUserMedia({ video: true })
    .then((stream) => {
        video.srcObject = stream;
    })
    .catch((error) => {
        console.error('Error accessing webcam:', error);
        alert('Unable to access the camera. Please allow camera permissions.');
    });

// Capture image from video feed
captureButton.addEventListener('click', () => {
    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    const imageDataURL = canvas.toDataURL('image/jpeg');
    capturedImageInput.value = imageDataURL;

    alert('Photo captured successfully!');
    submitButton.disabled = false; // Enable the submit button
});
