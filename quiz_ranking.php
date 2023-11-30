<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .return-button {
            margin-top: 40px; /* 하단 여백 */
            padding: 10px 10px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            font-size: 10px;
            cursor: pointer;
            position: absolute;
            transition: background-color 0.3s;
            right: 20px;
        }
        .return-button:hover {
            background-color: #45a049;
        }

        
    </style>
</head>
<body>

<?php
// 데이터베이스 연결 정보
$servername = "localhost"; // MySQL 서버 주소
$username = "phpadmin"; // MySQL 사용자명
$password = "phpadmin"; // MySQL 암호
$dbname = "goods"; // 사용할 데이터베이스 이름

// MySQL 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 순위 매기는 쿼리
$sql = "SELECT 
            nickname, 
            correct_answers,
            (SELECT COUNT(*) + 1 FROM user_score AS u2 WHERE u2.correct_answers > u1.correct_answers) AS rank
        FROM 
            user_score AS u1
        ORDER BY 
            correct_answers DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 테이블로 데이터 출력
    echo "<table>";
    echo "<tr><th>닉네임</th><th>맞춘 개수</th><th>순위</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["nickname"]. "</td><td>" . $row["correct_answers"]. "</td><td>" . $row["rank"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}


// 연결 종료
$conn->close();
//현재페이지에서 이전페이지 이동(javascript의 history객체 사용?)
?>
<a href="#" onClick="history.back();" class="return-button">뒤로가기</a>

</body>
</html>