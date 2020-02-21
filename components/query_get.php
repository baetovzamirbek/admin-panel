<?php

include 'conn.php';

$id = $_POST['id'];

try {
  $conn = $pdo->open();
  $stmt = $conn->prepare("SELECT products.id, products.name, category.id AS category_id, category.name AS cat_name , products.price, GROUP_CONCAT(descriptions.description), GROUP_CONCAT(descriptions.id)
                    FROM products
                    INNER JOIN category ON products.category_id = category.id
                    INNER JOIN descriptions ON descriptions.product_id = products.id 
                    WHERE products.id= :id
                    ");
  $stmt->execute(['id' => $id]);
  $stmt = $stmt->fetch();
  $output['name'] = $stmt['name'];
  $output['price'] = $stmt['price'];
  $output['description'] = explode(',', $stmt['GROUP_CONCAT(descriptions.description)']);
  $output['id'] = $id;
  $output['desc_id'] = explode(',', $stmt['GROUP_CONCAT(descriptions.id)']);
  $output['category_id'] = $stmt['category_id'];
} catch (PDOException $e) {
  $output['message'] = $e->getMessage();
}

$pdo->close();

echo json_encode($output);
