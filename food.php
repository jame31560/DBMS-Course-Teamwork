<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> YuntechEat </title>
    <?php
    $conn = new mysqli($SQL_URL, $SQL_USERNAME, $SQL_PASSWORD, "deliverysystem") or die("連接失敗");
    ?>
</head>

<body>
<?php include("config.php"); ?>
    <h1>YuntechEat 食物管理頁面</h1>
    <label>請選擇食物編號
        <select name="month">
            <?php
            $link = mysqli_connect("localhost","root",
            "","deliverysystem")
                or die("連線失敗!<br>");
            $sql = "SELECT * FROM food";
            mysqli_set_charset($link,"utf8");
            $result = mysqli_query($link, $sql);
            while($row = mysqli_fetch_assoc($result)) {
            echo "<option value=".$row["foodID"].">".$row["foodID"]."</option>\n";
            }	
		
	?>
        </select>

</body>

</html>