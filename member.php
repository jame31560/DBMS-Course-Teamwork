<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> YuntechEat </title>
    <?php
    $conn = new mysqli("localhost", "root", "123", "deliverysystem") or die("連接失敗");

    $dbname = "deliverysystem";
    $conn->query("SET NAMES utf8");
    $sql = "SELECT name from member";
    ?>

</head>

<body>

    <h1>YuntechEat 會員管理頁面</h1>
    <form id="form1" name="form1" method="post" action="">
        <label>請選擇會員名稱
            <select name="select">
                <?php
    $str="SELECT name FROM member ";
    $result = $conn->query($sql);
    while(list($name) = mysql_fetch_row($result))
    {
    echo "<option value=".$name."">"</option>\n";
    }
    ?>
            </select>

</body>

</html>