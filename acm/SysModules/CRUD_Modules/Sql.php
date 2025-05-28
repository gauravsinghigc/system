<?php

function SQL($SQL = null, $die = false, $PrintSQL = false)
{
    if ($SQL !== null) {
        // die entry
        if ($die === true) {
            die($SQL);
        }

        // print sql
        if ($PrintSQL === true) {
            echo "<br><hr><code>$SQL</code><hr><br>";
        }

        try {
            // Use the PDO connection constant you defined earlier
            $pdo = DBConnection; // PDO instance

            $stmt = $pdo->query($SQL);

            if ($stmt !== false) {
                return $stmt; // Returns PDOStatement object
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Optional: Log or echo error
            // echo "SQL Error: " . $e->getMessage();
            return false;
        }
    }

    return false;
}
