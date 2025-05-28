<?php include __DIR__ . "/../include/InstantAlerts.php"; ?>

<!-- Vendor JS Files -->
<script src="<?php echo ASSETS_URL; ?>/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ASSETS_URL; ?>/vendor/quill/quill.js"></script>
<script src="<?php echo ASSETS_URL; ?>/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?php echo ASSETS_URL; ?>/vendor/tinymce/tinymce.min.js"></script>

<!-- Template Main JS File -->
<script src="<?php echo ASSETS_URL; ?>/js/main.js"></script>
<script src="<?php echo ASSETS_URL; ?>/js/app.js"></script>

<script defer src="https://static.cloudflareinsights.com/beacon.min.js"></script>

<script>
    function updateTime() {
        let now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let seconds = now.getSeconds();
        let ampm = hours >= 12 ? "PM" : "AM";

        // Convert to 12-hour format with leading zero
        hours = hours % 12 || 12;
        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        let timeString = `${hours}:${minutes}:${seconds} ${ampm}`;
        document.getElementById("liveTime").innerHTML = timeString;
    }

    // Run updateTime immediately and every second
    updateTime();
    setInterval(updateTime, 1000);
</script>