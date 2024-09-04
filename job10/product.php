<?php

require_once 'category.php';

class Product {
    private int $id;
    private string $name;
    private array $photos;
    private int $price;
    private string $description;
    private int $quantity;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private int $category_id;

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        int $category_id = 0
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt ?: new DateTime();
        $this->updatedAt = $updatedAt ?: new DateTime();
        $this->category_id = $category_id;
    }

    // Méthode pour trouver tous les produits
    public static function findAll(PDO $pdo): array {
        $stmt = $pdo->prepare('SELECT * FROM product');
        $stmt->execute();
    
        $productDataList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $products = [];
    
        foreach ($productDataList as $productData) {
            $products[] = new Product(
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
        }
    
        return $products;
    }

    // Méthode pour récupérer la catégorie associée au produit
    public function getCategory(PDO $pdo): ?Category {
        $stmt = $pdo->prepare('SELECT * FROM category WHERE id = :id');
        $stmt->execute(['id' => $this->category_id]);
        $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($categoryData) {
            return new Category(
                $categoryData['id'],
                $categoryData['name'],
                $categoryData['description'],
                new DateTime($categoryData['createdAt']),
                new DateTime($categoryData['updatedAt'])
            );
        }
        
        return null;
    }

    // Méthode pour insérer un produit dans la base de données
    public function create(PDO $pdo) {
        $stmt = $pdo->prepare("
            INSERT INTO product (name, photos, price, description, quantity, createdAt, updatedAt, category_id)
            VALUES (:name, :photos, :price, :description, :quantity, :createdAt, :updatedAt, :category_id)
        ");
        
        $photos = json_encode($this->photos);

        $success = $stmt->execute([
            'name' => $this->name,
            'photos' => $photos,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'category_id' => $this->category_id
        ]);
        
        if ($success) {
            $this->id = $pdo->lastInsertId();
            return $this;
        } else {
            return false;
        }
    }

    // Méthode pour mettre à jour un produit dans la base de données
    public function update(PDO $pdo) {
        if ($this->id === 0) {
            return false; // Vérifie que le produit a un ID valide
        }

        $stmt = $pdo->prepare("
            UPDATE product SET 
                name = :name,
                photos = :photos,
                price = :price,
                description = :description,
                quantity = :quantity,
                updatedAt = :updatedAt,
                category_id = :category_id
            WHERE id = :id
        ");
        
        $photos = json_encode($this->photos);

        $success = $stmt->execute([
            'name' => $this->name,
            'photos' => $photos,
            'price' => $this->price,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
            'category_id' => $this->category_id,
            'id' => $this->id
        ]);

        return $success ? $this : false; // Retourne l'instance mise à jour si succès, sinon false
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPhotos(): array { return $this->photos; }
    public function getPrice(): int { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getQuantity(): int { return $this->quantity; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): DateTime { return $this->updatedAt; }
    public function getCategoryId(): int { return $this->category_id; }
}

?>
