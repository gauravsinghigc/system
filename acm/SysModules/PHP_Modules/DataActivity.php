<?php
//remove space
function RemoveSpace($string)
{
    $string = str_replace(' ', '-', $string);
    if ($string == null) {
        return null;
    } else {
        return $string;
    }
}

//remove special characters
function RemoveAllSpecialCharacters($string)
{
    $string = str_replace(' ', '_', $string);
    if ($string == null) {
        return null;
    } else {
        return $string;
    }
}

function ReplaceSpecialCharacters($string, $charToRemove)
{
    // Use str_replace to remove the specified character
    $cleanedString = str_replace($charToRemove, ' ', $string);
    return $cleanedString;
}

//lowercase all words
function LowerCase($string)
{
    $string = strtolower($string);
    if ($string == null) {
        return null;
    } else {
        return $string;
    }
}

//uppercase all words
function UpperCase($string)
{
    if ($string != null) {
        $string = strtoupper($string);
        if ($string == null) {
            return null;
        } else {
            return $string;
        }
    } else {
        return $string;
    }
}

//GET numbers from strings
function GetNumbers($strings)
{
    if ($strings == null) {
        $return = 0;
    } else {
        $return = intval(preg_replace('/[^0-9]+/', '', $strings), 10);
    }

    return $return;
}

//get string without numbers
function GetStrings($string, $replace = null)
{
    if ($string == null) {
        $returns = "";
    } else {
        $paragraph = $string;
        $special_chars = array("@", "#", "$", "&", "*", "%", "-", "_", "|", "/", "=", "\"", "(", ")", "\"", "\"", "!", "^", "`", "~", ";", ":", "'", "?", "<", ">", ".");

        if ($replace == null) {
            $returns = preg_replace('/\d+/', '', $string);
        } else {
            $returns = str_replace($special_chars, $replace, $paragraph);
        }
    }

    return $returns;
}

//show only limited characters
function LimitText($text, $start, $end)
{
    if ($text != null) {
        $LimitText = substr($text, $start, $end) . "...";
        $TotalStringVarChar = strlen($LimitText);
        if ($TotalStringVarChar >= $end) {
            $LimitText = substr($text, $start, $end) . "...";
        } else {
            $LimitText = substr($text, $start, $end);
        }
        return $LimitText;
    }
}

//get first word of string
function FirstWord($string)
{
    $start = 0;
    $end = 1;

    $LimitText = substr($string, $start, $end);
    $TotalStringVarChar = strlen($LimitText);
    if ($TotalStringVarChar > $end) {
        $LimitText = substr($string, $start, $end);
    } elseif ($TotalStringVarChar == 0 || $TotalStringVarChar == null || $TotalStringVarChar == "." || $TotalStringVarChar == " ") {
        $LimitText = "O";
    } else {
        $LimitText = substr($string, $start, $end);
    }
    return $LimitText;
}

function VALID_PHONE_NUMBER($phone)
{
    // If phone is empty, return empty string
    if (empty($phone)) {
        return "";
    }

    // Convert to string and remove any non-digit characters
    $phone = preg_replace('/[^0-9]/', '', (string)$phone);

    // Remove 91 from start if it exists
    if (substr($phone, 0, 2) === '91') {
        $phone = substr($phone, 2);
    }

    // Take only first 10 digits
    $phone = substr($phone, 0, 10);

    // Return the processed phone number
    return $phone;
}
