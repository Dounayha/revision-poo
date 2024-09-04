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

$stmt = $pdo->prepare('SELECT * FROM category WHERE id = :id');
$stmt->execute(['id' => 1]);
$categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($categoryData) {
    $category = new Category(
        $categoryData['id'],
        $categoryData['name'],
        $categoryData['description'],
        new DateTime($categoryData['createdAt']),
        new DateTime($categoryData['updatedAt'])
    );

    $products = $category->getProducts($pdo);

    if (!empty($products)) {
        echo "<h2>Produits associés à la catégorie : " . htmlspecialchars($category->getName()) . "</h2>";
        foreach ($products as $product) {
            echo "<p><strong>Nom du produit :</strong> " . htmlspecialchars($product->getName()) . "</p>";
            echo "<p><strong>Description :</strong> " . htmlspecialchars($product->getDescription()) . "</p>";
            echo "<p><strong>Prix :</strong> " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €</p>";
            echo "<hr>";
        }
    } else {
        echo "<p>Aucun produit associé à cette catégorie.</p>";
    }
} else {
    echo "<p>Aucune catégorie trouvée avec cet ID.</p>";
}

?>