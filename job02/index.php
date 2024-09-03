<?php


require_once 'product.php';
require_once 'category.php';


$product = new Product(
    1, 
    "Chaussures de sport", 
    ["photo1.jpg", "photo2.jpg"], 
    100, 
    "Des chaussures confortables pour le sport.", 
    50, 
    new DateTime('now'), 
    new DateTime('now')  
);

echo "<pre>";
var_dump($product);
echo "</pre>";

// Tester les getters
echo "<h2>Tests des getters :</h2>";
echo "ID : " . $product->getId() . "<br>";
echo "Nom : " . $product->getName() . "<br>";
echo "Prix : " . $product->getPrice() . "€<br>";
echo "Description : " . $product->getDescription() . "<br>";
echo "Quantité : " . $product->getQuantity() . "<br>";
echo "Créé le : " . $product->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
echo "Mis à jour le : " . $product->getUpdatedAt()->format('Y-m-d H:i:s') . "<br>";

// Modifier les propriétés avec les setters
$product->setName("Nouvelles chaussures de sport");
$product->setPrice(120);
$product->setQuantity(30);

// Vérifier les modifications avec var_dump() et les getters
echo "<h2>Après modifications avec les setters :</h2>";
echo "<pre>";
var_dump($product);
echo "</pre>";

echo "Nom modifié : " . $product->getName() . "<br>";
echo "Prix modifié : " . $product->getPrice() . "€<br>";
echo "Quantité modifiée : " . $product->getQuantity() . "<br>";
?>
