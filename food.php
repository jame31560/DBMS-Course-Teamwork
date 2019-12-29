<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> YuntechEat </title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+TC&display=swap" rel="stylesheet">
  <style>
  body {
    font-family: 'Noto Sans TC', sans-serif;
  }
  </style>
</head>

<body>
  <div class="container">
    <?php include("config.php"); ?>
    <?php
    $hasMsg = isset($_GET["msg"]);
    $isQuery = isset($_GET["query"]);
    $isEdit = isset($_GET["edit"]);
    $isCreate = isset($_GET["create"]);
    if ($isEdit) {
      $editID = explode(",", $_GET["edit"]);
      $editRestaurantID = (int)$editID[0];
      $editFoodID = (int)$editID[1];
    }
    $isUpdate = isset($_GET["update"]);
    if ($isUpdate) {
      $updateID = explode(",", $_GET["update"]);
      $updateRestaurantID = (int)$updateID[0];
      $updateFoodID = (int)$updateID[1];
      $foodName = $_GET["foodName"]; // update this on where
      $price = $_GET["price"];
      $imageURL = $_GET["imageURL"];
      $description = $_GET["description"];  
      // update code in here;
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(
        header("Location: food.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:"")));
      $sql = "UPDATE `food`
              SET `name` = '".$foodName."', `price` = '".$price."', `imageURL` = '".$imageURL."',
                  `description` = '".$description."'
              WHERE restaurantID = ".$updateRestaurantID." AND foodID = ".$updateFoodID.";";
      mysqli_set_charset($link, "utf8");
      try{
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
      }catch(Exception $e){
        header("Location: food.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      }
      mysqli_close($link);
      header("Location: food.php?msg=0".(($isQuery)?"&query=".$_GET["query"]:""));
    }
    $isDelete = isset($_GET["delete"]);
    if ($isDelete) {
      $deleteID = explode(",", $_GET["delete"]);
      $deleteRestaurantID = (int)$deleteID[0];
      $deleteFoodID = (int)$deleteID[1];
      // delete code in here
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(
        header("Location: food.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:""))); 
      mysqli_set_charset($link, "utf8");
      $sql = "DELETE FROM food WHERE restaurantID = ".$deleteRestaurantID." AND foodID = ".$deleteFoodID.";";
      try{
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
      }catch(Exception $e){
        header("Location: food.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      } 
      header("Location: food.php?msg=1".(($isQuery)?"&query=".$_GET["query"]:""));
    }
    $isCreate = isset($_GET["create"]);
    if ($isCreate) {
      $restaurant = $_GET["restaurantAdd"];
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(
        header("Location: food.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:"")));
      mysqli_set_charset($link, "utf8");
      $sql = 'SELECT MAX(foodID) AS foodID FROM `food` WHERE restaurantID = '.$restaurant.' GROUP BY restaurantID';
      try{
        $result = mysqli_query($link, $sql);
      }catch(Exception $e){
        header("Location: food.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      }
      $foodID = (int)mysqli_fetch_assoc($result)["foodID"] + 1;
      $foodName = $_GET["foodNameAdd"];
      $price = $_GET["priceAdd"];
      $imageURL = $_GET["imageURLAdd"];
      $description = $_GET["descriptionAdd"];
      // create code in here;
      $sql = "INSERT INTO food VALUES(
        '".$restaurant."','".$foodID."','".$foodName."','".$price."','".$imageURL."','".$description."');";
      try{
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
      }catch(Exception $e){
        header("Location: food.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      } 
      header("Location: food.php?msg=2".(($isQuery)?"&query=".$_GET["query"]:""));
    }
  ?>
    <h1 class="text-center mt-2">YuntechEat 食物管理頁面</h1>
    <hr>
    <?php
      if ($hasMsg) {
        $msg = "";
        switch ($_GET["msg"]) {
          case 0:
            $msg = "編輯成功";
            echo '<div class="alert alert-success" style="width: 100%;" role="alert">
                '.$msg.'
              </div>';
            break;
          case 1:
            $msg = "刪除成功";
            echo '<div class="alert alert-success" style="width: 100%;" role="alert">
                '.$msg.'
              </div>';
            break;
          case 2:
            $msg = "新增成功";
            echo '<div class="alert alert-success" style="width: 100%;" role="alert">
                '.$msg.'
              </div>';
            break;
          case -1:
            $msg = "錯誤操作";
            echo '<div class="alert alert-danger" style="width: 100%;" role="alert">
                '.$msg.'
              </div>';
            break;
          case -2:
            $msg = "無法連接資料庫";
            echo '<div class="alert alert-danger" style="width: 100%;" role="alert">
                '.$msg.'
              </div>';
            break;
          default:
            # code...
            break;
        }
        
      }
    ?>
    <form class="form-inline" action="food.php" method="GET">
      <div class="form-group mx-sm-3 mb-2">
        <label for="inputquery" class="sr-only">Account</label>
        <input name="query" type="text" class="form-control" id="inputquery" placeholder="餐點名稱" required
               value="<?php echo (($isQuery)?$_GET["query"]:"") ?>">
      </div>
      <button type="submit" class="btn btn-primary mb-2 mr-2">查詢</button>
      <?php 
      if ($isQuery) {
        echo '<button type="reset" class="btn btn-secondary mb-2 mr-2" onClick="document.location=\'food.php\';">取消查詢</button>';
      } 
    ?>
    </form>

    <form class="form-inline" action="food.php" method="GET">
      <?php
        if ($isQuery) {
          echo '<input name="query" type="text" class="form-control d-none" value="'.$_GET["query"].'">';
        }
      ?>

      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th class="align-middle text-center" scope="col">#</th>
            <th class="align-middle text-center" scope="col">餐廳</th>
            <th class="align-middle text-center" scope="col">餐廳電話</th>
            <th class="align-middle text-center" scope="col">編號</th>
            <th class="align-middle text-center" scope="col">餐點</th>
            <th class="align-middle text-center" scope="col">價格</th>
            <th class="align-middle text-center" scope="col">圖片</th>
            <th class="align-middle text-center" scope="col">敘述</th>
            <th class="align-middle text-center" scope="col">編輯</th>
            <th class="align-middle text-center" scope="col">刪除</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die("連線失敗!<br>");
            if ($isQuery) {
              $sql = "SELECT a.restaurantID AS restaurantID,
                             a.foodID AS foodID,
                             a.name AS foodName,
                             a.price AS price,
                             a.imageURL AS imageURL,
                             a.description AS description,
                             b.name AS restaurantName,
                             b.tel AS tel
                      FROM food AS a
                      JOIN restaurant AS b
                      ON a.restaurantID = b.restaurantID
                      WHERE a.name LIKE '%".$_GET["query"]."%'
                      ORDER BY a.restaurantID ASC, a.foodID ASC;";
            } else {
              $sql = "SELECT a.restaurantID AS restaurantID,
                             a.foodID AS foodID,
                             a.name AS foodName,
                             a.price AS price,
                             a.imageURL AS imageURL,
                             a.description AS description,
                             b.name AS restaurantName,
                             b.tel AS tel
                      FROM food AS a
                      JOIN restaurant AS b
                      ON a.restaurantID = b.restaurantID
                      ORDER BY a.restaurantID ASC, a.foodID ASC;";
            }
            mysqli_set_charset($link, "utf8");
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0) {
              echo '<tr><td class="align-middle text-center" colspan="10">查無結果</td></tr>';  //欄位數
            } else {
              $count = 0;
              while($row = mysqli_fetch_assoc($result)) {
                $count += 1;
                if ($isEdit && $editRestaurantID == $row["restaurantID"] && $editFoodID == $row["foodID"]) {
                  //編輯中
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$count.'</th>
                    <td class="align-middle text-center">'.$row["restaurantName"].'</td>
                    <td class="align-middle text-center">'.$row["tel"].'</td>
                    <td class="align-middle text-center">'.$row["foodID"].'</td>
                    <td class="align-middle text-center">
                      <input name="foodName" type="text" class="form-control form-control-sm" style="width: 120px;" value="'.$row["foodName"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="price" type="number" class="form-control form-control-sm" style="width: 70px;" min="0" value="'.$row["price"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="imageURL" type="text" class="form-control form-control-sm" style="width: 120px;" value="'.$row["imageURL"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="description" type="text" class="form-control form-control-sm" style="width: 160px;" value="'.$row["description"].'">
                    </td>
                    <td class="align-middle text-center" colspan="2">
                      <button class="btn btn-success btn-sm btn-block" type="submit" name="update" value="'.$row["restaurantID"].','.$row["foodID"].'">
                        送出
                      </button>
                    </td>
                  </tr>';
                } else {
                  //一般資訊
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$count.'</th>
                    <td class="align-middle text-center">'.$row["restaurantName"].'</td>
                    <td class="align-middle text-center">'.$row["tel"].'</td>
                    <td class="align-middle text-center">'.$row["foodID"].'</td>
                    <td class="align-middle text-center">'.$row["foodName"].'</td>
                    <td class="align-middle text-center">'.$row["price"].'</td>
                    <td class="align-middle text-center">'.$row["imageURL"].'</td>
                    <td class="align-middle text-center">'.$row["description"].'</td>
                    <td class="align-middle text-center">
                      <button class="btn btn-warning btn-sm btn-block" type="submit" name="edit" value="'.$row["restaurantID"].','.$row["foodID"].'">
                        編輯
                      </button>
                    </td>
                    <td class="align-middle text-center">
                      <button class="btn btn-danger btn-sm btn-block" type="submit" name="delete" value="'.$row["restaurantID"].','.$row["foodID"].'">
                        刪除
                      </button>
                    </td>
                  </tr>';
                }
              }
            }
          ?>
          <tr>
            <!-- 新增欄位 -->
            <th class="align-middle text-center" scope="row">+</th>
            <td class="align-middle text-center">
              <select class="form-control form-control-sm" name="restaurantAdd">
                <?php
                  $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD, "deliverysystem") or die(
                    "連線失敗!<br>");
                    $sql = "SELECT restaurantID, `name` FROM restaurant ORDER BY restaurantID ASC;";
                  mysqli_set_charset($link, "utf8");
                  $result = mysqli_query($link, $sql);
                  $count = 0;
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row["restaurantID"].'">'.$row["name"].'</option>';
                  }
                ?>
              </select>
            </td>
            <td class="align-middle text-center"></td>
            <td class="align-middle text-center"></td>
            <td class="align-middle text-center">
              <input name="foodNameAdd" type="text" class="form-control form-control-sm" style="width: 120px;">
            </td>
            <td class="align-middle text-center">
              <input name="priceAdd" type="number" class="form-control form-control-sm" min="0" style="width: 70px;">
            </td>
            <td class="align-middle text-center">
              <input name="imageURLAdd" type="text" class="form-control form-control-sm" style="width: 120px;">
            </td>
            <td class="align-middle text-center">
              <input name="descriptionAdd" type="text" class="form-control form-control-sm" style="width: 160px;">
            </td>
            <td class="align-middle text-center" colspan="2">
              <button class="btn btn-info btn-sm btn-block" type="submit" name="create">
                新增
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </form>
    <hr>
    <form action="index.html" method="get" class="text-center">
      <button type="submit" class="btn btn-dark btn-lg">回主選單</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
  </div>
</body>

</html>