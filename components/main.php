<?php

//fetchAll data from "ecommerce" database
try {
  $stmt = $conn->prepare("SELECT products.id, products.name, category.name AS cat_name , products.price, GROUP_CONCAT(descriptions.description SEPARATOR '</br></br>') AS descr
                                    FROM products
                                    LEFT JOIN category ON products.category_id = category.id
                                    LEFT JOIN descriptions ON products.id = descriptions.product_id
                                    GROUP BY products.id
                                    ");
  $stmt->execute();
  foreach ($stmt as $data) {  ?>

    <tbody id="qty_<?php echo $data['id']; ?>" class="desc_<?php echo $data['desc_id']; ?>">
      <tr>
        <td><?php echo $data['name'] ?></td>
        <td>$ <?php echo $data['price'] ?></td>
        <td><?php echo $data['descr'] ?></td>
        <td><?php echo $data['cat_name'] ?></td>
        <td><button type="button" class="btn btn-default btn-flat p-0"><i class="fa fa-lg fa-pencil" id="edit" data-id="<?php echo $data['id']; ?>"></i></button></td>
        <td><button type="button" class="btn btn-default btn-flat p-0"><i class="fa fa-lg fa-close" id="delete" data-id="<?php echo $data['id']; ?>"></i></button></td>
      </tr>

  <?php }
} catch (PDOException $e) {
  echo "<h5 class='p-4' style='color:red;'>Table doesn't exist</h5>";
}
