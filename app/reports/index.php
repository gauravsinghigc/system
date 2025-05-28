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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

<body>
    <?php include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php"; ?>

    <main id="main" class="main">
        <div class="pagetitle animate-fade-up">
            <div class="flex-s-b">
                <div>
                    <h1><i class="bi bi-building-gear text-danger bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="shadow-sm p-2 br-1">
                        <h5 class="app-heading"><i class="bi bi-search"></i> Search and Select Team Member</h5>
                        <form>
                            <input type="search" oninput="SearchData('SearchProvider', 'SearchRecords')" id="SearchProvider" value="<?php echo IfRequested("GET", "SearchTeamMember", "", null); ?>" name="SearchTeamMember" class="form-control form-control-sm" placeholder="Search via Full Name, Phone Number">
                        </form>
                        <ul class="team-reports-user-lists mt-1">
                            <?php include "components/UserSearchAndSelect.php"; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="shadow-sm p-2 br-1">
                        <h5 class="app-sub-heading"><i class="bi bi-person"></i> Analytical Report of Selected Team Member</h5>
                        <?php if ($SelectedUserId != null) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $ActiveTeamMenus = ReturnSessionalValues("getTeamModule", "ACTIVE_TEAM_MENU_LINK", "leads", "GET");
                                    foreach (TEAM_REPORTS_NAV_LINKS as $Key => $TeamReportMenus) {
                                        $ActiveLink = CheckEquality($ActiveTeamMenus, $Key, "btn-primary"); ?>
                                        <a class="btn btn-sm <?php echo $ActiveLink; ?> btn-default" href="?getTeamModule=<?php echo $Key; ?>">
                                            <i class="<?php echo $TeamReportMenus['icon']; ?>"></i>
                                            <?php echo $TeamReportMenus['name']; ?>
                                        </a>
                                    <?php } ?>
                                    <?php if (AuthAppUser("UserType") == "ADMIN") { ?>
                                        <a class="btn btn-sm btn-default" href="?getTeamModule=activitytracking">
                                            <i class="fa fa-map-marker"></i>
                                            View Activity On Map
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <hr>
                            <?php
                            if ($ActiveTeamMenus == "activitytracking") {
                                include "components/TeamActivityOnMap.php";
                            } else {
                                include "components/" . TEAM_REPORTS_NAV_LINKS[$ActiveTeamMenus]["module"];
                            } ?>
                        <?php } ?>
                    </div>
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
                                $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users ORDER BY UserFullName ASC", true);
                            } else {
                                $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users WHERE UserReportingManager='" . LOGIN_USER_ID . "' ORDER BY UserFullName ASC", true);
                            }
                            foreach ($AllUsers as $Users) {
                                echo "<option value='{$Users->UserId}'>(UID{$Users->UserId}) -{$Users->UserFullName} - {$Users->UserPhoneNumber}</option>";
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
                        <label>Update Leads Type</label>
                        <select class="form-select form-control" name="leads_type">
                            <?php echo InputOptionsWithKey([
                                "LEAD" => "LEAD",
                                "DATA" => "DATA",
                            ], IfRequested("GET", "leads_type", "", null)); ?>
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