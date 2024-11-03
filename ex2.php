<?php


interface Connectable
{
    public function connecter();
}


class BaseDeDonnees implements Connectable
{
    public function connecter()
    {
        echo "Connexion à la base de données\n"; 
    }
}


class Api implements Connectable
{
    public function connecter()
    {
        echo "Connexion à l'API\n";
    }
}


$connectables = [
    new BaseDeDonnees(),
    new Api()
];


foreach ($connectables as $connectable) {
    $connectable->connecter();
}
