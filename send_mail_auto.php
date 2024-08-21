<?php

# spam protection
if (isset($_POST["website"]) && $_POST["website"] == "") {
	/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "quote@quotefriendly.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$feedback_page = "feedback_form.html";
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";

$subject = 'QuoteFriendly Auto Quote';

$headers = "From: noreply@quotefriendly.com" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/

$lastName = $_REQUEST['lname'] ;
$firstName = $_REQUEST['fname'] ;
$addressN = $_REQUEST['addressNum'];
$addressS = $_REQUEST['addressSt'];
$addressC = $_REQUEST['addressCity'];
$addressZ = $_REQUEST['addressZip'];
$carCount = $_REQUEST['carCount'];
$carTruck = $_REQUEST['carTruck'];
$rv = $_REQUEST['rv'];
$boat = $_REQUEST['boat'];
$otherV = $_REQUEST['otherV'];
$carMake = $_REQUEST['carMake'];
$carModel = $_REQUEST['carModel'];
$carYear = $_REQUEST['carYear'];
$email = $_REQUEST['email'] ;
$phone = $_REQUEST['phone'] ;
$contactMethod = $_REQUEST['contactMethod'] ;
$contactTimeM = $_REQUEST['contactTimeM'] ;
$contactTimeA = $_REQUEST['contactTimeA'] ;
$contactTimeE = $_REQUEST['contactTimeE'] ;


$msg =
"<img style='width:120px;' src='https://quotefriendly.com/images/quotefriendly-logo.png' />" .
"<p><span style='color:#00A1DD;font-weight:bold'>Name:</span> " . $firstName . " " . $lastName . "</p>" .
"<p><span style='color:#00A1DD;font-weight:bold'>Address:</span> " . $addressN . " " . $addressS . ", " . $addressC . " " . $addressZ . "</p>" .
"<p><span style='color:#00A1DD;font-weight:bold'>Email:</span> " . $email . "</p>" .
"<p><span style='color:#00A1DD;font-weight:bold'>Phone:</span> " . $phone . "</p>" .
"<p><span style='color:#00A1DD;font-weight:bold'>What kind of vehicle to insure:</span> " . $carTruck . " " . $rv . " " . $boat . " " . $otherV   . "</p>" .
"<p><span style='color:#00A1DD;font-weight:bold'>How many vehicles they want to insure:</span> " . $carCount  . "</p>" .
"<p><span style='color:#00A1DD;font-weight:bold'>Preferred method of contact:</span> " . $contactMethod . "</p>" .
"<p><span style='color:#00A1DD;font-weight:bold'>When they want to be contacted:</span> " . $contactTimeM . " " . $contactTimeA . " " . $contactTimeE  . "</p>";

$msgConfirm = 
"<p style='font-size:1.3rem'>Hi " . $firstName . ",</p> " .
"<p style='font-size:1.1rem;line-height:1.6rem'>Thanks for reaching out to QuoteFriendly. We are really glad you did. We have recieved your information. We will review it within 24 hours and get back to you as soon as possible. </p>" .
"<p style='font-size:1.1rem;line-height:1.6rem'>Have a fantastic day,<br/>Your friends at</p>" .
"<img style='width:150px;' src='https://quotefriendly.com/images/quotefriendly-logo.png' />";

function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}


// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email'])) {
header( "Location: $feedback_page" );
}

/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email) || isInjected($firstName)  || isInjected($lastName) ) {
header( "Location: $error_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "Auto Quote", $msg, $headers );
	mail( "$email", "Quote Friendly Bundle Quote", $msgConfirm, $headers );
	header( "Location: $thankyou_page" );
}
  } else {
	http_response_code(400);
	exit;
  }

?>