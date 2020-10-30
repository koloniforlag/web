<?php
/* START ERROR FUNCTIONS */

function default_success() {
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Refresh" content="35; URL=titlar.html" charset="utf-8"/>
    <title>Koloni Förlag: Tack för din förhandsbeställning!</title>
    <link href="css/style.css" rel="stylesheet"/>
    <style>
    #menu .order 
    { color: #BACDD9 } 
    html, body 
    { height:100%; 
      margin: 0 0; 
      padding: 0;
      background-image: url('img/wiihiii2.png'); 
      background-repeat: no-repeat; 
      background-attachment: fixed; 
      background-position: top right; 
      background-size: 1331px 879px; }
    </style>
  </head>
  <body id="order">
    <div style="width:700px;padding:10px 0px;margin:auto;position:relative;">
      <div id="content">
        <br><br><br><br>
	    <p><h1>Tack för din förhandsbeställning!</h1></p>
	    <h7>Böckerna bör anlända till dig ungefär på utgivningsdatumet.</h7><br><br>
	    <p><a href="titlar.html">Klicka här</a> för att komma tillbaka till 
	    sidan med titlar, eller vänta i 30 sekunder så skickas du tillbaka automagiskt.</p>
	    <br><br>
      </div>
    </div>
  </body>
</html>

<?php

exit;
} /* end function: "default_success" */




function no_pst() {
?>

<html>

<head>
<title>Fel: ingenting skickades</title> 
</head><body bgcolor="#cfcfcf">
<center>


<table width=500 border=1><tr><td bgcolor="#cfcfcf">
<br><br>
<font face="Arial" color="#000000">
<center>
Ingenting skickades???<br><br>
</b></font></a>
</font></center>
<br><br>
</td></tr></table>
</center>

</body></html>

<?php
exit;
} /* end function: "no_pst" */



function msng_email() {

	$title = "<title>Fel format på e-postadressen!</title>";
	$errormessage = "<h2>Fel format på e-postadressen!</h2><b>Du måste skriva in en giltig e-postadress!</b>";

        echo "$title";
	echo "$errormessage";
	echo "$backbutton";
	echo "$footer";
        exit;

} /* end function: "msng_email" */




function msng_required() {

		$title = "<title>Ej ifyllda fält!</title>";
		$errormessage = "<h2>Uppgifter saknas!</h2><b>Följande nödvändiga fält lämnades tomma:</b><br><br>$REQ_error";

		echo "$title";
		echo "$errormessage";
		echo "$backbutton";
		echo "$footer";
		exit;

} /* end function: "msng_required" */

?>
