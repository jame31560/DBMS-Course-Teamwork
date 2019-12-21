<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> YuntechEat </title>
    <?php
    $conn = new mysqli("localhost", "root", "", "deliverysystem") or die("連接失敗");

    $sql = "SELECT account from member";
    ?>
</head>

<body>
    <h1>YuntechEat 會員管理頁面</h1>
    <label>請選擇會員名稱
        <select name="month">
            <?php
            $link = mysqli_connect("localhost","root",
            "","deliverysystem")
                or die("連線失敗!<br>");
            $sql = "SELECT * FROM member";
            mysqli_set_charset($link,"utf8");
            $result = mysqli_query($link, $sql);
            while($row = mysqli_fetch_assoc($result)) {
            echo "<option value=".$row["account"].">".$row["account"]."</option>\n";
            }	
		
	?>
        </select>

</body>

</html>