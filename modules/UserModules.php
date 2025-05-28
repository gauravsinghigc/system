<?php

//user details
function UserDetails($UserId)
{
  $AllUsers = SET_SQL("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $UserId . "' ORDER BY UserFullName ASC", true);
  if ($AllUsers == null) {
    NoData("No Users found!");
  } else {
    foreach ($AllUsers as $User) {
?>
      <p>
        <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
        <span class="text-gray small">
          <span><?php echo $User->UserPhoneNumber; ?></span><br>
          <span><?php echo $User->UserEmailId; ?></span><br>
        </span>
      </p>
<?php
    }
  }
}
//user image
function GetUserImage($UserId, $default = false)
{
  $UserProfileImage = FETCH("SELECT UserProfileImage FROM users where UserId='$UserId'", "UserProfileImage");
  if ($UserProfileImage == "default.png") {
    $UserProfileImg = STORAGE_URL_D . "/default.png";
  } else {
    $FilePath = DOMAIN . "/storage/users/" . $UserId . "/img/" . $UserProfileImage;
    if (file_exists($FilePath)) {
      $UserProfileImg = STORAGE_URL_U . "/" . $UserId . "/img/" . $UserProfileImage;
    } else {
      // UPDATE("UPDATE users SET UserProfileImage='default.png' where UserId='$UserId'");
      $UserProfileImage = FETCH("SELECT UserProfileImage FROM users where UserId='$UserId'", "UserProfileImage");
      $UserProfileImg = STORAGE_URL_U . "/" . $UserId . "/img/" . $UserProfileImage;
    }
  }

  //load default image
  if ($default == true) {
    $UserProfileImg = APP_LOGO;
  }

  //return results
  return $UserProfileImg;
}

//app users
function GetUserRecords($UserId, $require)
{
  if (empty($UserId)) {
    return null;
  } else {
    $CheckUsers = CHECK("SELECT $require FROM users where UserId='$UserId'");
    if ($CheckUsers == null) {
      return null;
    } else {
      $GetData = FETCH("SELECT $require FROM users where UserId='$UserId'", "$require");
      if ($require == "UserProfileImage") {
        if ($GetData == "user.png") {
          return STORAGE_URL_D . "/default.png";
        } else {
          return STORAGE_URL_U . "/$UserId/img/$GetData";
        }
      } else {
        return $GetData;
      }
    }
  }
}

//user social media urls
function UserUrls($UserId, $ReturnValue = null)
{
  if ($UserId == null) {
    return null;
  } else {
    $CheckUser = CHECK("SELECT user_url_id FROM users_urls where user_url_main_user_id='$UserId'");
    if ($CheckUser == null) {
      return null;
    } else {
      $ReturnValue = FETCH("SELECT $ReturnValue FROM users_urls where user_url_main_user_id='$UserId'", "$ReturnValue");
      return $ReturnValue;
    }
  }
}
