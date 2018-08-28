<?
	class Withings extends IPSModule
	{
		
    //**************************************************************************
    //
    //**************************************************************************    
    public function Create()
      {
      //Never delete this line!
      parent::Create();
    
      $this->RegisterPropertyInteger("Intervall", 21600);  
      $this->RegisterPropertyBoolean("BodyMeasures", false);
      $this->RegisterPropertyBoolean("BodyPuls", false);  
      $this->RegisterPropertyBoolean("BloodMeasures", false);  
      $this->RegisterPropertyString("Username", "user@user.de");  
      $this->RegisterPropertyString("Userpassword", "123456");  
      $this->RegisterPropertyString("User", "XXX");  
      $this->RegisterPropertyBoolean("Logging", false);  
      $this->RegisterPropertyBoolean("Modulaktiv", true);  
      $this->RegisterTimer("WIT_UpdateTimer", 0, 'WIT_Update($_IPS[\'TARGET\']);');
      $this->RegisterPropertyBoolean("BloodLogging", false);  
      $this->RegisterPropertyBoolean("BloodVisible", false);  
      $this->RegisterPropertyBoolean("BodyLogging" , false);  
      $this->RegisterPropertyBoolean("BodyVisible" , false);  
      }
    
    //**************************************************************************
    //
    //**************************************************************************    
		public function ApplyChanges()
		  {
			//Never delete this line!
			parent::ApplyChanges();
	    } 
?>
