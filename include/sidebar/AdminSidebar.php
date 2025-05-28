 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

   <ul class="sidebar-nav" id="sidebar-nav">
     <?php
      $ActiveSideBar = ReturnSessionalValues("menu", "ACTIVE_SIDEBAR_MENUS_FOR_ADMIN", "dashboard", "GET");
      foreach (ADMIN_SIDEBAR_MENUS as $AdminKeys => $Values) {
        $ActiveSideMenu = CheckEquality($ActiveSideBar, $AdminKeys, "active");
        include __DIR__ . "/components/MenuLinks.php";
      } ?>
   </ul>
 </aside>