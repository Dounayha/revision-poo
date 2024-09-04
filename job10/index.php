<?php

require_once 'product.php';
require_once 'category.php'; 

// Connexion à la base de données
try {
    $pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

// Crée une instance de Product avec les informations du produit
$newProduct = new Product(
    0, // L'ID sera généré automatiquement par la base de données
    'Nouveau Produit', // Nom du produit
    ['image1.jpg', 'image2.jpg'], // Exemple de photos (tableau d'images)
    1500, // Prix en centimes ou selon ton modèle de données
    'Description du nouveau produit', // Description
    20, // Quantité disponible
    new DateTime(), // Date de création
    new DateTime(), // Date de mise à jour
    1 // ID de la catégorie associée
);

// Appelle la méthode create pour insérer le produit dans la base de données
$createdProduct = $newProduct->create($pdo);

if ($createdProduct) {
    // Affiche un message de succès avec l'ID du produit créé
    echo "Produit créé avec succès : ID = " . $createdProduct->getId();
} else {
    // Affiche un message d'erreur en cas d'échec
    echo "Échec de l'insertion du produit.";
}

?>
