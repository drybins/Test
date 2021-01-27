<?php
	class BHKW extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();
			
			    $this->IPS_CreateVariableProfile("Kirsch.UpM", 1, " UpM", 0, 0, 1, 0, "");
				$this->IPS_CreateVariableProfile("Kirsch.Kw", 1, " Kw", 0, 0,1, 2, "");
				$this->IPS_CreateVariableProfile("Kirsch.Watt", 1, " Watt", 0, 0,1, 0, "");
				$this->IPS_CreateVariableProfile("Kirsch.Prozent", 1, " %", 0, 100,1, 0, "");
				$this->IPS_CreateVariableProfile("Kirsch.Status", 1, "", 1, 11, 1, 2, "");
				IPS_SetVariableProfileAssociation("Kirsch.Status", 1, "gestoppet", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 2, "startet", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 3, "aufwärmen", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 4, "läuft", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 5, "abkühlen", "", 0x7cfc00);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 10, "Notstop", "", 0xff0000);
				IPS_SetVariableProfileAssociation("Kirsch.Status", 11, "Fehler", "", 0xff0000);	

				$this->RegisterVariableInteger("KirschStatus", "Status", "Kirsch.Status", 10);
				$this->RegisterVariableInteger("Zielleistung", "Zielleistung", "Kirsch.Kw", 15);
				$this->RegisterVariableInteger("Referenzleistung", "Referenz Leistung", "Kirsch.Watt", 20);
				$this->RegisterVariableInteger("Wirkleistung", "Wirkleistung", "Kirsch.Watt", 25);
				$this->RegisterVariableFloat("Oeltemperatur", "Öltemperatur", "~Temperature", 30);
				
				$this->RegisterVariableFloat("Heizwasser", "Heizwasser", "~Temperature", 35);
				$this->RegisterVariableFloat("Abgasteperatur", "Abgasteperatur", "~Temperature", 40);
				$this->RegisterVariableFloat("Gehaeusetemperatur", "Gehäusetemperatur", "~Temperature", 45);
				$this->RegisterVariableInteger("Motordrehzahl", "Motordrehzahl", "Kirsch.UpM", 50);
				$this->RegisterVariableInteger("Speicherladepumpe", "Speicherladepumpe", "Kirsch.Prozent", 55);
				$this->RegisterVariableInteger("Drosselklapenstellung", "Drosselklapenstellung", "Kirsch.Prozent", 60);

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
			$data = utf8_decode($data->Buffer);
			//IPS_LogMessage("Device RECV", $cmd);
			//IPS_LogMessage("Device RECV", utf8_decode($data->Buffer));
			
			$start = strpos($data,"<",5);
			$end = strpos($data,">",$start);
			$cmd = substr($data, $start+1, $end-$start-1);
			IPS_LogMessage("Splitter CMD", $cmd);

			switch ($cmd)
			{
				case "statePP":
					$this->statePP($data);
					break;
				default:
					break;
			}
			
			
		}
		
		public function statePP($data)
		{
			$xmlData = @new SimpleXMLElement(utf8_encode($data), LIBXML_NOBLANKS + LIBXML_NONET);
			
			//Status des BHKW'S
			$ScriptData['STATUS'] = (string) $xmlData->common[0]->state;			
			$StatusID = $this->GetIDForIdent("KirschStatus");
			IPS_LogMessage("BHKW statePP StatusID", $StatusID);
			
			switch ($ScriptData['STATUS']) 
			{
				case "stop":
				SetValueInteger ($StatusID, 1);
				break;
			case "start":
				SetValueInteger ($StatusID, 2);
				break;
			case "warmup":
				SetValueInteger ($StatusID, 3);
				break;
			case "running":
				SetValueInteger ($StatusID, 4);
				break;
			case "cooldown":
				SetValueInteger ($StatusID, 5);
				break;
			case "emergencystop":
				SetValueInteger ($StatusID, 10);
				break;  
			case "error":
				SetValueInteger ($StatusID, 11);
				break;         
			default:
				//SetValueString (14320 , "Status nicht gefunden:" . $ScriptData['STATUS']);
			}
			
			// Target Power
			$ScriptData['TP'] = (string) $xmlData->common[0]->targetPower;
			SetValueInteger ($this->GetIDForIdent("Zielleistung"), $ScriptData['TP']);
			//Referenzleistung
			$ScriptData['RL'] = (string) $xmlData->common[0]->referencePower*1000;
			SetValueInteger ($this->GetIDForIdent("Referenzleistung"), $ScriptData['RL']);
			//Wirkleistung
			$ScriptData['E7'] = (Float) $xmlData->electric[0]->E7;
			SetValue ($this->GetIDForIdent("Wirkleistung"), $ScriptData['E7'])
			
			$ScriptData['OelT'] =  (string) $xmlData->sensors[0]->TI4;
			SetValueFloat ($this->GetIDForIdent("Oeltemperatur"), $ScriptData['OelT']);
			$ScriptData['HW'] =  (string) $xmlData->sensors[0]->TI3;
			SetValueFloat($this->GetIDForIdent("Heizwasser") , $ScriptData['HW']);
			$ScriptData['AT'] =  (string) $xmlData->sensors[0]->TI5;
			SetValueFloat ($this->GetIDForIdent("Abgasteperatur") , $ScriptData['AT']);
			$ScriptData['GT'] =  (string) $xmlData->sensors[0]->TI6;
			SetValueFloat ($this->GetIDForIdent("Gehaeusetemperatur") , $ScriptData['GT']);
			
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