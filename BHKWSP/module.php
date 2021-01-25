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

			$this->SendDataToChildren(json_encode(Array("DataID" => "{0B69414C-745C-B89D-FBAC-4932381406A0}", "Buffer" => $data->Buffer)));
		}

	}