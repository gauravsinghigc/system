 <div class="tab-pane fade pt-2" id="leads-stages-and-calls">
     <div class="row">
         <div class="col-md-3">
             <h5 class="app-heading"><i class="fa fa-gears"></i> Modify Flow Configurations</h5>
             <ul class="master-data-flow">
                 <?php
                    $ActiveMasterMenu = ReturnSessionalValues("master", "MASTER_MENU_VALUE", "stages");
                    foreach (MASTER_DATA_MENUS as $MasterKey => $KeyValues) {
                        $ActiveMenu = CheckEquality($ActiveMasterMenu, $MasterKey, "active");
                        include __DIR__ . "/../components/MasterDataFlowMenus.php";
                    } ?>
             </ul>
         </div>
         <div class="col-md-9">
             <?php include __DIR__ . "/../views/" . MASTER_DATA_MENUS[$ActiveMasterMenu]['module']; ?>
         </div>
     </div>
 </div>