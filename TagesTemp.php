<?

$archiveID=33024 /*[Archive Handler]*/;
$objectID=15580 /*[Wetter\HM Temeratur Sensor Garten\HM_Temperatursensor (OTH)\TEMPERATURE]*/;

/* Beispiel für aktuellen Tag
$start=strtotime("now 00:00:00"); // heute 00:00 Uhr
$ende = time(); // JETZT
*/

// Beispiel für die letzten 6 Stunde
$zeit=localtime(time(),0);
$h_anfang = $zeit[1]+360;
$start=strtotime("-". $h_anfang. "minutes". " -". $zeit[0]. "seconds"); 
$ende=strtotime("-". $zeit[1]. "minutes". " -". $zeit[0]. "seconds");  

$buffer = AC_GetLoggedValues($archiveID, $objectID, $start, $ende, 0);
$anzahl = count($buffer)-1;      // Index startet bei 0 (z.B. 0 bis 9 = 10 Datensätze)

$Summe_Interv=0;
$Summe_Temp=0

Foreach ($buffer as $wert)
	{
	$VTemp=$wert['Value'];
	$TTemp=$wert['Duration'];  // Differenz zum nächsten Datenpunkt in Sekunden
	$Summe_Temp=$Summe_Temp + ($VTemp * $TTemp);
	$Summe_Interv=$Summe_Interv + $TTemp;
	}
	
$Ergebnis=$Summe_Temp/$Summe_Interv;

echo "Die Durchschnittstemperatur von ". date('d.m.y H:i:s', $start)." bis ". date('d.m.y H:i:s', $ende). " beträgt: ". $Ergebnis. "°C";
print_r($buffer)

?>
