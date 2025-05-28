<?php
function INSERT($tablename = null, array $RequestedData = [], $PrintResults = false)
{
    if ($tablename != null && !empty($RequestedData)) {
        $columns = array_keys($RequestedData);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);
        $bindData = [];

        if ($PrintResults) {
            echo "<br><b style='color:green;'>• REQUESTING </b> -> <b>[$tablename]</b> ---- <b style='color:green;'>Sent!</b> <br><b style='color:red'><i> Data Received</i></b> <b>[$tablename]</b> @ [<br>";
        }

        $i = 0;
        foreach ($RequestedData as $key => $value) {
            $htmlValue = htmlentities($value);
            $bindData[":$key"] = $htmlValue;

            if ($PrintResults) {
                echo "&nbsp;&nbsp; <b style='color:grey;'> Index:</b> " . ($i + 1) . " ( <b> " . $key . "</b> : " . $htmlValue . " ) <br>";
            }

            $i++;
        }

        if ($PrintResults) {
            echo "]<br> ---<b style='color:primary;'>END</b><br><br>
            <B>---GENERATED SQL:---</B><br>";
        }

        $sql = "INSERT INTO $tablename (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";

        if ($PrintResults) {
            print("<textarea rows='4' style='width:100%;margin-top:0.5rem;'>$sql</textarea> <br><br>");
        }

        try {
            $pdo = DBConnection; // Assuming this is your PDO object
            $stmt = $pdo->prepare($sql);
            $success = $stmt->execute($bindData);
            return $success;
        } catch (PDOException $e) {
            return false;
        }
    }

    return false;
}
