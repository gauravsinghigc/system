<div class="card">
    <div class="card-body">
        <div class="row pt-4">
            <div class="col-md-12">
                <h4 class="app-sub-heading">Login Logs</h4>
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>LogsID</th>
                                <th>DateTime</th>
                                <th>ActivityName</th>
                                <th>LogType</th>
                                <th>EnvMode</th>
                                <th>LogDesc</th>
                                <th>MoreDetails</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $AllLoginsLogs = SET_SQL("SELECT * FROM systemlogs WHERE logbyUserId='$SelectedUserId' ORDER BY DATE(created_at) DESC", true);
                            if ($AllLoginsLogs != null) {
                                foreach ($AllLoginsLogs as $Log) { ?>
                                    <tr>
                                        <td><?php echo $Log->LogsId; ?></td>
                                        <td><?php echo date("d-M-Y H:i:s", strtotime($Log->created_at)); ?></td>
                                        <td><?php echo $Log->logTitle; ?></td>
                                        <td><?php echo $Log->logtype; ?></td>
                                        <td><?php echo $Log->logenv; ?></td>
                                        <td><?php echo SECURE($Log->logdesc, "d"); ?></td>
                                        <td><?php echo SECURE($Log->systeminfo, "d"); ?></td>

                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>