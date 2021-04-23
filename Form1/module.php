<?php

declare(strict_types=1);


class FormularTest extends ipsmodule
{


    /**
     * Interne Funktion des SDK.
     */
    public function Create()
    {
        parent::Create();

        $this->RegisterPropertyString('Host', '');
        $this->RegisterPropertyString('Username', '');
        $this->RegisterPropertyString('Password', '');
        $this->RegisterPropertyString('Database', 'IPS');
        $this->RegisterPropertyString('Variables', json_encode([]));
        $this->RegisterTimer('LogData', 0, 'ACmySQL_LogData($_IPS[\'TARGET\']);');
        $this->Vars = [];
        $this->Buffer = [];
    }

    /**
     * Interne Funktion des SDK.
     */
    public function ApplyChanges()
    {
        parent::ApplyChanges();

    }

    /**
     * Interne Funktion des SDK.
     */
    public function GetConfigurationForm()
    {
        $form = json_decode(file_get_contents(__DIR__ . '/form.json'), true);

        $ConfigVars = json_decode($this->ReadPropertyString('Variables'), true);
 
        return json_encode($form);
    }
    
        /**
     * Interne Funktion des SDK.
     */
    public function FTest($NR)
    {
        $myfile = fopen("c:\\programdata\\symcon\\webfront\\user\\newfile.txt", "w") or die("Unable to open file!");
        $txt = "John Doe\n";
        fwrite($myfile, $txt);
        $txt = "Jane Doe\n";
        fwrite($myfile, $txt);
        fclose($myfile);
        $Result = $NR + $NR;
        return json_encode($Result);
    }
    

}

/* @} */
