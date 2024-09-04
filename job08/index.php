<?php

require_once 'product.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

$products = Product::findAll($pdo);

if (!empty($products)) {
    echo "<h2>Liste des produits :</h2>";
    foreach ($products as $product) {
        echo "<p><strong>Nom :</strong> " . htmlspecialchars($product->getName()) . "</p>";
        echo "<p><strong>Description :</strong> " . htmlspecialchars($product->getDescription()) . "</p>";
        echo "<p><strong>Prix :</strong> " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €</p>";
        echo "<p><strong>Quantité en stock :</strong> " . $product->getQuantity() . "</p>";
        echo "<p><strong>Date de création :</strong> " . $product->getCreatedAt()->format('d/m/Y H:i:s') . "</p>";
        echo "<p><strong>Date de mise à jour :</strong> " . $product->getUpdatedAt()->format('d/m/Y H:i:s') . "</p>";
        echo "<hr>";
    }
} else {
    echo "<p>Aucun produit trouvé.</p>";
}

?>