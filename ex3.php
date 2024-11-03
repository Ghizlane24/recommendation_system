<?php


trait Logger
{
    public function logInfo($message)
    {
        echo "INFO: " . $message . "\n"; 
    }

    public function logError($message)
    {
        echo "ERROR: " . $message . "\n"; 
    }
}


class FichierLogger
{
    use Logger;

    public function enregistrerDansFichier($message)
    {
        echo "Enregistrement dans le fichier : " . $message . "\n"; 
    }
}


class ConsoleLogger
{
    use Logger;

    public function enregistrerDansConsole($message)
    {
        echo "Affichage dans la console : " . $message . "\n"; 
    }
}


$fichierLogger = new FichierLogger();
$consoleLogger = new ConsoleLogger();


$fichierLogger->logInfo("Ceci est un message d'information pour le fichier.");
$fichierLogger->logError("Ceci est un message d'erreur pour le fichier.");
$consoleLogger->logInfo("Ceci est un message d'information pour la console.");
$consoleLogger->logError("Ceci est un message d'erreur pour la console.");


$fichierLogger->enregistrerDansFichier("Message spécifique au fichier.");
$consoleLogger->enregistrerDansConsole("Message spécifique à la console.");
