<?php

# spam protection
if (isset($_POST["website"]) && $_POST["website"] == "") {
	/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "quote@kwikquote.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$feedback_page = "feedback_form.html";
$error_page = "error_message.html";
$thankyou_page = "thank_you.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/

$lastName = $_REQUEST['lname'] ;
$firstName = $_REQUEST['fname'] ;
$liveInFlorida = $_REQUEST['liveFlorida'] ;
$addressN = $_REQUEST['addressNum'];
$addressS = $_REQUEST['addressSt'];
$addressC = $_REQUEST['addressCity'];
$addressZ = $_REQUEST['addressZip'];
$own = $_REQUEST['closing'];
$birthDay = $_REQUEST['dob-day'];
$birthMonth = $_REQUEST['dob-month'];
$birthYear = $_REQUEST['dob-year'];
$homeType = $_REQUEST['typeHome'];
$pastClaim = $_REQUEST['pastClaim'];
$homeAge = $_REQUEST['homeAge'];
$petsN = $_REQUEST['petsNo'];
$petsC = $_REQUEST['petsC'];
$petsD = $_REQUEST['petsD'];
$petsO = $_REQUEST['petsO'];
$message = $_REQUEST['message'];

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
$carCount = $_REQUEST['carCount'];
$msg = 
"Name: " . $firstName . " " . $firstName . "\r\n" . 
"Address: " . $addressN . " " . $addressS . ", " . $addressC . " " . $addressZ . "\r\n" . 
"Email: " . $email . "\r\n" . 
"Phone: " . $phone . "\r\n" . 
"Own or about to Purchase: " . $own . "\r\n" . 
"Birthday: " . $birthYear . " " . $birthMonth . " " . $birthDay . "\r\n" .
"Type of Home: " . $homeType . "\r\n" .
"Pets: " . $petsN . " " . $petsD . " " . $petsC . " " . $petsO . "\r\n" .
"What kind of vehicle to insure " . $carTruck . " " . $rv . " " . $boat . " " . $otherV . "\r\n" .
"Car Details " . $carMake . " " . $carModel . " " . $carYear . "\r\n" .
"Age of Home: " . $homeAge . "\r\n" .
"How many vehicles they want to insure: " . $carCount . "\r\n" .
"Claim in the past 3 years: " . $pastClaim . "\r\n" .
"When I want to be contacted: " . $contactTimeM . " " . $contactTimeA . " " . $contactTimeE . "\r\n"  .
"Message: " . $message . "\r\n" ;

/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
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

	mail( "$webmaster_email", "Feedback Form Results", $msg );

	header( "Location: $thankyou_page" );
}
  } else {
	http_response_code(400);
	exit;
  }

?>