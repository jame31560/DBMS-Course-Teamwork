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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script>
  $(document).ready(function() {
    $('#myDropDown').change(function() {
      //Selected value
      var inputValue = $(this).val();
      document.location.href = "order.php?rest=" + inputValue + "<?php
        echo ((isset($_GET["query"]))?"&query=".$_GET["query"]:"").((isset($_GET["check"]))?"&check=".$_GET["check"]:"") 
      ?>";
    });
  });
  </script>
</head>

<body>
  <div class="container">
    <?php include("config.php"); ?>
    <?php
    $hasMsg = isset($_GET["msg"]);
    $isQuery = isset($_GET["query"]);
    $isEditDetail = isset($_GET["editDetail"]);
    $isCheck = isset($_GET["check"]);
    if ($isEditDetail) {
      $editID = $_GET["editDetail"];
      $editID = explode(",", $_GET["editDetail"]);
      $editRestaurantID = (int)$editID[0];
      $editFoodID = (int)$editID[1];
    }
    if ($isCheck) {
      $checkID = $_GET["check"];
    }
    $isUpdateDetail = isset($_GET["updateDetail"]);
    if ($isUpdateDetail) {
      $updateDetailID = $_GET["updateDetail"];
      $updateDetailID = explode(",", $_GET["updateDetail"]);
      $updateRestaurantID = (int)$updateDetailID[0];
      $updateFoodID = (int)$updateDetailID[1];
      $orderID = $_GET["check"];
      $foodCount = $_GET["foodCount"];
      // update code in here;
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(
        header("Location: order.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:"")));
      $sql = "UPDATE orderdetail SET foodCount = '".$foodCount."' WHERE restaurantID = '".$updateRestaurantID."' AND orderID = '".$orderID."' and foodID = '".$updateFoodID."';";
      // $sql = "SELECT * FROM member";
      mysqli_set_charset($link, "utf8");
      try{
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
      }catch(Exception $e){
        header("Location: order.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""));
      }
      mysqli_close($link);
      header("Location: order.php?msg=0".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""));
    }
    $isDeleteOrder = isset($_GET["deleteOrder"]);
    if ($isDeleteOrder) {
      $orderID = $_GET["deleteOrder"];
      // delete code in here
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(
        header("Location: order.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:""))); 
      try{
        $sql = "DELETE FROM orderdetail WHERE orderID = '".$orderID."';";
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
        $sql = "DELETE FROM orderhistory WHERE orderID = '".$orderID."';";
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
      }catch(Exception $e){
        header("Location: order.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      } 
      header("Location: order.php?msg=1".(($isQuery)?"&query=".$_GET["query"]:""));
    }
    $isCreate = isset($_GET["create"]);
    if ($isCreate) {
      $member = $_GET["memberAdd"];
      $staff = $_GET["staffAdd"];
      // create code in here;
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(
        header("Location: order.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""))); 
      $sql = "INSERT INTO `orderhistory` (`memberID`, `deliveryStaffID`) VALUES ('".$member."','".$staff."');";
      echo $sql;
      try{
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
      }catch(Exception $e){
        header("Location: order.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""));
      } 
      header("Location: order.php?msg=2".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""));
    }
    $isAddDetail = isset($_GET["addDetail"]);
    if ($isAddDetail) {
      $addRestaurantID = $_GET["detailAddRest"];
      $addFoodID = $_GET["detailAddFood"];
      $addFoodCount = $_GET["detailAddFoodCount"];
      $addOrderID = $_GET["check"];
      // create code in here;
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(
        header("Location: order.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""))); 
      $sql = "INSERT INTO `orderdetail` (`orderID`, `restaurantID`, `foodID`, `foodCount`) VALUES ('".$addOrderID."','".$addRestaurantID."','".$addFoodID."','".$addFoodCount."');";
      echo $sql;
      try{
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
      }catch(Exception $e){
        header("Location: order.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""));
      } 
      header("Location: order.php?msg=2".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""));
    }
    $isDeleteDetail = isset($_GET["deleteDetail"]);
    if ($isDeleteDetail) {
      $orderID = $_GET["check"];
      $deleteID = explode(",", $_GET["deleteDetail"]);
      $deleteRestaurantID = (int)$deleteID[0];
      $deleteFoodID = (int)$deleteID[1];
      // delete code in here
      $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die(
        header("Location: order.php?msg=-2".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""))); 
      try{
        $sql = "DELETE FROM orderdetail WHERE orderID = '".$orderID."' and restaurantID = '".$deleteRestaurantID."' and foodID = '".$deleteFoodID."';";
        if(!mysqli_query($link, $sql)) {
          throw new Exception("Error Processing Request", 1);
        }
      }catch(Exception $e){
        header("Location: order.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""));
      } 
      header("Location: order.php?msg=1".(($isQuery)?"&query=".$_GET["query"]:"").(($isCheck)?"&check=".$_GET["check"]:""));
    }
  ?>
    <h1 class="text-center mt-2">YuntechEat 購買紀錄管理頁面</h1>
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
    <form class="form-inline" action="order.php" method="GET">
      <div class="form-group mx-sm-3 mb-2">
        <label for="inputquery" class="sr-only">Account</label>
        <input name="query" type="text" class="form-control" id="inputquery" placeholder="訂單編號" required
               value="<?php echo (($isQuery)?$_GET["query"]:"") ?>">
      </div>
      <button type="submit" class="btn btn-primary mb-2 mr-2">查詢</button>
      <?php 
      if ($isQuery) {
        echo '<button type="reset" class="btn btn-secondary mb-2 mr-2" onClick="document.location=\'order.php\';">取消查詢</button>';
      } 
    ?>
    </form>

    <form class="form-inline" action="order.php" method="GET">
      <?php
        if ($isQuery) {
          echo '<input name="query" type="text" class="form-control d-none" value="'.$_GET["query"].'">';
        }
        if ($isCheck) {
          echo '<input name="check" type="text" class="form-control d-none" value="'.$_GET["check"].'">';
        }
      ?>

      <table class="table table-hover table-sm">
        <thead>
          <tr>
            <th class="align-middle text-center" scope="col">訂單編號</th>
            <th class="align-middle text-center" scope="col">會員姓名</th>
            <th class="align-middle text-center" scope="col">外送員姓名</th>
            <th class="align-middle text-center" scope="col">成立時間</th>
            <th class="align-middle text-center" scope="col">抵達</th>
            <th class="align-middle text-center" scope="col">查看</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD,"deliverysystem") or die("連線失敗!<br>");
            if ($isQuery) {
              $sql = "SELECT a.orderID, a.memberID, b.name AS memberName,
                             a.deliveryStaffID, a.staffName, a.creationDatetime, a.arrived FROM (
                        SELECT a.orderID, a.memberID, a.deliveryStaffID, b.name AS staffName,
                               a.creationDatetime, a.arrived
                        FROM `orderhistory` AS a
                        LEFT JOIN deliveryStaff AS b
                        ON a.deliveryStaffID = b.deliveryStaffID) AS a
                      LEFT JOIN member AS b
                      ON a.memberID = b.memberID
                      WHERE a.orderID = ".$_GET["query"]." ORDER BY orderID ASC;";
            } else {
              $sql = "SELECT a.orderID, a.memberID, b.name AS memberName,
                              a.deliveryStaffID, a.staffName, a.creationDatetime, a.arrived FROM (
                        SELECT a.orderID, a.memberID, a.deliveryStaffID, b.name AS staffName,
                                a.creationDatetime, a.arrived
                        FROM `orderhistory` AS a
                        LEFT JOIN deliveryStaff AS b
                        ON a.deliveryStaffID = b.deliveryStaffID) AS a
                      LEFT JOIN member AS b
                      ON a.memberID = b.memberID
                      ORDER BY orderID ASC;";
            }
            mysqli_set_charset($link, "utf8");
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0) {
              echo '<tr><td class="align-middle text-center" colspan="6">查無結果</td></tr>';  //欄位數
            } else {
              while($row = mysqli_fetch_assoc($result)) {
                if ($isCheck && $checkID == $row["orderID"]) {
                  //編輯中
                  echo '<tr style="
                            border-top-style: dashed;
                            border-color: black;
                          ">
                    <th class="align-middle text-center" scope="row" style="
                        border-left-style: dashed;
                      ">'.$row["orderID"].'</th>
                    <td class="align-middle text-center">'.$row["memberName"].'</td>
                    <td class="align-middle text-center">'.$row["staffName"].'</td>
                    <td class="align-middle text-center">'.$row["creationDatetime"].'</td>
                    <td class="align-middle text-center">'.(($row["arrived"] == 0)?"未送達":"已送達").'</td>
                    <td class="align-middle text-center" style="
                        border-right-style: dashed;
                      ">
                      <input type="button" class="btn btn-dark btn-sm btn-block" value="關閉"
                          onClick="javascript:location.href = \'order.php?t=0'.(($isQuery)?"&query=".$_GET["query"]:"").'\';">
                    </td>
                  </tr>';

                  echo '<tr style="
                            border-bottom-style: dashed;
                            border-color: black;
                          ">
                          <td class="align-middle text-center" style="
                            border-left-style: dashed;
                            border-right-style: dashed;
                          " colspan="6">
                          <div class="mx-sm-3 text-right mt-3">
                            <table class="table table-hover table-sm">
                            <thead>
                              <tr>
                                <th class="align-middle text-center" scope="col">餐廳</th>
                                <th class="align-middle text-center" scope="col">餐點</th>
                                <th class="align-middle text-center" scope="col">價格</th>
                                <th class="align-middle text-center" scope="col">數量</th>
                                <th class="align-middle text-center" scope="col">小計</th>
                                <th class="align-middle text-center" scope="col">編輯</th>
                                <th class="align-middle text-center" scope="col">刪除</th>
                                </tr>
                            </thead>
                            <tbody>';
                  
                  $sql = "SELECT a.orderID, a.restaurantID, a.restaurantName, a.foodID,
                                  b.name AS foodName, b.price, a.foodCount FROM (
                            SELECT a.orderID, a.restaurantID, b.name AS restaurantName, a.foodID, a.foodCount
                            FROM `orderdetail` AS a
                            LEFT JOIN restaurant AS b
                            ON a.restaurantID = b.restaurantID
                          ) AS a
                          LEFT JOIN food AS b
                          ON a.foodID = b.foodID AND a.restaurantID = b.restaurantID
                          WHERE a.orderID = ".$row["orderID"]."
                          ORDER BY a.restaurantID ASC, a.foodID ASC";
                  $detailResult = mysqli_query($link, $sql);
                  $total = 0;
                  if (mysqli_num_rows($detailResult) == 0) {
                    echo '<td class="align-middle text-center" colspan="6">無訂購餐點</td>';
                  } else {
                    while($detail = mysqli_fetch_assoc($detailResult)) {
                      $cost = (int)$detail["price"] * (int)$detail["foodCount"];
                      $total += $cost;
                      echo '<tr>';
                      echo '<td class="align-middle text-center">'.$detail["restaurantName"].'</td>';
                      echo '<td class="align-middle text-center">'.$detail["foodName"].'</td>';
                      echo '<td class="align-middle text-center">'.$detail["price"].'</td>';
                      if ($isEditDetail && $editRestaurantID == $detail["restaurantID"] && $editFoodID == $detail["foodID"]) {
                        echo '<td class="align-middle text-center">
                        <input name="foodCount" type="number" class="form-control form-control-sm" style="width: 70px;" min="1" value="'.$detail["foodCount"].'">
                              </td>';
                      } else {
                        echo '<td class="align-middle text-center">'.$detail["foodCount"].'</td>';
                      }
                      echo '<td class="align-middle text-center">'.$cost.'</td>';
                      if ($isEditDetail && $editRestaurantID == $detail["restaurantID"] && $editFoodID == $detail["foodID"]) {
                        echo '<td class="align-middle text-center" colspan="2">
                                <button class="btn btn-success btn-sm btn-block" type="submit" name="updateDetail" value="'.$detail["restaurantID"].','.$detail["foodID"].'">
                                  完成
                                </button>
                              </td>';
                      } else {
                        echo '<td class="align-middle text-center">
                                <button class="btn btn-warning btn-sm btn-block" type="submit" name="editDetail" value="'.$detail["restaurantID"].','.$detail["foodID"].'">
                                  編輯
                                </button>
                              </td>';
                        echo '<td class="align-middle text-center">
                                <button class="btn btn-danger btn-sm btn-block" type="submit" name="deleteDetail" value="'.$detail["restaurantID"].','.$detail["foodID"].'">
                                  刪除
                                </button>
                              </td>';
                      }
                      echo '</tr>';
                    }
                  }
                  echo '<tr>';
                  echo '<td class="align-middle text-center">';
                  echo '<select class="form-control form-control-sm" name="detailAddRest" id="myDropDown">';
                  $sql = "SELECT restaurantID, `name` FROM restaurant ORDER BY restaurantID ASC;";
                  $linkrest = mysqli_query($link, $sql);
                  $count = 0;
                  $default = -1;
                  while($restList = mysqli_fetch_assoc($linkrest)) {
                    if ($default == -1) {
                      $default = $restList["restaurantID"];
                    }
                    echo '<option value="'.$restList["restaurantID"].'" '.((isset($_GET["rest"])&&(int)$_GET["rest"]==$restList["restaurantID"])?"selected":"").'>'.$restList["name"].'</option>';
                  }
                  echo '</select>';
                  echo '</td>';
                  echo '<td class="align-middle text-center">';
                  echo '<select class="form-control form-control-sm" name="detailAddFood">';
                  $sql = "SELECT foodID, `name` FROM food WHERE restaurantID = ".((isset($_GET["rest"]))?$_GET["rest"]:$default)." ORDER BY foodID ASC;";
                  echo $sql;
                  $linkrest = mysqli_query($link, $sql);
                  $count = 0;
                  while($restList = mysqli_fetch_assoc($linkrest)) {
                    echo '<option value="'.$restList["foodID"].'">'.$restList["name"].'</option>';
                  }
                  echo '</select>';
                  echo '</td>';
                  echo '<td class="align-middle text-center"></td>';
                  echo '<td class="align-middle text-center"><input name="detailAddFoodCount" type="number" class="form-control form-control-sm" style="width: 70px;" min="1" value="1"></td>';
                  echo '<td class="align-middle text-center"></td>';
                  echo '<td class="align-middle text-center" colspan="2"><button class="btn btn-info btn-sm btn-block" type="submit" name="addDetail" value="'.$row["orderID"].'">
                      新增
                      </button></td>';
                  echo '</tr>';
                  echo '<tr>';
                  echo '<th class="align-middle text-center">總計</th>';
                  echo '<th class="align-middle text-center" colspan="3"></th>';
                  echo '<th class="align-middle text-center">'.$total.'</th>';
                  echo '<th class="align-middle text-center" colspan="2"></th>';
                  echo '</tr>';
                  
                  echo '    </tbody>
                            </table>  </div>  
                            <div class="mx-sm-3 text-right mb-3">
                              <button class="btn btn-danger btn-sm"
                              type="submit" name="deleteOrder" value="'.$row["orderID"].'">
                                刪除此筆訂單
                              </button>
                            </div>  
                          </td>
                        </tr>';

                } else {
                  //一般資訊
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$row["orderID"].'</th>
                    <td class="align-middle text-center">'.$row["memberName"].'</td>
                    <td class="align-middle text-center">'.$row["staffName"].'</td>
                    <td class="align-middle text-center">'.$row["creationDatetime"].'</td>
                    <td class="align-middle text-center">'.(($row["arrived"] == 0)?"未送達":"已送達").'</td>
                    <td class="align-middle text-center">
                      <button class="btn btn-secondary btn-sm btn-block" type="submit" name="check" value="'.$row["orderID"].'">
                        詳細資料
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
              <select class="form-control form-control-sm" name="memberAdd">
                <?php
                  $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD, "deliverysystem") or die(
                    "連線失敗!<br>");
                    $sql = "SELECT memberID, `name` FROM member ORDER BY memberID ASC;";
                  mysqli_set_charset($link, "utf8");
                  $result = mysqli_query($link, $sql);
                  $count = 0;
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row["memberID"].'">'.$row["name"].'</option>';
                  }
                ?>
              </select>
            </td>
            <td class="align-middle text-center">
              <select class="form-control form-control-sm" name="staffAdd">
                <?php
                  $link = mysqli_connect($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD, "deliverysystem") or die(
                    "連線失敗!<br>");
                    $sql = "SELECT deliverystaffID, `name` FROM deliverystaff ORDER BY deliverystaffID ASC;";
                  mysqli_set_charset($link, "utf8");
                  $result = mysqli_query($link, $sql);
                  $count = 0;
                  while($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="'.$row["deliverystaffID"].'">'.$row["name"].'</option>';
                  }
                ?>
              </select>
            </td>
            <td class="align-middle text-center"></td>
            <td class="align-middle text-center"></td>
            <td class="align-middle text-center">
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