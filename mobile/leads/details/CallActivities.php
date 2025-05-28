 <div class="tab-pane fade show active" id="call-feedback" role="tabpanel" aria-labelledby="call-feedback-tab">
     <h5 class="app-sub-heading text-primary fw-bold mb-3"><i class="bi bi-telephone-fill me-2"></i>Call Feedback</h5>
     <div class="row mb-4" style="max-height: 5rem;">
         <div class="col-4">
             <div class="widget text-center p-2 bg-white border rounded shadow-sm d-flex flex-column justify-content-center" style="height: 100%;">
                 <span class="text-primary fw-bold" style="font-size: 1.5rem;">
                     <?php echo TOTAL($LeadActivitySQL); ?>
                 </span>
                 <strong class="text-muted small" style="font-size: 0.55rem !important;">Total Calls</strong>
             </div>
         </div>
         <div class="col-4">
             <div class="widget text-center p-2 bg-white border rounded shadow-sm d-flex flex-column justify-content-center" style="height: 100%;">
                 <span class="text-success fw-bold" style="font-size: 1.5rem;">
                     <?php echo TOTAL($LeadActivitySQL . " and leads_activity_type='INCOMING'"); ?>
                 </span>
                 <strong class="text-muted small" style="font-size: 0.55rem !important;">Incoming Calls</strong>
             </div>
         </div>
         <div class="col-4">
             <div class="widget text-center p-2 bg-white border rounded shadow-sm d-flex flex-column justify-content-center" style="height: 100%;">
                 <span class="text-info fw-bold" style="font-size: 1.5rem;">
                     <?php echo TOTAL($LeadActivitySQL . " and leads_activity_type='OUTGOING'"); ?>
                 </span>
                 <strong class="text-muted small" style="font-size: 0.55rem !important;">Outgoing Calls</strong>
             </div>
         </div>
     </div>
     <div class="position-relative py-4" style="padding-left:0.25rem !important;">

         <ul class="timeline list-unstyled position-relative pl-3" style="padding-left:0.55rem !important;">
             <?php
                $AllCalFeedBacks = SET_SQL($LeadActivitySQL . " ORDER BY leads_acitivity_id ASC", true);
                if ($AllCalFeedBacks != null) {
                    foreach ($AllCalFeedBacks as $Calls) {
                ?>
                     <li class="mb-3" style="box-shadow: -6px 5px 2px 2px lightskyblue;border-radius: 3rem;">
                         <div class="d-flex align-items-start flex-column position-relative">
                             <!-- Arrow Icon Aligned with Center Line -->
                             <div class="position-absolute bg-light" style="font-size: 1.4rem; right:1px; border-radius:10rem;padding:0.5rem 1rem;">
                                 <i class="bi bi-telephone-outbound-fill text-primary"></i>
                             </div>

                             <!-- Timeline Content -->
                             <div class="p-3 w-100">
                                 <!-- Date and Time -->
                                 <div class="d-flex justify-content-start align-items-center mb-2 ml-4">
                                     <span class="badge rounded-pill bg-primary text-white" style="font-size: 0.65rem;">
                                         <?php echo DATE_FORMATES("d M, Y", $Calls->leads_activity_date_time); ?>
                                     </span>
                                     <small class="text-muted ml-2 small" style="font-size: 0.55rem;">
                                         <?php echo DATE_FORMATES("h:i A", $Calls->leads_activity_date_time); ?>
                                     </small>
                                 </div>

                                 <!-- Stage and Sub Stage in Separate Alignment -->
                                 <div class="d-flex justify-content-start mb-3">
                                     <span class="badge text-dark p-1" style="font-size: 0.6rem; background-color:<?php echo FETCH("SELECT config_leads_stage_color_code FROM config_leads_stages where config_leads_stages_id='" . $Calls->leads_acitivity_call_status . "'", "config_leads_stage_color_code"); ?>;">
                                         <?php echo FETCH("SELECT config_leads_stage_name FROM config_leads_stages where config_leads_stages_id='" . $Calls->leads_acitivity_call_status . "'", "config_leads_stage_name"); ?>
                                     </span>
                                     <span class="badge bg-success p-1 text-white ml-2" style="font-size: 0.6rem;">
                                         <?php echo FETCH("SELECT config_call_sub_status_name FROM config_leads_sub_stages where config_call_sub_status_id ='" . $Calls->leads_acitivity_call_sub_status . "'", "config_call_sub_status_name"); ?>
                                     </span>
                                 </div>


                                 <!-- Remarks -->
                                 <div class="mb-1" style="font-size: 0.75rem;">
                                     <span class="detail-title fw-bold">Remarks:</span>
                                     <?php echo SECURE($Calls->leads_activity_feedbacks, "d"); ?>
                                     <br>
                                 </div>

                                 <!-- Voice Note -->
                                 <?php if ($Calls->leads_activity_have_voice_notes == 1) {
                                        $VoiceNoteFile = $Calls->leads_activity_voice_notes_file;
                                        $StoragePath = "../../storage/leads/audios/$LeadsId";
                                        $VoiceNoteFullPath = "$StoragePath/$VoiceNoteFile";
                                    ?>
                                     <div class="mt-2">
                                         <audio controls class="w-100">
                                             <source src="<?php echo $VoiceNoteFullPath; ?>" type="audio/mp3">
                                         </audio>
                                     </div>
                                 <?php } ?>

                                 <!-- Activity By -->
                                 <div class="text-end">
                                     <span class="text-secondary" style="font-size: 0.45rem; font-style: italic;">
                                         (UID<?php echo $Calls->leads_activity_created_by; ?>)-<?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Calls->leads_activity_created_by . "'", "UserFullName"); ?>
                                     </span>
                                 </div>
                             </div>
                         </div>
                     </li>
                 <?php }
                } else { ?>
                 <div class="alert alert-warning text-center">
                     <i class="bi bi-exclamation"></i> No Activity Found!
                 </div>
             <?php } ?>
         </ul>
     </div>
 </div>

 <!-- Call Feedback Modal -->
 <div class="modal fade" id="addCallFeedbackModal" tabindex="-1" aria-labelledby="addCallFeedbackModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header app-heading">
                 <h5 class="modal-title" id="addCallFeedbackModalLabel"><i class="bi bi-phone text-success"></i> Add Call Feedback</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST" id="callFeedbackForm" enctype="multipart/form-data">
                     <?php echo FormPrimaryInputs(true, [
                            "Leads_Stage_Current" => FETCH($LeadsSQL, "leads_stages"),
                            "LeadsId" => $LeadsId
                        ]); ?>
                     <input type="hidden" name="leads_activity_type" value="Outgoing">
                     <!-- Call Type Radio Buttons -->
                     <div class="col-md-4 mb-3">
                         <label class="form-label">Add Call Status</label>
                         <select class="form-select" name="leads_acitivity_call_status" id="callStatus">
                             <option value="">Select Status</option>
                             <?php
                                $CheckNotInrestedCount = FETCH("SELECT leads_acitivity_id FROM leads_activities where leads_activity_main_leads_id='$LeadsId' and leads_acitivity_call_status='3'", "leads_acitivity_id");
                                if ($CheckNotInrestedCount == null) {
                                    $LostDisabled = " config_leads_stages_id!='12' and";
                                } else {
                                    $LostDisabled = "";
                                }
                                $AllLeadsStages = SET_SQL("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where $LostDisabled config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
                                if ($AllLeadsStages != null) {
                                    foreach ($AllLeadsStages as $Stages) {
                                        echo "<option value='" . $Stages->config_leads_stages_id . "'>" . $Stages->config_leads_stage_name . "</option>";
                                    }
                                }
                                ?>
                         </select>
                     </div>
                     <div class="col-md-4 mb-3">
                         <label class="form-label">All Call Sub-Status</label>
                         <select class="form-select" name="leads_acitivity_call_sub_status" id="callSubStatus">
                             <option value="">Select Sub-Status</option>
                         </select>
                     </div>
                     <div class="mb-3">
                         <label for="callFeedback" class="form-label">Feedback</label>
                         <textarea class="form-control" name="leads_activity_feedbacks" required="" id="callFeedback" rows="3" placeholder="Enter feedback"></textarea>
                     </div>

                     <!-- Voice Input Features -->
                     <div class="mb-3">
                         <div class="d-flex gap-2 position-relative">
                             <!-- Voice Typing Button -->
                             <button type="button" class="btn btn-outline-primary position-relative" id="voiceTypingBtn">
                                 <i class="bi bi-mic"></i> Voice Typing
                                 <div class="voice-equalizer d-none" id="voiceTypingEqualizer">
                                     <span></span><span></span><span></span>
                                 </div>
                             </button>

                             <!-- Voice Recording Button -->
                             <button type="button" class="btn btn-outline-success position-relative" id="startRecordingBtn">
                                 <i class="bi bi-record-circle"></i> Record Voice Note
                                 <div class="voice-equalizer d-none" id="recordingEqualizer">
                                     <span></span><span></span><span></span>
                                 </div>
                             </button>

                             <!-- Stop Recording Button (hidden initially) -->
                             <button type="button" class="btn btn-outline-danger d-none" id="stopRecordingBtn">
                                 <i class="bi bi-stop-circle"></i> Stop Recording
                             </button>
                         </div>

                         <!-- Recording Preview Section (hidden initially) -->
                         <div class="mt-3 d-none" id="recordingPreview">
                             <div class="d-flex align-items-center gap-2">
                                 <audio controls id="audioPreview" class="flex-grow-1"></audio>
                                 <button type="button" class="btn btn-sm btn-danger p-1" id="removeRecording" title="Remove">
                                     <i class="bi bi-trash"></i>
                                 </button>
                                 <button type="button" class="btn btn-sm btn-success p-1" id="reRecordBtn" title="Re-Record">
                                     <i class="bi bi-record-circle"></i>
                                 </button>
                             </div>
                             <small class="text-muted text-center d-block mt-2" id="recordingMessage">Recording audio is already attached in feedback for team head and admin. No need to re-attach, just submit.</small>
                         </div>

                         <!-- Hidden file input for storing recording -->
                         <input type="file" name="leads_activity_voice_notes_file" id="voiceRecordingInput" class="d-none" accept="audio/*">
                     </div>
                 </form>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="submit" name="SaveCallFeedBack" form="callFeedbackForm" class="btn btn-primary" id="submitFeedback">Add FeedBack <i class="bi bi-plus text-success"></i></button>
             </div>
         </div>
     </div>
 </div>

 <script>
     // Voice Typing (unchanged)
     const voiceTypingBtn = document.getElementById('voiceTypingBtn');
     const callFeedback = document.getElementById('callFeedback');
     const voiceTypingEqualizer = document.getElementById('voiceTypingEqualizer');
     let recognition;
     let voiceTimeout;

     if ('webkitSpeechRecognition' in window) {
         recognition = new webkitSpeechRecognition();
         recognition.continuous = true;
         recognition.interimResults = true;

         recognition.onresult = function(event) {
             clearTimeout(voiceTimeout);
             let transcript = '';
             for (let i = event.resultIndex; i < event.results.length; i++) {
                 transcript += event.results[i][0].transcript;
             }
             callFeedback.value = transcript + ' ';
             voiceTimeout = setTimeout(checkVoiceInput, 5000);
         };

         recognition.onend = function() {
             voiceTypingBtn.innerHTML = '<i class="bi bi-mic"></i> Voice Typing';
             voiceTypingBtn.classList.remove('btn-primary');
             voiceTypingBtn.classList.add('btn-outline-primary');
             voiceTypingEqualizer.classList.add('d-none');
             clearTimeout(voiceTimeout);
         };

         function checkVoiceInput() {
             recognition.stop();
             alert('No voice input found! Please start saying feedback after clicking.');
         }

         voiceTypingBtn.addEventListener('click', function() {
             if (voiceTypingBtn.classList.contains('btn-outline-primary')) {
                 recognition.start();
                 voiceTypingBtn.innerHTML = '<i class="bi bi-mic-mute"></i> Stop Voice Typing';
                 voiceTypingBtn.classList.remove('btn-outline-primary');
                 voiceTypingBtn.classList.add('btn-primary');
                 voiceTypingEqualizer.classList.remove('d-none');
                 voiceTimeout = setTimeout(checkVoiceInput, 5000);
             } else {
                 recognition.stop();
             }
         });
     }

     // Voice Recording
     const startRecordingBtn = document.getElementById('startRecordingBtn');
     const stopRecordingBtn = document.getElementById('stopRecordingBtn');
     const recordingPreview = document.getElementById('recordingPreview');
     const audioPreview = document.getElementById('audioPreview');
     const removeRecording = document.getElementById('removeRecording');
     const reRecordBtn = document.getElementById('reRecordBtn');
     const voiceRecordingInput = document.getElementById('voiceRecordingInput');
     const recordingEqualizer = document.getElementById('recordingEqualizer');
     let mediaRecorder;
     let audioChunks = [];
     let isRecording = false;

     navigator.mediaDevices.getUserMedia({
             audio: true
         })
         .then(stream => {
             mediaRecorder = new MediaRecorder(stream);

             // Collect audio data as it becomes available
             mediaRecorder.ondataavailable = event => {
                 if (event.data.size > 0) { // Only push if there's actual data
                     audioChunks.push(event.data);
                 }
             };

             // Handle stopping the recording
             mediaRecorder.onstop = () => {
                 recordingEqualizer.classList.add('d-none');
                 startRecordingBtn.classList.remove('d-none');
                 stopRecordingBtn.classList.add('d-none');
                 isRecording = false;

                 if (audioChunks.length > 0 && audioChunks[0].size > 0) {
                     const audioBlob = new Blob(audioChunks, {
                         type: 'audio/mp3'
                     });
                     const audioUrl = URL.createObjectURL(audioBlob);
                     audioPreview.src = audioUrl;

                     // Generate filename with date-time, lead_id, and random string
                     const dateTime = new Date().toISOString().replace(/[:.]/g, '-');
                     const leadId = '<?php echo FETCH($LeadsSQL, "leads_id"); ?>'; // Assuming leads_id is available
                     const randomStr = Math.random().toString(36).substring(2, 8);
                     const fileName = `recording_${dateTime}_${leadId}_${randomStr}.mp3`;

                     // Convert Blob to File and attach to hidden input
                     const audioFile = new File([audioBlob], fileName, {
                         type: 'audio/ogg'
                     });
                     const dataTransfer = new DataTransfer();
                     dataTransfer.items.add(audioFile);
                     voiceRecordingInput.files = dataTransfer.files;

                     // Show preview
                     recordingPreview.classList.remove('d-none');
                     alert('Recording attached with feedback.');
                 } else {
                     alert('No audio recorded! Please speak while recording.');
                 }
                 audioChunks = []; // Reset chunks after processing
             };

             // Start recording
             startRecordingBtn.addEventListener('click', () => {
                 if (!isRecording) {
                     audioChunks = [];
                     mediaRecorder.start(1000); // Collect data every 1 second
                     startRecordingBtn.classList.add('d-none');
                     stopRecordingBtn.classList.remove('d-none');
                     recordingEqualizer.classList.remove('d-none');
                     isRecording = true;
                 }
             });

             // Stop recording
             stopRecordingBtn.addEventListener('click', () => {
                 if (isRecording) {
                     mediaRecorder.stop();
                 }
             });

             // Remove recording
             removeRecording.addEventListener('click', () => {
                 recordingPreview.classList.add('d-none');
                 voiceRecordingInput.value = '';
                 audioPreview.src = '';
                 audioChunks = [];
             });

             // Re-record
             reRecordBtn.addEventListener('click', () => {
                 if (!isRecording) {
                     audioChunks = [];
                     mediaRecorder.start(1000); // Collect data every 1 second
                     recordingPreview.classList.add('d-none');
                     startRecordingBtn.classList.add('d-none');
                     stopRecordingBtn.classList.remove('d-none');
                     recordingEqualizer.classList.remove('d-none');
                     isRecording = true;
                 }
             });
         })
         .catch(err => {
             console.error('Error accessing microphone:', err);
             alert('Unable to access microphone. Please check permissions.');
         });
 </script>

 <script>
     // Call Status and Sub-Status Data
     const subStatusData = {
         <?php

            $AllCallStatus = SET_SQL("SELECT config_leads_stage_name, config_leads_stages_id FROM config_leads_stages where config_leads_stage_status='1' ORDER by config_leads_stage_name ASC", true);
            if ($AllCallStatus != null) {
                $output = [];
                foreach ($AllCallStatus as $MainCallStatus) {
                    $AllCallSubStatus = SET_SQL("SELECT config_call_sub_status_id , config_call_sub_status_name FROM config_leads_sub_stages WHERE config_call_sub_status_main_id='" . $MainCallStatus->config_leads_stages_id . "'", true);
                    if ($AllCallSubStatus != null) {
                        $subStatusArray = [];
                        foreach ($AllCallSubStatus as $SubCallStatus) {
                            $subStatusArray[] = "{id: '" . $SubCallStatus->config_call_sub_status_id  . "', name: '" . $SubCallStatus->config_call_sub_status_name . "'}";
                        }

                        $output[] = "'" . $MainCallStatus->config_leads_stages_id . "': [" . implode(',', $subStatusArray) . "]";
                    }
                }
                echo implode(',', $output);
            }
            ?>
     };

     // DOM Elements for Call Status
     const callStatusSelect = document.getElementById('callStatus');
     const callSubStatusSelect = document.getElementById('callSubStatus');

     // Populate Sub-Status based on Call Status
     callStatusSelect.addEventListener('change', function() {
         const selectedStatus = this.value;
         console.log('Selected Status:', selectedStatus, 'Data:', subStatusData[selectedStatus]);
         callSubStatusSelect.innerHTML = '<option value="">Select Sub-Status</option>';
         if (subStatusData[selectedStatus] && Array.isArray(subStatusData[selectedStatus])) {
             subStatusData[selectedStatus].forEach(subStatus => {
                 const option = new Option(subStatus.name, subStatus.id);
                 callSubStatusSelect.appendChild(option);
             });
             callSubStatusSelect.required = true;
         } else {
             callSubStatusSelect.required = false;
         }
     });
 </script>