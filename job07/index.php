<?php

require_once 'product.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

$product = new Product(0, '', [], 0, '', 0, new DateTime(), new DateTime(), 0);

$productInstance = $product->findOneById(4, $pdo);

if ($productInstance) {
    echo "<h2>Produit trouvé :</h2>";
    echo "<p><strong>Nom :</strong> " . htmlspecialchars($productInstance->getName()) . "</p>";
    echo "<p><strong>Description :</strong> " . htmlspecialchars($productInstance->getDescription()) . "</p>";
    echo "<p><strong>Prix :</strong> " . number_format($productInstance->getPrice() / 100, 2, ',', ' ') . " €</p>";
    echo "<p><strong>Quantité en stock :</strong> " . $productInstance->getQuantity() . "</p>";
    echo "<p><strong>Date de création :</strong> " . $productInstance->getCreatedAt()->format('d/m/Y H:i:s') . "</p>";
    echo "<p><strong>Date de mise à jour :</strong> " . $productInstance->getUpdatedAt()->format('d/m/Y H:i:s') . "</p>";
} else {
    echo "<p>Aucun produit trouvé avec l'ID 7.</p>";
}

?>