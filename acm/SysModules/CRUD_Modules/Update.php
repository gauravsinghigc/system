<?php
// Update table using PDO
function UPDATE($sqltables, array $columns, $conditions, $PrintResponses = false)
{
    $PDO = DBConnection; // Use your global PDO connection

    $setParts = [];
    $params = [];
    $countkeys = 0;

    if ($PrintResponses) {
        echo "<br><b style='color:green;'>• REQUESTING </b> -> <b>[$sqltables]</b> ---- <b style='color:green;'>Sent!</b> <br><b style='color:red'><i> Data Received</i></b> <b>[$sqltables]</b> @ [<br>";
    }

    foreach ($columns as $key => $value) {
        $countkeys++;
        $setParts[] = "$key = :$key";
        $params[":$key"] = htmlentities(trim($value));

        if ($PrintResponses) {
            echo "&nbsp;&nbsp; <b style='color:grey;'> Index:</b> $countkeys ( <b>$key</b> : $value ) <br>";
        }
    }

    $setString = implode(", ", $setParts);
    $sql = "UPDATE $sqltables SET $setString WHERE $conditions";

    if ($PrintResponses) {
        echo "]<br> ---<b style='color:primary;'>END</b><br><hr>---";
        echo "<textarea rows='4' style='width:100%;margin-top:0.5rem;'>$sql</textarea><br><br>";
    }

    try {
        $stmt = $PDO->prepare($sql);
        $update = $stmt->execute($params);

        return $update ? true : false;
    } catch (PDOException $e) {
        if ($PrintResponses) {
            echo "<b style='color:red;'>Error:</b> " . $e->getMessage();
        }
        return false;
    }
}
