<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
// Page variables
$PageName = "Expenses";
$PageDescription = "Manage and track expenses within " . APP_NAME;

// Checking User Has A Plan Or Not
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

            let prevClass = currentPage === 1 ? "disabled" : "";
            pagination.innerHTML += `<li class="page-item ${prevClass}"><a class="page-link" href="#" onclick="generatePagination(${currentPage - 1})">Previous</a></li>`;

            for (let i = 1; i <= 3; i++) {
                pagination.innerHTML += getPaginationItem(i, currentPage);
            }

            if (currentPage > 5) {
                pagination.innerHTML += `<li class="page-item disabled"><a class="page-link">...</a></li>`;
            }

            let start = Math.max(4, currentPage - 2);
            let end = Math.min(97, currentPage + 2);
            for (let i = start; i <= end; i++) {
                pagination.innerHTML += getPaginationItem(i, currentPage);
            }

            if (currentPage < 96) {
                pagination.innerHTML += `<li class="page-item disabled"><a class="page-link">...</a></li>`;
            }

            for (let i = 98; i <= totalPages; i++) {
                pagination.innerHTML += getPaginationItem(i, currentPage);
            }

            let nextClass = currentPage === totalPages ? "disabled" : "";
            pagination.innerHTML += `<li class="page-item ${nextClass}"><a class="page-link" href="#" onclick="generatePagination(${currentPage + 1})">Next</a></li>`;
        }

        function getPaginationItem(page, currentPage) {
            let activeClass = page === currentPage ? "active" : "";
            return `<li class="page-item ${activeClass}"><a class="page-link" href="#" onclick="generatePagination(${page})">${page}</a></li>`;
        }

        // Show/Hide Filter Popup
        function toggleFilterPopup() {
            let popup = document.getElementById("filterPopup");
            popup.style.display = popup.style.display === "block" ? "none" : "block";
        }

        // Show/Hide Add Expense Popup
        function toggleAddExpensePopup() {
            let popup = document.getElementById("addExpensePopup");
            popup.style.display = popup.style.display === "block" ? "none" : "block";
        }

        generatePagination();
    </script>
    <style>
        .tab-content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
            background: #fff;
        }

        .table thead th {
            background-color: #007bff;
            color: white;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .widget-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            background: #fff;
        }

        .filter-popup,
        .add-expense-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .filter-popup .btn-close,
        .add-expense-popup .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
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
                    <h1><i class="bi bi-wallet2 text-danger bold"></i> <?php echo $PageName; ?></h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?php echo $PageName; ?></li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button class="btn btn-md btn-danger" onclick="toggleAddExpensePopup()"><i class="bi bi-plus"></i> Add New Expense</button>
                </div>
            </div>
        </div><!-- End Page Title -->

        <!-- Add Expense Popup -->
        <div class="add-expense-popup" id="addExpensePopup">
            <h5>Add New Expense</h5>
            <button class="btn-close" onclick="toggleAddExpensePopup()"></button>
            <form>
                <div class="mb-3">
                    <label for="expenseDate" class="form-label">Date</label>
                    <input type="date" class="form-control" id="expenseDate" required>
                </div>
                <div class="mb-3">
                    <label for="expenseAmount" class="form-label">Amount (₹)</label>
                    <input type="number" class="form-control" id="expenseAmount" placeholder="Enter Amount in Rupees" required>
                </div>
                <div class="mb-3">
                    <label for="expenseCategory" class="form-label">Category</label>
                    <select class="form-select" id="expenseCategory" required>
                        <option value="">Select Category</option>
                        <option value="Travel">Travel</option>
                        <option value="Food">Food</option>
                        <option value="Office">Office</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="expenseDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="expenseDescription" rows="3" placeholder="Enter Description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-circle"></i> Submit Expense</button>
            </form>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <!-- Expenses Widget -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="widget-card">
                                        <h6>Total Expenses</h6>
                                        <h3 class="text-primary">₹5,000</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="widget-card">
                                        <h6>Today</h6>
                                        <h3 class="text-success">₹200</h3>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="widget-card">
                                        <h6>Yesterday</h6>
                                        <h3 class="text-warning">₹150</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- User Selection and Filter Button -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="userSelection" class="form-label">Select User</label>
                                    <select class="form-select" id="userSelection">
                                        <option value="all">All Users</option>
                                        <option value="me">By Me</option>
                                        <option value="user1">User 1</option>
                                        <option value="user2">User 2</option>
                                        <option value="user3">User 3</option>
                                    </select>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button class="btn btn-primary mt-4" onclick="toggleFilterPopup()"><i class="bi bi-funnel"></i> Filter</button>
                                </div>
                            </div>

                            <!-- Filter Popup -->
                            <div class="filter-popup" id="filterPopup">
                                <h5>Filter Options</h5>
                                <button class="btn-close" onclick="toggleFilterPopup()"></button>
                                <div class="mb-3">
                                    <label for="filterAmount" class="form-label">Amount (₹)</label>
                                    <input type="number" class="form-control" id="filterAmount" placeholder="Enter Amount in Rupees">
                                </div>
                                <div class="mb-3">
                                    <label for="filterDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="filterDate">
                                </div>
                                <div class="mb-3">
                                    <label for="filterCategory" class="form-label">Category</label>
                                    <select class="form-select" id="filterCategory">
                                        <option value="">Select Category</option>
                                        <option value="Travel">Travel</option>
                                        <option value="Food">Food</option>
                                        <option value="Office">Office</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="filterStatus" class="form-label">Status</label>
                                    <select class="form-select" id="filterStatus">
                                        <option value="">Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> Apply Filters</button>
                            </div>

                            <!-- Expenses List -->
                            <div class="row mt-2">
                                <div class="col-md-12 mb-3">
                                    <h4><i class="bi bi-list-ul text-primary"></i> Expenses List</h4>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>SNo.</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Category</th>
                                                <th>Submitted By</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 1; $i <= 50; $i++) { ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>2025-03-<?php echo sprintf("%02d", $i); ?></td>
                                                    <td>₹<?php echo rand(50, 500); ?></td>
                                                    <td><?php echo ($i % 3 == 0) ? "Travel" : (($i % 3 == 1) ? "Food" : "Office"); ?></td>
                                                    <td>User <?php echo $i % 3 + 1; ?></td>
                                                    <td><?php echo ($i % 3 == 0) ? "Pending" : (($i % 3 == 1) ? "Approved" : "Rejected"); ?></td>
                                                    <td><button class="btn btn-sm btn-outline-primary">View</button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <p class="pt-4">50 Records showing from Total 100 Records</p>
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