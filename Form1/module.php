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
        $txt = "<!DOCTYPE html>\n";
        fwrite($myfile, $txt);
        $txt = "<html lang=\"de\">\n";
        fwrite($myfile, $txt);
        $txt = "<body>\n";
        fwrite($myfile, $txt);
        $txt = "<table>\n";
        fwrite($myfile, $txt);
        $txt = "<tr>\n";
        fwrite($myfile, $txt);
        $txt = "<td>02</td><td>0a</td>\n";
        fwrite($myfile, $txt);
        $txt = "</tr>\n";
        fwrite($myfile, $txt);
        $txt = "</tabele>\n";
        fwrite($myfile, $txt);
        $txt = "</body>\n";
        fwrite($myfile, $txt);
        fclose($myfile);
        $Result = $NR + $NR;
        return json_encode($Result);
    }
    

}

/* @} */
