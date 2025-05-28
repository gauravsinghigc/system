<?php
// Count Data using PDO
function TOTAL($SQL = null, $die = null, $PrintSQL = false)
{
  $SQL = "$SQL";

  if ($die === true) {
    die($SQL);
  }

  // Print SQL if enabled
  if ($PrintSQL === true) {
    echo "<br><hr><code>$SQL</code><hr><br>";
  }

  if ($SQL !== null) {
    try {
      $pdo = DBConnection; // Assuming DBConnection is your PDO instance
      $stmt = $pdo->query($SQL);
      $Count = $stmt->rowCount();

      return ($Count > 0) ? $Count : 0;
    } catch (PDOException $e) {
      return 0;
    }
  }

  return 0;
}
