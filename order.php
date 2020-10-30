<?php

/*
##########################################################################################
##  FILE: order.php                                                                     ##
##                                                                                      ##
##  Novice Form                                   Version 1.1                           ##
##  © Copyright 2000-2003 Seth Michael Knorr      mail@sethknorr.com                    ##
##                                                                                      ##
##                       http://www.noviceform.com/                                     ##
##         Please contact me with any bugs found, or any bug fixes.                     ##
##                                                                                      ##
##                                                                                      ##
##########################################################################################
##                                                                                      ##
##  There is no email support provided for this script, the only support can be         ##
##  found at our web site: http://www.noviceform.com/                                   ##
##                                                                                      ##
##                                                                                      ##
##  ANY PERSON(S) MAY USE AND MODIFY THESE SCRIPT(S) FREE OF CHARGE FOR EITHER BUSINESS ##
##  OR PERSONAL, HOWEVER AT ALL TIMES HEADERS AND COPYRIGHT MUST ALWAYS REMAIN IN TACT. ##
##                                                                                      ##
##  REDISTRIBUTION FOR PROFIT IS PROHIBITED WITH OUT THE CONSENT OF SETH KNORR.         ##
##                                                                                      ##
##  By using this code you agree to indemnify Seth M. Knorr from any liability that     ##
##  might arise from its use.                                                           ##
##                                                                                      ##
##                                                                                      ##
##########################################################################################
*/


/* $sendto is the email where form results are sent to */
   $sendto = "order@koloni.info";

/* $ccto is the email where form results can be carbon copied to */
   $ccto = "";

/*
         O P T I O N A L   V A R I A B L E S 
*/


/*
TO POST PHP ERRORS TO PAGE FOR DEBUGGING SET:
	$report_errors = "ALL";


TO REMOVE PHP ERRORS FROM POSTING TO THE PAGE FOR USE SET:
	$report_errors = "NONE";

*/
$report_errors = "NONE";


$setokurl = "1";

$okurls = "http://korpenkoloni.se,http://www.korpenkoloni.se,http://koloni.info,http://www.koloni.info";

/*

        N O   N E E D   T O   E D I T   A N Y   V A R I A B L E S   B E L O W

*/




if ($report_errors == "NONE") {
error_reporting(0);
}else{
error_reporting(E_ALL);
}


/* --- I F   S E T   O K   U R L   = 1  ----- */

	if ($setokurl == "1"){

  $found_url = "0";
  $referer =$_SERVER["HTTP_REFERER"];
  $referer = str_replace("://", "[CS]", $referer);
  $referer_sp = explode("/", $referer);
  $referer = "$referer_sp[0]";
  $referer .= "/";
  $referer = str_replace("[CS]", "://", $referer);
  $referer = strtolower($referer);

  $okurls = explode(",", $okurls);

foreach ($okurls as $myokurls) {

$myokurls = strtolower($myokurls);

     if ($referer == strtolower($myokurls)) { 
      $found_url = "1"; 
      }

  }

  if ($found_url == "0") {
  $ERROR_action = "bad_okurl";
  include("$PATH_error,$PAGE_error");
  }

	}
/* --- E N D   I F   S E T   O K   U R L   = 1  --- */



/* check to see if posted */
/*
if ($HTTP_GET_VARS || ! $HTTP_POST_VARS || $_GET || ! $_POST) {
jonas variant:*/
if (! empty($_GET) || empty($_POST)) {
include("orderror.php");
no_pst();

}else{


 /* IF OLDER VERSION OF PHP CONVERT TO NEWER VARIABLES */
	if (! $_POST) {
	$_POST = "$HTTP_POST_VARS";
	}

	if (! $_SERVER) {
	$_SERVER = "$HTTP_SERVER_VARS";
	}


$year = date("Y");
$month = date("m");
$day = date("d");
$hour = date("h");
$min = date("i");
$tod = date("a");


$ip=$_SERVER["REMOTE_ADDR"];


$SEND_prnt = "Formuläret nedan skickades in av " . $_POST{"email"} . " från IP-adressen $ip den $month/$day/$year klockan $hour:$min $tod \n";
$SEND_prnt .= "-------------------------------------------------------------------------\n\n";

/* CHECK TO SEE IF $_POST{"required"} IS SET */
if ($_POST{"required"}){


  $post_required = $_POST{"required"};
  $required = explode(",", $post_required);
  $reqnum = count($required);

	for ($req=0; $req < $reqnum; $req++) {

	$REQ_name = $required[$req];
	$REQ_value = $_POST{"$REQ_name"};


  if ($REQ_name == "email") {
     $goodem = ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $_POST{"email"}, $trashed);

        if (! $goodem) {
	include("orderror.php");
	msng_email();
        }  /* end ! $goodem */

  }
  elseif (! $_POST{"$REQ_name"}) {
 		 $isreqe = "1";
 		 $REQ_error .= "<li> $REQ_name ";
  		 } /* end ! req val */

          } /* end REQ for loop  */


                /* IF THERE ARE ANY REQUIRED FIELDS NOT FILLED IN */

		if ($isreqe == "1") {
		include("orderror.php");
		msng_required();
		}


} /* END CHECK TO SEE IF $_POST{"required"} IS SET */


/* END IF THERE ARE ANY REQUIRED FIELDS NOT FILLED IN */


/* GET POSTED VARIABLES */


foreach ($_POST as $NVPOST_name => $NVPOST_value) {

$NVPOST_value = str_replace("\r", "", $NVPOST_value);

$NVPOST_value = preg_replace("'\cc:'si", "Cc ", $NVPOST_value);
$NVPOST_value = preg_replace("'\bcc:'si", "bcc ", $NVPOST_value);
$NVPOST_value = preg_replace("'\to:'si", "to ", $NVPOST_value);
$NVPOST_value = preg_replace("'\bc:'si", "bc ", $NVPOST_value);



	if (strtolower($NVPOST_name) == "subject") {

	$NVPOST_value = str_replace(":", ";", $NVPOST_value);
	}


            /* G E T   E M A I L */
       
            if (strtolower($NVPOST_name) == "email") {
            $SEND_email = "$NVPOST_value";
	    $SEND_email = str_replace(":", "", $SEND_email);
	    $SEND_email = str_replace(" ", "", $SEND_email);
            }

            /* END GET LEADS EMAIL */
 
   if (! $_POST{"sort"}) {


                            /* CHECK TO SEE IF CONFIG FIELD */
                            if ($NVPOST_name == "subject" || $NVPOST_name == "sort" || $NVPOST_name == "required" || $NVPOST_name == "lyckat"){}else{
                            $SEND_prnt .= "$NVPOST_value \n\n";
                            }
   } /* end ! sort */
  

} /* end foreach */


  /* END GET POSTED VARIABLES */




  if ($_POST{"sort"}) {

  /* SORT VARIABLES */

	$sortvars = explode(",", $_POST{"sort"});
	$sortnum = count($sortvars);

               for ($num=0; $num < $sortnum; $num++) {
	       $SEND_prnt .= "$sortvars[$num]: " . $_POST{"$sortvars[$num]"} . " \n";
	       }

  }   /* END SORT VARIABLES */




/* send mail */


if (! $ccto) {
$header = "From: $SEND_email\r\nReply-to: $SEND_email\r\nSubject: Förhandsbeställning";
}else{
$header = "From: $SEND_email\r\nReply-to: $SEND_email\r\nCc: $ccto\r\nSubject: Förhandsbeställning";
}


mail($sendto, $_POST{"subject"}, $SEND_prnt, $header);

/* END sendmail */

     /* CHECK TO SEE IF FORM SPECIFYS A SUCCESS PAGE */
     if (! $_POST{"lyckat"}) {

include("orderror.php");
default_success();

     }else{
     $successpage=$_POST{"lyckat"};
     header("Location: $successpage");  /* redirect */  
     exit;
     }



} /* END IF POSTED */


?>
