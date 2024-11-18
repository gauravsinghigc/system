<?php


//update profile image 
if (isset($_POST['updateprofileimage'])) {
    $UserId  = $_POST['updateprofileimage'];
    $UserProfileImage = UPLOAD_FILES("../storage/users/$UserId/img", "null", "Profile_Photo_" . "_UID_" . $UserId, "UserProfileImage");
    $Update = UPDATE_SQL("UPDATE users SET UserProfileImage='$UserProfileImage' where UserId='$UserId'");
    RESPONSE($Update, "Profile Image Updated!", "Unable to update profile image!");

    //remove employee
} else if (isset($_GET['remove_team_member'])) {
    $access_url = SECURE($_GET['access_url'], "d");
    $remove_team_member = SECURE($_GET['remove_team_member'], "d");

    if ($remove_team_member == true) {
        $control_id = SECURE($_GET['control_id'], "d");
        $delete = DELETE_FROM("users", "UserId='$control_id'");
    } else {
        $delete = false;
    }

    RESPONSE($delete, "Team member is removed successfully!", "Unable to remove team member!");
}
