<?php

/* doxbomber v0.4:
 *  a PHP script used to spread false doxes
 *
 * Release notes for v0.4:
 *  -Made a few small revisions
 *  -Added birthdays, random age selector, couple of other things
 *  -Made the USERNAME section a bit easier to use
 *  -Added some documentation to help users
 *  -Added titles
 *
 * Made by a couple of anons.
 *
 * Legal: Do whatever you want. Rename it, rewrite it, fork it, whatever.
 *
 * Templates taken from doxes on Pastebin, DOXBIN, etc.
 * Oh, and before I forget, here's a big ol' thank you to all of the doxers who made this script possible ;)
 */

function generateDox($username, $username2, $username3) {
	$ret = array();

    // Checks for the year
	$thisyear = int(date("Y")); # This is used to create a birthyear; unless you know what you're doing, leave this alone.
	
	// Selects a first name
	$firstname = file_get_contents("firstnames.txt");
	$firstname = explode("\n", $firstname);
	$firstname = $firstname[rand(0, count($firstname) - 1)];

	// Selects a middle name
	$middlename = file_get_contents("firstnames.txt");
	$middlename = explode("\n", $middlename);
	$middlename = $middlename[rand(0, count($middlename) - 1)];
	$middleinitial = str_split($middlename);
	$middleinitial = $middleinitial[0];

	// Selects a last name
	$lastname = file_get_contents("lastnames.txt");
	$lastname = explode("\n", $lastname);
	$lastname = $lastname[rand(0, count($lastname) - 1)];

	// Grabs the whole name (only for the paste title)
	$fullname = $firstname . " " . $middlename . " " . $lastname;
	
	// Selects a state
	$state = file_get_contents("states.txt");
	$state = explode("\n", $state);
	$state = $state[rand(0, count($state) - 1)];

	// Selects a town
	$town = file_get_contents("towns.txt");
	$town = explode("\n", $town);
	$town = $town[rand(0, count($town) - 1)];

	// Generates an address
	$street = file_get_contents("streets.txt");
	$street = explode("\n", $street);
	$street = $street[rand(0, count($street) - 1)];
	$address = rand(3, 497) . " " . $street . ", " . $town . ", " . $state . ", USA";

	// Generate phone numbers
	$phone = "(" . rand(201,989) . ") " . rand(100,999) . "-" . rand(1000,9999);
	$phone2 = "(" . rand(201,989) . ") " . rand(100,999) . "-" . rand(1000,9999);
	$phone3 = "(" . rand(201,989) . ") " . rand(100,999) . "-" . rand(1000,9999);

	// Generates an age
	$age = rand(13,79);
	
	// Generates a full date of birth
	$yearofbirth = $thisyear - $age;
	$monthofbirth = rand(1,12);
	$dayofbirth = rand(1,30);
	if ($monthofbirth == 2) {
	  $dayofbirth = rand(1,28);
	}
	$dob = $dayofbirth . "/" . $monthofbirth . "/" . $yearofbirth;
		
	// Generates an SSN
	$ssn = rand(0,9) . rand(0,9) . rand(0,9) . "-" . rand(0,9) . rand(0,9) . "-" . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9);

	// Generates an IP address
	$ip = rand(1,255) . "." . rand(1,255) . "." . rand(1,255) . "." . rand(1,255);

	// Selects a template
	$alltemplates = scandir("templates");
	$template = $alltemplates[rand(0, count($alltemplates) - 1)];
	$template = file_get_contents("templates/".$template);
	$template = str_replace("**FNAME**", $firstname, $template); # If you've made your name public, change $firstname to "name"
	$template = str_replace("**LNAME**", $lastname, $template); # Same instruction as first name
	$template = str_replace("**MNAME**", $middlename, $template); # Same instruction as last name
	$template = str_replace("**USERNAME**", $username, $template);
	$template = str_replace("**USERNAME2**", $username2, $template);
	$template = str_replace("**USERNAME3**", $username3, $template);
	$template = str_replace("**PHONE**", $phone, $template);
	$template = str_replace("**PHONE2**", $phone2, $template);
	$template = str_replace("**PHONE3**", $phone3, $template);
	$template = str_replace("**ADDRESS**", $address, $template);
	$template = str_replace("**STATE**", $state, $template);
	$template = str_replace("**TOWN**", $town, $template);
	$template = str_replace("**AGE**", $age, $template);
	$template = str_replace("**DOB**", $dob, $template);
	$template = str_replace("**SSN**", "[redacted]", $template); # Change "[redacted]" (with quotes) to $ssn if you'd like to use the ssn function (there ARE templates with **SSN** in them, but not many)
	$template = str_replace("**MIDDLEINITIAL**", $middleinitial, $template);
	$template = str_replace("**IP**", $ip, $template);

	return $template;
}

// Generates a title
function genTitle($username) {
	$titles = array(
	"$username dox",
	"dox on $username",
	"dox of $username",
	"$username OWNED",
	"$username d0x",
	"$username",
	"$username exposed",
	"LOL $username got PWNED",
	"$username doxxed",
	"REAL dox of $username",
	"UPDATED - Dox on $username",
	"DOX on $username",
	".: $username dox :.",
	"$username doxed and PWNED",
	"$username doxed & OWNED",
	"$username gettin owned ;)",
	"fuck $username",
	"the rape of $username",
	"$username lol",
	#"$username exposed as $fullname",
    "$username got owned",
	"$username is a faggot",
	"$username #dox"
	);
}

function sendCurl($url, $postparams, $useragent="Mozilla/5.0 (Windows NT 6.2; Win64; x64; rv:16.0) Gecko/16.0 Firefox/16.0", $specialreturn=false) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postparams);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
	if($specialreturn == false) {
		if(curl_exec($ch) != false) return curl_getinfo($ch, CURLINFO_EFFECTIVE_URL) . "\n"; else return "Paste failed. :(\n";
	} else {
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
		return curl_exec($ch);
	}
}

function pasteDPaste($title, $poster, $bodytext) {
	return sendCurl("http://dpaste.com/", "title=$title&poster=$poster&hold=on&content=$bodytext");
}

function pasteEugene($title, $poster, $bodytext) {
	return sendCurl("http://eugeneciurana.com/pastebin/pastebin.php", "parent_pid=&format=text&code2=$bodytext&poster=$poster&pastebinForm7_hf_0=&paste=Send&expiry=f");
}

function pasteFrugal($title, $poster, $bodytext) {
	return sendCurl("http://frugalware.org/paste/", "parent_pid=&format=text&code2=$bodytext&human=yes&poster=$poster&pastebinForm7_hf_0=&paste=Send&expiry=f");
}

function pasteHPaste($title, $poster, $bodytext) {
	return sendCurl("http://hpaste.org/new", "title=$title&author=$poster&language=&channel=&paste=$bodytext&email=&submit=Submit");
}

function pasteMathBin($title, $poster, $bodytext) {
	return sendCurl("http://mathb.in/?post", "code=$bodytext&title=$title&name=$poster&submit=Save and get new URL&id=&date=");
}

function pasteMathBin2($title, $poster, $bodytext) {
	return sendCurl("http://mathbin.net/index.html", "title=$title&name=$poster&save=1&id=&body=$bodytext");
}

// NO POSTER FEATURE
function paste2($title, $poster, $bodytext) {
	return sendCurl("http://paste2.org/", "code=$bodytext&lang=text&description=$title&parent=");
}

// NO POSTER FEATURE
function paste8($title, $poster, $bodytext) {
	return sendCurl("http://paste8.com/index.php", "parent_pid=&code2=$bodytext&poster=$title&format=text&expiry=f");
}

function pastebinCA($title, $poster, $bodytext) {
	echo sendCurl("http://pastebin.ca/", "content=$bodytext&postkey=&postkeysig=&name=$title&description=$title&tags=dox&type=1&expiry=&encryptpw=&s=Submit Post", true);
}

function pasteCrossLfs($title, $poster, $bodytext) {
	return sendCurl("http://pastebin.cross-lfs.org/pastebin.php", "parent_pid=&format=text&code2=$bodytext&poster=$poster&paste=Send&expiry=f");
}

function pasteDixo($title, $poster, $bodytext) {
	return sendCurl("http://pastebin.dixo.net/pastebin.php", "parent_pid=&format=text&code2=$bodytext&poster=$poster&pastebinForm7_hf_0=&paste=Send&expiry=f");
}

function pasteGraal($title, $poster, $bodytext) {
	return sendCurl("http://pastebin.graalcenter.org/paste.php", "text=$bodytext&syntax=BBCode");
}

function pasteMozilla($title, $poster, $bodytext) {
	return sendCurl("http://pastebin.graalcenter.org/paste.php", "parent_pid=&format=text&code2=$bodytext&poster=$poster&pastebinForm7_hf_0=&paste=Send&expiry=f");
}

function pasteChakra($title, $poster, $bodytext) {
	return sendCurl("http://paste.chakra-project.org/", "paste_user=$poster&paste_lang=text&paste_data=$bodytext&paste_password=&paste_expire=0&paste_submit=Paste");
}

function pasteKDE($title, $poster, $bodytext) {
	return sendCurl("http://paste.kde.org/", "paste_user=$poster&paste_lang=text&paste_data=$bodytext&paste_password=&paste_expire=0&paste_submit=Paste");
}

// No poster or title features
function pasteMappify($title, $poster, $bodytext) {
	return sendCurl("http://paste.mappify.org/new/", "content=$bodytext&lang=0");
}

function pasteUbuntu($title, $poster, $bodytext) {
	return sendCurl("http://paste.ubuntu.com/", "poster=$poster&syntax=text&content=$bodytext");
}


// Now replace ALL OF THE NAMES with the usernames you'd like to falsely dox.
// Each username slot is filled with NAME-NUMBER for your convenience. Simply use the replace command.
// N1 is USERNAME, N2 is USERNAME2, N3 is USERNAME3.
$doxtitle = genTitle("USERNAME");

echo pasteDPaste($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteEugene($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteFrugal($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteHPaste($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteMathBin($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteMathBin2($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteMathBin2($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pastebinCA($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteCrossLfs($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteDixo($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteGraal($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteMozilla($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteChakra($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteKDE($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
echo pasteUbuntu($doxtitle, $doxtitle, generateDox("N1", "N2", "N3"));
?>
