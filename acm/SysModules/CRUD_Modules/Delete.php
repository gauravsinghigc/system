<?php
// delete using PDO
function DELETE_FROM($table = null, $conditions = "", $die = false)
{
  if ($table !== null && !empty($conditions)) {
    $sql = "DELETE FROM $table WHERE $conditions";

    // If die is true, show query and exit
    if ($die === true) {
      die($sql);
    }

    try {
      $pdo = DBConnection; // Assumes DBConnection is your PDO instance
      $stmt = $pdo->prepare($sql);
      $result = $stmt->execute();

      return $result; // true or false
    } catch (PDOException $e) {
      return false;
    }
  }

  return false;
}
