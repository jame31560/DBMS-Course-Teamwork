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
      $editID = $_GET["edit"];
    }
    $isUpdate = isset($_GET["update"]);
    if ($isUpdate) {
      $restaurantID = $_GET["update"]; // update this on where
      $name = $_GET["name"];
      $tel = $_GET["tel"];
      $address = $_GET["address"];
      // update code in here;
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(header("Location: restaurant.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:"")));
      $sql = "UPDATE restaurant SET name = '".$name."' , tel = '".$tel."' , address = '".$address."' WHERE restaurantID = '".$restaurantID."'";
      // $sql = "SELECT * FROM member";
      mysqli_set_charset($link, "utf8");
      try{
        mysqli_query($link, $sql);
      }catch(Exception $e){
        header("Location: restaurant.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      }
      mysqli_close($link);
      header("Location: restaurant.php?msg=0".(($isQuery)?"&query=".$_GET["query"]:""));
    }
    $isDelete = isset($_GET["delete"]);
    if ($isDelete) {
      $restaurantID = $_GET["delete"];
      // delete code in here
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(header("Location: restaurant.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:""))); 
      $sql = "DELETE FROM restaurant WHERE restaurantID = '".$restaurantID."'";
      try{
        mysqli_query($link, $sql);
      }catch(Exception $e){
        header("Location: restaurant.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      } 
      header("Location: restaurant.php?msg=1".(($isQuery)?"&query=".$_GET["query"]:""));
    }
    $isCreate = isset($_GET["create"]);
    if ($isCreate) {
      $name = $_GET["nameAdd"];
      $tel = $_GET["telAdd"];
      $address = $_GET["addressAdd"];
      // create code in here;
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(header("Location: restaurant.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:""))); 
      $sql = "INSERT INTO restaurant VALUES(NULL,'".$name."','".$tel."','".$address."')";
      try{
        mysqli_query($link, $sql);
      }catch(Exception $e){
        header("Location: restaurant.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      } 
      header("Location: restaurant.php?msg=2".(($isQuery)?"&query=".$_GET["query"]:""));
    }
  ?>
    <h1 class="text-center mt-2">YuntechEat 餐廳管理頁面</h1>
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
    <form class="form-inline" action="restaurant.php" method="GET">
      <div class="form-group mx-sm-3 mb-2">
        <label for="inputquery" class="sr-only">Account</label>
        <input name="query" type="text" class="form-control" id="inputquery" placeholder="餐廳名稱" required
               value="<?php echo (($isQuery)?$_GET["query"]:"") ?>">
      </div>
      <button type="submit" class="btn btn-primary mb-2 mr-2">查詢</button>
      <?php 
      if ($isQuery) {
        echo '<button type="reset" class="btn btn-secondary mb-2 mr-2" onClick="document.location=\'restaurant.php\';">取消查詢</button>';
      } 
    ?>
    </form>

    <form class="form-inline" action="restaurant.php" method="GET">
      <?php
        if ($isQuery) {
          echo '<input name="query" type="text" class="form-control d-none" value="'.$_GET["query"].'">';
        }
      ?>

      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th class="align-middle text-center" scope="col">#</th>
            <th class="align-middle text-center" scope="col">餐廳名稱</th>
            <th class="align-middle text-center" scope="col">餐廳電話</th>
            <th class="align-middle text-center" scope="col">編號</th>
            <th class="align-middle text-center" scope="col">名稱</th>
            <th class="align-middle text-center" scope="col">價格</th>
            <th class="align-middle text-center" scope="col">圖片網址</th>
            <th class="align-middle text-center" scope="col">敘述</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die("連線失敗!<br>");
            if ($isQuery) {
              $sql = "SELECT * FROM restaurant WHERE name LIKE '%".$_GET["query"]."%'";
            } else {
              $sql = "SELECT * FROM restaurant";
            }
            mysqli_set_charset($link, "utf8");
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0) {
              echo '<tr><td class="align-middle text-center" colspan="6">查無結果</td></tr>';  //欄位數
            } else {
              while($row = mysqli_fetch_assoc($result)) {
                if ($isEdit && $editID == $row["restaurantID"]) {
                  //編輯中
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$row["restaurantID"].'</th>
                    <td class="align-middle text-center">
                      <input name="name" type="text" class="form-control form-control-sm" style="width: 120px;" value="'.$row["name"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="tel" type="text" class="form-control form-control-sm" style="width: 120px;" value="'.$row["tel"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="address" type="text" class="form-control form-control-sm" style="width: 480px;" value="'.$row["address"].'">
                    </td>
                    <td class="align-middle text-center" colspan="2">
                      <button class="btn btn-success btn-sm btn-block" type="submit" name="update" value="'.$row["restaurantID"].'">
                        送出
                      </button>
                    </td>
                  </tr>';
                } else {
                  //一般資訊
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$row["restaurantID"].'</th>
                    <td class="align-middle text-center">'.$row["name"].'</td>
                    <td class="align-middle text-center">'.$row["tel"].'</td>
                    <td class="align-middle text-center">'.$row["address"].'</td>
                    <td class="align-middle text-center">
                      <button class="btn btn-warning btn-sm btn-block" type="submit" name="edit" value="'.$row["restaurantID"].'">
                        編輯
                      </button>
                    </td>
                    <td class="align-middle text-center">
                      <button class="btn btn-danger btn-sm btn-block" type="submit" name="delete" value="'.$row["restaurantID"].'">
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
              <input name="nameAdd" type="text" class="form-control form-control-sm" style="width: 120px;">
            </td>
            <td class="align-middle text-center">
              <input name="telAdd" type="text" class="form-control form-control-sm" style="width: 120px;">
            </td>
            <td class="align-middle text-center">
              <input name="addressAdd" type="text" class="form-control form-control-sm" style="width: 480px;">
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