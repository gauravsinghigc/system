<?php
if (CONTROL_NOTIFICATION == "true") { ?>
  <?php if (isset($_SESSION['ALERT_TYPE']) && isset($_SESSION['ALERT_MSG'])) { ?>
    <div id="HideGsiAlertWindow">
      <div class="gsi-solution-alerts">
        <div class="notification-box">
          <?php if (CONTROL_NOTIFICATION_SOUND == "true") { ?>
            <audio controls autoplay hidden="">
              <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/<?php echo $_SESSION['ALERT_TYPE']; ?>.mp3" type="audio/ogg">
              <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/<?php echo $_SESSION['ALERT_TYPE']; ?>.mp3" type="audio/ogg">
            </audio>
          <?php } ?>
          <h4 class="bg-<?php echo $_SESSION['ALERT_TYPE']; ?> p-2 h5 text-white" onclick="HideMsgNote()"><i class="fa fa-check-circle"></i> Notifications!
            <i class="fa fa-times"></i>
          </h4>
          <p class="mb-0">
            <span class="font-14">
              <?php echo $_SESSION['ALERT_MSG']; ?>
            </span>
            <br><br>
          </p>
        </div>
      </div>
    </div>
    <script>
      function HideMsgNote() {
        document.getElementById("HideGsiAlertWindow").style.display = "none";
      }
      setTimeout(HideMsgNote, <?php echo CONTROL_MSG_DISPLAY_TIME; ?>);
    </script>
<?php
    unset($_SESSION['ALERT_TYPE']);
    unset($_SESSION['ALERT_MSG']);
  }
} ?>