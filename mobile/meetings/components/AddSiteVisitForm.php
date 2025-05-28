 <!-- Site Visits Modal -->
 <div class="modal fade" id="addSiteVisitModal" tabindex="-1" aria-labelledby="addSiteVisitModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header app-heading">
                 <h5 class="modal-title" id="addSiteVisitModalLabel">Add Site Visit</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body p-0">
                 <form class="row" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php" method="POST" enctype="multipart/form-data">
                     <?php echo FormPrimaryInputs(true); ?>
                     <div class="col-md-12 mb-3 form-group">
                         <label>Select Leads/Person Name</label>
                         <input type="search" placeholder="Search Leads Person..." class="form-control" id="LeadsTriggerred" oninput="SearchData('LeadsTriggerred', 'LeadsRecords')">
                         <div class="pt-3 mt-3 mb-3 pb-3 shadow-md p-2 br-1" style="max-height: 20rem;overflow-y:scroll;">
                             <?php
                                if (AuthAppUser("UserType") == "ADMIN") {
                                    $AllLeads = SET_SQL("SELECT leads_id, leads_full_name, leads_phone_number FROM leads where leads_is_removed!='1' ORDER BY leads_full_name ASC", true);
                                } else if (AuthAppUser("UserType") == "TEAM_HEAD") {
                                    if ($ActiveLeadsView == "MY-LEADS") {
                                        $AllLeads = SET_SQL("SELECT leads_id, leads_full_name, leads_phone_number FROM leads where  leads_is_removed!='1' and leads_managed_by='" . LOGIN_USER_ID . "' ORDER BY leads_full_name ASC", true);
                                    } else {
                                        $AllLeads = SET_SQL("SELECT leads_id, leads_full_name, leads_phone_number FROM leads, users where leads_is_removed!='1' and leads.leads_managed_by=users.UserId and UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY leads_full_name ASC", true);
                                    }
                                } else {
                                    $AllLeads = SET_SQL("SELECT leads_id, leads_full_name, leads_phone_number FROM leads where leads_is_removed!='1' and leads_managed_by='" . LOGIN_USER_ID . "' ORDER BY leads_full_name ASC", true);
                                }
                                if ($AllLeads != null) {
                                    foreach ($AllLeads as $Lead) { ?>
                                     <label class='shadow-sm p-1 br-1 LeadsRecords w-100 mb-2'>
                                         <input type="radio" required name="leads_Id" value="<?php echo SECURE($Lead->leads_id, "e"); ?>">
                                         <b><?php echo $Lead->leads_full_name; ?></b> (<?php echo $Lead->leads_phone_number; ?>)
                                     </label>
                             <?php  }
                                } ?>
                         </div>
                     </div>
                     <div class="col-md-6 mb-3">
                         <label class="form-label">Select Project For Visit</label>
                         <select class="form-select" name="leads_site_visits_projects_id" required>
                             <option value="">Select Project</option>
                             <?php
                                $AllProjects = SET_SQL("SELECT projects_id, projects_name, projects_developed_by, projects_locations_id FROM projects where projects_listing_status='1'", true);
                                if ($AllProjects != null) {
                                    foreach ($AllProjects as $AllProject) {
                                        $ProjectLocation = FETCH("SELECT config_projects_locations_name FROM config_projects_locations where config_projects_locations_id='" . $AllProject->projects_locations_id . "'", "config_projects_locations_name");
                                        $DeveloperName = FETCH("SELECT projects_developers_name FROM projects_developers where projects_developers_id='" . $AllProject->projects_developed_by . "'", "projects_developers_name");
                                        $projects_id = $AllProject->projects_id;
                                        $projects_name = $AllProject->projects_name;
                                        echo "<option value='$projects_id'>$projects_name By $DeveloperName ($ProjectLocation)</option>";
                                    }
                                } ?>
                         </select>
                     </div>
                     <div class="col-md-6">
                         <label>Managed By</label>
                         <select name="leads_site_visit_handled_by" class="form-control">
                             <option value="<?php echo LOGIN_USER_ID; ?>" selected><?php echo AuthAppUser("UserFullName"); ?> (Assigned For Self)</option>
                             <?php
                                if (AuthAppUser("UserType") == "ADMIN") {
                                    $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserId!='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                                } else if (AuthAppUser("UserType") == "TEAM_HEAD") {
                                    $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserId!='" . LOGIN_USER_ID . "' and UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                                } else {
                                    $AllUsers = SET_SQL("SELECT UserId, UserFullName FROM users where UserId='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                                }
                                if ($AllUsers != null) {
                                    foreach ($AllUsers as $AllUser) {
                                        $UserId = $AllUser->UserId;
                                        $UserFullName = $AllUser->UserFullName;
                                        $SelectedUser = CheckEquality($UserId, LOGIN_USER_ID, "selected");
                                        echo "<option value='$UserId' $SelectedUser>$UserFullName</option>";
                                    }
                                } ?>
                         </select>
                     </div>
                     <div class="col-md-6 mb-3">
                         <label>Site Visit Status</label>
                         <select class="form-control" onchange="SiteVisitControll()" id='SiteVisitStatus' name="leads_site_visit_status">
                             <?php echo InputOptionsWithKey([
                                    "1" => "Schedule Site Visit",
                                    "2" => "Site Visit Done",
                                    "3" => "Site Visit Cancelled"
                                ], "1"); ?>
                         </select>
                     </div>
                     <div class="mb-3 col-md-6">
                         <label for="visitDate" class="form-label">Site Visit Date</label>
                         <input type="datetime-local" name="leads_site_visit_schedule_date" class="form-control" id="visitDate" required>
                     </div>
                     <div class="mb-3 col-md-12">
                         <div class="form-check">
                             <input class="form-check-input" value="true" name="CheckReminderOption" type="checkbox" id="addReminderCheckbox" onchange="toggleReminderFields()">
                             <label class="form-check-label" for="addReminderCheckbox">
                                 <?php echo ART_ICON['clock']; ?> Add Reminder for Next Call <?php echo ART_ICON['call']; ?>
                             </label>
                         </div>

                         <div id="reminderFields" style="display: none; margin-top: 10px;">
                             <div class="flex-s-b">
                                 <div class="mb-3 w-50 m-1">
                                     <label for="reminderDate" class="form-label">Reminder Date</label>
                                     <input type="date" class="form-control" id="reminderDate" name="reminder_date">
                                 </div>

                                 <div class="mb-3 w-50 m-1">
                                     <label for="reminderTime" class="form-label">Reminder Time</label>
                                     <input type="time" class="form-control" id="reminderTime" name="reminder_time">
                                 </div>
                             </div>

                             <div class="flex-s-b">
                                 <div class="mb-3 w-75 m-1">
                                     <label for="reminderMsg" class="form-label">Reminder Message</label>
                                     <textarea class="form-control" id="reminderMsg" name="Reminder_Message" rows="1"></textarea>
                                 </div>
                                 <div class="mb-3 w-50 m-1">
                                     <label for="reminderFOR" class="form-label">Set Reminder For</label>
                                     <select id="reminderFOR" name="set_reminder_for" class="form-control">
                                         <option value="<?php echo LOGIN_USER_ID; ?>" selected><?php echo AuthAppUser("UserFullName"); ?> (Assigned For Self)</option>
                                         <?php
                                            if ($AllUsers != null) {
                                                foreach ($AllUsers as $AllUser) {
                                                    $UserId = $AllUser->UserId;
                                                    $UserFullName = $AllUser->UserFullName;
                                                    $SelectedUser = CheckEquality($UserId, LOGIN_USER_ID, "selected");
                                                    echo "<option value='$UserId' $SelectedUser>$UserFullName</option>";
                                                }
                                            } ?>
                                     </select>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="mb-3">
                         <label for="feedbackTextarea" class="form-label">Site Visit Remarks</label>
                         <div class="input-group-append pull-right mb-2" style="float:right;">
                             <button class="btn btn-xs btn-outline-secondary" type="button" onclick="startVoiceInput()" id="micBtn">
                                 🎤 Speak
                             </button>
                         </div>
                         <textarea class="form-control" name="leads_site_visit_notes" id="feedbackTextarea" rows="3" placeholder="Enter remarks" required></textarea>
                     </div>


                     <div class="hidden" id='UploadImages'>
                         <div class="row mt-4 mb-3">
                             <div class="col-md-12">
                                 <label>Upload Site Visit Images (Multiple/Optional)</label>
                                 <input type="file" class="form-control" onchange="PreviewImages('feedbackFilesInput', 'FeedBackImages')" name="leads_activity_attached_file[]" id="feedbackFilesInput" multiple accept="image/*">
                             </div>
                             <div class="col-md-12">
                                 <div class="img-preview" id="FeedBackImages"></div>
                             </div>
                         </div>
                     </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                 <button type="submit" name="AddSiteVisitRecords" class="btn btn-primary">Save Visit <i class="bi bi-check-circle text-success"></i></button>
             </div>
         </div>
         </form>
     </div>
 </div>

 <script>
     function startVoiceInput() {
         // Check if browser supports Web Speech API
         const isBrowser = typeof window.SpeechRecognition !== "undefined" || typeof window.webkitSpeechRecognition !== "undefined";

         if (isBrowser) {
             const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
             const recognition = new SpeechRecognition();

             recognition.lang = 'en-IN';
             recognition.interimResults = false;
             recognition.maxAlternatives = 1;

             recognition.onstart = () => {
                 document.getElementById("micBtn").innerText = "🎙️ Listening...";
                 document.getElementById("micBtn").classList.remove("btn-outline-secondary");
                 document.getElementById("micBtn").classList.add("btn-primary");
             };

             recognition.onresult = (event) => {
                 const transcript = event.results[0][0].transcript;
                 document.getElementById("feedbackTextarea").value = transcript;
             };

             recognition.onerror = (event) => {
                 console.error("Speech recognition error:", event.error);
                 alert("Error during speech recognition: " + event.error);
             };

             recognition.onend = () => {
                 document.getElementById("micBtn").innerText = "🎤 Speak";
                 document.getElementById("micBtn").classList.remove("btn-primary");
                 document.getElementById("micBtn").classList.add("btn-outline-secondary");
             };

             recognition.start();
         } else if (typeof Android !== 'undefined' && Android.startSpeechRecognition) {
             // WebView fallback to native Android
             Android.startSpeechRecognition();
         } else {
             alert("Speech recognition not supported on this device.");
         }
     }
 </script>


 <script>
     function toggleReminderFields() {
         const isChecked = document.getElementById('addReminderCheckbox').checked;
         const reminderFields = document.getElementById('reminderFields');

         const date = document.getElementById('reminderDate');
         const time = document.getElementById('reminderTime');
         const msg = document.getElementById('reminderMsg');
         const reminderFOR = document.getElementById('reminderFOR');

         if (isChecked) {
             reminderFields.style.display = 'block';
             date.setAttribute('required', 'required');
             time.setAttribute('required', 'required');
             msg.setAttribute('required', 'required');
             reminderFOR.setAttribute('required', 'required');
         } else {
             reminderFields.style.display = 'none';
             date.removeAttribute('required');
             time.removeAttribute('required');
             msg.removeAttribute('required');
             reminderFOR.removeAttribute('required');
         }
     }
 </script>

 <script>
     function SiteVisitControll() {
         var SiteVisitStatus = document.getElementById("SiteVisitStatus");
         var UploadImages = document.getElementById("UploadImages");
         var inputs = UploadImages.getElementsByTagName("input"); // Get all input elements inside UploadImages

         if (SiteVisitStatus.value == "2") {
             UploadImages.style.display = "block";
             // Make all inputs required
             for (var i = 0; i < inputs.length; i++) {
                 inputs[i].setAttribute("required", "required");
             }
         } else {
             UploadImages.style.display = "none";
             // Remove required attribute from all inputs
             for (var i = 0; i < inputs.length; i++) {
                 inputs[i].removeAttribute("required");
             }
         }
     }
 </script>