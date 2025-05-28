<section class="site-visit-container" id="SiteVisitHandler" style="display: none; padding: 0 !important;">
    <form class="data-container" method="POST" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>/ModuleController/SiteVisitController.php" style="width: 100% !important; bottom: 0 !important; position: absolute !important;">
        <?php echo FormPrimaryInputs(true); ?>
        <input type="hidden" name="SiteVisitIdForBackend" id="SiteVisitIdDB1" value="">
        <input type="hidden" name="LeadsId" id="GetLeadId" value="">
        <a class="btn btn-lg br-5 btn-danger pull-right" onclick="ControlForms('SiteVisitHandler')"><i class="fa fa-times"></i> Cancel</a>
        <h1 class="app-heading app-fs-4"><i class="fa fa-map-marker text-success"></i> Complete Site Visit (Reminder)</h1>
        <div class="shadow-sm p-3 mb-5 bg-body rounded">
            <h5 class="text-primary fw-bold mb-0"><?php echo isset(ART_ICON['guest']) ? ART_ICON['guest'] : 'Guest'; ?> <span id="PersonName2"></span></h5>
            <h6 class="text-success fw-bold mb-0 mt-0"><?php echo isset(ART_ICON['call']) ? ART_ICON['call'] : 'Call'; ?> <span id="PersonPhoneNumber2"></span></h6>
            <h6 class="text-info fw-bold mb-0 mt-0"><?php echo isset(ART_ICON['star']) ? ART_ICON['star'] : 'Star'; ?> <span id="ProjectName2"></span></h6>
            <p>
                <span class="fw-bold small"><?php echo isset(ART_ICON['info']) ? ART_ICON['info'] : 'Info'; ?></span>
                <span id="LastMessage"></span>
            </p>
        </div>

        <div class="feedbackarea">
            <div class="CapturePhoto" style="position: relative; width: 100%; height: 250px; overflow: hidden; background: #000;">
                <video id="cameraFeed" autoplay playsinline style="width: 100%; height: 100%; object-fit: cover; display: block;"></video>
                <img id="capturedImage" style="width: 100%; height: 100%; object-fit: cover; display: none;" alt="Captured Photo">
                <canvas id="photoCanvas" style="display: none;"></canvas>
                <div id="cameraError" style="display: none; color: red; font-size: 12px; position: absolute; bottom: 40px; left: 10px;">Camera access failed. Please check permissions or use HTTPS.</div>
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
                <label>Customer Feedback About Site Visit</label>
                <textarea class="form-control form-control-lg" style="font-size: 4vw !important;" name="leads_site_visit_response" id="leads_site_visit_response" rows="2" placeholder="Enter Customer feedback here..."></textarea>
            </div>
        </div>

        <div class="site-visit-footer text-center mt-3">
            <button type="submit" name="SiteVisitCompleted" class="btn btn-success br-5 btn-lg app-fs-4">Complete Site Visit <i class="fa fa-check text-warning"></i></button>
        </div>
    </form>

    <script>
        function SiteVisitController(GetLeadId, SiteVisitId, PersonName, PersonPhoneNumber, LastMessage, ProjectName) {
            try {
                console.log('Initializing SiteVisitController with LeadId:', GetLeadId);
                document.getElementById("SiteVisitIdDB1").value = SiteVisitId || '';
                document.getElementById("GetLeadId").value = GetLeadId || '';
                document.getElementById("PersonName2").innerHTML = PersonName || '';
                document.getElementById("PersonPhoneNumber2").innerHTML = PersonPhoneNumber || '';
                document.getElementById("LastMessage").innerHTML = LastMessage || '';
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

            console.log('Starting camera...');

            // Reset UI
            capturedImage.style.display = 'none';
            recaptureButton.style.display = 'none';
            video.style.display = 'block';
            cameraError.style.display = 'none';
            captureButton.style.display = 'block';

            // Check for camera support
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                cameraError.innerText = 'Camera not supported on this device or browser. Please use file upload instead.';
                cameraError.style.display = 'block';
                captureButton.style.display = 'none';
                console.error('Camera API not supported');
                return;
            }

            console.log('Requesting camera access...');
            navigator.mediaDevices.getUserMedia({
                    video: true // Minimal constraints for maximum compatibility
                })
                .then(stream => {
                    console.log('Camera access granted');
                    video.srcObject = stream;
                    video.onloadedmetadata = () => {
                        console.log('Video metadata loaded, playing...');
                        video.play().catch(err => {
                            console.error('Error playing video:', err);
                            cameraError.innerText = 'Failed to start camera: ' + err.message + '. Please use file upload instead.';
                            cameraError.style.display = 'block';
                            captureButton.style.display = 'none';
                        });
                    };
                })
                .catch(err => {
                    console.error('Error accessing camera:', err);
                    cameraError.innerText = `Camera access failed: ${err.message}. Please check permissions or use HTTPS, or upload images manually.`;
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

                console.log('Capturing photo...');

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
                    ctx.font = '12px Arial';
                    ctx.textAlign = 'left';
                    ctx.textBaseline = 'top';
                    const lines = stampText.split('\n');
                    lines.forEach((line, index) => {
                        ctx.fillText(line, 10, canvas.height - 75 + index * 14);
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
                        const tracks = stream.getTracks();
                        tracks.forEach(track => track.stop());
                        video.srcObject = null;
                    }

                    console.log('Photo captured successfully');
                }
            } catch (err) {
                console.error('Error capturing photo:', err);
                alert('Failed to capture photo: ' + err.message);
            }
        }

        function PreviewImages(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            preview.innerHTML = ''; // Clear previous previews

            console.log('Previewing images...');

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '100px';
                            img.style.maxHeight = '100px';
                            img.style.margin = '5px';
                            img.style.objectFit = 'cover';
                            preview.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        // Event listeners
        document.getElementById('captureButton').addEventListener('click', capturePhoto);
        document.getElementById('recaptureButton').addEventListener('click', startCamera);

        function ControlForms(formId) {
            try {
                console.log('Closing form:', formId);
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