<?php
$Dir = "../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
// Page variables
$PageName = ADMIN_SIDEBAR_MENUS[ReturnSessionalValues("menu", "ACTIVE_MENU_PAGE_TITLE", "dashboard", "GET")]['name'];
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

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

        // Toggle Popups
        function toggleCreateBookingPopup() {
            let popup = document.getElementById("createBookingPopup");
            popup.style.display = popup.style.display === "block" ? "none" : "block";
        }

        function toggleReceivePaymentPopup() {
            let popup = document.getElementById("receivePaymentPopup");
            popup.style.display = popup.style.display === "block" ? "none" : "block";
        }

        // Toggle Views
        function toggleView(view) {
            let listView = document.getElementById("listView");
            let calendarView = document.getElementById("calendarView");
            if (view === 'list') {
                listView.style.display = "block";
                calendarView.style.display = "none";
            } else {
                listView.style.display = "none";
                calendarView.style.display = "block";
            }
        }

        generatePagination();
    </script>
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            background-color: #343a40;
            /* bg-dark */
            color: white;
        }

        .button-group button {
            margin-right: 10px;
        }

        .popup {
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

        .popup .btn-close {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .calendar {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .calendar th,
        .calendar td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            width: 14.28%;
        }

        .calendar th {
            background-color: #343a40;
            /* bg-dark */
            color: white;
        }

        .calendar td {
            height: 100px;
            vertical-align: top;
        }

        .calendar .event {
            background-color: #d1ecf1;
            border-radius: 3px;
            padding: 2px 5px;
            margin: 2px 0;
            font-size: 12px;
        }

        .filter-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
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
                    <h1><i class="bi bi-cart text-danger bold"></i> Sales</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Sales</li>
                        </ol>
                    </nav>
                </div>
                <div class="button-group">
                    <button class="btn btn-md btn-primary" onclick="toggleCreateBookingPopup()"><i class="bi bi-plus"></i> Create Booking</button>
                    <button class="btn btn-md btn-primary" onclick="toggleReceivePaymentPopup()"><i class="bi bi-cash"></i> Receive Payment</button>
                    <button class="btn btn-md btn-primary" onclick="toggleView('list')"><i class="bi bi-list"></i> List View</button>
                    <button class="btn btn-md btn-primary" onclick="toggleView('calendar')"><i class="bi bi-calendar"></i> Calendar View</button>
                </div>
            </div>
        </div><!-- End Page Title -->

        <!-- Create Booking Popup -->
        <div class="popup" id="createBookingPopup">
            <h5>Create New Booking</h5>
            <button class="btn-close" onclick="toggleCreateBookingPopup()"></button>
            <form>
                <div class="mb-3">
                    <label for="bookingCustomer" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="bookingCustomer" placeholder="Enter Customer Name" required>
                </div>
                <div class="mb-3">
                    <label for="bookingDate" class="form-label">Booking Date</label>
                    <input type="date" class="form-control" id="bookingDate" required>
                </div>
                <div class="mb-3">
                    <label for="bookingAmount" class="form-label">Amount (₹)</label>
                    <input type="number" class="form-control" id="bookingAmount" placeholder="Enter Amount" required>
                </div>
                <div class="mb-3">
                    <label for="bookingProject" class="form-label">Project</label>
                    <select class="form-select" id="bookingProject" required>
                        <option value="">Select Project</option>
                        <option value="Project A">Project A</option>
                        <option value="Project B">Project B</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-circle"></i> Create Booking</button>
            </form>
        </div>

        <!-- Receive Payment Popup -->
        <div class="popup" id="receivePaymentPopup">
            <h5>Receive Payment</h5>
            <button class="btn-close" onclick="toggleReceivePaymentPopup()"></button>
            <form>
                <div class="mb-3">
                    <label for="paymentCustomer" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="paymentCustomer" placeholder="Enter Customer Name" required>
                </div>
                <div class="mb-3">
                    <label for="paymentDate" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="paymentDate" required>
                </div>
                <div class="mb-3">
                    <label for="paymentAmount" class="form-label">Amount (₹)</label>
                    <input type="number" class="form-control" id="paymentAmount" placeholder="Enter Amount" required>
                </div>
                <div class="mb-3">
                    <label for="paymentMethod" class="form-label">Payment Method</label>
                    <select class="form-select" id="paymentMethod" required>
                        <option value="">Select Method</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="UPI">UPI</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-circle"></i> Receive Payment</button>
            </form>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <!-- Filter Section -->
                            <div class="filter-section">
                                <h5 class="bg-dark text-white p-2 mb-3">Filters</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="filterCustomer" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="filterCustomer" placeholder="Enter Customer Name">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filterDate" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="filterDate">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filterProject" class="form-label">Project</label>
                                        <select class="form-select" id="filterProject">
                                            <option value="">Select Project</option>
                                            <option value="Project A">Project A</option>
                                            <option value="Project B">Project B</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filterStatus" class="form-label">Status</label>
                                        <select class="form-select" id="filterStatus">
                                            <option value="">Select Status</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Completed">Completed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 text-end mt-3">
                                        <button class="btn btn-primary"><i class="bi bi-search"></i> Apply Filters</button>
                                        <button class="btn btn-outline-dark"><i class="bi bi-arrow-clockwise"></i> Reset</button>
                                    </div>
                                </div>
                            </div>

                            <!-- List View -->
                            <div id="listView" style="display: block;">
                                <h4 class="bg-dark text-white p-2 mb-3"><i class="bi bi-list-ul"></i> Bookings and Payments</h4>
                                <table class="table table-striped" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>SNo.</th>
                                            <th>Type</th>
                                            <th>Customer Name</th>
                                            <th>Project</th>
                                            <th>Amount (₹)</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php for ($i = 1; $i <= 10; $i++) { ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo ($i % 2 == 0) ? "Booking" : "Payment"; ?></td>
                                                <td>Customer <?php echo $i; ?></td>
                                                <td>Project <?php echo ($i % 2 == 0) ? "A" : "B"; ?></td>
                                                <td>₹<?php echo rand(5000, 50000); ?></td>
                                                <td>2025-03-<?php echo sprintf("%02d", $i); ?></td>
                                                <td><?php echo ($i % 2 == 0) ? "Pending" : "Completed"; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary"><i class="bi bi-eye"></i> View</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="pt-4">10 Records showing from Total 50 Records</p>
                                    </div>
                                    <div class="col-md-6 pt-3 text-right">
                                        <nav aria-label="Page navigation" class="pull-right">
                                            <ul class="pagination" id="pagination"></ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>

                            <!-- Calendar View -->
                            <div id="calendarView" style="display: none;">
                                <h4 class="bg-dark text-white p-2 mb-3"><i class="bi bi-calendar"></i> Calendar View</h4>
                                <table class="calendar">
                                    <thead>
                                        <tr>
                                            <th>Sun</th>
                                            <th>Mon</th>
                                            <th>Tue</th>
                                            <th>Wed</th>
                                            <th>Thu</th>
                                            <th>Fri</th>
                                            <th>Sat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3<br>
                                                <div class="event">Booking: ₹10,000</div>
                                            </td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td>9</td>
                                            <td>10<br>
                                                <div class="event">Payment: ₹15,000</div>
                                            </td>
                                            <td>11</td>
                                            <td>12</td>
                                            <td>13</td>
                                            <td>14</td>
                                        </tr>
                                        <tr>
                                            <td>15</td>
                                            <td>16</td>
                                            <td>17</td>
                                            <td>18</td>
                                            <td>19</td>
                                            <td>20</td>
                                            <td>21</td>
                                        </tr>
                                        <tr>
                                            <td>22</td>
                                            <td>23</td>
                                            <td>24</td>
                                            <td>25</td>
                                            <td>26</td>
                                            <td>27</td>
                                            <td>28</td>
                                        </tr>
                                        <tr>
                                            <td>29</td>
                                            <td>30</td>
                                            <td>31</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
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