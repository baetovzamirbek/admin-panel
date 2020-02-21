<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <!-- Custom CSS -->
  <link href="components/style.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<!--connect to database -->
<?php include 'components/conn.php'; ?>
<?php $conn = $pdo->open(); ?>
<!--connect to script -->
<?php include 'components/scripts.php' ?>

<body>
  <!-- Main content -->
  <section>
    <div class="container">
      <div class="row ml-5">
        <h1>Product</h1>
        <h5 class="ml-3 pt-3">Control panel</h5>
      </div>
      <button type="button" class="btn btn-danger m-4" onclick="toggle()" id="changeButton">Add a Product</button>
      <div class="card p-3 mb-5" id="toggleCard" style="display: none;">
        <form action="">
          <div>
            <h5 class="text-center mt-3 mb-4" id="textProd">Add a new product</h5>
          </div>
          <div class="row mb-3">
            <label for="inputName" class="col-2">Name</label>
            <div class="col-10">
              <input type="text" class="form-control" id="inputName" placeholder="">
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputPrice" class="col-2">Price</label>
            <div class="col-10">
              <input type="number" class="form-control" id="inputPrice" placeholder="">
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputDescription" id="labelDescription" class="col-2">Description</label>
            <div class="col-10 text">
              <textarea class="form-control mb-3" id="inputDescription1" rows="1"></textarea>
            </div>
            <div id="plus">
              <i class="fa fa-sm fa-plus">
              </i>
              Add
            </div>
            <div id="clear">
              <i class="fa fa-sm fa-minus">
              </i>
              Remove
            </div>
          </div>
          <div class="row mb-3">
            <label for="inputCategory" class="col-2">Category</label>
            <div class="col-10">
              <select name="filter_col" id="form-control">

                <?php $pdo->showCategoryData(); ?>

              </select>
            </div>
          </div>
          <div class="row m-3">
            <div class="col">
              <button type="button" class="btn btn-success" id="save" data-id="0">Save Product</button>
              <button type="button" class="btn btn-primary" id="add">Add a new Product</button>
            </div>
          </div>
        </form>
      </div>

      <div class="card p-3">
        <table class="table table-bordered ">
          <thead>
            <th id="th_name">Name</th>
            <th id="th_price">Price</th>
            <th id="th_decription">Description</th>
            <th id="th_category">Category</th>
            <th id="th_icon"></th>
            <th id="th_icon"></th>
          </thead>

          <?php include 'components/main.php' ?>
          <!--close connection!-->
          <?php $pdo->close(); ?>


        </table>
      </div>
    </div>
  </section>
</body>

</html>