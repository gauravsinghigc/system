<?php
$Dir = "../../..";
require_once $Dir . '/acm/SysFileAutoLoader.php';
require_once $Dir . '/handler/AuthController/AuthAccessController.php';
$Missed = $_POST['value'];
$companyID = CompanyId;
$TDate = date("Y-m-d");
$name = $_POST['name'];

if (isset($_POST['value']) && isset($_POST['name'])) {
    if ($_POST['name'] == "Yesterday") {
        if (AuthAppUser("UserType") == "Admin") {
            $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowMainId, LeadFollowUpUpdatedAt, LeadFollowStatus, LeadFollowUpDate 
                                             FROM lead_followups, company_users  
                                             WHERE company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy 
                                             AND company_users.company_main_id='$companyID' 
                                             AND Date(lead_followups.LeadFollowUpCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'  
                                             ORDER BY LeadFollowUpId DESC LIMIT 50", true);
        } else {
            $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowMainId, LeadFollowUpUpdatedAt, LeadFollowStatus, LeadFollowUpDate 
                                             FROM lead_followups, company_users  
                                             WHERE company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy 
                                             AND company_users.company_main_id='$companyID' 
                                             AND lead_followups.LeadFollowUpHandleBy='" . AuthAppUser('UserId') . "' 
                                             AND Date(lead_followups.LeadFollowUpCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'  
                                             ORDER BY LeadFollowUpId DESC 
                                             LIMIT 50", true); // Add the LIMIT clause with a number indicating the maximum number of rows to return
        }
    } elseif ($_POST['name'] == "customDate") {
        if (AuthAppUser("UserType") == "Admin") {
            $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowMainId, LeadFollowUpUpdatedAt, LeadFollowStatus, LeadFollowUpDate 
                                             FROM lead_followups, company_users  
                                             WHERE company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy 
                                             AND company_users.company_main_id='$companyID' 
                                             AND Date(lead_followups.LeadFollowUpCreatedAt)='$Missed'  
                                             ORDER BY LeadFollowUpId DESC LIMIT 50", true);
        } else {
            $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowMainId, LeadFollowUpUpdatedAt, LeadFollowStatus, LeadFollowUpDate 
                                             FROM lead_followups, company_users  
                                             WHERE company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy 
                                             AND company_users.company_main_id='$companyID' 
                                             AND lead_followups.LeadFollowUpHandleBy='" . AuthAppUser('UserId') . "' 
                                             AND Date(lead_followups.LeadFollowUpCreatedAt)='$Missed'  
                                             ORDER BY LeadFollowUpId DESC 
                                             LIMIT 50", true); // Add the LIMIT clause with a number indicating the maximum number of rows to return
        }
    } else {
        if (AuthAppUser("UserType") == "Admin") {
            $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowMainId, LeadFollowUpUpdatedAt, LeadFollowStatus, LeadFollowUpDate 
                                             FROM lead_followups, company_users  
                                             WHERE company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy 
                                             AND company_users.company_main_id='$companyID' 
                                             AND Date(lead_followups.LeadFollowUpCreatedAt)='" . CURRENT_DATE . "'  
                                             ORDER BY LeadFollowUpId DESC LIMIT 50", true);
        } else {
            $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowMainId, LeadFollowUpUpdatedAt, LeadFollowStatus, LeadFollowUpDate 
                                             FROM lead_followups, company_users  
                                             WHERE company_users.company_alloted_user_id=lead_followups.LeadFollowUpHandleBy 
                                             AND company_users.company_main_id='$companyID' 
                                             AND lead_followups.LeadFollowUpHandleBy='" . AuthAppUser('UserId') . "' 
                                             AND Date(lead_followups.LeadFollowUpCreatedAt)='" . CURRENT_DATE . "'  
                                             ORDER BY LeadFollowUpId DESC 
                                             LIMIT 50", true); // Add the LIMIT clause with a number indicating the maximum number of rows to return
        }
    }
}
if ($fetclFollowUps != null) {
    foreach ($fetclFollowUps as $F) {
?>
        <li>
            <span class='text-center bg-light text-black rounded shadow-sm'>
                <span class=''>
                    <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt) == "NA") { ?>
                        <span class='h5'>No Call</span><br>
                    <?php } else { ?>
                        <span class="p-t-3 text-black">
                            <span class='h4 text-success'><i class='fa fa-phone'></i></span><br>
                            <span class='small'>Called at </span><br>
                            <span class='h5'> <?php echo DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt); ?></span><br>
                            <span> <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpUpdatedAt); ?></span><br>
                        </span>
                    <?php } ?>
                </span>
            </span>
            <p style='line-height:0.9rem !important;margin-top:0.5rem !important;'>
                <a href="<?php echo DOMAIN; ?>/app/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>&alert=true">
                    <span>
                        <?php
                        $MainLeadType = FETCH("SELECT LeadType FROM leads WHERE Leadsid='" . $F->LeadFollowMainId . "'", "LeadType");
                        if ($MainLeadType == "LEAD") {
                            $RecordTypeClass = "btn-success";
                            $Star = "<i class='fa fa-star fa-spin'></i>";
                        } else {
                            $RecordTypeClass = "btn-default";
                            $Star = "";
                        }
                        ?>
                        <span class="pull-right btn btn-xs <?php echo $RecordTypeClass; ?> fs-10 w-auto" style="font-weight:bold !important;padding:0.2rem !important;margin-top:-0.7rem;">
                            <?php echo $Star . " " . FETCH("SELECT LeadType FROM leads WHERE Leadsid='" . $F->LeadFollowMainId . "'", "LeadType"); ?>
                        </span>
                        <span style="font-size:1.1rem !important;font-weight:600 !important;">
                            <?php echo FETCH("SELECT LeadSalutations FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations"); ?>
                            <?php echo FETCH("SELECT LeadPersonFullname FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?><br>
                            <span style="font-size:0.75rem !important;font-weight:500 !important;" class='text-dark bold'>
                                <i class='fa fa-phone-square text-primary'></i> <?php echo FETCH("SELECT LeadPersonPhoneNumber FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber"); ?>
                            </span><br>
                            <span style="font-size:0.75rem !important;font-weight:500 !important;">
                                <i class='fa fa-hashtag text-primary'></i> <?php
                                                                            $Requirement = FETCH("SELECT ProjectName FROM projects where ProjectsId='" . FETCH("SELECT LeadRequirementDetails FROM lead_requirements WHERE LeadMainId='" . $F->LeadFollowMainId . "'", "LeadRequirementDetails") . "'", "ProjectName");
                                                                            if ($Requirement == null) {
                                                                                echo "<span class='text-secondary'>No Project Selected!</span>";
                                                                            } else {
                                                                                echo $Requirement;
                                                                            } ?>
                            </span>
                        </span><br>
                        <span class='text-danger bold fs-11'>
                            <span class='pull-left w-50' style="padding-top:0px !important;">
                                <i class='fa fa-refresh text-primary'></i> <?php echo UpperCase($F->LeadFollowStatus); ?></span>
                            <span class='pull-right w-50 text-right small' style="padding-top:0px !important;">
                                <?php
                                $currentdate = date("Y-m-d");
                                if ($F->LeadFollowUpTime != null && $F->LeadFollowUpDate == $currentdate) {
                                    echo "<i class='fa fa-clock text-warning'></i>" . GetMinutes($F->LeadFollowUpTime, date("h:i A"));
                                } ?>
                            </span>
                        </span>
                        <br>
                        <i class="fa fa-thumbs-up text-primary"></i>
                        <?php if ($F->LeadFollowCurrentStatus == "Follow Up" or $F->LeadFollowCurrentStatus == "follow Up" || $F->LeadFollowCurrentStatus == "FollowUp" || $F->LeadFollowCurrentStatus == "FOLLOW-UP") { ?>
                            <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                                <span class='fs-11 text-grey'>
                                    <?php echo UpperCase($F->LeadFollowCurrentStatus); ?> @
                                    <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?>
                                        <?php echo $F->LeadFollowUpTime; ?>
                                    </span>
                                </span>
                            <?php } ?>
                            <span class="text-grey">
                            <?php } else { ?>
                                <span class="text-grey"><?php echo UpperCase($F->LeadFollowStatus); ?>
                                <?php } ?>
                                </span>
                            </span><br>
                            <span style="font-size:0.85rem;">
                                <span class="text-black fs-13"><i class='fa fa-edit text-primary'></i> <?php echo LimitText($F->LeadFollowUpDescriptions, 0, 130); ?></span>
                                <br>
                                <i style="font-size:0.55rem;" class='text-primary pull-right shadow-sm rounded p-1 pl-1 pr-2'>
                                    <i class='fa fa-user shadow-sm p-1 rounded'></i> By <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?>
                                    - (UI<?php echo $F->LeadFollowUpHandleBy; ?>)
                                </i>
                            </span>
                    </span>
                </a>
            </p>
        </li>
<?php
    }
} else {
    echo NoData("No Activity Found!!!");
}
?>