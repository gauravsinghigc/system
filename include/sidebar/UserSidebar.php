 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">
   <ul class="sidebar-nav" id="sidebar-nav">
     <?php
      $ActiveSideBar = ReturnSessionalValues("menu", "ACTIVE_SIDEBAR_MENU_FOR_USER", "dashboard", "GET");
      foreach (USER_SIDEBAR_MENUS as $AdminKeys => $Values) {
        $ActiveSideMenu = CheckEquality($ActiveSideBar, $AdminKeys, "active");
        include __DIR__ . "/components/MenuLinks.php";
      } ?>
   </ul>
 </aside>