<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>Add New User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="POST" action="<?php echo CONTROLLER; ?>/ModuleController/UserController.php" enctype="multipart/form-data">
                    <?php echo FormPrimaryInputs(true); ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Salutation</label>
                            <select class="form-select" name="UserSalutation">
                                <?php echo InputOptionsWithKey(SALUTATION, ""); ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="UserFullName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number <span id='PhoneMsg' class="text-danger"></span></label>
                            <input type="tel" oninput='CheckPhoneNumber()' id='GetPhoneNumbers' class="form-control" name="UserPhoneNumber" required maxlength="10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span id='EmailMsg' class="text-danger"></span></label>
                            <input type="email" oninput='CheckEmailId()' id='GetEmailIds' class="form-control" name="UserEmailId" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="text" value="<?php echo rand(000000, 999999); ?>" class="form-control" name="UserPassword" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="UserDateOfBirth">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control" value="<?php echo APP_NAME; ?>" name="UserCompanyName">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Designation</label>
                            <input type="text" class="form-control" name="UserDesignation">
                        </div>
                        <!-- Address Fields Start -->
                        <div class="col-md-12">
                            <label class="form-label">Street Address</label>
                            <textarea class="form-control" name="UserStreetAddress" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Locality</label>
                            <input type="text" class="form-control" name="UserLocality">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="UserCity">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">State</label>
                            <input type="text" class="form-control" name="UserState">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="UserCountry">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pincode <span id='PincodeMsg' class="text-danger"></span></label>
                            <input type="text" oninput='CheckPincode()' id='GetPincode' class="form-control" name="UserPincode" maxlength="6">
                        </div>
                        <div class="col-md-6">
                            <label>Reporting Manager Will Be</label>
                            <select name="UserReportingManager" class="form-control" required="">
                                <option value="">Select Reporting Manager</option>
                                <?php
                                $GetAllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserStatus='1' ORDER BY UserFullName", true);
                                if ($GetAllUsers != null) {
                                    foreach ($GetAllUsers as $Users) {
                                        echo '<option value="' . $Users->UserId . '"> ' . $Users->UserId . ' - ' . $Users->UserFullName . ' (' . $Users->UserPhoneNumber . ') </option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <!-- Address Fields End -->
                        <div class="col-md-12">
                            <label class="form-label">User Type</label>
                            <div class="btn-group" role="group">
                                <input type="radio" class="d-none" name="UserType" value="ADMIN" id="typeAdmin">
                                <label class="btn btn-outline-danger text-black user-type-btn" for="typeAdmin">
                                    <i class="bi bi-shield-lock me-1"></i> Admin
                                </label>
                                <input type="radio" class="d-none" name="UserType" value="USER" id="typeUser">
                                <label class="btn btn-outline-danger text-black user-type-btn" for="typeUser">
                                    <i class="bi bi-person me-1"></i> User
                                </label>
                                <input type="radio" class="d-none" name="UserType" value="TEAM_HEAD" id="typeCoord">
                                <label class="btn btn-outline-danger text-black user-type-btn" for="typeCoord">
                                    <i class="bi bi-people me-1"></i> TEAM HEAD
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="UserStatus" required>
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" class="form-control" onchange="PreviewImages('ProfileImage', 'PreviewOfProfile')" id='ProfileImage' name="UserProfileImage" accept="image/*">
                        </div>
                        <div class="col-md-3">
                            <div class="img-preview" id='PreviewOfProfile'></div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="UserNotes" rows="3"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="SaveNewUserRecords" form="addUserForm" class="btn btn-dark btn-md" id="saveUserBtn">Save User <i class="fa fa-check-circle text-success"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    <?php
    // Phone numbers
    $AllPhoneNumbers = SET_SQL("SELECT * FROM users ORDER BY UserPhoneNumber ASC", true);
    $PhoneNumber = "";
    if ($AllPhoneNumbers != null) {
        foreach ($AllPhoneNumbers as $PhoneNumbers) {
            $PhoneNumber .= "'" . $PhoneNumbers->UserPhoneNumber . "',";
        }
    }

    // Email ids
    $AllEmailIds = SET_SQL("SELECT * FROM users ORDER BY UserEmailId ASC", true);
    $EmailIds = "";
    if ($AllEmailIds != null) {
        foreach ($AllEmailIds as $EmailId) {
            $EmailIds .= "'" . $EmailId->UserEmailId . "',";
        }
    }
    ?>
    var PhoneNumbers = [<?php echo rtrim($PhoneNumber, ','); ?>];
    var EmailIds = [<?php echo rtrim($EmailIds, ','); ?>];

    // Check and validate phone number
    function CheckPhoneNumber() {
        const phoneInput = document.getElementById('GetPhoneNumbers');
        const phoneMsg = document.getElementById('PhoneMsg');
        const saveBtn = document.getElementById('saveUserBtn');
        const phoneValue = phoneInput.value.trim();

        // Phone number validation for exactly 10 digits
        const phoneRegex = /^[0-9]{10}$/;

        if (phoneValue === '') {
            phoneMsg.innerHTML = 'Phone number is required';
            phoneInput.classList.add('is-invalid');
            saveBtn.disabled = true;
        } else if (!phoneRegex.test(phoneValue)) {
            phoneMsg.innerHTML = 'Enter exactly 10 digits';
            phoneInput.classList.add('is-invalid');
            saveBtn.disabled = true;
        } else if (PhoneNumbers.includes(phoneValue)) {
            phoneMsg.innerHTML = 'Phone number already exists';
            phoneInput.classList.add('is-invalid');
            saveBtn.disabled = true;
        } else {
            phoneMsg.innerHTML = '<i class="fa fa-check text-success"></i>';
            phoneInput.classList.remove('is-invalid');
            phoneInput.classList.add('is-valid');
            saveBtn.disabled = false;
        }
    }

    // Check and validate email id
    function CheckEmailId() {
        const emailInput = document.getElementById('GetEmailIds');
        const emailMsg = document.getElementById('EmailMsg');
        const saveBtn = document.getElementById('saveUserBtn');
        const emailValue = emailInput.value.trim();

        // Basic email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailValue === '') {
            emailMsg.innerHTML = 'Email is required';
            emailInput.classList.add('is-invalid');
            saveBtn.disabled = true;
        } else if (!emailRegex.test(emailValue)) {
            emailMsg.innerHTML = 'Invalid email format';
            emailInput.classList.add('is-invalid');
            saveBtn.disabled = true;
        } else if (EmailIds.includes(emailValue)) {
            emailMsg.innerHTML = 'Email already exists';
            emailInput.classList.add('is-invalid');
            saveBtn.disabled = true;
        } else {
            emailMsg.innerHTML = '<i class="fa fa-check text-success"></i>';
            emailInput.classList.remove('is-invalid');
            emailInput.classList.add('is-valid');
            saveBtn.disabled = false;
        }
    }

    // Check and validate pincode
    function CheckPincode() {
        const pincodeInput = document.getElementById('GetPincode');
        const pincodeMsg = document.getElementById('PincodeMsg');
        const saveBtn = document.getElementById('saveUserBtn');
        const pincodeValue = pincodeInput.value.trim();

        // Pincode validation for exactly 6 digits
        const pincodeRegex = /^[0-9]{6}$/;

        if (pincodeValue === '') {
            pincodeMsg.innerHTML = '';
            pincodeInput.classList.remove('is-invalid', 'is-valid');
            saveBtn.disabled = false; // Pincode is optional
        } else if (!pincodeRegex.test(pincodeValue)) {
            pincodeMsg.innerHTML = 'Enter exactly 6 digits';
            pincodeInput.classList.add('is-invalid');
            pincodeInput.classList.remove('is-valid');
            saveBtn.disabled = true;
        } else {
            pincodeMsg.innerHTML = '<i class="fa fa-check text-success"></i>';
            pincodeInput.classList.remove('is-invalid');
            pincodeInput.classList.add('is-valid');
            saveBtn.disabled = false;
        }
    }

    // Modal animation
    var addUserModal = document.getElementById('addUserModal')
    addUserModal.addEventListener('show.bs.modal', function(event) {
        var modal = this
        modal.classList.add('fade-in')
    })

    // User type button toggle
    document.querySelectorAll('.user-type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.user-type-btn').forEach(b => {
                b.classList.remove('active');
                b.classList.add('text-black');
                b.classList.remove('text-white');
            });
            this.classList.add('active');
            this.classList.remove('text-black');
            this.classList.add('text-white');
        });
    });

    // Reset validation on modal close
    addUserModal.addEventListener('hidden.bs.modal', function(event) {
        document.getElementById('PhoneMsg').innerHTML = '';
        document.getElementById('EmailMsg').innerHTML = '';
        document.getElementById('PincodeMsg').innerHTML = '';
        document.getElementById('GetPhoneNumbers').classList.remove('is-invalid', 'is-valid');
        document.getElementById('GetEmailIds').classList.remove('is-invalid', 'is-valid');
        document.getElementById('GetPincode').classList.remove('is-invalid', 'is-valid');
        document.getElementById('saveUserBtn').disabled = false;
        document.getElementById('addUserForm').reset();
    });
</script>