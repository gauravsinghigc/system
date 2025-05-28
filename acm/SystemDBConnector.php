<?php

// DB Configurations
if (CONTROL_DATABASE == true) {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_SERVER_HOST . ";dbname=" . DB_SERVER_DB_NAME . ";charset=utf8mb4",
            DB_SERVER_USER,
            DB_SERVER_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => true // Optional: persistent connection
            ]
        );

        define("DBConnection", $pdo); // Just like your current constant

        $DBStatus = "<i class='fa fa-check-circle text-success'></i> Online";
    } catch (PDOException $e) {
        define("DBConnection", null); // in case needed
        $DBStatus = "<i class='fa fa-warning text-danger'></i> Offline - " . $e->getMessage();
    }
} else {
    $DBStatus = "<i class='fa fa-times text-warning'></i> DB Not Used!";
}


//display Database Status
if (CONTROL_DB_STATUS == true) {
    echo $DBStatus;
}
