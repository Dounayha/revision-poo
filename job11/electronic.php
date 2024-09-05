<?php

require_once 'product.php';

class Electronic extends Product {
    private string $brand;
    private int $warranty_fee;

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        int $category_id = 0,
        string $brand = '',
        int $warranty_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id);
        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
    }

    // Méthode pour insérer un produit électronique dans la base de données
    public function create(PDO $pdo) {
        // Appelle la méthode create de la classe parente pour insérer dans Product
        parent::create($pdo);

        // Insère les détails spécifiques à Electronic
        $stmt = $pdo->prepare("
            INSERT INTO electronic (product_id, brand, warranty_fee)
            VALUES (:product_id, :brand, :warranty_fee)
        ");

        $stmt->execute([
            'product_id' => $this->getId(),
            'brand' => $this->brand,
            'warranty_fee' => $this->warranty_fee
        ]);
    }

    // Getters et Setters spécifiques à Electronic
    public function getBrand(): string { return $this->brand; }
    public function getWarrantyFee(): int { return $this->warranty_fee; }

    public function setBrand(string $brand): void { $this->brand = $brand; }
    public function setWarrantyFee(int $warranty_fee): void { $this->warranty_fee = $warranty_fee; }
}
?>
