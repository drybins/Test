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
			IPS_LogMessage("Splitter RECV", utf8_decode($data->Buffer));
			DRTEST1($data);
			$this->SendDataToChildren(json_encode(Array("DataID" => "{185A67F4-5748-3EE1-4EED-CAF56975F21B}", "Buffer" => $data->Buffer)));
		}
		
		public function DRTEST1($data)
		{
			$end = $strpos($data,">",30);
			$cmd = $substr($data, 30, $end-30);
			IPS_LogMessage("Splitter CMD", $cmd);
			
		}
	}