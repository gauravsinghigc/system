<?php
// Suggestion List using PDO
function SUGGEST($table = false, $column = "", $order = "ASC", $enc = null)
{
   if ($table != false && $column != "") {
      $CHECK_project_tags = CHECK("SELECT $column FROM $table");
      if ($CHECK_project_tags != 0) {
         echo "<datalist id='$column'>";

         $SQL_project_tags = SQL("SELECT $column FROM $table GROUP BY $column ORDER BY $column $order");

         while ($FetchTags = $SQL_project_tags->fetch(PDO::FETCH_ASSOC)) {
            $value = $FetchTags[$column];
            if ($enc == null) {
               echo "<option value='" . htmlspecialchars($value) . "'>";
            } else {
               echo "<option value='" . SECURE($value, $enc) . "'></option>";
            }
         }

         echo "</datalist>";
      }
   }
}
