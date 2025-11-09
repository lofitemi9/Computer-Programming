<?php
class OrderSaver
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(array $post): int
    {
        $customer   = trim($post['customer_name'] ?? $post['name'] ?? '');
        $phone      = trim($post['phone'] ?? '');
        $email      = trim($post['email'] ?? '');
        $size       = trim($post['size'] ?? '');
        $crust      = trim($post['crust'] ?? '');
        $quantity   = max(1, (int)($post['quantity'] ?? 1));
        $notes      = trim($post['special_notes'] ?? $post['notes'] ?? '');
        $total      = (float)($post['total_price'] ?? 0);

        $toppings_text = null;
        if (isset($post['toppings'])) {
            if (is_array($post['toppings'])) {
                $toppings_text = implode(', ', array_map('strval', $post['toppings']));
            } else {
                $toppings_text = (string)$post['toppings'];
            }
        }

        $raw_json = json_encode($post, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $sql = 'INSERT INTO orders
                (customer_name, phone, email, size, crust, toppings_text, quantity, special_notes, total_price, raw_payload)
                VALUES
                (:customer_name, :phone, :email, :size, :crust, :toppings_text, :quantity, :special_notes, :total_price, CAST(:raw_payload AS JSON))';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':customer_name' => $customer,
            ':phone'         => $phone,
            ':email'         => $email,
            ':size'          => $size,
            ':crust'         => $crust,
            ':toppings_text' => $toppings_text,
            ':quantity'      => $quantity,
            ':special_notes' => $notes,
            ':total_price'   => $total,
            ':raw_payload'   => $raw_json,
        ]);

        return (int)$this->pdo->lastInsertId();
    }
}
