<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";
$UserID = $_SESSION['APP_LOGIN_USER_ID'];
$PageName = "Team Reports";

SQL("UPDATE configurations SET configurationvalue='100' where configurationname='DEFAULT_RECORD_LISTING'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.85, maximum-scale=1.0, user-scalable=no" name="viewport" />
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
                    <form>
                        <input type="search" oninput="SearchData('SearchProvider', 'SearchRecords')" id="SearchProvider" value="<?php echo IfRequested("GET", "SearchTeamMember", "", null); ?>" name="SearchTeamMember" class="form-control" placeholder="Search via Full Name, Phone Number">
                    </form>
                    <ul class="team-reports-user-lists mt-1">
                        <?php include "components/UserSearchAndSelect.php"; ?>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php"; ?>
</body>

</html>