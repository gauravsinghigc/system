<div class="data-display bg-light">
    <div class="flex-s-b w-100">
        <form action="">
            <label class="btn btn-xs btn-default"><input type="radio" name="missedmeeting" value="Missed">Missed <span class="count2">
                    <?php
                    if (AuthAppUser("UserType") == "Admin") {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and (LeadFollowStatus like '%MEETING PLANNED%' OR LeadFollowStatus like '%SITE VISIT PLANNED%') and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)<'$TDate' and  lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } else {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and (LeadFollowStatus like '%MEETING PLANNED%' OR LeadFollowStatus like '%SITE VISIT PLANNED%') and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)<'$TDate' and LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } ?>
                </span></label>
            <label class="btn btn-xs btn-default"><input type="radio" checked name="missedmeeting" value="Today">Today <span class="count2">
                    <?php
                    if (AuthAppUser("UserType") == "Admin") {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and (LeadFollowStatus like '%MEETING PLANNED%' OR LeadFollowStatus like '%SITE VISIT PLANNED%') and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)='$TDate' and  lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } else {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and (LeadFollowStatus like '%MEETING PLANNED%' OR LeadFollowStatus like '%SITE VISIT PLANNED%') and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)='$TDate' and LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } ?>
                </span></label>
            <label class="btn btn-xs btn-default"><input type="radio" name="missedmeeting" value="Tomorrow">Tomorrow <span class="count2">
                    <?php
                    if (AuthAppUser("UserType") == "Admin") {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and (LeadFollowStatus like '%MEETING PLANNED%' OR LeadFollowStatus like '%SITE VISIT PLANNED%') and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)='" . date("Y-m-d", strtotime("+1 days")) . "' and  lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } else {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, leads where leads.LeadsId=lead_followups.LeadFollowMainId and (LeadFollowStatus like '%MEETING PLANNED%' OR LeadFollowStatus like '%SITE VISIT PLANNED%') and leads.CompanyID='$companyID' and lead_followups.LeadFollowCurrentStatus like '%FOLLOW-UP%' and DATE( lead_followups.LeadFollowUpDate)='" . date("Y-m-d", strtotime("+1 days")) . "' and LeadFollowUpHandleBy='" . AuthAppUser("UserId") . "' and lead_followups.LeadFollowUpRemindStatus='ACTIVE' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } ?>
                </span></label>
            <span class="btn btn-xs btn-default" onclick="Databar('date2')"><i class="fa fa-calendar"></i> Custom</span>
        </form>
    </div>
    <div class="hidden mt-1 " id="date2">
        <input type="date" id="meetingdate" value="" name="FollowupDate" class="form-control">
    </div>
    <ul class="calling-list" id="meeting-list">
    </ul>
</div>
<a href="<?php echo APP_URL; ?>/leads/?lead_status=meeting" class="btn btn-md btn-primary pull-right mt-3 mb-2">View All Meetings <i class='fa fa-angle-right'></i></a>
<script>
    $(document).ready(function() {
        function sendData(value, name) {
            $.ajax({
                url: "<?php echo DOMAIN . "/include/common/AllAjax/MeetingAjax.php"; ?>",
                method: 'POST',
                data: {
                    name: name,
                    value: value
                },
                success: function(data) {
                    $("#meeting-list").html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr, status, error);
                }
            });
        }
        sendData("Today", "Today");
        $('input[type=radio][name=missedmeeting]').change(function() {
            var selectedValue = $('input[type=radio][name=missedmeeting]:checked').val();
            sendData(selectedValue, selectedValue);
        });

        $('#meetingdate').change(function() {
            $('input[type=radio][name=missedmeeting]').prop('checked', false);
            var customDate = $('#meetingdate').val();
            sendData(customDate, "customDate");
        });
    });
</script>