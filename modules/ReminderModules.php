<?php
function ReminderStatus($StatusValue, $return = "tag")
{
    if ($return == "tag") {
        if ($StatusValue == 0) {
            $Return = "<span class='btn btn-sm tag-warning text-white'><i class='fa fa-clock'></i> ACTIVE</span>";
        } elseif ($StatusValue == 1) {
            $Return = "<span class='btn btn-sm tag-success text-white'><i class='fa fa-check-circle'></i> COMPLETED</span>";
        } elseif ($StatusValue == 2) {
            $Return = "<span class='btn btn-sm tag-danger text-white'><i class='fa fa-times'></i> DROPPED</span>";
        } else {
            $Return = "<span class='btn btn-sm tag-dark text-white'><i class='fa fa-warning'></i> MISSED</span>";
        }
    } else {
        return $StatusValue == 0 ? "ACTIVE" : ($StatusValue == 1 ? "COMPLETED" : ($StatusValue == 2 ? "DROPPED" : "MISSED"));
    }

    return $Return;
}
