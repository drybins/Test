<?php
	class BHKWSP extends IPSModule {

		public function Create()
		{
			//Never delete this line!
			parent::Create();

			$this->RequireParent("{3CFF0FD9-E306-41DB-9B5A-9D06D38576C3}");
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

		public function ForwardData($JSONString)
		{
			$data = json_decode($JSONString);
			IPS_LogMessage("Splitter FRWD", utf8_decode($data->Buffer));

			$this->SendDataToParent(json_encode(Array("DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}", "Buffer" => $data->Buffer)));

			return "String data for device instance!";
		}

		public function ReceiveData($JSONString)
		{
			$data = json_decode($JSONString);
			//IPS_LogMessage("Splitter RECV", utf8_decode($data->Buffer));
					//Kontrollieren ob Buffer leer ist.
			$bufferData = $this->GetBuffer("DataBuffer");
			$bufferData .= $data->Buffer;
			IPS_LogMessage("Splitter bufferData", $bufferData);
			
			$bufferParts = explode("\r\n", $bufferData);

		//Letzten Eintrag nicht auswerten, da dieser nicht vollständig ist.
		if(sizeof($bufferParts) > 1) {
			for($i=0; $i<sizeof($bufferParts)-1; $i++) 
			{
				IPS_LogMessage("Splitter bufferParts", $i . ":" .$bufferParts[$i]);
				//$this->SendDebug("Data", $bufferParts[$i], 0);
				//$this->AnalyseData($bufferParts[$i]);
			}
		}
			//$this->DRTEST(utf8_decode($data->Buffer));
			//$this->SendDataToChildren(json_encode(Array("DataID" => "{185A67F4-5748-3EE1-4EED-CAF56975F21B}", "Buffer" => $data->Buffer)));
		}
		
		public function DRTEST(string $data)
		{
			$data1 = $this->GetBuffer("dataBuffer");
			if(strlen($data1)>0)
			{
				$data = $data1 . $data;
				IPS_LogMessage("Splitter Data_eingang", $data);
			}
			$start = strpos($data,"<",5);
			$end = strpos($data,">",$start);
			$cmd = substr($data, $start+1, $end-$start-1);
			//IPS_LogMessage("Splitter CMD", $cmd);
			$cmdend = strpos($data, "/" . $cmd,0);
			$cmdrest = substr($data, $cmdend);
			IPS_LogMessage("Splitter CMDrest", $cmdrest);
			if($cmdend >0)
			{
				$cmdend = $cmdend + strlen($cmd) + 2;
				$cmdparm = substr($data,0,$cmdend);
				//IPS_LogMessage("Splitter CMD", $cmd);
				switch ($cmd)
				{
					case "statePP":
						$this->statePP($cmdparm);
						break;
					default:
						break;
				}
			}
			else
			{
				IPS_LogMessage("Splitter cmdstart", substr($data,0,5));
				if(strcmp(substr($data,0,5),"<?xml") == 0)
				{
					$this->SetBuffer("dataBuffer",$data);
				}
			}
		}
		
		public function statePP(string $cmd)
		{
			IPS_LogMessage("Splitter statePP", $cmd);
			
			$xmlData = @new SimpleXMLElement(utf8_encode($cmd), LIBXML_NOBLANKS + LIBXML_NONET);
			$SatusID = $this->GetIDForIdent("KirschStatus");
			IPS_LogMessage("Splitter statePP StatusID", $StatusID);
			$ScriptData['STATUS'] = (string) $xmlData->common[0]->state;
			switch ($ScriptData['STATUS']) 
			{
				case "stop":
					SetValueInteger ($SatusID, 1);
					break;
				case "start":
					SetValueInteger ($SatusID, 2);
					break;
				case "warmup":
					SetValueInteger ($SatusID, 3);
					break;
				case "running":
					SetValueInteger ($SatusID, 4);
					break;
				case "cooldown":
					SetValueInteger ($SatusID, 5);
					break;
				case "emergencystop":
					SetValueInteger ($SatusID, 10);
					break;  
				case "error":
					SetValueInteger ($SatusID, 11);
					break;         
				default:
					//SetValueString (14320 , "Status nicht gefunden:" . $ScriptData['STATUS']);
					IPS_LogMessage("Splitter statePP status nicht gefunden", $cmd);
			}
		}
	}