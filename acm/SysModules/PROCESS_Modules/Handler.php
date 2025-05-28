<?php
//flash msg
function MSG($type, $msg)
{
    $_SESSION['ALERT_TYPE'] = "$type";
    $_SESSION['ALERT_MSG'] = "$msg";
}

//function for msg and redirect same
function LOCATION($type, $msg, $url)
{
    MSG("$type", "$msg");
    header("location: $url");
    exit();
}

//responser for all controllers
function RESPONSE($act, $msg, $msg2, $access_url = null)
{
    if ($access_url != null) {
        $access_url = $access_url;
    } else {
        global $access_url;
    }

    if ($act == true) {
        $type = "success";
        $msg = "$msg";
    } else {
        $type = "danger";
        $msg = "$msg2";
    }
    LOCATION($type, "$msg", "$access_url");
}

//controller request
function CONTROLLER($controllername = null)
{

    if ($controllername == null) {
        $controller = CONTROLLER;
    } else {
        $controller = DOMAIN . "/handler/" . $controllername;
    }

    return $controller;
}

//Request Handler
function RequestHandler($Response, array $results)
{
    RESPONSE($Response, $results['true'], $results['false']);
}

//function HandleInvalidData()
function HandleInvalidData($Data, $redirectto)
{
    if ($Data == null || $Data == '' || $Data == false || $Data == " ") {
        header("location: $redirectto");
        exit();
    }
}
