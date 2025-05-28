<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";
$UserID = $_SESSION['APP_LOGIN_USER_ID'];
$PageName = "Team Reports";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=0.95, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include_once $Dir . "/assets/HeaderStyleSheets.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .table-container {
            width: 100% !important;
            overflow-x: scroll !important;
            border-radius: 8px !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100% !important;
            border-collapse: collapse !important;
            min-width: max-content !important;
            background: #fff !important;
        }

        table tr th {
            background: black !important;
            color: white !important;
            border-bottom: 1px solid #ddd !important;
        }

        table tr th,
        table tr td {
            font-size: 0.65rem !important;
            padding: 2px 5px !important;
        }

        .table-container table tr th,
        .table-container table tr td {
            font-size: 0.83rem !important;
            padding: 2px 5px !important;
        }
    </style>
</head>

<body class="pb-5 mb-5">
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <section class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0">
                    <ul class="team-reports-user-lists mt-1">
                        <?php
                        $SelectedUserId = SECURE(ReturnSessionalValues("SelectedUserId", "SELECTED_USER_ID", IfRequested("GET", "SelectedUserId", null, null), "GET"), "d");
                        if ($SelectedUserId != null) {
                            $AllUsersSQL = SET_SQL("SELECT UserStatus, UserEmailId, UserPhoneNumber, UserDesignation, UserProfileImage, UserId, UserFullName, UserSalutation, UserFullName  FROM users WHERE UserId='$SelectedUserId'", true);
                            if ($AllUsersSQL != null) {
                                foreach ($AllUsersSQL as $Users) {
                                    if ($Users->UserProfileImage == null || $Users->UserProfileImage == "" || $Users->UserProfileImage == " ") {
                                        $UserProfileImage = APP_LOGO;
                                    } else {
                                        $UserProfileImage = STORAGE_URL . "/users/" . $Users->UserId . "/img/" . $Users->UserProfileImage;
                                    } ?>
                                    <li class='SearchRecords'>
                                        <a class='text-secondary active' href="reports.php?SelectedUserId=<?php echo SECURE($Users->UserId, "e"); ?>">
                                            <img src="<?php echo STORAGE_URL_D; ?>/tool-img/right-side-icon.png" class="active-user-icon">
                                            <div class="user_lists">
                                                <div class="user-img">
                                                    <img src="<?php echo $UserProfileImage; ?>" alt="<?php echo $Users->UserFullName; ?>" class="img-fluid rounded-circle">
                                                </div>
                                                <div class="user-details">
                                                    <span class='pull-right small mr-2 small'><?php echo StatusViewWithText($Users->UserStatus); ?></span>
                                                    <h5>
                                                        <?php echo $Users->UserSalutation; ?>
                                                        <?php echo $Users->UserFullName; ?>
                                                    </h5>
                                                    <h6><?php echo $Users->UserDesignation; ?></h6>
                                                    <p>
                                                        <span><i class="bi bi-phone-fill text-primary"></i> <?php echo $Users->UserPhoneNumber; ?></span>
                                                        <span><i class="bi bi-envelope text-warning"></i> <?php echo $Users->UserEmailId; ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                        <?php
                                }
                            }
                        } ?>
                    </ul>
                </div>
                <div class="col-md-12 p-0">
                    <?php if ($SelectedUserId != null) { ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                $ActiveTeamMenus = ReturnSessionalValues("getTeamModule", "ACTIVE_TEAM_MENU_LINK", "leads", "GET");
                                foreach (TEAM_REPORTS_NAV_LINKS as $Key => $TeamReportMenus) {
                                    $ActiveLink = CheckEquality($ActiveTeamMenus, $Key, "btn-primary"); ?>
                                    <a class="btn btn-xs <?php echo $ActiveLink; ?> btn-default" href="?getTeamModule=<?php echo $Key; ?>">
                                        <i class="<?php echo $TeamReportMenus['icon']; ?>"></i>
                                        <?php echo $TeamReportMenus['name']; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <hr>
                        <?php include "components/" . TEAM_REPORTS_NAV_LINKS[$ActiveTeamMenus]["module"]; ?>
                    <?php } ?>
                </div>
            </div>
        </section>


    </main>

    <!-- Modals -->
    <div id="assignModal" class="modal">
        <div class="modal-content">
            <div class="modal-header app-heading">
                <h5 class="modal-title" id="my-modal-title">Assign Leads to Users</h5>
            </div>
            <form class="row" id="AssignFormForLeads" method="POST" action="<?php echo CONTROLLER; ?>/ModuleController/LeadsController.php">
                <?php echo FormPrimaryInputs(true); ?>
                <div class="col-md-7">
                    <h5 class="app-sub-heading">Selected Leads For Assign/Re-Assign</h5>
                    <div id="assignSelectedLeads" class="mb-3"></div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label>Assign To</label>
                        <select class="form-control" name="leads_managed_by" id="assignUser" required>
                            <option value="">Select User</option>
                            <?php
                            if (AuthAppUser("UserType") == "ADMIN") {
                                $users = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users WHERE UserStatus='1' ORDER BY UserFullName", true);
                            } else {
                                $users = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users WHERE UserStatus='1' and UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName", true);
                            }
                            foreach ($users as $user) {
                                echo "<option value='{$user->UserId}'>(UID{$user->UserId}) -{$user->UserFullName} - {$user->UserPhoneNumber}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Stage</label>
                        <select class="form-control" name="leads_stages" id="assignStage" required>
                            <option value="">Select Stage</option>
                            <?php
                            $AllLeadsStages = SET_SQL("SELECT config_leads_stages_id, config_leads_stage_name FROM config_leads_stages ORDER BY config_leads_stage_name", true);
                            foreach ($AllLeadsStages as $stage) {
                                echo "<option value='{$stage->config_leads_stages_id}'>{$stage->config_leads_stage_name}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Priority Level</label>
                        <select name="leads_assigned_priority_level" class="form-control">
                            <option value="">Select Priority Level</option>
                            <?php
                            $AllPriorityLevels = SET_SQL("SELECT config_priority_level_id, config_priority_level_name FROM config_priority_levels where config_priority_level_status='1'", true);
                            if ($AllPriorityLevels != null) {
                                foreach ($AllPriorityLevels as $Priority) { ?>
                                    <option value="<?php echo $Priority->config_priority_level_id; ?>"><?php echo $Priority->config_priority_level_name; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 text-right">
                    <hr>
                    <button class="btn btn-primary btn-md" name="AssignSelectedLeads" onclick="submitAssign()"><i class="bi bi-check-circle text-success"></i> Assign</button>
                    <button class="btn btn-default btn-md ml-2" onclick="closeModal('assignModal')"><i class="bi bi-x-circle text-success"></i> Close</button>
                </div>
            </form>

        </div>
    </div>

    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
    <script>
        // Select All functionality
        document.getElementById("selectAll").addEventListener("change", function(e) {
            document.querySelectorAll(".d-selection").forEach((checkbox) => {
                checkbox.checked = e.target.checked;
            });
            // Show/hide based on if any are checked
            document.getElementById("RemoveButtonOption").style.display = e.target.checked ?
                "block" :
                "none";
            document.getElementById("AssignButtonOption").style.display = e.target.checked ?
                "block" :
                "none";
            document.getElementById("SelectionActivityOptions").style.display = e.target
                .checked ?
                "block" :
                "none";
        });

        // Individual checkbox functionality
        document
            .querySelectorAll('.d-selection[name="SELECTED_LEADS[]"]')
            .forEach((checkbox) => {
                checkbox.addEventListener("change", function() {
                    const allChecked = Array.from(
                        document.querySelectorAll('.d-selection[name="SELECTED_LEADS[]"]')
                    ).every((cb) => cb.checked);
                    document.getElementById("selectAll").checked = allChecked;

                    // Check if at least one checkbox is checked
                    const anyChecked = Array.from(
                        document.querySelectorAll('.d-selection[name="SELECTED_LEADS[]"]')
                    ).some((cb) => cb.checked);
                    document.getElementById("AssignButtonOption").style.display = anyChecked ?
                        "block" :
                        "none";
                    document.getElementById("RemoveButtonOption").style.display = anyChecked ?
                        "block" :
                        "none";
                    document.getElementById("SelectionActivityOptions").style.display =
                        anyChecked ? "block" : "none";
                });
            });

        function showAssignModal() {
            const selected = getSelectedLeadsData();
            if (selected.length === 0) {
                alert("Please select at least one lead");
                return;
            }
            const content = selected
                .map(
                    (lead) =>
                    `<div class='selected-leads small'>
        <input type='checkbox' checked hidden name='selected_leads_id[]' value='${lead.id}'>
        <b>Name:</b> ${lead.name}, <b>Phone:</b> ${lead.phone}
        </div>`
                )
                .join("");
            document.getElementById("assignSelectedLeads").innerHTML = content;
            document.getElementById("assignModal").style.display = "block";
        }

        function showRemoveModal() {
            const selected = getSelectedLeadsData();
            if (selected.length === 0) {
                alert("Please select at least one lead");
                return;
            }
            const content = selected
                .map(
                    (lead) =>
                    `<div class='selected-leads small'>
        <input type='checkbox' checked hidden name='selected_leads_id[]' value='${lead.id}'>
        <b>Name:</b> ${lead.name}, <b>Phone:</b> ${lead.phone}
        </div>`
                )
                .join("");
            document.getElementById("removeSelectedLeads").innerHTML = content;
            document.getElementById("removeModal").style.display = "block"; // Fixed typo: Display -> display
        }

        function showMoveModal() {
            const selected = getSelectedLeadsData();
            if (selected.length === 0) {
                alert("Please select at least one lead");
                return;
            }
            const content = selected
                .map(
                    (lead) =>
                    `<div class='selected-leads small'>
        <input type='checkbox' checked hidden name='selected_leads_id[]' value='${lead.id}'>
        <b>Name:</b> ${lead.name}, <b>Phone:</b> ${lead.phone}
        </div>`
                )
                .join("");
            document.getElementById("moveSelectedLeads").innerHTML = content;
            document.getElementById("moveModal").style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        function getSelectedLeadsData() {
            return Array.from(
                document.querySelectorAll('.d-selection[name="SELECTED_LEADS[]"]:checked')
            ).map((cb) => ({
                id: cb.value,
                name: cb.parentElement.nextElementSibling.nextElementSibling.textContent.trim(),
                phone: cb.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.textContent.trim(),
            }));
        }

        function submitAssign() {
            const selected = getSelectedLeadsData();
            const assignUser = document.getElementById("assignUser").value;
            const assignStage = document.getElementById("assignStage").value;

            if (!assignUser || !assignStage) {
                alert("Please select both a user and a stage");
                return;
            }

            console.log(
                "Assigning",
                selected,
                "to user",
                assignUser,
                "and stage",
                assignStage
            );
            alert(
                `Assigning ${selected.length} leads to user ID ${assignUser} and stage ID ${assignStage}`
            );
            document.getElementById("AssignFormForLeads").submit();
        }
    </script>
</body>

</html>