<?php
// Klassendefinition
class BHKW extends IPSModule
{

    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create()
    {
        // Diese Zeile nicht löschen.
        parent::Create();

        //if(!IPS_VariableProfileExists("Dierk")) {
        //    IPS_CreateVariableProfile("Dierk", 1);
        //}
        //if(!IPS_VARIABLEPROFILEEXISTS("Kw")
        //{
        //    IPS_CreateVariableProfile("Kw",1);
        //}
	//$this->CreateVariableProfile("ESERA.Spannung15V", 2, " V", 0, 15, 0.1, 2, "");
        $this->IPS_CreateVariableProfile("Dierk", 2, " V", 0, 15, 0.1, 2, "";
	
	$this->ConnectParent("{3CFF0FD9-E306-41DB-9B5A-9D06D38576C3}");
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
        private function CreateVariableProfile($ProfileName, $ProfileType, $Suffix, $MinValue, $MaxValue, $StepSize, $Digits, $Icon) 
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
