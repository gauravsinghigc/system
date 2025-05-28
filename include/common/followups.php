<div class="data-display bg-light">
    <div class="flex-s-b w-100">
        <form action="">
            <label class="btn btn-xs btn-default"><input type="radio" name="missedfollowups" value="Missed">Missed <span class="count2">
                    <?php
                    if (AuthAppUser("UserType") == "Admin") {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)<'$TDate' and  lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } else {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and DATE(LeadFollowUpDate)<'$TDate' and LeadFollowCurrentStatus like '%FOLLOW-UP%'  and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC");
                    } ?>
                </span></label>
            <label class="btn btn-xs btn-default"><input type="radio" checked name="missedfollowups" value="Today">Today <span class="count2">
                    <?php
                    if (AuthAppUser("UserType") == "Admin") {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)='$TDate' and  lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } else {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and DATE(LeadFollowUpDate)='$TDate' and LeadFollowCurrentStatus like '%FOLLOW-UP%'  and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC");
                    } ?>
                </span></label>
            <label class="btn btn-xs btn-default"><input type="radio" name="missedfollowups" value="Tomorrow">Tomorrow <span class="count2">
                    <?php
                    if (AuthAppUser("UserType") == "Admin") {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)='" . date("Y-m-d", strtotime("+1 days")) . "' and  lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } else {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and DATE(LeadFollowUpDate)='" . date("Y-m-d", strtotime("+1 days")) . "' and LeadFollowCurrentStatus like '%FOLLOW-UP%'  and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC");
                    } ?>
                </span></label>
            <span class="btn btn-xs btn-default" onclick="Databar('date1')"><i class="fa fa-calendar"></i> Custom</span>
        </form>
    </div>
    <div class="hidden mt-1 " id="date1">
        <input type="date" id="date" value="" name="FollowupDate" class="form-control">
    </div>
    <ul class="calling-list" id="followup-list">
        <span><i class="fa fa-truck-loading fa-spin"></i></span>
    </ul>
</div>
<a href="<?php echo APP_URL; ?>/leads/?lead_status=FOLLOW-UP" class="btn btn-md btn-primary pull-right mt-3 mb-2">View All Follow Ups <i class='fa fa-angle-right'></i></a>
<script>
    $(document).ready(function() {
        function sendData(value, name) {
            $.ajax({
                url: "<?php echo DOMAIN . "/include/common/AllAjax/FollowupAjax.php"; ?>",
                method: 'POST',
                data: {
                    name: name,
                    value: value
                },
                success: function(data) {
                    $("#followup-list").html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr, status, error);
                }
            });
        }
        sendData("Today", "Today");
        $('input[type=radio][name=missedfollowups]').change(function() {
            var selectedValue = $('input[type=radio][name=missedfollowups]:checked').val();
            sendData(selectedValue, selectedValue);
        });

        $('#date').change(function() {
            $('input[type=radio][name=missedfollowups]').prop('checked', false);
            var customDate = $('#date').val();
            sendData(customDate, "customDate");
        });
    });
</script>