<?php

class Database
{

  /*
|--------------------------------------------------------------------------
| DATABASE CONFIGURATION
|--------------------------------------------------------------------------
 */
  private $server = "mysql:host=localhost;dbname=ecommerce";
  private $username = "root";
  private $password = "";
  private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
  protected $conn;

  public function open()
  {
    try {
      $this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
      return $this->conn;
    } catch (PDOException $e) {
      echo "<h3 class='text-center p-5' style='color:red'>Database doesn't exist, please create it.</h3>";
    }
  }

  public function showCategoryData()
  {
    try {
      $data = $this->open()->prepare("SELECT * FROM category");
      $data->execute();
      $data = $data->fetchAll();
      foreach ($data as $cat_data) {
        echo "<option value='" . $cat_data['id'] . "'>" . $cat_data['name'] . "</option>";
      }
    } catch (PDOException $e) {
      echo "category_error";
    }
  }

  public function close()
  {
    $this->conn = null;
  }
}

$pdo = new Database();
