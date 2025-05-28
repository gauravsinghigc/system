<?php
//foreach loop html tag attribute display
function LOOP_TagsAttributes($data)
{
  foreach ($data as $key => $values) {
    return "$key='$values'";
  }
}

$req = "<span class='text-danger'>*</span>";

function moneyFormatIndia($number)
{
  // Sanitize input: convert to numeric or default to 0
  $number = is_numeric($number) ? (float)$number : 0;

  // Format number in Indian style
  $formatted = number_format($number, 0, '', ',');

  // Custom formatting to match Indian number system (e.g., 12,34,567)
  $len = strlen($formatted);
  if ($len <= 3) return $formatted;

  $last3 = substr($formatted, -3);
  $rest = substr($formatted, 0, $len - 3);
  $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);

  return $rest . "" . $last3;
}


//price function display
function Price($price, $class = null, $icon = null)
{
  if ($price == null || $price == "" || $price == " " || $price == "Not Available") {
    $price = 0;
  }
  $price = moneyFormatIndia($price);

  if ($icon == "icon") {
    $icon = "<i class='fa fa-inr'></i>";
  } else if ($icon == "text") {
    $icon = "INR";
  } else {
    $icon = $icon;
  }
  echo "<span class='$class'>$icon $price</span>";
}

//mrp price function display
function MrpPrice($price)
{
  echo "<span class='text-danger'><strike>Rs.$price</strike></span>";
}

//delete confirmation pop 
function CONFIRM_DELETE_POPUP($id, array $DeleteRequests, $controller, $btnname = null, $btncss = null)
{
  $new_no = rand(0000, 99999999);
  $id = $id . "_" . $new_no;

  //if btnname is null
  if ($btnname == null) {
    $btnname = "<i class='fa fa-trash'></i>";
  }

  //if btncss is null
  if ($btncss == null) {
    $btncss = "";
  }

  $MoreRequests = "";
  foreach ($DeleteRequests as $keys => $Deletevalues) {
    $MoreRequests .= "<input type='hidden' name='" . $keys . "' value='" . SECURE($Deletevalues, "e") . "'>
    ";
  }
?>
  <a class="sqaure <?php echo $btncss; ?>" onclick="ControlForms('<?php echo $id; ?>')"><?php echo $btnname; ?></a>
  <section class="popup-background" id="<?php echo $id; ?>">
    <form class="action-area" method="POST" action="<?php echo $controller; ?>">
      <?php
      echo FormPrimaryInputs(true);
      echo $MoreRequests; ?>
      <div class="ref-image">
        <h1 class="text-center">
          <img src="<?php echo STORAGE_URL_D; ?>/tool-img/failed.gif" class="w-25" alt="Remove Record" title="Remove Record">
        </h1>
      </div>
      <div class="activity-details">
        <h5 class="action-title">
          <span class="action-title-text">Confirm Delete Action!</span>
        </h5>
        <p class="action-desc">
          <span class="action-desc-text">You can't recover this if you delete this!</span>
        </p>
      </div>
      <div class="activity-action">
        <a onclick="ControlForms('<?php echo $id; ?>')" class="btn btn-lg btn-danger">Cancel</a>
        <button type="submit" name="<?php echo array_key_first($DeleteRequests); ?>" class="btn btn-lg btn-success">Confirm & Delete</button>
      </div>
    </form>
  </section>
<?php }


//Status View
function STATUS($status)
{
  if ($status == "1") {
    $s = "Active";
    $b = "btn-success";
  } else {
    $s = "Inactive";
    $b = "btn-danger";
  }

  echo "<span class='btn btn-sm $b'>$s</span>";
}

//no data found View
function NoDataTableView($title, $columns)
{ ?>
  <tr>
    <td colspan="<?php echo $columns; ?>"><?php echo $title; ?></td>
  </tr>
<?php }

//function phone
function PHONE($phonenumber, $visibility = "text", $class = null, $icon = null)
{
  if ($phonenumber == null || $phonenumber == "" || $phonenumber == "null") {
    return false;
  } else {
    if ($visibility == "text") {
      echo "<span class='$class'><i class='$icon'></i> $phonenumber</span>";
    } else {
      echo "<a href='tel:$phonenumber' target='_blank' class='$class'><i class='$icon'></i> $phonenumber</a>";
    }
  }
}

//function email
function EMAIL($emailid, $visibility = "text", $class = null, $icon = null)
{
  if ($emailid == null || $emailid == "" || $emailid == "null") {
    return false;
  } else {
    if ($visibility == "text") {
      echo "<span class='$class'><i class='$icon'></i> $emailid</span>";
    } else {
      echo "<a href='mailto:$emailid' target='_blank' class='$class'><i class='$icon'></i> $emailid</a>";
    }
  }
}

//function website
function WEBSITE($website, $visibility = "text", $class = null, $icon = null)
{
  if ($website == null || $website == "" || $website == "null") {
    return false;
  } else {
    if ($visibility == "text") {
      echo "<span class='$class'><i class='$icon'></i> $website</span>";
    } else {
      echo "<a href='$website' target='_blank' class='$class'><i class='$icon'></i> $website</a>";
    }
  }
}

//function address
function ADDRESS($address, $visibility = "text", $class = null, $icon = null)
{
  if ($address == null || $address == "" || $address == "null") {
    return false;
  } else {
    if ($visibility == "text") {
      echo "<span class='$class'><i class='$icon'></i> $address</span>";
    } else {
      echo "<a href='https://www.google.com/maps/search/?api=1&query=$address' target='_blank' class='$class'><i class='$icon'></i> $address</a>";
    }
  }
}


//text area with editors
function TextareaWithEditor(array $attributes, $id)
{
?>
  <script>
    tinymce.init({
      selector: 'textarea#<?php echo $id; ?>',
      menubar: false
    });
  </script>
  <textarea id="<?php echo $id; ?>" <?php echo LOOP_TagsAttributes($attributes); ?>></textarea>
<?php
}

//status view
function StatusView($data)
{
  if ($data == "1" || $data == 1) {
    return "<span class='text-success'><i class='fa fa-check-circle'></i></span>";
  } else {
    return "<span class='text-danger'><i class='fa fa-warning'></i></span>";
  }
}

//status view
function StatusViewWithText($data)
{
  if ($data == "1" or $data == 1 or $data == "Active" or $data == "ACTIVE") {
    return "<span class='badge badge-success bg-success'><i class='fa fa-check-circle'></i> Active</span>";
  } elseif ($data == "2" or $data == 2 or $data == "Inactive" or $data == "INACTIVE" or $data == "0") {
    return "<span class='badge-danger badge bg-warning'><i class='fa fa-warning'></i> Inactive</span>";
  } elseif ($data == "3" or $data == 3 or $data == "Deleted" or $data == "DELETED") {
    return "<span class='badge-danger badge bg-danger'><i class='fa fa-trash'></i> Deleted!</span>";
  } else {
    return "<span class='badge-secodary badge bg-default'>Unknown</span>";
  }
}

//function get serial nos
function SerialNo()
{
  if (isset($_GET["DefaultLisitingCount"])) {
    $DEFAULT_RECORD_LISTING = $_GET["DefaultLisitingCount"];
    SQL("UPDATE configurations SET configurationvalue='$DEFAULT_RECORD_LISTING' where configurationname='DEFAULT_RECORD_LISTING'");
  }

  $SerialNo = 0;
  if (isset($_GET['view_page'])) {
    $view_page = $_GET['view_page'];
    if ($view_page == 1) {
      $SerialNo = 0;
    } else {
      $SerialNo = CONFIG("DEFAULT_RECORD_LISTING") * ($view_page - 1);
    }
  } else {
    $SerialNo = $SerialNo;
  }

  return $SerialNo;
}
//pagination Headers
function listingstartfrom($Return = null)
{
  if (isset($_GET["DefaultLisitingCount"])) {
    $DEFAULT_RECORD_LISTING = $_GET["DefaultLisitingCount"];
    SQL("UPDATE configurations SET configurationvalue='$DEFAULT_RECORD_LISTING' where configurationname='DEFAULT_RECORD_LISTING'");
  }

  $RecordLimit = (int)CONFIG("DEFAULT_RECORD_LISTING");

  $page = 1;
  // Get current page number
  if (isset($_GET["view_page"])) {
    $page = $_GET["view_page"];
  } else {
    $page = 1;
  }
  $value = $page - 1;
  $start = $value * $RecordLimit;

  if ($Return == null) {
    return null;
  } else {
    if ($Return == "start") {
      return $start;
    } elseif ($Return == "end") {
      return $RecordLimit;
    }
  }
}

//pagination footers
function PaginationFooter(int $TotalItems = 0, $RedirectForAll = "index.php")
{

  $RecordLimit = CONFIG("DEFAULT_RECORD_LISTING");
  if (isset($_GET["DefaultLisitingCount"])) {
    $DEFAULT_RECORD_LISTING = $_GET["DefaultLisitingCount"];
    SQL("UPDATE configurations SET configurationvalue='$DEFAULT_RECORD_LISTING' where configurationname='DEFAULT_RECORD_LISTING'");
  }

  // Get current page number
  if (isset($_GET["view_page"])) {
    $page = $_GET["view_page"];
  } else {
    $page = 1;
  }


  $next_page = ($page + 1);
  $previous_page = ($page - 1);
  $NetPages = round(($TotalItems / $RecordLimit) + 0.5);
  if ($NetPages == 1) {
    $next_page = 1;
  }

  if ($previous_page == 0) {
    $previous_page = 1;
  }

  if ($next_page > $NetPages) {
    $next_page = $NetPages;
  }

  //prepare url parameter and pass with pagination
  $UrlParameters = "";
  $AddFilterValueInListingCount = "";
  if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
      if ($key != "view_page") {
        $UrlParameters .= "&$key=$value";
        $AddFilterValueInListingCount .= "<input type='hidden' name='$key' value='$value'>";
      }
    }
  }
?>
  <div class="col-md-12 flex-s-b mt-3 mb-1 pl-0 pr-0">
    <div style="width:25% !important;">
      <h6 class="mb-0 mt-1" style="font-size:0.85rem;">Page <b><?php echo moneyFormatIndia(IfRequested("GET", "view_page", $page, false)); ?></b> from <b><?php echo moneyFormatIndia($NetPages); ?> </b> pages <br>Total <b><?php echo moneyFormatIndia($TotalItems); ?></b> entries</h6>
    </div>
    <div style="width:20% !important;">
      <form class="flex-s-b">
        <?php echo $AddFilterValueInListingCount; ?>
        <select onchange="form.submit()" name='DefaultLisitingCount' class="form-control form-control-sm m-1">
          <?php echo InputOptionsWithKey(
            [
              "10" => "10",
              "15" => "15",
              "25" => "25",
              "50" => "50",
              "100" => "100",
              "250" => "250",
              "500" => "500",
              "1000" => "1000",
            ],
            IfRequested("GET", "DefaultLisitingCount", DEFAULT_RECORD_LISTING, null)
          ); ?>
        </select>
        <input type="number" name="view_page" onchange="form.submit()" class="form-control fs-12 m-1 form-control-sm" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
      </form>
    </div>
    <div style="width:40% !important;">
      <div class="flex-s-b pt-1">
        <span class="mr-1">
          <a href="?view_page=<?php echo $previous_page . $UrlParameters; ?>" class="btn btn-sm fs-14 btn-primary"><i class="fa fa-angle-double-left"></i> Previous Page</a>
        </span>
        <span class="ml-1">
          <a href="?view_page=<?php echo $next_page . $UrlParameters; ?>" class="btn btn-sm fs-14 btn-primary"> Next Page <i class="fa fa-angle-double-right"></i></a>
        </span>
        <?php if (isset($_GET['view_page'])) { ?>
          <span class="ml-1">
            <a href="<?php echo $RedirectForAll; ?>" class="btn btn-sm fs-14 btn-danger mb-0"><i class="fa fa-times"></i> First Page</a>
          </span>
        <?php } ?>
      </div>
    </div>
  </div>
<?php
}


function Applistingstartfrom($Return = null)
{

  $RecordLimit = 10;

  $page = 1;
  // Get current page number
  if (isset($_GET["view_page"])) {
    $page = $_GET["view_page"];
  } else {
    $page = 1;
  }
  $value = $page - 1;
  $start = $value * $RecordLimit;

  if ($Return == null) {
    return null;
  } else {
    if ($Return == "start") {
      return $start;
    } elseif ($Return == "end") {
      return $RecordLimit;
    }
  }
}

function AppPaginationFooter(int $TotalItems = 0, $RedirectForAll = "index.php")
{

  $RecordLimit = 10;

  // Get current page number
  if (isset($_GET["view_page"])) {
    $page = $_GET["view_page"];
  } else {
    $page = 1;
  }


  $next_page = ($page + 1);
  $previous_page = ($page - 1);
  $NetPages = round(($TotalItems / $RecordLimit) + 0.5);
  if ($NetPages == 1) {
    $next_page = 1;
  }

  if ($previous_page == 0) {
    $previous_page = 1;
  }

  if ($next_page > $NetPages) {
    $next_page = $NetPages;
  }

  //prepare url parameter and pass with pagination
  $UrlParameters = "";
  $AddFilterValueInListingCount = "";
  if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
      if ($key != "view_page") {
        $UrlParameters .= "&$key=$value";
        $AddFilterValueInListingCount .= "<input type='hidden' name='$key' value='$value'>";
      }
    }
  }
?>
  <div class="col-md-12">
    <div class="flex-s-b p-3 pt-2">
      <div style="width:40% !important;">
        <h6 class="mb-0 mt-2 app-fs-3">Page <b><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from <b><?php echo $NetPages; ?> </b> pages <br>Total <b><?php echo $TotalItems; ?></b> entries</h6>
      </div>
      <div style="width:60% !important;">
        <div class="flex-s-b pt-1">
          <span class="mr-1">
            <a href="?view_page=<?php echo $previous_page . $UrlParameters; ?>" class="btn btn-md app-fs-3 btn-primary"><i class="fa fa-angle-double-left"></i> Back</a>
          </span>
          <span class="ml-1">
            <a href="?view_page=<?php echo $next_page . $UrlParameters; ?>" class="btn btn-md app-fs-3 btn-primary">Next <i class="fa fa-angle-double-right"></i></a>
          </span>
          <?php if (isset($_GET['view_page'])) { ?>
            <span class="ml-1">
              <a href="<?php echo $RedirectForAll; ?>" class="btn btn-md app-fs-3 btn-danger mb-0"><i class="fa fa-times"></i> Clear</a>
            </span>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php
}

//define constants
define("SERIAL_NO", SerialNo());
define("START_FROM", listingstartfrom("start"));
define("APP_START_FROM", Applistingstartfrom("start"));


//fontawesome icon
function FontIcon($icon)
{
  return "<i class='fa fa-$icon'></i>";
}

function ValidatePhoneNumber($number)
{
  // Remove all non-digit characters
  $number = preg_replace('/\D/', '', $number);

  // Take last 10 digits (useful if country code like 91, +91 is present)
  if (strlen($number) >= 10) {
    $number = substr($number, -10);
  }

  // Validate Indian mobile number format (starts with 6-9 and has 10 digits)
  if (preg_match('/^[6-9]\d{9}$/', $number)) {
    return $number;
  }

  return null; // Invalid number
}
