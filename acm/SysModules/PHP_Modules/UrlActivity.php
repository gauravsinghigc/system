<?php
//Get running url
function GET_URL()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";
    // Append the host(domain name, ip) to the URL.
    $url .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL
    $url .= $_SERVER['REQUEST_URI'];

    return $url;
}

//runing url
define("RUNNING_URL", GET_URL());

function ClearFilters($InitiateFilter = null, $Redirect = "index.php")
{
    if ($InitiateFilter != null) {

        if (isset($_GET["$InitiateFilter"])) {
            // Initialize the variable to hold the generated HTML
            $filterDisplay = '';

            if (!empty($_GET)) {
                $filterDisplay .= '<div class="row filter-block br-1">';
                $filterDisplay .= '<div class="col-md-10">';
                $filterDisplay .= '<p class="mb-0 text-black">';

                // Loop through each parameter and append to the variable
                foreach ($_GET as $key => $value) {
                    $filterDisplay .= '<span class="text-black">';
                    $filterDisplay .= '[ ' . ReplaceSpecialCharacters($key, "_") . ': ';
                    $filterDisplay .= '<b>' . htmlspecialchars($value) . '</b> ],';
                    $filterDisplay .= '</span>';
                }

                $filterDisplay .= '</p>';
                $filterDisplay .= '</div>';
                $filterDisplay .= '<div class="col-md-2">';
                $filterDisplay .= '<a href="' . $Redirect . '" class="btn btn-xs mt-2 btn-danger pull-right">';
                $filterDisplay .= '<i class="fa fa-times"></i> Clear Filters';
                $filterDisplay .= '</a>';
                $filterDisplay .= '</div>';
                $filterDisplay .= '</div>';
            }

            // Echo the variable to display the generated HTML
            return $filterDisplay;
        }
    }
}
