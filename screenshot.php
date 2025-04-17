<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Work Tracker</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        #notification {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <button id="checkin-btn">Check In</button>
    <button id="checkout-btn" disabled>Check Out</button>

    <div id="notification">Your screen is being accessed</div>

    <script>
        let screenshotInterval;
        let checkInTime;
        let mediaStream;

        async function startScreenCapture() {
            try {
                mediaStream = await navigator.mediaDevices.getDisplayMedia({ video: true });
                return true;
            } catch (err) {
                console.error("Error: " + err);
                return false;
            }
        }

        function stopScreenCapture() {
            if (mediaStream) {
                let tracks = mediaStream.getTracks();
                tracks.forEach(track => track.stop());
                mediaStream = null;
            }
        }

        async function captureScreenshot() {
            if (!mediaStream) {
                let accessGranted = await startScreenCapture();
                if (!accessGranted) {
                    alert("Screen capture permission denied.");
                    return;
                }
            }

            let videoTrack = mediaStream.getVideoTracks()[0];
            let imageCapture = new ImageCapture(videoTrack);
            let bitmap = await imageCapture.grabFrame();

            let canvas = document.createElement('canvas');
            canvas.width = bitmap.width;
            canvas.height = bitmap.height;
            let context = canvas.getContext('2d');
            context.drawImage(bitmap, 0, 0, bitmap.width, bitmap.height);

            let dataURL = canvas.toDataURL('image/png');
            $.ajax({
                type: 'POST',
                url: 'save_screenshot.php',
                data: { imgBase64: dataURL },
                success: function(response) {
                    console.log('Screenshot saved successfully!');
                },
                error: function(err) {
                    console.error('Error saving screenshot:', err);
                }
            });
        }

        $('#checkin-btn').on('click', async function() {
            // Record the check-in time
            checkInTime = new Date();

            // Enable the Check Out button
            $('#checkout-btn').prop('disabled', false);
            $('#checkin-btn').prop('disabled', true);

            // Start taking screenshots every 5 minutes
            screenshotInterval = setInterval(async function() {
                $('#notification').fadeIn().delay(3000).fadeOut();
                await captureScreenshot();
            }, 300000); // 300000 ms = 5 minutes

            $('#notification').fadeIn().delay(3000).fadeOut();
            await captureScreenshot();
        });

        $('#checkout-btn').on('click', function() {
            // Record the check-out time and calculate the duration
            let checkOutTime = new Date();
            let duration = checkOutTime - checkInTime; // Duration in milliseconds

            // Convert duration to hours, minutes, and seconds
            let hours = Math.floor(duration / 3600000);
            let minutes = Math.floor((duration % 3600000) / 60000);
            let seconds = Math.floor((duration % 60000) / 1000);

            console.log(`Checked in for: ${hours} hours, ${minutes} minutes, ${seconds} seconds`);

            // Stop taking screenshots
            clearInterval(screenshotInterval);
            stopScreenCapture();

            // Reset buttons
            $('#checkout-btn').prop('disabled', true);
            $('#checkin-btn').prop('disabled', false);

            alert('You have checked out.');
        });
    </script>
</body>
</html>
