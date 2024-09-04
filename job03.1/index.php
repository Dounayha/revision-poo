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

// Instanciation sans paramètres
$category = new Category();
$product1 = new Product();

// Instanciation avec quelques paramètres
$product2 = new Product(name: "T-Shirt", price: 1000);

// Vérification
prettyDump($category, 'Empty Category');
prettyDump($product1, 'Empty Product');
prettyDump($product2, 'Partially Filled Product');

// Création d'une catégorie avec tous les paramètres
$category1 = new Category(1, "Vêtements", "Tous les types de vêtements", new DateTime(), new DateTime());

// Création d'un produit associé à la catégorie
$product3 = new Product(
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
prettyDump($product3->getId(), 'Product ID');
prettyDump($product3->getName(), 'Product Name');
prettyDump($product3->getPhotos(), 'Product Photos');
prettyDump($product3->getPrice(), 'Product Price');
prettyDump($product3->getDescription(), 'Product Description');
prettyDump($product3->getQuantity(), 'Product Quantity');
prettyDump($product3->getCreatedAt(), 'Product Created At');
prettyDump($product3->getUpdatedAt(), 'Product Updated At');
prettyDump($product3->getCategoryId(), 'Category ID Associated with Product');

// Modification des valeurs avec les setters
$product3->setName("T-Shirt Sale");
$product3->setPrice(1500);

// Vérification des modifications
prettyDump($product3->getName(), 'Updated Product Name');
prettyDump($product3->getPrice(), 'Updated Product Price');

?>