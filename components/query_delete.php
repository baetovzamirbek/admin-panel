<?php

include 'conn.php';

$id = $_POST['id'];

try {
  $conn = $pdo->open();
  $stmt = $conn->prepare("DELETE descriptions
                    FROM products
                    INNER JOIN descriptions ON descriptions.product_id = products.id               
                    WHERE products.id= :id");
  $stmt->execute(['id' => $id]);
  $stmt1 = $conn->prepare("DELETE products FROM products WHERE id= :id");
  $stmt1->execute(['id' => $id]);
  $output['message'] = 'success';
  $output['empty'] = checkTableEmpty($conn);
} catch (PDOException $e) {
  $output['message'] = $e->getMessage();
}

function checkTableEmpty($conn)
{
  try {
    $check = $conn->prepare("SELECT * FROM products");
    $check->execute();
    $check = count($check->fetchAll());
    return $check;
  } catch (PDOException $e) {
  }
}

$pdo->close();

echo json_encode($output);
