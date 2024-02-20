<!DOCTYPE html>
<html  lang="de">	
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="meta description">
<title>Kalender</title>


<style>
	html {background:#fff;	  overflow: hidden;}

	#formwrap {	
		padding: 0 0 1em 0;
		text-align:center;	
	}
	
	#calform {
		font-family:Helvetica,Arial,sans-serif;
		color:#333;
		
	}
	
	#calform select {
		font-size:1em;
		margin-top:1em;
		padding:1px;
	}
	
	#calform input[type="number"] {
		padding:1px 3px;
		font-size:16px;
		max-width: 2em;
		border:0;
	}
	#calform input[type="submit"]{
		font-size:16px;
		padding: 1px 7px;
	}
	
	.hide {
		position: absolute;
		height: 1px;
		width: 1px;
		overflow: hidden;
		clip: rect(0 0 0 0);
/*		clip-path: inset(100%);*/
		white-space: nowrap;	
	}
	
	.flexcal {
		display: flex; 
		flex-flow: row wrap;
		/* column-gap:2em; not working on iOS */
		font-family:Helvetica,Arial,sans-serif;
		justify-content: center;
		color:#333;
		padding:0;
/*		padding-bottom: calc(2em - 5%);*/
		
	}
	
	
	@supports (display: grid) {
		.flexcal div {min-height: 16em;}
		.flexcal ul {
			display: grid;
			grid-template-columns: repeat(7, 1fr);
			list-style: none;
			padding:0;
			margin: 10px;
		}
		#not_supported {display:none;}
	}
	
	@supports not (display: grid) {
		#formwrap, .flexcal {
			display:none;
		}
		#not_supported {display:block;}
	}
	
	.flexcal li {
		text-align: center;
		width:25px;
		height:25px;
		line-height:25px;	
	}
	
	
	@media only screen and (min-device-width: 800px) {
		.flexcal li {padding-top:1px !important;}
	}		

	.we {background:#e1e1e1;}
	.heute {
		color:#fff;
		font-weight:700;
		background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAGFBMVEVHcEzzLS/zHx/zHR3zFxfzERH0GxvzDAwsT1xpAAAAB3RSTlMAECpTrN13Lu6E4wAAAOhJREFUeNrtl8sKwzAMBK3n/v8fFwolENI41Vw7d28iyZa06xvmkVlvMsNt/YR36US1r4dYlC6psCfHWzf0ViK0Ie5jT21JB5/f/ETrIX2dvdRj0q7PI4XUT+Qw/oO+yf+gFqYBPkvAQZ4CAEGYhti5AsNKmMbYkQGShdKYevcAAfyTQpLGklAMJoQtF8JXCBGrhciVVKCEqL+AuAAvY0MBfJXxY8LPmTYU3NJwU6VtHQ8WPNrocMXjnS8YfMUhQRhd8+iiyVddpJC2kEIaNxzc8oxdSxq3fdx4cuvLzfce8+iP/e8b+/8CfUNX6ut+YCUAAAAASUVORK5CYII=');
		background-size: contain;
		background-repeat: no-repeat;
	}
	
	.flexcal li:nth-child(-n+7){
		font-weight:700;
	}
	
	.flexcal h2 {
		text-align: center;
		font-variant:all-small-caps;
		border:none;
		padding:0;
		font-weight:400;
		margin-top:0;
	}
	
	
	
	#next_month, #prev_month {
		display: block;
		opacity: .6;
		position: fixed;
		border:0;
		background:transparent;
	}
	
	#prev_month {
		left:1em;
		top: 11px;
	}
	#next_month {
		right:1em;
		top: 14px;
	}
	
	.warning{color:#e80000;border:1px solid #e80000;padding:5px!important;margin-top:1em !important;display:block;}
	
</style>



</head>
<body>



<?php

$anzahl = 3; //default Anzahl Monate angezeigt 

$month = "";
$year = "";

if (isset ($_COOKIE["Anzahl_month"])) {
	$anzahl = $_COOKIE["Anzahl_month"];
} else {
}

$jahr = date('Y');
$monat = date('m');

if (isset($_POST['month'])) {
	$month = $_POST['month'];
	$monat = date($month);
}
if (isset($_POST['year'])) {
	$year = $_POST['year'];
	$jahr = date($year);
}
if (isset($_POST['anzahl'])) {
	$anzahl = $_POST['anzahl'];
	setcookie ("Anzahl_month", $anzahl);
} 


function kal($y,$m) { 
	setlocale(LC_TIME, "de_DE.UTF-8");

	$heute_d = date ('j');
	$heute_m = date ('m');
	$heute_y = date ('Y');

	// $heute_d = date ('31');
	// $heute_m = date ('07');
	// $heute_y = date ('2021');
	
	if ($m > 12) {
		$m = $m - 12;
		$y++;
	}

	$a = cal_days_in_month(CAL_GREGORIAN,$m,$y);
	
	$starttag = date($y.'-'.$m.'-01');
 	$start = strtotime ( $starttag );
	$b = date('w',$start); 
	if ($b == 0) {$b = 7;} // Sonntag = 1!
	
	$monat = strftime("%B",$start);	
	echo "<div>\n";
	echo "<h2>$monat $y</h2>\n";
	echo "<ul>\n";
	
	$day = array("Mo","Di","Mi","Do","Fr","Sa","So");
	for ($k = 0; $k < count($day); $k++) {
		echo "<li>$day[$k]</li>\n";
	}
	
	// 1. Tag des Monats positionieren
	if ($b >= 6) {
		// Wenn Tag 1 Wochenende farblich hinterlegen
		if ($heute_d == 1 && $m == $heute_m && $y == $heute_y) {
			echo "<li class=\"we heute\" style=\"grid-column-start: $b;\">1</li>\n";
		} else {
			echo "<li class=\"we\" style=\"grid-column-start: $b;\">1</li>\n";		
		}
	} else {
		
		if ($heute_d == 1 && $m == $heute_m && $y == $heute_y) {
			echo "<li class=\"heute\" style=\"grid-column-start: $b;\">1</li>\n";
		} else {
			echo "<li style=\"grid-column-start: $b;\">1</li>\n";			
		}
	}


	
	for ($i = 2; $i <= $a; $i++) {

		// Wochenenden farblich hinterlegen
		if (($i+$b) % 7 <= 1 ) {
			if ($i == $heute_d && $m == $heute_m && $y == $heute_y) {
				echo "<li class=\"we heute\">$i</li>\n";
			} else {
				echo "<li class=\"we\">$i</li>\n";
			}
			
		} else {	
			if ($i == $heute_d && $m == $heute_m && $y == $heute_y) {
				echo "<li class=\"heute\">$i</li>\n";
			} else {
				echo "<li>$i</li>\n";
			}
		}
	}
	

	echo "</ul>\n</div>\n";
}

 
if ($monat == 12 ) {
	$next_month = 1;
	$next_year = $jahr + 1;
} else {
	$next_month = $monat + 1;
	$next_year = $jahr;
}
if ($monat == 1 ) {
	$prev_month = 12;
	$prev_year = $jahr - 1;
} else {
	$prev_month = $monat - 1;
	$prev_year = $jahr;
}
?>




<div id="not_supported">
<p class='warning'>Ihr Browser unterstützt leider die hier verwendeten modernen CSS-Techniken nicht. Bitte verwenden Sie einen <a  href='//browsehappy.com/'>aktuellen Browser</a>.</p>
</div>

<!-- Das <div> in dem der Kalender sitzt -->
<div class="flexcal">
<?php
for ($i = 1; $i <=12; $i++) {
	if ($anzahl >= $i) {kal($jahr,$monat+$i-1);}
}
?>
</div>

<div id="formwrap">

<form id="zurueck" action="kalender_inc.php" method="POST">
	<input type="hidden" id="month" name="month" value="<?php echo $prev_month; ?>" >
	<input type="hidden" id="year" name="year" value="<?php echo $prev_year; ?>" >
	<label for="prev_month" class="hide">Ein Monat früher</label>
	<input type="submit" id="prev_month" title="Ein Monat zurück" value="◀︎" >
</form>

<form id="vor" action="kalender_inc.php" method="POST">
	<input type="hidden" id="month" name="month" value="<?php echo $next_month; ?>" >
	<input type="hidden" id="year" name="year" value="<?php echo $next_year; ?>" >
	<label for="next_month" class="hide">Ein Monat später</label>
	<input type="submit" id="next_month" title="Ein Monat vor" value="▶︎">
</form>


<!-- Das Formular zur Wahl der Anzeige -->
<form id="calform" action="kalender_inc.php" method="POST">
	
	<input type="number" id="anzahl" name="anzahl" min="1" max="12" value="<?php echo $anzahl; ?>" step="1" >
	<label for="anzahl">Monat(e)</label>
	<input type="submit" value="zeigen" >

</form>
</div>




