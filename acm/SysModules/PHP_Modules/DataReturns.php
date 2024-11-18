<?php

//function booleans values 
function BOOL_DATA($data = true, $true = true, $false = false)
{
  if ($data == true) {
    return $true;
  } else {
    return $false;
  }
}

//return value
function ReturnValue($data)
{
  if ($data == null) {
    return "Not Available";
  } else {
    return $data;
  }
}

//get phone number format with mask 
function PhoneNumberMask($phoneNumber)
{
  // Check if the phone number is at least 4 digits long
  if (strlen($phoneNumber) >= 4) {
    // Get the last 4 digits of the phone number
    $lastFourDigits = substr($phoneNumber, -4);

    // Replace the rest with "XXXX"
    $maskedPhoneNumber = 'XX-XXXX-' . $lastFourDigits;

    // Display the masked phone number
    return $maskedPhoneNumber;
  } else {
    // Handle cases where the phone number is too short
    return $phoneNumber;
  }
}

//return different color every time
function RandomColorText($text)
{
  // Generate a random color in hex format
  $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));

  // Return the text wrapped with a span tag and inline style for color
  return '<span style="color:' . $randomColor . ';">' . $text . '</span>';
}
