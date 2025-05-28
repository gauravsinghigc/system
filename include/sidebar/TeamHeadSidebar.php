 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

   <ul class="sidebar-nav" id="sidebar-nav">
     <?php
      $ActiveSideBar = ReturnSessionalValues("menu", "ACTIVE_SIDEBAR_MENU_FOR_COORDINATOR", "dashboard", "GET");
      foreach (TEAM_HEAD_SIDEBARS as $AdminKeys => $Values) {
        $ActiveSideMenu = CheckEquality($ActiveSideBar, $AdminKeys, "active");
        include __DIR__ . "/components/MenuLinks.php";
      } ?>
   </ul>

 </aside>