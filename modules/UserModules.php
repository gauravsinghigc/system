<?php
//function get user details name and id clickable for created by, updated by, assigned by and much more roles
function AttachUserEntity($UserId = null)
{
    if ($UserId != null) {
        $UserSQL = "SELECT UserFullName FROM users where UserId='$UserId'";
        $UserName = FETCH($UserSQL, "UserFullName");
        $UserLink = "<a href='" . APP_URL . "/users/details/?uid=" . SECURE($UserId, "e") . "' class='btn btn-xs btn-light font-italic fs-9'>
        <i class='fa fa-user text-dark'></i> $UserName ($UserId)
        </a>";
        return $UserLink;
    } else {
        return null;
    }
}
