<?php


interface Calculable
{
    public function calculer($a, $b);
}


class Addition implements Calculable
{
    public function calculer($a, $b)
    {
        return $a + $b; 
    }
}

class Multiplication implements Calculable
{
    public function calculer($a, $b)
    {
        return $a * $b; 
    }
}


$addition = new Addition();
$multiplication = new Multiplication();



$resultatAddition = $addition->calculer(5, 10);
$resultatMultiplication = $multiplication->calculer(5, 10);

echo "La somme de 5 et 10 est : " . $resultatAddition . "\n"; 
echo "Le produit de 5 et 10 est : " . $resultatMultiplication . "\n"; 