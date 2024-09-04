<?php


require_once 'product.php';


try {
    $pdo = new PDO('mysql:host=localhost;dbname=draft_shop', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

// Requête pour récupérer le produit avec l'id 7 sous forme de tableau associatif
$stmt = $pdo->prepare('SELECT * FROM product WHERE id = :id');
$stmt->execute(['id' => 7]);
$productData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($productData) {
    //  instance de Product avec les données récupérées
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

    // Utiliser la méthode getCategory pour récupérer la catégorie associée
    $category = $product->getCategory($pdo);

    if ($category) {
        echo "<h2>Informations sur la catégorie associée</h2>";
        echo "<p><strong>ID :</strong> " . htmlspecialchars($category->getId()) . "</p>";
        echo "<p><strong>Nom :</strong> " . htmlspecialchars($category->getName()) . "</p>";
        echo "<p><strong>Description :</strong> " . htmlspecialchars($category->getDescription()) . "</p>";
        echo "<p><strong>Créé le :</strong> " . $category->getCreatedAt()->format('d/m/Y H:i:s') . "</p>";
        echo "<p><strong>Mis à jour le :</strong> " . $category->getUpdatedAt()->format('d/m/Y H:i:s') . "</p>";
    } else {
        echo "<p>Aucune catégorie trouvée pour ce produit.</p>";
    }
} else {
    echo "<p>Aucun produit trouvé avec l'id 7.</p>";
}

?>