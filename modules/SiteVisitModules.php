<?php
function SiteVisitStatus($StatusValue, $return = "tag")
{
    if ($return == "tag") {
        if ($StatusValue == 1) {
            $Return = "<span class='btn btn-xs tag-warning text-white'><i class='fa fa-clock'></i> SCHEDULED</span>";
        } elseif ($StatusValue == 2) {
            $Return = "<span class='btn btn-xs tag-success text-white'><i class='fa fa-check-circle'></i> COMPLETED</span>";
        } elseif ($StatusValue == 3) {
            $Return = "<span class='btn btn-xs tag-danger text-white'><i class='fa fa-times'></i> CANCELLED</span>";
        } else {
            $Return = "<span class='btn btn-xs tag-dark text-white'><i class='fa fa-warning'></i> MISSED</span>";
        }
    } else {
        return $StatusValue == 1 ? "Scheduled" : ($StatusValue == 2 ? "Completed" : ($StatusValue == 3 ? "Cancelled" : "Missed"));
    }

    return $Return;
}
