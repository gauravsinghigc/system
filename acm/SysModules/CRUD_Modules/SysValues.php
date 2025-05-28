<?php
// Configuration fetcher using PDO
function CONFIG($Data, $die = false)
{
    $PDO = DBConnection;

    $SELECT_configurations = "SELECT configurationname, configurationvalue FROM configurations WHERE configurationname = :name";

    // Die for debugging
    if ($die == true) {
        die($SELECT_configurations);
    }

    // Prepare and execute query
    $stmt = $PDO->prepare($SELECT_configurations);
    $stmt->execute([':name' => $Data]);
    $Configurations = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$Configurations) {
        $Value = null;

        // Check again with helper (optional if SQL is already executed)
        $Check = CHECK("SELECT configurationvalue FROM configurations WHERE configurationname = '$Data'");
        if ($Check == null) {
            $data = [
                "configurationname" => $Data,
                "configurationvalue" => ""
            ];
            INSERT("configurations", $data); // make sure your INSERT() function is using PDO
        }
    } else {
        $Value = $Configurations['configurationvalue'];
    }

    return $Value ?? null;
}
