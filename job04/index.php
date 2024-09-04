<?php

require_once 'product.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

$stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
$stmt->execute(['id' => 7]);
$productData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($productData) {
    // * Hydrating
    $product = new Product(
        $productData['id'],
        $productData['name'],
        explode(',', $productData['photos']), 
        $productData['price'],
        $productData['description'],
        $productData['quantity'],
        new DateTime($productData['createdAt']),
        new DateTime($productData['updatedAt']),
        $productData['category_id']
    );

    echo "<p>L'ID de la catégorie associée au produit est : " . htmlspecialchars($product->getCategoryId()) . "</p>";
} else {
    echo "<p>Aucun produit trouvé avec l'id 7.</p>";
}

?>