<?php

// Inclure la classe Product
require_once 'product.php';

// Créer une instance de Product
$product = new Product(
    1, // id
    "Chaussures de sport", // name
    ["photo1.jpg", "photo2.jpg"], // photos
    100, // price
    "Des chaussures confortables pour le sport.", // description
    50, // quantity
    new DateTime('now'), // createdAt
    new DateTime('now')  // updatedAt
);

// Utiliser var_dump() pour afficher les propriétés de l'objet
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
