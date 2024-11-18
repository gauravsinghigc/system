<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <ul class="main-navigation-bar">
                <?php foreach (NAVIGATION_MENUS as $key => $value) {
                    // CHECK_DIR_AND_CREATE_IF_EMPTY(__DIR__ . "/../../app" . $value['url']);
                ?>
                    <li id='<?php echo $key; ?>' class='RecordsList'>
                        <a href="<?php echo $value['url']; ?>">
                            <i class='fa fa-<?php echo $value['icon']; ?>'></i>
                            <span class='title'>
                                <?php echo $value['title']; ?>
                                <?php
                                if ($value['counts'] != 0) {
                                    echo "<span class='counts'>" . $value['counts'] . "</span>";
                                }
                                ?>
                            </span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</section>