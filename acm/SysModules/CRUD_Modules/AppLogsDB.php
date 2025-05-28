<?php
// Generate Log file for the project using PDO
function GENERATE_APP_LOGS($TITLE, $ACTION, $logtype, $UserId = LOGIN_USER_ID)
{
    $PDO = DBConnection; //Your global PDO connection

    $TITLE = strtoupper($TITLE);

    // Convert array ACTION to string key=value, ...
    if (is_array($ACTION)) {
        $ArrayValues = "";
        foreach ($ACTION as $key => $value) {
            $ArrayValues .= "$key=$value, ";
        }
        $ACTION = rtrim($ArrayValues, ", ");
    }

    if (defined('CONTROL_APP_LOGS') && CONTROL_APP_LOGS === "true") {
        $logTitle = $TITLE;
        $logdesc = SECURE($ACTION, "e");  // Assuming SECURE function still applies
        $systeminfo = SYSTEM_INFO;
        $logenv = CONTROL_WORK_ENV;
        $logbyUserId = $UserId;
        $created_at = CURRENT_DATE_TIME;

        $sql = "INSERT INTO systemlogs (logTitle, logdesc, created_at, systeminfo, logtype, logenv, logbyUserId) 
                VALUES (:logTitle, :logdesc, :created_at, :systeminfo, :logtype, :logenv, :logbyUserId)";

        try {
            $stmt = $PDO->prepare($sql);
            $stmt->execute([
                ':logTitle' => $logTitle,
                ':logdesc' => $logdesc,
                ':created_at' => $created_at,
                ':systeminfo' => $systeminfo,
                ':logtype' => $logtype,
                ':logenv' => $logenv,
                ':logbyUserId' => $logbyUserId
            ]);
        } catch (PDOException $e) {
            // Optionally log error or handle it as needed
            echo "Log Insert Error: " . $e->getMessage();
        }
    }
}
