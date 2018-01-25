<?
	class KirschBHKW extends IPSModule

	{

		

		public function Create()

		{

			//Never delete this line!

			parent::Create();

			//$this->RegisterVariableString("BHKWIP", "IP", "IP", 1);
			//$this->RegisterVariableInteger("BHKWPort", "Port", "Port");
			//$this->RegisterVariableFloat("LastSourceValue", "Last Value (Temporary)", "", 2);

		}

	

		public function ApplyChanges()

		{

			

			//Never delete this line!_
			parent::ApplyChanges();

		}

	

		/**

		* This function will be available automatically after the module is imported with the module control.

		* Using the custom prefix this function will be callable from PHP and JSON-RPC through:

		*

		* EZS_Update($id);

		*

		*/

		public function CPU_Last()

		{

			// Quelle: http://www.ip-symcon.de/forum/f56/systeminfo-z-b-sys_getharddiskinfo-webfront-darstellen-9152/#post75369
			//print_r(Sys_GetHarddiskInfo());
			$parentID = IPS_GetObject($_IPS['SELF']);
			//$parentID = IPS_GetObject($IPS_SELF);
			//$parentID = $_IPS['SELF'];
			$parentID = $parentID['ParentID'];


			$cpuInfo = Sys_GetCPUInfo();

			for ($i = 0; $i < count($cpuInfo) - 5; $i++)
			{
				SetValueInteger(CreateVariableByName($parentID, 'CPU '.$i, 1, '~Valve'), $cpuInfo['CPU_'.$i]);
			}
			SetValueInteger(CreateVariableByName($parentID, 'durchschnittliche Last', 1, '~Valve'), $cpuInfo['CPU_AVG']);

			IPS_SetScriptTimer($_IPS['SELF'], 1);

			function CreateVariableByName($id, $name, $type, $profile = "")
			{
			//  global $_IPS['SELF'];
			$vid = @IPS_GetVariableIDByName($name, $id);
			if($vid === false)
			{
				$vid = IPS_CreateVariable($type);
				IPS_SetParent($vid, $id);
				IPS_SetName($vid, $name);
				IPS_SetInfo($vid, "this variable was created by script #$IPS_SELF");
				if($profile !== "") { IPS_SetVariableCustomProfile($vid, $profile); }
			}
		return $vid;
		} 

		}

	}
?>
