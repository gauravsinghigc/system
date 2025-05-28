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
        // Show/Hide Add Reminder Popup
        function toggleAddReminderPopup() {
            let popup = document.getElementById("addReminderPopup");
            popup.style.display = popup.style.display === "block" ? "none" : "block";
        }

        // Show/Hide Send Mail Popup
        function toggleSendMailPopup() {
            let popup = document.getElementById("sendMailPopup");
            popup.style.display = popup.style.display === "block" ? "none" : "block";
        }

        // Toggle between List and Calendar Views
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
    </script>
    <style>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            background-color: #007bff;
            color: white;
        }

        .button-group {
            margin-bottom: 15px;
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
            background-color: #007bff;
            color: white;
        }

        .calendar td {
            height: 100px;
            vertical-align: top;
        }

        .calendar .event {
            background-color: #f8d7da;
            border-radius: 3px;
            padding: 2px 5px;
            margin: 2px 0;
            font-size: 12px;
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
                    <h1><i class="bi bi-envelope text-danger bold"></i> Email and Reminders</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo DOMAIN; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Email and Reminders</li>
                        </ol>
                    </nav>
                </div>
                <div class="button-group">
                    <button class="btn btn-md btn-danger" onclick="toggleAddReminderPopup()"><i class="bi bi-bell"></i> Add Reminder</button>
                    <button class="btn btn-md btn-primary" onclick="toggleSendMailPopup()"><i class="bi bi-send"></i> Send Mail</button>
                    <button class="btn btn-md btn-outline-secondary" onclick="toggleView('list')"><i class="bi bi-list"></i> List View</button>
                    <button class="btn btn-md btn-outline-secondary" onclick="toggleView('calendar')"><i class="bi bi-calendar"></i> Calendar View</button>
                </div>
            </div>
        </div><!-- End Page Title -->

        <!-- Add Reminder Popup -->
        <div class="popup" id="addReminderPopup">
            <h5>Add New Reminder</h5>
            <button class="btn-close" onclick="toggleAddReminderPopup()"></button>
            <form>
                <div class="mb-3">
                    <label for="reminderTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="reminderTitle" placeholder="Enter Reminder Title" required>
                </div>
                <div class="mb-3">
                    <label for="reminderDate" class="form-label">Date & Time</label>
                    <input type="datetime-local" class="form-control" id="reminderDate" required>
                </div>
                <div class="mb-3">
                    <label for="reminderDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="reminderDescription" rows="3" placeholder="Enter Description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="reminderUser" class="form-label">Assign To</label>
                    <select class="form-select" id="reminderUser" required>
                        <option value="">Select User</option>
                        <option value="user1">User 1</option>
                        <option value="user2">User 2</option>
                        <option value="user3">User 3</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-check-circle"></i> Set Reminder</button>
            </form>
        </div>

        <!-- Send Mail Popup -->
        <div class="popup" id="sendMailPopup">
            <h5>Send Email</h5>
            <button class="btn-close" onclick="toggleSendMailPopup()"></button>
            <form>
                <div class="mb-3">
                    <label for="mailTo" class="form-label">To</label>
                    <input type="email" class="form-control" id="mailTo" placeholder="Enter Recipient Email" required>
                </div>
                <div class="mb-3">
                    <label for="mailSubject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="mailSubject" placeholder="Enter Subject" required>
                </div>
                <div class="mb-3">
                    <label for="mailBody" class="form-label">Message</label>
                    <textarea class="form-control" id="mailBody" rows="5" placeholder="Enter Email Content" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-send"></i> Send Email</button>
            </form>
        </div>

        <section class="section profile">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card br-1">
                        <div class="card-body pt-3">
                            <!-- List View -->
                            <div id="listView" style="display: block;">
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h4><i class="bi bi-list-ul text-primary"></i> Email and Reminder Logs</h4>
                                        <table class="table table-striped" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>SNo.</th>
                                                    <th>Type</th>
                                                    <th>Title/Subject</th>
                                                    <th>Recipient/Assigned To</th>
                                                    <th>Date & Time</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i = 1; $i <= 10; $i++) { ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo ($i % 2 == 0) ? "Reminder" : "Email"; ?></td>
                                                        <td><?php echo ($i % 2 == 0) ? "Meeting Reminder" : "Project Update"; ?></td>
                                                        <td><?php echo "User " . ($i % 3 + 1); ?></td>
                                                        <td>2025-03-<?php echo sprintf("%02d", $i); ?> 10:00</td>
                                                        <td><?php echo ($i % 2 == 0) ? "Pending" : "Sent"; ?></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> View</button>
                                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="pt-4">10 Records showing from Total 50 Records</p>
                                    </div>
                                    <div class="col-md-6 pt-3 text-right justify-content-end align-content-end">
                                        <!-- Pagination can be added here if needed -->
                                    </div>
                                </div>
                            </div>

                            <!-- Calendar View -->
                            <div id="calendarView" style="display: none;">
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h4><i class="bi bi-calendar text-primary"></i> Calendar View</h4>
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
                                                        <div class="event">Meeting Reminder</div>
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
                                                        <div class="event">Project Update Email</div>
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