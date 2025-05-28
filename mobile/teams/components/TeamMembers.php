<style>
    table.table tr th,
    table.table tr td {
        padding: 2px !important;
        text-align: left;
        font-size: 0.8rem !important;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    .modal {
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
        }

        to {
            transform: translateY(0);
        }
    }

    .user-type-btn {
        transition: all 0.3s ease;
        margin-right: 5px;
    }

    .user-type-btn:hover {
        transform: translateY(-2px);
    }

    .user-type-btn.active {
        background-color: #dc3545 !important;
        color: white !important;
    }

    .filter-card {
        background: #f8f9fa;
        border-radius: 8px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <h4 class="app-sub-heading">Team Members</h4>
    </div>

    <!-- User Listing -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Designation</th>
                    <th>UserType</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $AllUsers = SET_SQL("SELECT * FROM users where UserId!='1' and UserReportingManager='$SelectedUserId' ORDER BY UserId DESC", true);
                if ($AllUsers != null) {
                    $SerialNo = 0;
                    foreach ($AllUsers as $Users) {
                        $SerialNo++;
                        if ($Users->UserProfileImage == null || $Users->UserProfileImage == "" || $Users->UserProfileImage == " ") {
                            $UserProfileImage = APP_LOGO;
                        } else {
                            $UserProfileImage = STORAGE_URL . "/users/" . $Users->UserId . "/img/" . $Users->UserProfileImage;
                        }  ?>
                        <tr>
                            <td><?php echo $SerialNo; ?></td>
                            <td>
                                <img src="<?php echo $UserProfileImage; ?>" class="img-fluid list-icon">
                            </td>
                            <td>
                                <a class="bold" href="?SelectedUserId=<?php echo SECURE($Users->UserId, "e"); ?>">
                                    <?php echo LimitText($Users->UserFullName, 0, 30); ?>
                                </a>
                            </td>
                            <td><?php echo LimitText($Users->UserEmailId, 0, 20); ?></td>
                            <td><?php echo $Users->UserPhoneNumber; ?></td>
                            <td><?php echo  RandomColorText($Users->UserDesignation); ?></td>
                            <td>
                                <span class="bg-dark text-white btn-xs btn"><?php echo $Users->UserType; ?></span>
                            </td>
                            <td>
                                <form action="<?php echo CONTROLLER; ?>/ModuleController/UserController.php" method="POST" class="pull-right user-status">
                                    <?php
                                    echo FormPrimaryInputs(true, [
                                        "UserId" => $Users->UserId,
                                        "UpdateUserStatus" => "true"
                                    ]);
                                    $Selection = CheckEquality($Users->UserStatus, 1, "checked");
                                    ?>

                                    <label class="custom-switch-ui">
                                        <input onchange="form.submit()" value="true" name="UserStatus" <?php echo $Selection; ?> type="checkbox" id="switch<?php echo $Users->UserId; ?>">
                                        <span class="slider-switch"></span>
                                    </label>
                                </form>
                            </td>
                        </tr>
                <?php }
                } else {
                    //echo for no users in table column count span
                    echo "<tr>
                                                <td colspan='9' align='center'>No users found.</td>
                                            </tr>";
                } ?>
            </tbody>
        </table>
    </div>
</div>