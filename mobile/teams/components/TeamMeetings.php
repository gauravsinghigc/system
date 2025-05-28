<div class="card">
    <div class="card-body">
        <div class="row pt-4">
            <div class="col-md-12">
                <h4 class="app-sub-heading">All Site Visit History</h4>
            </div>
        </div>
        <?php $LeadsSiteVisitSQL = "SELECT * FROM leads_site_visits where leads_site_visit_handled_by='$SelectedUserId'"; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row mb-4">
                    <div class="col-6 mb-2">
                        <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                            <strong class="text-primary">All Site Visits</strong><br>
                            <span class="display-6 text-primary fw-bold">
                                <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                            <strong class="text-info">Scheduled Site Visits</strong><br>
                            <span class="display-6 text-info fw-bold">
                                <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                            <strong class="text-success">Completed Site Visits</strong><br>
                            <span class="display-6 text-success fw-bold">
                                <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                            </span>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="widget text-center p-3 bg-white border rounded shadow-sm">
                            <strong class="text-danger">Cancelled Site Visits</strong><br>
                            <span class="display-6 text-danger fw-bold">
                                <?php echo TOTAL($LeadsSiteVisitSQL); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <ul class="timeline list-unstyled position-relative" style="max-height: 50rem; overflow-y: auto;">
                    <?php
                    $AllSiteVisits = SET_SQL($LeadsSiteVisitSQL . " ORDER BY leads_site_visit_id ASC", true);
                    if ($AllSiteVisits != null) {
                        foreach ($AllSiteVisits as $SiteVisits) { ?>
                            <li class="timeline-item mb-4 position-relative">
                                <div class="d-flex align-items-start">
                                    <!-- Milestone Point (Date and Time) -->
                                    <div class="flex-shrink-0 me-3 text-center">
                                        <span class="badge rounded-pill bg-primary text-white"><?php echo DATE_FORMATES("d M, Y", $SiteVisits->leads_site_visit_added_on); ?></span><br>
                                        <small class="text-muted"><?php echo DATE_FORMATES("h:i A", $SiteVisits->leads_site_visit_added_on); ?></small>
                                        <div class="timeline-point bg-primary rounded-circle position-absolute" style="width: 10px; height: 10px; top: 10px; left: 1px;"></div>
                                    </div>
                                    <!-- Timeline Content -->
                                    <div class="timeline-content p-3 bg-white rounded shadow-sm flex-grow-1 border-start border-primary">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <strong class="text-primary m-1"><?php echo UpperCase(FETCH("SELECT projects_name FROM projects where projects_id='" . $SiteVisits->leads_site_visits_projects_id . "'", "projects_name")); ?></strong>
                                        </div>
                                        <div class="mt-2">
                                            <span class="detail-title fw-bold">Scheduled For :</span>
                                            <?php echo DATE_FORMATES("d M, y", $SiteVisits->leads_site_visit_schedule_date); ?>
                                            <br>
                                            <span class="detail-title fw-bold">By:</span>
                                            (UID<?php echo $SiteVisits->leads_site_visit_handled_by; ?>)-
                                            <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $SiteVisits->leads_site_visit_handled_by . "'", "UserFullName"); ?>
                                            <br>
                                            <span class="detail-title fw-bold">Reminder Note:</span>
                                            <?php echo SECURE($SiteVisits->leads_site_visit_notes, "d"); ?>
                                            <br>
                                            <?php
                                            $SiteVisitImages = SET_SQL("SELECT * FROM leads_site_visits_attachements where leads_activity_main_id='" . $SiteVisits->leads_site_visit_id . "'", true);
                                            if ($SiteVisitImages != null) {
                                                foreach ($SiteVisitImages as $SiteVisitImage) {
                                            ?>
                                                    <a href="<?php echo STORAGE_URL; ?>/leads/site-visits/<?php echo $LeadsId . "/" . $SiteVisitImage->leads_activity_attached_file; ?>" target="_blank">
                                                        <img src="<?php echo STORAGE_URL; ?>/leads/site-visits/<?php echo $LeadsId . "/" . $SiteVisitImage->leads_activity_attached_file; ?>" style="width:100px;height:100px;">
                                                    </a>
                                            <?php
                                                }
                                            } ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php }
                    } else { ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation"></i>
                            No Site Visit Found!
                        </div>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>