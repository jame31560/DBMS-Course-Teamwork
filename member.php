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
  <?php
    $hasMsg = isset($_GET["msg"]);
    $isQuery = isset($_GET["query"]);
    $isEdit = isset($_GET["edit"]);
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
      header("Location: member.php?msg=0");
    }
    $isDelete = isset($_GET["delete"]);
    if ($isDelete) {
      $memberID = $_GET["delete"];
      // delete code in here
      header("Location: member.php?msg=1");
    }
  ?>
  <h1 class="text-center mt-2">YuntechEat 會員管理頁面</h1>
  <form class="form-inline" action="member.php" method="GET">
    <div class="form-group mx-sm-3 mb-2">
      <button type="submit" class="btn btn-info mb-2">New</button>
    </div>
  </form>

  <form class="form-inline" action="member.php" method="GET">
    <div class="form-group mx-sm-3 mb-2">
      <label for="inputquery" class="sr-only">Account</label>
      <input name="query" type="text" class="form-control" id="inputquery" placeholder="Account" required>
    </div>
    <button type="submit" class="btn btn-primary mb-2 mr-2">Query</button>
    <?php 
      if ($isQuery) {
        echo '<button class="btn btn-secondary mb-2 mr-2" onClick="document.location=\'member.php\';">取消查詢</button>';
      } 
    ?>
  </form>

  <form class="form-inline" action="member.php" method="GET">
    <div class="form-group mx-sm-3 mb-2">
      <?php 
        if ($hasMsg) {
          $msg = "";
          switch ($_GET["msg"]) {
            case 0:
              $msg = "Update success!";
              break;
            case 1:
              $msg = "Delete success!";
              break;
            default:
              # code...
              break;
          }
          echo '<div class="alert alert-success" role="alert">
                  '.$msg.'
                </div>';
        }
      ?>
      <table class="table">
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
              echo '<tr><td class="align-middle text-center" colspan="8">查無結果</td></tr>';
            } else {
              while($row = mysqli_fetch_assoc($result)) {
                if ($isEdit && $editID == $row["memberID"]) {
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$row["memberID"].'</th>
                    <td class="align-middle text-center">
                      <input name="account" type="text" class="form-control" value="'.$row["account"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="name" type="text" class="form-control" value="'.$row["name"].'">
                    </td>
                    <td class="align-middle text-center">
                      <select class="form-control" name="gender">
                        <option value="1"'.(($row["gender"] == 1)?"selected":"").'>男</option>
                        <option value="0"'.(($row["gender"] == 0)?"selected":"").'>女</option>
                      </select>
                    </td>
                    <td class="align-middle text-center">
                      <input name="birthday" type="text" class="form-control" value="'.$row["birthday"].'">
                    </td>
                    <td class="align-middle text-center">
                      <input name="email" type="text" class="form-control" value="'.$row["email"].'">
                    </td>
                    <td class="align-middle text-center">
                      <button class="btn btn-warning btn-sm" type="submit" name="update" value="'.$row["memberID"].'">
                        送出
                      </button>
                    </td>
                    <td class="align-middle text-center"></td>
                  </tr>';
                } else {
                  echo '<tr>
                    <th class="align-middle text-center" scope="row">'.$row["memberID"].'</th>
                    <td class="align-middle text-center">'.$row["account"].'</td>
                    <td class="align-middle text-center">'.$row["name"].'</td>
                    <td class="align-middle text-center">'.(($row["gender"] == 1)?"男":"女").'</td>
                    <td class="align-middle text-center">'.$row["birthday"].'</td>
                    <td class="align-middle text-center">'.$row["email"].'</td>
                    <td class="align-middle text-center">
                      <button class="btn btn-warning btn-sm" type="submit" name="edit" value="'.$row["memberID"].'">
                        編輯
                      </button>
                    </td>
                    <td class="align-middle text-center">
                      <button class="btn btn-danger btn-sm" type="submit" name="delete" value="'.$row["memberID"].'">
                        刪除
                      </button>
                    </td>
                  </tr>';
                }
              }
            }
          ?>
        </tbody>
      </table>
    </div>
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
</body>

</html>