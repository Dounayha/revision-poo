<?php

require_once 'product.php'; 
require_once 'category.php'; 

try {
    $pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

// ID du produit à récupérer et mettre à jour
$productId = 18; 


$stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
$stmt->execute(['id' => $productId]);
$productData = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si le produit existe
if ($productData) {
    // Créer une instance de Product à partir des données récupérées
    $product = new Product(
        $productData['id'],
        $productData['name'],
        json_decode($productData['photos'], true), // Convertir le JSON en tableau
        $productData['price'],
        $productData['description'],
        $productData['quantity'],
        new DateTime($productData['createdAt']),
        new DateTime($productData['updatedAt']),
        $productData['category_id']
    );

    // Modifier certaines propriétés du produit
    $product->setName('Nom mis à jour'); 
    $product->setPrice(1800); 
    $product->setDescription('BLABLA'); 
    $product->setQuantity(25); 
    $product->setPhotos(['updated_image1.jpg', 'updated_image2.jpg']); // Nouvelles photos
    $product->setUpdatedAt(new DateTime()); 

    // Appeler la méthode update pour mettre à jour le produit dans la base de données
    $updatedProduct = $product->update($pdo);

    // Vérification du succès de la mise à jour
    if ($updatedProduct) {
        echo "Produit mis à jour avec succès : ID = " . $updatedProduct->getId();
    } else {
        echo "Échec de la mise à jour du produit.";
    }
} else {
    echo "Produit avec l'ID $productId introuvable.";
}

?>
