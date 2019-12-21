<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> YuntechEat </title>
    <?php
    $conn = new mysqli("localhost", "root", "", "deliverysystem") or die("連接失敗");

    $dbname = "deliverysystem";
    $conn->query("SET NAMES utf8");
    $sql = "SELECT name from member";
    ?>

</head>

<body>
    <?php
    $result = $conn->query($sql);

    if ($conn->errno != 0){ // 查詢失敗
    echo "錯誤代碼: ".odbc_error($link)."<br/>";
    echo "錯誤訊息: ".odbc_errormsg($link)."<br/>"; 
    }
    else{
    $col_2 = [];
    while ($row = $result->fetch_row()){
        print_r($row);
        array_push($col_2, $row);
    }
    echo (count($col_2)) ;
    echo $col_2[1][0];    
}
    ?>
    <h1>YuntechEat 會員管理頁面</h1>
    <label>請選擇會員名稱
        <select name="month">
            <?php
		$month_select = array('', '1', '2', '3', '4', '5', 
					'6', '7', '8', '9', '10','11', '12');
        for($i = 0 ; $i < count($col_2);$i++){
            $name = $col_2[i][0];
            echo ("<option value=\"$name\">$name</option>");
        }	
		
	?>
        </select>

</body>

</html>