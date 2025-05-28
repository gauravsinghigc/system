 <!-- Phone Number Data Preparation -->
 <script>
     <?php
        $PhoneNumbers = [];
        $AllPhoneNumbers = SET_SQL("SELECT leads_phone_number FROM leads ORDER BY leads_phone_number DESC", true);
        if ($AllPhoneNumbers != null) {
            foreach ($AllPhoneNumbers as $PhoneNumber) {
                $PhoneNumbers[] = $PhoneNumber->leads_phone_number;
            }
        }
        $AlternatePhoneNumbers = [];
        $AllAlternatePhoneNumbers = SET_SQL("SELECT leads_alternate_phone FROM leads ORDER BY leads_alternate_phone DESC", true);
        if ($AllAlternatePhoneNumbers != null) {
            foreach ($AllAlternatePhoneNumbers as $AlternatePhoneNumber) {
                if (!empty($AlternatePhoneNumber->leads_alternate_phone)) {
                    $AlternatePhoneNumbers[] = $AlternatePhoneNumber->leads_alternate_phone;
                }
            }
        }
        $EmailAddresses = [];
        $AllEmailAddresses = SET_SQL("SELECT leads_email_id FROM leads ORDER BY leads_email_id DESC", true);
        if ($AllEmailAddresses != null) {
            foreach ($AllEmailAddresses as $EmailAddress) {
                if (!empty($EmailAddress->leads_email_id)) {
                    $EmailAddresses[] = $EmailAddress->leads_email_id;
                }
            }
        }
        ?>
     const PhoneNumber = <?php echo json_encode($PhoneNumbers); ?>;
     const AlternatePhoneNumber = <?php echo json_encode($AlternatePhoneNumbers); ?>;
     const EmailAddress = <?php echo json_encode($EmailAddresses); ?>;
 </script>

 <!-- Phone Number Validation Script -->
 <script>
     // DOM Elements for Phone Validation
     const phoneInput = document.getElementById('PhoneNumber');
     const altPhoneInput = document.getElementById('AltPhoneNumber');
     const phoneValidationMsg = document.getElementById('phoneValidationMsg');
     const altPhoneValidationMsg = document.getElementById('altPhoneValidationMsg');
     const submitBtn = document.getElementById('submitBtn');
     const viewSavedLead = document.getElementById('viewSavedLead');

     // Phone Validation Function
     function validatePhone(input, validationMsg, existingNumbers, isAlt = false) {
         const value = input.value.trim();
         validationMsg.textContent = '';
         submitBtn.disabled = false;
         viewSavedLead.style.display = 'none';

         input.value = input.value.replace(/[^0-9]/g, '');

         if (value.length > 0) {
             if (value.length !== 10) {
                 validationMsg.textContent = `${isAlt ? 'Alternate p' : 'P'}hone number must be 10 digits.`;
                 validationMsg.className = 'form-text text-danger';
                 submitBtn.disabled = true;
             } else if (existingNumbers.includes(value) || (!isAlt && AlternatePhoneNumber.includes(value)) || (isAlt && PhoneNumber.includes(value))) {
                 validationMsg.textContent = `This ${isAlt ? 'alternate ' : ''}phone number is already used.`;
                 validationMsg.className = 'form-text text-danger';
                 submitBtn.disabled = true;
                 viewSavedLead.style.display = 'inline-block';
                 viewSavedLead.href = '<?php echo DOMAIN; ?>/leads/view?phone=' + encodeURIComponent(value);
             } else {
                 validationMsg.textContent = `${isAlt ? 'Alternate p' : 'P'}hone number is valid.`;
                 validationMsg.className = 'form-text text-success';
             }
         }
     }

     // Event Listeners for Phone Validation
     phoneInput.addEventListener('input', () => validatePhone(phoneInput, phoneValidationMsg, PhoneNumber));
     altPhoneInput.addEventListener('input', () => validatePhone(altPhoneInput, altPhoneValidationMsg, AlternatePhoneNumber, true));
 </script>

 <!-- Call Status and Sub-Status Handling Script -->
 <script>
     // Call Status and Sub-Status Data
     const subStatusData = {
         <?php
            $AllCallStatus = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name FROM config_leads_stages WHERE config_leads_stage_status='1' ORDER BY config_leads_stages_id ASC", true);
            if ($AllCallStatus != null) {
                $output = [];
                foreach ($AllCallStatus as $MainCallStatus) {
                    $AllCallSubStatus = SET_SQL("SELECT config_call_sub_status_id , config_leads_stage_name FROM config_leads_sub_stages WHERE config_leads_sub_stages_main_id='" . $MainCallStatus->config_leads_stages_id . "'", true);
                    if ($AllCallSubStatus != null) {
                        $subStatusArray = [];
                        foreach ($AllCallSubStatus as $SubCallStatus) {
                            $subStatusArray[] = "{id: '" . $SubCallStatus->config_call_sub_status_id  . "', name: '" . $SubCallStatus->config_leads_stage_name . "'}";
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

 <!-- Form Submission Validation Script -->
 <script>
     // Form Submission Handling
     const form = document.getElementById('leadForm');
     form.addEventListener('submit', function(e) {
         const phoneValue = phoneInput.value.trim();
         const altPhoneValue = altPhoneInput.value.trim();
         const selectedStatus = callStatusSelect.value;
         const selectedSubStatus = callSubStatusSelect.value;

         // Phone Number Validation
         if (phoneValue.length !== 10 || (altPhoneValue && altPhoneValue.length !== 10)) {
             e.preventDefault();
             alert('Phone numbers must be exactly 10 digits.');
             return;
         }

         // Sub-Status Validation
         if (selectedStatus && subStatusData[selectedStatus] && subStatusData[selectedStatus].length > 0 && !selectedSubStatus) {
             e.preventDefault();
             alert('Please select a sub-status when available.');
             callSubStatusSelect.focus();
             return;
         }
     });
 </script>

 <!-- Priority Button Group Script -->
 <script>
     // Priority Button Group Handling
     document.querySelectorAll('.priority-btn-group .btn').forEach(btn => {
         btn.addEventListener('click', function() {
             document.querySelectorAll('.priority-btn-group .btn').forEach(b => {
                 b.classList.remove('active', 'btn-success', 'btn-warning', 'btn-danger');
                 b.classList.add('btn-outline-info');
             });
             this.classList.add('active');
             this.classList.remove('btn-outline-info');
             const priorityId = this.getAttribute('for');
             if (priorityId === 'priority1') this.classList.add('btn-success');
             else if (priorityId === 'priority2') this.classList.add('btn-warning');
             else this.classList.add('btn-danger');
         });
     });
 </script>