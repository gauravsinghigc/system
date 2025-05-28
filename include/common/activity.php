<div class="data-display bg-light">
    <div class="flex-s-b w-100">
        <form action="" class="text-center">
            <label class="btn btn-xs btn-default"><input type="radio" name="Activity" value="Yesterday">Yesterday <span class="count2">
                    <?php
                    if (AuthAppUser("UserType") == "Admin") {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, company_users  where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and Date(lead_followups.LeadFollowUpCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } else {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, company_users  where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and lead_followups.LeadFollowUpHandleBy='" . AuthAppUser('UserId') . "' and Date(lead_followups.LeadFollowUpCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } ?>
                </span></label>
            <label class="btn btn-xs btn-default"><input type="radio" checked name="Activity" value="Today">Today <span class="count2">
                    <?php
                    if (AuthAppUser("UserType") == "Admin") {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, company_users  where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and Date(lead_followups.LeadFollowUpCreatedAt)='" . CURRENT_DATE . "' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } else {
                        echo TOTAL("SELECT LeadFollowUpId FROM lead_followups, company_users  where company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy and company_users.company_main_id='$companyID' and lead_followups.LeadFollowUpHandleBy='" . AuthAppUser('UserId') . "' and Date(lead_followups.LeadFollowUpCreatedAt)='" . CURRENT_DATE . "' ORDER BY lead_followups.LeadFollowUpId DESC");
                    } ?>
                </span></label>
            <span class="btn btn-xs btn-default" onclick="Databar('date3')"><i class="fa fa-calendar"></i> Custom</span>
        </form>
    </div>
    <div class="hidden mt-1 " id="date3">
        <input type="date" id="Activitydate" value="" name="FollowupDate" class="form-control">
    </div>
    <ul class="calling-list" id="activity-list">
    </ul>
</div>
<script>
    $(document).ready(function() {
        function sendData(value, name) {
            $.ajax({
                url: "<?php echo DOMAIN . "/include/common/AllAjax/ActivityAjax.php"; ?>",
                method: 'POST',
                data: {
                    name: name,
                    value: value
                },
                success: function(data) {
                    $("#activity-list").html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr, status, error);
                }
            });
        }
        sendData("Today", "Today");
        $('input[type=radio][name=Activity]').change(function() {
            var selectedValue = $('input[type=radio][name=Activity]:checked').val();
            sendData(selectedValue, selectedValue);
        });

        $('#Activitydate').change(function() {
            $('input[type=radio][name=Activity]').prop('checked', false);
            var customDate = $('#Activitydate').val();
            sendData(customDate, "customDate");
        });
    });
</script>