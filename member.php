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
      $memberID = $_GET["update"]; // update this on where
      $account = $_GET["account"];
      $name = $_GET["name"];
      $gender = $_GET["gender"];
      $email = $_GET["email"];
      $birthday = $_GET["birthday"];
      // update code in here;
      // header("Location: member.php?msg=-1".(($isQuery)?"&query=".$_GET["query"]:""));
      header("Location: member.php?msg=0".(($isQuery)?"&query=".$_GET["query"]:""));
    }
    $isDelete = isset($_GET["delete"]);
    if ($isDelete) {
      $memberID = $_GET["delete"];
      // delete code in here
      header("Location: member.php?msg=1".(($isQuery)?"&query=".$_GET["query"]:""));
    }
    if ($isCreate) {
      $account = $_GET["accountAdd"];
      $name = $_GET["nameAdd"];
      $gender = $_GET["genderAdd"];
      $email = $_GET["emailAdd"];
      $birthday = $_GET["birthdayAdd"];
      // create code in here;
      header("Location: member.php?msg=2".(($isQuery)?"&query=".$_GET["query"]:""));
    }
  ?>
    <h1 class="text-center mt-2">YuntechEat 會員管理頁面</h1>
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
          default:
            # code...
            break;
        }
        
      }
    ?>
    <form class="form-inline" action="member.php" method="GET">
      <div class="form-group mx-sm-3 mb-2">
        <label for="inputquery" class="sr-only">Account</label>
        <input name="query" type="text" class="form-control" id="inputquery" placeholder="帳號" required
               value="<?php echo (($isQuery)?$_GET["query"]:"") ?>">
      </div>
      <button type="submit" class="btn btn-primary mb-2 mr-2">查詢</button>
      <?php 
      if ($isQuery) {
        echo '<button type="reset" class="btn btn-secondary mb-2 mr-2" onClick="document.location=\'member.php\';">取消查詢</button>';
      } 
    ?>
    </form>

    <form class="form-inline" action="member.php" method="GET">
      <?php
        if ($isQuery) {
          echo '<input name="query" type="text" class="form-control d-none" value="'.$_GET["query"].'">';
        }
      ?>

      <table class="table table-striped table-hover table-sm">
        <thead>
          <tr>
            <th class="align-middle text-center" scope="col">編號</th>
            <th class="align-middle text-center" scope="col">帳號</th>
            <th class="align-middle text-center" scope="col">姓名</th>
            <th class="align-middle text-center" scope="col">性別</th>
            <th class="align-middle text-center" scope="col">生日</th>
            <th class="align-middle text-center" scope="col">信箱</th>
            <th class="align-middle text-center" scope="col">編輯</th>
            <th class="align-middle text-center" scope="col">刪除</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $link = mysqli_connect("localhost","root", "","deliverysystem") or die("連線失敗!<br>");
            if ($isQuery) {
              $sql = "SELECT * FROM member WHERE account LIKE '%".$_GET["query"]."%'";
            } else {
              $sql = "SELECT * FROM member";
            }
            mysqli_set_charset($link, "utf8");
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) == 0) {
              echo '<tr><td class="align-middle text-center" colspan="8">查無結果</td></tr>';  //欄位數
            } else {
              while($row = mysqli_fetch_assoc($result)) {
                if ($isEdit && $editID == $row["memberID"]) {
                  //編輯中
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$row["memberID"].'</th>
                    <td class="align-middle text-center">
                      <input name="account" type="text" class="form-control form-control-sm" style="width: 120px;" value="'.$row["account"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="name" type="text" class="form-control form-control-sm" style="width: 120px;" value="'.$row["name"].'">
                    </td>
                    <td class="align-middle text-center">
                      <select class="form-control form-control-sm" name="gender">
                        <option value="1"'.(($row["gender"] == 1)?"selected":"").'>男</option>
                        <option value="0"'.(($row["gender"] == 0)?"selected":"").'>女</option>
                      </select>
                    </td>
                    <td class="align-middle text-center">
                      <input name="birthday" type="text" class="form-control form-control-sm" style="width: 120px;" value="'.$row["birthday"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="email" type="text" class="form-control form-control-sm" style="width: 180px;" value="'.$row["email"].'">
                    </td>
                    <td class="align-middle text-center" colspan="2">
                      <button class="btn btn-success btn-sm btn-block" type="submit" name="update" value="'.$row["memberID"].'">
                        送出
                      </button>
                    </td>
                  </tr>';
                } else {
                  //一般資訊
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$row["memberID"].'</th>
                    <td class="align-middle text-center">'.$row["account"].'</td>
                    <td class="align-middle text-center">'.$row["name"].'</td>
                    <td class="align-middle text-center">'.(($row["gender"] == 1)?"男":"女").'</td>
                    <td class="align-middle text-center">'.$row["birthday"].'</td>
                    <td class="align-middle text-center">'.$row["email"].'</td>
                    <td class="align-middle text-center">
                      <button class="btn btn-warning btn-sm btn-block" type="submit" name="edit" value="'.$row["memberID"].'">
                        編輯
                      </button>
                    </td>
                    <td class="align-middle text-center">
                      <button class="btn btn-danger btn-sm btn-block" type="submit" name="delete" value="'.$row["memberID"].'">
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
              <input name="accountAdd" type="text" class="form-control form-control-sm" style="width: 120px;">
            </td>
            <td class="align-middle text-center">
              <input name="nameAdd" type="text" class="form-control form-control-sm" style="width: 120px;">
            </td>
            <td class="align-middle text-center">
              <select class="form-control form-control-sm" name="genderAdd">
                <option value="1">男</option>
                <option value="0">女</option>
              </select>
            </td>
            <td class="align-middle text-center">
              <input name="birthdayAdd" type="text" class="form-control form-control-sm" style="width: 120px;">
            </td>
            <td class="align-middle text-center">
              <input name="emailAdd" type="text" class="form-control form-control-sm" style="width: 180px;">
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