<?php

require_once 'product.php';

class Clothing extends Product {
    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;

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
        string $size = '',
        string $color = '',
        string $type = '',
        int $material_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id);
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }

    // Méthode pour insérer un vêtement dans la base de données
    public function create(PDO $pdo) {
        // Appelle la méthode create de la classe parente pour insérer dans Product
        parent::create($pdo);

        // Insère les détails spécifiques à Clothing
        $stmt = $pdo->prepare("
            INSERT INTO clothing (product_id, size, color, type, material_fee)
            VALUES (:product_id, :size, :color, :type, :material_fee)
        ");

        $stmt->execute([
            'product_id' => $this->getId(),
            'size' => $this->size,
            'color' => $this->color,
            'type' => $this->type,
            'material_fee' => $this->material_fee
        ]);
    }

    // Getters et Setters spécifiques à Clothing
    public function getSize(): string { return $this->size; }
    public function getColor(): string { return $this->color; }
    public function getType(): string { return $this->type; }
    public function getMaterialFee(): int { return $this->material_fee; }

    public function setSize(string $size): void { $this->size = $size; }
    public function setColor(string $color): void { $this->color = $color; }
    public function setType(string $type): void { $this->type = $type; }
    public function setMaterialFee(int $material_fee): void { $this->material_fee = $material_fee; }
}
?>
