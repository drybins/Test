<?php
// Klassendefinition
class BHKW extends IPSModule
{

    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create()
    {
        // Diese Zeile nicht löschen.
        parent::Create();
	
	       	// 1 - Profilname
	// 2 - ProfilTyp 0 - Boolean, 1 - Integer, 2- Float, 3 - String 
	// 3 - Profil Suffix
	// 4 - MinValue
	// 5 - MaxValue 
	// 6 - Stepsize
	// 7 - Nachkommastellen
	// 8 - Icon
	    
        $this->IPS_CreateVariableProfile("Kw", 1, " Kw", 0, 0,1, 2, "");
	$this->IPS_CreateVariableProfile("Status", 1, " Kw", 1, 11, 1, 2, "");
	    IPS_SetVariableProfileAssociation("Status", 1, "gestoppet", "", "LawnGreen");
	$this->IPS_CreateVariableProfile("UpM", 1, " UpM", 0, 0, 1, 0, "");
	//$this->RegisterVariableFloat("AnalogOut1", "Analog Out1", "Dierk");  

	//$this->ConnectParent("{3CFF0FD9-E306-41DB-9B5A-9D06D38576C3}");
    }

    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges()
    {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();
   
    
    }
    
    

    public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			IPS_LogMessage("IOTest RECV", utf8_decode($data->Buffer));

			//Parse and write values to our variables
			
			//Send response back to the splitter
			return "OK from " . $this->InstanceID;
		}
        private function IPS_CreateVariableProfile($ProfileName, $ProfileType, $Suffix, $MinValue, $MaxValue, $StepSize, $Digits, $Icon) 
	{
		    if (!IPS_VariableProfileExists($ProfileName)) 
		    {
			       IPS_CreateVariableProfile($ProfileName, $ProfileType);
			       IPS_SetVariableProfileText($ProfileName, "", $Suffix);
			       IPS_SetVariableProfileValues($ProfileName, $MinValue, $MaxValue, $StepSize);
			       IPS_SetVariableProfileDigits($ProfileName, $Digits);
			       IPS_SetVariableProfileIcon($ProfileName, $Icon);
		    }
	 }
}
