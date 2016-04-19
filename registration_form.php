<?php

/*
##########################################################################################
## Testno popravljanje - IV		                                        	##
## Maj 2009, preverjanje davcne, april 2014 removal davcne 00000000                     ##
##                                                                      	        ##
## Ta datoteka je v windows 1250 charset formatu in mora biti popravljana 		##
## v windozih - po možnosti v notepadu							##
##                                                              	                ##
## Praviloma vedno spreminjamo naslov kongresa in naslovnika                            ##
##########################################################################################

*/

$kongres = "X. Spominsko sreèanje Lidije Andolšek-Jeras 2014";


/* $sendto is the email where form results are sent to */
  
$sendto = "ivan.verdenik@mf.uni-lj.si";
/* $ccto = "ivan@verdenik.si"; */

/* $ccto is the email where form results can be carbon copied to */
$ccto = "martina.peclin@mf.uni-lj.si";
  

/*
#####################################################################################
##  Januar 2011, prvic uporabljeno za UZ šolo                                      ##
## April 2011, Novakovi dnevi                                                      ##
## Avgust 2011, ANdolšek                                                           ##
## v prijave.html je treba popravit action direktorij                              ##
## Oktober 2012, prenos na nov strežnik                                            ##
##  Zdaj pa Ivan programira. Vkljucitev vseh prijav v mysql bazo z imenom prijave, ##
##  potem pa še generiranje pdf-ja za tiskanje                                     ##
##                                                                                 ##
## najprej definiranje spremenljivk oz. konstant                                   ## 
#####################################################################################
*/

	$host = 'localhost';
	$user = 'prijavitelj';
	$pass = 'geslo';
	$database = 'prijave';
	$tabela = 'singularnost';
	
	
	
	


/*

        N O   N E E D   T O   E D I T   A N Y   V A R I A B L E S   B E L O W

*/


$footer = "<br><br><br><br><br><center><font face=\"Arial\"><a href=\"http://www.obgyn-si.org/\" target=\"_blank\"><font color=\"#ff0000\">Procesiranje registracije zagotavlja IV</font></a> </center></font>";

$backbutton = "<br><br><b>Hit your browsers back button and resubmit the form.</b>";



/* check to see if posted */
/* if ($HTTP_GET_VARS || ! $HTTP_POST_VARS || $_GET || ! $_POST) { */
if ($_GET || ! $_POST) {
include("nverror.php");
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
$hour = date("H");
$min = date("i");
$tod = date("a");


$ip=$_SERVER["REMOTE_ADDR"];

$SEND_prnt = "The form below was submited by " . $_POST{"email"} . " from Ip address: $ip on $monthnameactual $month/$day/$year at $hour:$min \n";
$SEND_prnt .= "-------------------------------------------------------------------------\n\n";


/* CHECK TO SEE IF $_POST{"required"} IS SET */
if ($_POST{"required"}){

  $post_required = $_POST{"required"};
  $required = split(",", $post_required);

  $reqnum = count($required);

	for ($req=0; $req < $reqnum; $req++) {

	$REQ_name = $required[$req];
	$REQ_value = $POST{"$REQ_name"};


  if ($REQ_name == "email") {
     $goodem = ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $_POST{"email"}, $trashed);

        if (! $goodem) {
	include("nverror.php");
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
		include("nverror.php");
		msng_required();
		}


} /* END CHECK TO SEE IF $_POST{"required"} IS SET */


/* END IF THERE ARE ANY REQUIRED FIELDS NOT FILLED IN */


/* GET POSTED VARIABLES */


foreach ($_POST as $NVPOST_name => $NVPOST_value) {

            /* GET LEADS EMAIL */

            $email_lower = strtolower($NVPOST_name);
        
            if ($email_lower == "email") {
            $SEND_email = "$NVPOST_value";
            }
            elseif ($email_lower == "davcna") {
            $jajcek = "$NVPOST_value";
            
            if (strlen($jajcek) != 8){
            include("nverror.php");
			msng_ds();
            }

	if ($jajcek == "00000000"){
		include("nverror.php");
		msng_ds();
		}


/* dolzina ustreza, kaj pa vsebina? */            
			$suma = 0;
			for ($i=1; $i<8; $i++){
			$suma += (9-$i)*substr($jajcek,$i-1,1);
			}
			while ($suma >0) $suma-=11;
			$suma = 0 - $suma;
			if ($suma == 10) $suma=0;
			if ($suma != substr($jajcek,7,1)){
            include("nverror.php");
			msng_ds();
            }
            }

            /* END GET LEADS EMAIL */
 
   if (! $_POST{"sort"}) {


                            /* CHECK TO SEE IF CONFIG FIELD */
                            if ($NVPOST_name == "subject" || $NVPOST_name == "sort" || $NVPOST_name == "required" || $NVPOST_name == "success_page"){}else{
                            $SEND_prnt .= "$NVPOST_name: $NVPOST_value \n";
                            }
   } /* end ! sort */
  

} /* end foreach */


  /* END GET POSTED VARIABLES */




  if ($_POST{"sort"}) {

  /* SORT VARIABLES */

	$sortvars = split(",", $_POST{"sort"});
	$sortnum = count($sortvars);

               for ($num=0; $num < $sortnum; $num++) {
	       $SEND_prnt .= "$sortvars[$num]: " . $_POST{"$sortvars[$num]"} . " \n";
	       $SEND_prnt .= "$jajcek";
	       }

  }   /* END SORT VARIABLES */




/* send mail */


if (! $ccto) {
$header = "From: $SEND_email\r\nReply-to: $SEND_email";
}
	else	{
$header = "From: $SEND_email\r\nReply-to: $SEND_email\r\nCc: $ccto";
}

mail($sendto, $_POST{"subject"}, $SEND_prnt, $header);


/* END sendmail
Forma je bila uspešno izpolnjena in emajlirana na željeni naslov. Zdaj pa sledi
najprej generiranje sql zapisa, kasneje pa še ostalo  */



		// connect to the mysql database server.
	$connect = @mysql_connect ($host, $user, $pass);

	if ( $connect )
	{
			mysql_select_db ( $database );

/* prikljuèek na bazo uspešen. Sledi polnjenje s prijaviteljivimi podatki */	
		
			
	$cas_prijave = "$day/$month/$year ob $hour:$min";
	$ime = $_POST[ime];
	$priimek = $_POST[priimek];	
	$naslov = $_POST[naslov];	
	$phone = $_POST[phone];	
	$email = $_POST[email];	
	$sstatus = $_POST[sstatus];	
	$zavezanec = $_POST[zavezanec];	
	$davcna = $_POST[davcna];	
	$placnik = $_POST[placnik];
	
	$sql_query = "INSERT INTO $tabela VALUES ('','$kongres','$cas_prijave','$ime','$priimek','$naslov','$phone','$email',
	'$placnik','$zavezanec','$sstatus','$davcna')";

	
			if ( ! @mysql_query ( $sql_query ) )
			{
				die ( mysql_error() );
			}		
			else {
					$sql_query2 = "SELECT max(id) FROM $tabela;";   				
					$row = mysql_fetch_row(mysql_query( $sql_query2 ));
					$id_number = $row[0];
					}
					 
/* polnjenej s podatki uspešno */
/* zdaj pa gremo na pripravo pdf s potrdilom */
			


// zacetek iniciaizacije pedeefa
include '../pedeef/class.ezpdf.php';
// A4 format je za nas zakon
$pdf = new Cezpdf();
// setup the helvetica font for use with german characters
$diff=array(200=>'Ccaron',232=>'ccaron',
            154=>'scaron',138=>'Scaron',
            158=>'zcaron',142=>'Zcaron',
            240=>'dcroat',208=>'Dcroat',
            230=>'cacute',198=>'Cacute');
$pdf->selectFont('../pedeef/fonts/verdana.afm',array('encoding'=>'WinAnsiEncoding','differences'=>$diff));
$levi_rob = 60;
$desni_rob = 60;
$zgornji_rob = 60;
$spodnji_rob = 60;


// še margine
$pdf->ezSetMargins($zgornji_rob,$spodnji_rob,$levi_rob,$desni_rob);  
// konec inicializacije pedeefa

$koord_x = 70;
$koord_y = 750;

$pdf->ezSetY($koord_y);

// ** GET CONFIGURATION DATA **

			
				
$li1 = "Potrdilo o registraciji za: " . $kongres . "\n";
$li_info = "Vaša prijava je bila uspešna!\n";
$li2 = "Podrobnosti o registraciji ";
$li3 = "ID: " . $id_number . "\n";
$li4 = "Prijava sprejeta " . $cas_prijave . "\n";
$li5 = "Udelezenec / Udelezenka: " . $ime . " " . $priimek . "\n";
$li6 = "Plaènik: " . $placnik . "\n";
$li7 = "Davèna številka plaènika: " . $davcna . "\n";
$li8 = "Vrsta udeležbe: " . $sstatus . "\n";
$li9 = "\n\n\n Prièujoèi obrazec natisnite in ga obdržite kot potrdilo o registraciji!";


$pdf->ezText($li1, 14);
$pdf->ezText($li_info, 12);
$pdf->ezText($li2, 10);
$pdf->ezText($li3, 10);
$pdf->ezText($li4, 10);
$pdf->ezText($li5, 10);
$pdf->ezText($li6, 10);
$pdf->ezText($li7, 10);
$pdf->ezText($li8, 10);
$pdf->ezText($li9, 8);


// konec pdfiranja


$pdf->ezStream();


		}	
	else {
		trigger_error ( mysql_error(), E_USER_ERROR );
	}

     /* CHECK TO SEE IF FORM SPECIFYS A SUCCESS PAGE */
     if (! $_POST{"success_page"}) {

include("nverror.php");
default_success();

     }else{
     $successpage=$_POST{"success_page"};
     header("Location: $successpage");  /* redirect */  
     exit;
     }


} /* END IF POSTED */

?>
