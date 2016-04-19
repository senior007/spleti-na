<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">


<?php
/* START ERROR FUNCTIONS */

function default_success() {
?>

	<html>
	<head>
	<title>Hvala.</title>
	</head>
	<body>
	<BR><BR><CENTER>
<?php
include "success.html";
?>
	</CENTER>
	<?php echo "$footer"; ?>

	</body>
	</html>

<?php

exit;
} /* end function: "default_success" */




function no_pst() {
?>

<html>

<head>
<title>Obrazec za registracijo &nbsp; &nbsp; &nbsp; &nbsp;  Verzija 2.1 </title> 
</head><body bgcolor="#cfcfcf">
<center>


<table width=500 border=1><tr><td bgcolor="#000080">
<br><br>
<font face="Arial" color="#ffffff">
<center>
Obrazec za registracijo &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  Verzija 2.1<br><br>

 &copy; Copyright 2014 Ivan Verdenik<br><br>

</font></center>
<br><br>
</td></tr></table>
</center>

</body></html>

<?php
exit;
} /* end function: "no_pst" */



function msng_email() {

	$title = "<title>Email manjka ali je neprimerne oblike!</title>";
	$errormessage = "<h2>Email manjka ali je neprimerne oblike.</h2><b>!</b>";

        echo "$title";
	echo "$errormessage";
	echo "$backbutton";
	echo "$footer";
        exit;

} /* end function: "msng_email" */




function msng_required() {

		$title = "<title>Manjkajoči podatki!</title>";
		$errormessage = "<h2>Manjkajoči podatki!</h2><b>Vsa polja morajo biti izpolnjena:</b><br><br>$REQ_error";

		echo "$title";
		echo "$errormessage";
		echo "$backbutton";
		echo "$footer";
		exit;

} /* end function: "msng_required" */


function msng_ds() {

	$title = "<title>Davčna številka ni pravilna!</title>";
	$errormessage = "<h2>Davčna številka ni pravilna!</h2><b>!</b>";

        echo "$title";
	echo "$errormessage";
	echo "$backbutton";
	echo "$footer";
        exit;

} /* end function: "msng_email" */

?>
