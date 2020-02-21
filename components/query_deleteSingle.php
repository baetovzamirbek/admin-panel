<?php
include 'conn.php';

$desc_id = $_POST['desc_id'];

try {
  $conn = $pdo->open();
  $stmt = $conn->prepare("DELETE FROM product_description WHERE product_description.id= :id");
  $stmt->execute(['id' => $desc_id]);
  $output['message'] = 'success';
} catch (PDOException $e) {
  $output['message'] = $e->getMessage();
}

$pdo->close();
echo json_encode($output);
