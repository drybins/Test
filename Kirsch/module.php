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
        $this->IPS_CreateVariableProfile("Dierk",1);
    }

    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges()
    {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();
        $this->ConnectParent("{3CFF0FD9-E306-41DB-9B5A-9D06D38576C3}");
    
    }
    
    

    public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			IPS_LogMessage("IOTest RECV", utf8_decode($data->Buffer));

			//Parse and write values to our variables
			
			//Send response back to the splitter
			return "OK from " . $this->InstanceID;
		}
}
