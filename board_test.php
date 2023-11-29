<!-- board_test.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        tr:hover {
            cursor: pointer;
            background-color: #ccc;
        }

    </style>
    <title>게시판</title>
</head>
<body>
    <h1>게시판</h1>

    <?php
    $servername = "localhost";
    $username = "phpadmin";
    $password = "phpadmin";
    $dbname = "goods";

    // 데이터베이스 연결
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");
    // 연결 확인
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 쿼리 작성 및 실행
    $sql = "SELECT id, author, title, content, file_path FROM board_table";
    $result = $conn->query($sql);

    // 결과가 있는 경우에만 출력
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>제목</th><th>작성자</th><th>내용</th><th>첨부 파일</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr onclick='location.href=\"board.php?id=" . $row['id'] . "\";'>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['author'] . "</td>";
            echo "<td>" . (mb_strlen($row['content'], 'UTF-8') > 20 ? mb_substr($row['content'], 0, 20, 'UTF-8') . "..." : $row['content']) . "</td>";
            echo "<td>" . ($row['file_path'] ? "있음" : "없음") . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "게시물이 없습니다.";
    }

    // 연결 종료
    $conn->close();
    ?>
</body>
</html>