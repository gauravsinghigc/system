<section class="Instant-Feedback-Form" id="SiteVisitHandler" style="display: none;">
    <form class="feedback-container" method="POST" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>/ModuleController/SiteVisitController.php">
        <?php echo FormPrimaryInputs(true); ?>
        <input type="hidden" name="SiteVisitIdForBackend" id="SiteVisitIdDB2" value="">
        <input type="hidden" name="LeadsId" id="GetLeadId2" value="">
        <h1 class="app-heading app-fs-5"><i class="fa fa-map-marker text-success"></i> Add Site Visit Details</h1>
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="text-primary fw-bold mb-0 app-fs-4"><i class="fa fa-user text-success"></i> <span id="PersonName2"></span></h5>
            <h6 class="text-success fw-bold mb-0 mt-0 app-fs-4"><i class="fa fa-phone text-primary"></i> <span id="PersonPhoneNumber2"></span></h6>
            <h6 class="text-info fw-bold mb-0 mt-0 app-fs-4"><i class="fa fa-star text-warning"></i> <span id="ProjectName2"></span></h6>
            <p class="app-fs-3">
                <span class="fw-bold">Remark:</span>
                <span id="LastMessage2"></span>
            </p>
        </div>

        <div class="feedbackarea">
            <div class="CapturePhoto" style="position: relative; width: 100%; height: 450px; overflow: hidden; background: #000;">
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

            <div class="p-3 pt-0 pb-0">
                <div class="row mt-4 mb-3">
                    <div class="col-md-12">
                        <label>Upload Site Visit Images (Multiple/Optional)</label>
                        <input type="file" class="form-control" onchange="PreviewImages('feedbackFilesInput', 'FeedBackImages')" name="leads_activity_attached_file[]" id="feedbackFilesInput" multiple accept="image/*">
                    </div>
                    <div class="col-md-12">
                        <div class="img-preview" id="FeedBackImages" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>
                    </div>
                </div>
            </div>

            <div class="form-group mt-3">
                <label class="app-fs-3">Customer Feedback About Site Visit</label>
                <textarea class="form-control" name="leads_site_visit_response" id="leads_site_visit_response" rows="2" style="font-size:4vw !important;" placeholder="Enter Customer feedback here..."></textarea>
            </div>
        </div>

        <div class="site-visit-footer text-center mt-4 mb-4">
            <hr>
            <button type="submit" name="SiteVisitCompleted" class="btn btn-success btn-lg app-fs-5 circle">&nbsp; Complete Site Visit <i class="fa fa-check text-warning app-fs-4"></i> &nbsp;</button>
            <a class="btn btn-lg btn-warning circle" onclick="ControlForms('SiteVisitHandler')"><i class="fa fa-times"></i> Cancel</a>

        </div>
    </form>

    <script>
        function SiteVisitController(GetLeadId, SiteVisitId, PersonName, PersonPhoneNumber, LastMessage, ProjectName) {
            try {
                document.getElementById("SiteVisitIdDB2").value = SiteVisitId || '';
                document.getElementById("GetLeadId2").value = GetLeadId || '';
                document.getElementById("PersonName2").innerHTML = PersonName || '';
                document.getElementById("PersonPhoneNumber2").innerHTML = PersonPhoneNumber || '';
                document.getElementById("LastMessage2").innerHTML = LastMessage || '';
                document.getElementById("ProjectName2").innerHTML = ProjectName || '';
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
                        facingMode: 'environment',
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 720
                        }
                    }
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.play();
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

                // Set canvas dimensions to match video
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;

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
                    ctx.fillRect(0, canvas.height - 100, canvas.width, 100);
                    ctx.fillStyle = 'white';
                    ctx.font = '14px Arial';
                    ctx.textAlign = 'left';
                    ctx.textBaseline = 'top';
                    const lines = stampText.split('\n');
                    lines.forEach((line, index) => {
                        ctx.fillText(line, 10, canvas.height - 90 + index * 15);
                    });

                    // Convert canvas to base64
                    const dataURL = canvas.toDataURL('image/jpeg', 0.8);
                    capturedPhotoInput.value = dataURL;
                    capturedImage.src = dataURL;

                    // Update UI
                    capturedImage.style.display = 'block';
                    video.style.display = 'none';
                    captureButton.style.display = 'none';
                    recaptureButton.style.display = 'block';

                    // Stop camera feed
                    const stream = video.srcObject;
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
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
    </script>
</section>