<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
//pagevariables
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

// checking User Has A Plan Or Not
$UserID = $_SESSION['APP_LOGIN_USER_ID'];

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
</head>

<body>
    <?php
    include_once $Dir . "/include/Header.php";
    include_once $Dir . "/include/Sidebar.php";
    ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <div class="flex-s-b">
                <div>
                    <h1><i class="bi bi-building-gear text-danger bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button class="btn btn-md btn-danger" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="bi bi-plus"></i> Add New User
                    </button>
                </div>
            </div>
        </div>

        <section class="section profile">
            <form class="row bg-white" action="">
                <div class="col-md-3 form-group">
                    <label>FullName</label>
                    <input type="search" value="<?php echo IfRequested("GET", "UserFullName", "", false); ?>" placeholder="Enter Name..." name="UserFullName" onchange="form.submit()" class="form-control form-control-sm">
                </div>
                <div class="col-md-3 form-group">
                    <label>Phone Number</label>
                    <input type="search" value="<?php echo IfRequested("GET", "UserPhoneNumber", "", false); ?>" placeholder="Enter Phone Number..." name="UserPhoneNumber" onchange="form.submit()" class="form-control form-control-sm">
                </div>
                <div class="col-md-3 form-group">
                    <label>User Type</label>
                    <select name="UserType" class="form-control form-control-sm" onchange="form.submit()">
                        <option value="">All Users</option>
                        <?php foreach (APP_SIDE_BARS as $Key => $Values) {
                            $UserTypeChecking = CheckEquality($Key, IfRequested("GET", "UserType", "", false), "selected"); ?>
                            <option value="<?php echo $Key; ?>" <?php echo $UserTypeChecking; ?>><?php echo $Key; ?></option>
                        <?php }  ?>
                    </select>
                </div>
                <div class="col-md-3 form-group">
                    <label>Reporting Manager</label>
                    <select name="UserReportingManager" class="form-control form-control-sm" onchange="form.submit()">
                        <option value="">All Users</option>
                        <?php
                        $GetAllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber FROM users ORDER BY UserFullName ASC", true);
                        if ($GetAllUsers != null) {
                            foreach ($GetAllUsers as $Users) {
                                $SelectedReportingManager = CheckEquality($Users->UserId, IfRequested("GET", "UserReportingManager", "", false), "selected");
                                echo '<option value="' . $Users->UserId . '" ' . $SelectedReportingManager . '> ' . $Users->UserFullName . ' (' . $Users->UserPhoneNumber . ') </option>';
                            }
                        } ?>
                    </select>
                </div>
            </form>
            <div class="row">
                <div class="col-xl-12">
                    <!-- User Listing -->
                    <div class="card br-1 fade-in">
                        <div class="card-body pt-3">
                            <div class="table-container">
                                <table class="">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Designation</th>
                                            <th>UserType</th>
                                            <th>ReportingManager</th>
                                            <th>TeamOf</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $SelectedColumns = "UserSalutation, UserReportingManager, UserStatus, UserType, UserDesignation, UserPhoneNumber, UserEmailId, UserProfileImage, UserId, UserFullName";
                                        if (isset($_GET["UserReportingManager"])) {
                                            $UserPhoneNumber = $_GET["UserPhoneNumber"];
                                            $UserFullName = $_GET["UserFullName"];
                                            $UserType = $_GET["UserType"];
                                            $UserReportingManager = trim($_GET["UserReportingManager"]);

                                            if (empty($UserReportingManager)) {
                                                $ReportingConditions = "";
                                            } else {
                                                $ReportingConditions = "and UserReportingManager='$UserReportingManager'";
                                            }
                                            $AllUsersSql = "SELECT $SelectedColumns FROM users where UserType LIKE '%$UserType%' and UserPhoneNumber LIKE '%$UserPhoneNumber%' and UserFullName LIKE '%$UserFullName%' and UserId!='1' $ReportingConditions ORDER BY DATE(UserCreatedAt) DESC";
                                        } else {
                                            $AllUsersSql = "SELECT $SelectedColumns FROM users where UserId!='1' ORDER BY UserId DESC";
                                        }

                                        $AllUsers = SET_SQL($AllUsersSql, true);
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
                                                        <a class="bold" href="details/?UserId=<?php echo SECURE($Users->UserId, "e"); ?>">
                                                            <?php echo $Users->UserSalutation . " " . UpperCase(LimitText($Users->UserFullName, 0, 30)); ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo LimitText($Users->UserEmailId, 0, 50); ?></td>
                                                    <td><?php echo $Users->UserPhoneNumber; ?></td>
                                                    <td><?php echo  RandomColorText($Users->UserDesignation); ?></td>
                                                    <td>
                                                        <span class="bg-dark text-white btn-xs btn"><?php echo $Users->UserType; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if ($Users->UserReportingManager == 1) { ?>
                                                            <span class="text-black small bold">
                                                                (ID:<?php echo $Users->UserReportingManager; ?>)-<?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Users->UserReportingManager . "'", "UserFullName"); ?>
                                                            </span>
                                                        <?php } else { ?>
                                                            <a href="details/?UserId=<?php echo SECURE($Users->UserReportingManager, "e"); ?>" class="text-primary small bold text-decoration-underline">
                                                                (ID:<?php echo $Users->UserReportingManager; ?>)-<?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Users->UserReportingManager . "'", "UserFullName"); ?>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <b><?php echo TOTAL("SELECT UserId FROM users where UserReportingManager='" . $Users->UserId . "'"); ?> Users</b>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $CheckLeads = CHECK("SELECT leads_id FROM leads where leads_managed_by='" . $Users->UserId . "'");
                                                        if ($CheckLeads == null) {
                                                            CONFIRM_DELETE_POPUP(
                                                                "userslist",
                                                                [
                                                                    "RemoveUserRecords" => true,
                                                                    "UserId" => $Users->UserId
                                                                ],
                                                                CONTROLLER . "/ModuleController/UserController.php",
                                                                "<i class='fa fa-trash'></i>",
                                                                "btn btn-xs pull-right btn-danger ml-1"
                                                            );
                                                        } else {
                                                            echo "<span class='btn btn-xs pull-right ml-1 btn-secondary btn-disabled'><i class='fa fa-trash'></i></span>";
                                                        } ?>
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
                                                <td colspan='10' align='center' style='text-align:center;'>
                                                <span class='alert alert-warning mt-4 d-block w-100'><i class='fa fa-warning'></i> No users found.</span>
                                                </td>
                                            </tr>";
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>
    <?php
    include __DIR__ . "/components/AddUserForm.php";
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>
</body>

</html>