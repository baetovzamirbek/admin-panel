<?php

include 'conn.php';

$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];
$category_name = $_POST['category_name'];

try {
  $conn = $pdo->open();
  $stmt = $conn->prepare("INSERT INTO products
                        (name, price, date_view, category_id) VALUES
                        (:name, :price, :date, :category_id)");
  $stmt->execute(['name' => $name, 'price' => $price, 'date' => date("Y-m-d"), 'category_id' => $category_id]);
  $last_id = $conn->lastInsertId(); //Get last inserted product id

  foreach ($description as $data) {
    $stmt1 = $conn->prepare("INSERT INTO descriptions 
                          (description, product_id) VALUES 
                          (:desc, :product_id)");
    $stmt1->execute(['desc' => $data, 'product_id' =>  $last_id]);
  }

  $description = implode("</br></br>", $description);
  $output['message'] = 'Item added to Database';
  $output['code'] = '<tbody id="qty_' . $last_id . '">
                      <tr>
                        <td>' . $name . '</td>
                        <td>$ ' . $price . '</td>
                        <td>' . $description . '</td>
                        <td>' . $category_name . '</td>
                        <td><button type="button" class="btn btn-default btn-flat p-0"><i class="fa fa-lg fa-pencil" id="edit" data-id="' . $last_id . '"></i></button></td>
                        <td><button type="button" class="btn btn-default btn-flat p-0"><i class="fa fa-lg fa-close" id="delete" data-id="' . $last_id . '" ></i></button></td>
                      </tr>
                    </tbody>';
} catch (PDOException $e) {
  $output['message'] = 'Incorrect data entered:' . $e->getMessage();
}

$pdo->close();

echo json_encode($output);
