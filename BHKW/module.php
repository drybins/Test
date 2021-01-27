<?php
	class BHKW extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();
			
			    $this->IPS_CreateVariableProfile("Kirsch.UpM", 1, " UpM", 0, 0, 1, 0, "");
				$this->IPS_CreateVariableProfile("Kirsch.Kw", 1, " Kw", 0, 0,1, 2, "");
				$this->IPS_CreateVariableProfile("Kirsch.Status", 1, "", 1, 11, 1, 2, "");
				IPS_SetVariableProfileAssociation("Kirsch.Status", 1, "gestoppet", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 2, "startet", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 3, "aufwärmen", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 4, "läuft", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 5, "abkühlen", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 10, "Notstop", "", 0xff0000);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 11, "Fehler", "", 0xff0000);	

				$this->RegisterVariableInteger("KirschStatus", "Status", "Kirsch.Status", 10);

				$this->ConnectParent("{33B9B2D7-6BC5-1CF6-A86F-E76622A7FFB7}");
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();
		}

		public function Send()
		{
			$this->SendDataToParent(json_encode(Array("DataID" => "{EB1230DE-C6EE-1739-07A1-3742EE4FB43F}")));
		}

		public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			$cmd = utf8_decode($data->Buffer);
			IPS_LogMessage("Device RECV", $cmd);
			//IPS_LogMessage("Device RECV", utf8_decode($data->Buffer));
			
			//$xmlData = @new SimpleXMLElement(utf8_encode($data), LIBXML_NOBLANKS + LIBXML_NONET);
			$xmlData = @new SimpleXMLElement($data, LIBXML_NOBLANKS + LIBXML_NONET);
			$SatusID = $this->GetIDForIdent("KirschStatus");
			IPS_LogMessage("BHKW statePP StatusID", $StatusID);
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