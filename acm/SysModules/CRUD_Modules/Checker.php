<?php
//Check function
/**
 * @SQL : database query for execution
 * @die : for diing the query
 * @PrintSQL : print sql without dieing
 */

function CHECK($SQL = null, $die = false, $PrintSQL = false)
{
    $Check = "$SQL";

    // die entry
    if ($die === true) {
        die($Check);
    }

    // print sql
    if ($PrintSQL === true) {
        echo "<br><hr><code>$SQL</code><hr><br>";
    }

    // check query
    if ($SQL !== null) {
        $stmt = SQL($SQL); // using your PDO-based SQL()

        if ($stmt && $stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
