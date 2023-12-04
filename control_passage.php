<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>모의고사 지문 관리</title>
    <link rel="stylesheet" href="./CSS/styles.css">
    <style>
        body {
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
            margin : 0 auto;
            width: 90%;
            overflow: auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        /* 버튼 위치 조정 */
        .fixed-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .fixed-buttons input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            margin: 0 0 10px 0;
        }

        .fixed-buttons input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .passage_container {
            background-color: #333;
            width: 80%;
            border-radius: 8px;
            display: flex;
            flex-direction:column;
            align-items: center;
        }

        footer{
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");

$sql_create_exam_texts = "CREATE TABLE IF NOT EXISTS exam_texts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    year INT NOT NULL,
    month INT NOT NULL,
    grade INT NOT NULL,
    number INT NOT NULL,
    passage TEXT NOT NULL,
    interpret TEXT NOT NULL
)";
$conn->query($sql_create_exam_texts);

// POST 요청을 확인하고 선택된 항목을 삭제
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_selected'])) {
    if (isset($_POST['selected_items']) && !empty($_POST['selected_items'])) {
        // 선택된 항목을 삭제
        $selectedItems = implode(',', $_POST['selected_items']);
        $sql_delete_data = "DELETE FROM exam_texts WHERE id IN ($selectedItems)";
        if ($conn->query($sql_delete_data) === TRUE) {
            echo "<p>선택된 항목이 삭제되었습니다.</p>";
        } else {
            echo "<p>삭제 중 오류가 발생했습니다: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>선택된 항목이 없습니다.</p>";
    }
}

// exam_texts 테이블에서 데이터 가져오기
$sql_select_data = "SELECT * FROM exam_texts";
$result = $conn->query($sql_select_data);

if ($result->num_rows > 0) {
    echo "<div class = 'passage_container'>";
    echo '<h2>지문 DATABASE</h2>';
    echo '<form action="" method="post">';
    echo '<table>';
    echo '<tr><th>선택</th><th>번호</th><th>시행 연도</th><th>시행 월</th><th>학년</th><th>문제 번호</th><th>원문</th><th>해석</th></tr>';
    
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td><input type="checkbox" name="selected_items[]" value="' . $row['id'] . '"></td>';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['year'] . '</td>';
        echo '<td>' . $row['month'] . '</td>';
        echo '<td>' . $row['grade'] . '</td>';
        echo '<td>' . $row['number'] . '</td>';
        echo '<td>' . $row['passage'] . '</td>';
        echo '<td>' . $row['interpret'] . '</td>';
        echo '</tr>';
    }  
} else {
    echo '<p style = "color: red">자료가 하나도 없습니다. 추가 버튼을 눌러 자료를 추가하세요.</p>';
}
echo '</div>';
// 데이터베이스 연결 종료
$conn->close();
?>


<!-- 버튼을 고정시킬 부분 추가 -->
<div class="fixed-buttons">
    <!-- 선택한 항목 삭제 버튼 -->
    <form action="" method="post">
            <input type="submit" name="delete_selected" value="선택한 항목 삭제">
    </form>
    </form>
    <!-- 자료 추가/업데이트 버튼 -->
    <form action="add_passage.php" method="post">
        <input type="submit" value="자료 추가/업데이트">
    </form>
</div>
</table>

        <footer>
            <a href="teacher.php" style="color: white">관리자 페이지로</a>
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
        </footer>

</body>
</html>
