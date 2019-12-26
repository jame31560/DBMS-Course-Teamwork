<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> YuntechEat </title>
</head>


<body>
    <h1>YuntechEat 會員管理詳細頁面</h1>
    <?php
    if (isset($_POST["useraccount"])){
        $link = mysqli_connect("localhost","root",
                    "","deliverysystem")
        or die("無法開啟MySQL資料庫連接!<br>");
        echo $_POST["useraccount"];
        $sql = "SELECT * FROM member WHERE account = '".$_POST["useraccount"]."'";
        mysqli_set_charset($link,"utf8");
        $result = mysqli_query($link, $sql);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($conn));
            exit();
        }
        if (mysqli_num_rows($result) > 0) {
           // 输出数据
            while($row = mysqli_fetch_assoc($result)) {
                $memberid = $row["memberID"];
                $account = $row["account"];
                $password = $row["password"];
                $name = $row["name"];
                if($row["gender"] = 1 ){
                    $gender = "男";
                }else{
                    $gender = "女";
                }
                $birthday = $row["birthday"];
                $email= $row["email"];
        }
    }
}
    ?>
    會員編號: <input type="text" name="useraccount1" value="<?php echo $memberid ?>" /></br>
    會員帳號: <input type="text" name="useraccount1" value="<?php echo $account ?>" /></br>
    會員密碼: <input type="text" name="useraccount1" value="<?php echo $password ?>" /></br>
    會員名字: <input type="text" name="useraccount1" value="<?php echo $name ?>" /></br>
    會員性別: <input type="text" name="useraccount1" value="<?php echo $gender ?>" /></br>
    會員生日: <input type="text" name="useraccount1" value="<?php echo $birthday ?>" /></br>
    會員信箱: <input type="text" name="useraccount1" value="<?php echo $email ?>" />


</body>

</html>