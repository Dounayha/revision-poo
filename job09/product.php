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
                new DateTime($categoryData['UpdatedAt'])
            );
        }
        
        return null;
    }

    public function create(PDO $pdo) {
        // Prépare la requête SQL d'insertion
        $stmt = $pdo->prepare("
            INSERT INTO product (name, photos, price, description, quantity, createdAt, updatedAt, category_id)
            VALUES (:name, :photos, :price, :description, :quantity, :createdAt, :updatedAt, :category_id)
        ");
        
        // Convertit les photos en JSON
        $photos = json_encode($this->photos);

        // Exécute la requête avec les données de l'objet courant
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

        // Si l'insertion a réussi, met à jour l'ID de l'objet avec l'ID généré
        if ($success) {
            $this->id = (int) $pdo->lastInsertId();
            return $this; // Retourne l'instance de Product avec l'ID mis à jour
        } else {
            return false; // Retourne false si l'insertion échoue
        }
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
