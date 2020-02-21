<?php

include 'conn.php';

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];
$category_name = $_POST['category_name'];
$desc_id = $_POST['desc_id'];

try {
  $conn = $pdo->open();
  $stmt = $conn->prepare("UPDATE products SET name=:name, price=:price, date_view=:date, category_id=:category_id WHERE id=:id");
  $stmt->execute(['name' => $name, 'price' => $price, 'date' => date("Y-m-d"), 'category_id' => $category_id, 'id' => $id]);

  foreach (array_combine($description, $desc_id) as $data => $d_id) {
    $stmt1 = $conn->prepare("UPDATE descriptions SET description=:data WHERE id=:id");
    $stmt1->execute(['data' => $data, 'id' => $d_id]);
  }

  $description = implode("</br></br>", $description);
  $output['message'] = 'success';
  $output['code'] = '<tr>
                        <td>' . $name . '</td>
                        <td>$ ' . $price . '</td>
                        <td>' . $description . '</td>
                        <td>' . $category_name . '</td>
                        <td><button type="button" class="btn btn-default btn-flat p-0"><i class="fa fa-lg fa-pencil" id="edit" data-id="' . $id . '"></i></button></td>
                        <td><button type="button" class="btn btn-default btn-flat p-0"><i class="fa fa-lg fa-close" id="delete" data-id="' . $id . '" ></i></button></td>
                    </tr>';
} catch (PDOException $e) {
  $output['message'] = 'Incorrect data entered';
}
$pdo->close();

echo json_encode($output);
