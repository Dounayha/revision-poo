<?php

// Inclure les fichiers de classe
require_once 'category.php';
require_once 'product.php';

// Fonction pour rendre le var_dump plus propre
function prettyDump($variable, $label = '') {
    echo "<h3>$label</h3>";
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
}

// Création d'une catégorie
$category1 = new Category(1, "Vêtements", "Tous les types de vêtements", new DateTime(), new DateTime());

// Création d'un produit associé à la catégorie
$product1 = new Product(
    1,                          // id du produit
    "T-Shirt",                  // nom du produit
    ["photo1.jpg", "photo2.jpg"], // photos
    1000,                       // prix
    "Un t-shirt de qualité.",   // description
    10,                         // quantité
    new DateTime(),             // date de création
    new DateTime(),             // date de mise à jour
    $category1->getId()         // ID de la catégorie associée
);

// Affichage pour vérifier que tout fonctionne bien
prettyDump($product1->getId(), 'Product ID');
prettyDump($product1->getName(), 'Product Name');
prettyDump($product1->getPhotos(), 'Product Photos');
prettyDump($product1->getPrice(), 'Product Price');
prettyDump($product1->getDescription(), 'Product Description');
prettyDump($product1->getQuantity(), 'Product Quantity');
prettyDump($product1->getCreatedAt(), 'Product Created At');
prettyDump($product1->getUpdatedAt(), 'Product Updated At');
prettyDump($product1->getCategoryId(), 'Category ID Associated with Product');

// Modification des valeurs avec les setters
$product1->setName("T-Shirt Sale");
$product1->setPrice(1500);

// Vérification des modifications
prettyDump($product1->getName(), 'Updated Product Name');
prettyDump($product1->getPrice(), 'Updated Product Price');

?>