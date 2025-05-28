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
    <script>
        function generatePagination(currentPage = 1) {
            let pagination = document.getElementById("pagination");
            pagination.innerHTML = ""; // Clear existing pagination
            let totalPages = 100;

            // Previous Button
            let prevClass = currentPage === 1 ? "disabled" : "";
            pagination.innerHTML += `<li class="page-item ${prevClass}"><a class="page-link" href="#" onclick="generatePagination(${currentPage - 1})">Previous</a></li>`;

            // First 3 Pages
            for (let i = 1; i <= 3; i++) {
                pagination.innerHTML += getPaginationItem(i, currentPage);
            }

            // Dots if needed
            if (currentPage > 5) {
                pagination.innerHTML += `<li class="page-item disabled"><a class="page-link">...</a></li>`;
            }

            // Middle Pages (2 pages before & after current page)
            let start = Math.max(4, currentPage - 2);
            let end = Math.min(97, currentPage + 2);
            for (let i = start; i <= end; i++) {
                pagination.innerHTML += getPaginationItem(i, currentPage);
            }

            // Dots if needed
            if (currentPage < 96) {
                pagination.innerHTML += `<li class="page-item disabled"><a class="page-link">...</a></li>`;
            }

            // Last 3 Pages
            for (let i = 98; i <= totalPages; i++) {
                pagination.innerHTML += getPaginationItem(i, currentPage);
            }

            // Next Button
            let nextClass = currentPage === totalPages ? "disabled" : "";
            pagination.innerHTML += `<li class="page-item ${nextClass}"><a class="page-link" href="#" onclick="generatePagination(${currentPage + 1})">Next</a></li>`;
        }

        // Function to create a pagination item
        function getPaginationItem(page, currentPage) {
            let activeClass = page === currentPage ? "active" : "";
            return `<li class="page-item ${activeClass}"><a class="page-link" href="#" onclick="generatePagination(${page})">${page}</a></li>`;
        }

        // Initialize pagination
        generatePagination();
    </script>
</head>

<body onload="generatePagination()">
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
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="<?php echo APP_URL; ?>/contacts/add" class="btn btn-md btn-danger"><i class="bi bi-plus"></i> Add New Contacts</a>
                </div>
            </div>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">

                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <div class="row">
                                <div class="col-md-12 text-right">

                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12 mb-2">
                                    <a href="" class="btn btn-sm btn-outline-success">Move Contacts</a>
                                    <a href="" class="btn btn-sm btn-outline-warning">Assign Contacts</a>
                                    <a href="" class="btn btn-sm btn-outline-dark">Upload Contacts</a>
                                    <a href="" class="btn btn-sm btn-outline-success">Export Contacts</a>

                                </div>
                                <div class="col-md-12">
                                    <div class="large-scale-data-records">
                                        <table class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:2% !important;"><input type="checkbox" class="d-selection" name="ALL_SELECTED"></th>
                                                    <th class="w-pr-5">SNo. <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">ContactName <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">PhoneNumber <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">EmailId <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">ProjectName <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">DeveloperName <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">ContactsStage <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">ContactSources <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">AssignedTo <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">AssignedOn <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">ContactsTypes <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">Priority <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">Budgets <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">ReportingManager <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">CallBackReason <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">CreadedOn <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">PreviousStage <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">PreviousAssignTo <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">AssignedBy <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">LastModifiedOn <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">LastModifiedBy <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="w-pr-2">Status <i class="bi bi-arrow-down-up"></i></th>
                                                    <th class="text-right w-pr-10">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $Start = 0;
                                                while ($Start <= 30) {
                                                    $Start++; ?>
                                                    <tr>
                                                        <td><input class="d-selection mt-2" type="checkbox" name="row_1"></td>
                                                        <td>1</td>
                                                        <td>John Doe</td>
                                                        <td>9876543210</td>
                                                        <td>johndoe@example.com</td>
                                                        <td>Project A</td>
                                                        <td>Developer A</td>
                                                        <td>New</td>
                                                        <td>Phone</td>
                                                        <td>User A</td>
                                                        <td>2022-01-01</td>
                                                        <td>Sales</td>
                                                        <td>High</td>
                                                        <td>$5000</td>
                                                        <td>Manager A</td>
                                                        <td>Meeting</td>
                                                        <td>2022-01-01</td>
                                                        <td>New</td>
                                                        <td>User A</td>
                                                        <td>Admin</td>
                                                        <td>21 March 2025</td>
                                                        <td>User A</td>
                                                        <td>Active</td>
                                                        <td class="text-right">
                                                            <a href="<?php echo APP_URL; ?>/contacts/edit/1" class="btn btn-xs btn-primary">
                                                                <i class="bi bi-pencil-square"></i> View Details
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="pt-4">30 Records showing from Total 100 Records </p>
                                </div>
                                <div class="col-md-6 pt-3 text-right justify-content-end align-content-end">
                                    <nav aria-label="Page navigation" class="pull-right">
                                        <ul class="pagination" id="pagination"></ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
    <?php
    include_once $Dir . "/include/Footer.php";
    include_once $Dir . "/assets/FooterScripts.php";
    ?>
</body>

</html>