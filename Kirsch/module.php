<?php
// Klassendefinition
class BHKW extends IPSModule
{

    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create()
    {
        // Diese Zeile nicht löschen.
        parent::Create();

        if(!IPS_VariableProfileExists("Dierk")) {
            IPS_CreateVariableProfile("Dierk", 1);
        }
        //if(!IPS_VARIABLEPROFILEEXISTS("Kw")
        //{
        //    IPS_CreateVariableProfile("Kw",1);
        //}
        //$this->IPS_CreateVariableProfile("Dierk",1);
    }

    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges()
    {
        // Diese Zeile nicht löschen
        parent::ApplyChanges();
    }

    /**
     * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
     * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
     *
     * ABC_MeineErsteEigeneFunktion($id);
     *
     */
    public function MeineErsteEigeneFunktion()
    {
        // Selbsterstellter Code
    }
}
