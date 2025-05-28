<section class="site-visit-container" id="SiteVisitHandler" style="display: none;">
    <form id="siteVisitForm" class="data-container" method="POST" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>/ModuleController/SiteVisitController.php">
        <?php echo FormPrimaryInputs(true); ?>
        <input type="hidden" name="SiteVisitIdForBackend" id="SiteVisitIdDB" value="">
        <input type="hidden" name="LeadsId" id="GetLeadId" value="">
        <h1 class="app-heading"><i class="fa fa-map-marker text-success"></i> Add Site Visit Details</h1>
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="text-primary fw-bold mb-0"><?php echo isset(ART_ICON['guest']) ? ART_ICON['guest'] : 'Guest'; ?> <span id="PersonName"></span></h5>
            <h6 class="text-success fw-bold mb-0 mt-0"><?php echo isset(ART_ICON['call']) ? ART_ICON['call'] : 'Call'; ?> <span id="PersonPhoneNumber"></span></h6>
            <h6 class="text-info fw-bold mb-0 mt-0"><?php echo isset(ART_ICON['star']) ? ART_ICON['star'] : 'Star'; ?> Project: <span id="ProjectName"></span></h6>
            <p>
                <span class="fw-bold small"><?php echo isset(ART_ICON['info']) ? ART_ICON['info'] : 'Info'; ?></span>
                <span id="LastMessage"></span>
            </p>
        </div>

        <div class="feedbackarea">
            <div class="CapturePhoto" style="position: relative; width: 100%; height: 400px; overflow: hidden; background: #000;">
                <video id="cameraFeed" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover; display: block;"></video>
                <img id="capturedImage" style="width: 100%; height: 100%; object-fit: cover; display: none;" alt="Captured Photo">
                <canvas id="photoCanvas" style="display: none;"></canvas>
                <div id="cameraError" style="display: none; color: red; font-size: 12px; position: absolute; bottom: 40px; left: 10px;">Camera access failed. Please check permissions.</div>
                <div style="position: absolute; bottom: 10px; left: 10px; z-index: 9999;">
                    <button type="button" id="captureButton" class="btn btn-primary btn-sm">📸 Capture Now</button>
                    <button type="button" id="recaptureButton" class="btn btn-warning btn-sm" style="display: none;">🔄 Recapture</button>
                </div>
                <input type="hidden" name="captured_photo" id="capturedPhotoInput">
                <textarea name="photo_details" id="photoDetails" readonly style="display: none;"></textarea>
            </div>

            <div class="form-group mt-3">
                <label>Customer Feedback About Site Visit</label>
                <textarea class="form-control" name="leads_site_visit_response" id="leads_site_visit_response" rows="2" placeholder="Enter Customer feedback here..."></textarea>
            </div>
        </div>

        <div class="site-visit-footer text-center mt-3">
            <hr>
            <button type="submit" name="SiteVisitCompleted" class="btn btn-dark btn-md">Complete Site Visit <i class="fa fa-check text-success"></i></button>
            <a class="btn btn-md btn-default" onclick="ControlForms('SiteVisitHandler')"><i class="fa fa-times"></i> Cancel</a>
        </div>
    </form>

    <script>
        function SiteVisitController(GetLeadId, SiteVisitId, PersonName, PersonPhoneNumber, LastMessage, ProjectName) {
            try {
                document.getElementById("SiteVisitIdDB").value = SiteVisitId || '';
                document.getElementById("GetLeadId").value = GetLeadId || '';
                document.getElementById("PersonName").innerHTML = PersonName || '';
                document.getElementById("PersonPhoneNumber").innerHTML = PersonPhoneNumber || '';
                document.getElementById("LastMessage").innerHTML = LastMessage || '';
                document.getElementById("ProjectName").innerHTML = ProjectName || '';
                document.getElementById("SiteVisitHandler").style.display = "block";
                startCamera();
            } catch (err) {
                console.error('Error in SiteVisitController:', err);
                alert('Failed to initialize form: ' + err.message);
            }
        }

        function startCamera() {
            const video = document.getElementById('cameraFeed');
            const captureButton = document.getElementById('captureButton');
            const capturedImage = document.getElementById('capturedImage');
            const recaptureButton = document.getElementById('recaptureButton');
            const cameraError = document.getElementById('cameraError');

            // Reset UI
            capturedImage.style.display = 'none';
            recaptureButton.style.display = 'none';
            video.style.display = 'block';
            cameraError.style.display = 'none';
            captureButton.style.display = 'block';

            // Check for camera support
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                cameraError.innerText = 'Camera not supported on this device.';
                cameraError.style.display = 'block';
                captureButton.style.display = 'none';
                console.error('Camera API not supported');
                return;
            }

            // Access the device camera
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: {
                            ideal: 'environment'
                        },
                        width: {
                            ideal: 720
                        },
                        height: {
                            ideal: 600
                        }
                    }
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.onloadedmetadata = () => {
                        video.play().catch(err => {
                            console.error('Error playing video:', err);
                            cameraError.innerText = 'Failed to start camera.';
                            cameraError.style.display = 'block';
                            captureButton.style.display = 'none';
                        });
                    };
                })
                .catch(err => {
                    console.error('Error accessing camera:', err);
                    cameraError.innerText = 'Camera access failed. Please check permissions.';
                    cameraError.style.display = 'block';
                    captureButton.style.display = 'none';
                });
        }

        function capturePhoto() {
            try {
                const video = document.getElementById('cameraFeed');
                const canvas = document.getElementById('photoCanvas');
                const capturedPhotoInput = document.getElementById('capturedPhotoInput');
                const capturedImage = document.getElementById('capturedImage');
                const captureButton = document.getElementById('captureButton');
                const recaptureButton = document.getElementById('recaptureButton');
                const photoDetails = document.getElementById('photoDetails');

                // Set canvas to video's actual dimensions
                canvas.width = video.videoWidth || 720;
                canvas.height = video.videoHeight || 600;

                // Draw video frame to canvas
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                // Get stamp details
                const dateObj = new Date();
                const dateTime = `${dateObj.getDate()} ${dateObj.toLocaleString('default', { month: 'short' })}, ${dateObj.getFullYear()} ${((dateObj.getHours() % 12) || 12)}:${dateObj.getMinutes().toString().padStart(2, '0')}:${dateObj.getSeconds().toString().padStart(2, '0')} ${dateObj.getHours() >= 12 ? 'PM' : 'AM'}`;
                const deviceInfo = navigator.userAgent;
                let stampText = `Date: ${dateTime}\nDevice: ${deviceInfo}`;
                let latitude = '',
                    longitude = '',
                    locationName = 'Unknown Location';

                // Get geolocation
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                        stampText = `Coordinates: ${latitude}, ${longitude}\n${stampText}`;
                        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                            .then(response => response.json())
                            .then(data => {
                                locationName = data.display_name || 'Unknown Location';
                                stampText = `Location: ${locationName}\n${stampText}`;
                                photoDetails.value = stampText;
                                drawStampAndSave();
                            })
                            .catch(err => {
                                console.error('Geolocation reverse lookup failed:', err);
                                photoDetails.value = stampText;
                                drawStampAndSave();
                            });
                    },
                    (err) => {
                        console.error('Geolocation error:', err);
                        photoDetails.value = stampText;
                        drawStampAndSave();
                    }, {
                        timeout: 10000,
                        enableHighAccuracy: true
                    }
                );

                function drawStampAndSave() {
                    // Draw stamp text on canvas
                    ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
                    ctx.fillRect(0, canvas.height - 90, canvas.width, 100);
                    ctx.fillStyle = 'white';
                    ctx.font = '10px Arial';
                    ctx.textAlign = 'left';
                    ctx.textBaseline = 'top';
                    const lines = stampText.split('\n');
                    lines.forEach((line, index) => {
                        ctx.fillText(line, 10, canvas.height - 75 + index * 12);
                    });

                    // Convert canvas to base64
                    const dataURL = canvas.toDataURL('image/jpeg', 0.8);
                    capturedPhotoInput.value = dataURL;
                    capturedImage.src = dataURL;

                    // Debug: Log base64 data
                    console.log('Base64 Data Size:', dataURL.length);
                    console.log('Base64 Data Preview:', dataURL.substring(0, 100));

                    // Update UI
                    capturedImage.style.display = 'block';
                    video.style.display = 'none';
                    captureButton.style.display = 'none';
                    recaptureButton.style.display = 'block';

                    // Stop camera feed
                    const stream = video.srcObject;
                    if (stream) {
                        const tracks = stream.getTracks();
                        tracks.forEach(track => track.stop());
                        video.srcObject = null;
                    }
                }
            } catch (err) {
                console.error('Error capturing photo:', err);
                alert('Failed to capture photo: ' + err.message);
            }
        }

        // Capture photo on button click
        document.getElementById('captureButton').addEventListener('click', capturePhoto);

        // Recapture photo on button click
        document.getElementById('recaptureButton').addEventListener('click', startCamera);

        // Stop camera when canceling the form
        function ControlForms(formId) {
            try {
                const video = document.getElementById('cameraFeed');
                if (video.srcObject) {
                    const stream = video.srcObject;
                    const tracks = stream.getTracks();
                    tracks.forEach(track => track.stop());
                    video.srcObject = null;
                }
                document.getElementById(formId).style.display = 'none';
            } catch (err) {
                console.error('Error closing form:', err);
                alert('Failed to close form: ' + err.message);
            }
        }
    </script>
</section>