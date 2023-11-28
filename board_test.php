<?php
//MariaDB에 txt 데이터를 삽입할 수 있는지 확인하는 코드입니다. 

$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 파일 읽기
$fileContent = file_get_contents('테스트용 지문TEXT.txt');

$sql_create_table = "
CREATE TABLE IF NOT EXISTS test_TABLE (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file_data LONGBLOB
)";

if ($conn->query($sql_create_table) != TRUE) {
    echo "테이블 생성 오류: " . $conn->error;
}

// 파일 내용을 데이터베이스에 삽입
$sql = "INSERT INTO test_TABLE (file_data) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $fileContent);

if ($stmt->execute()) {
    echo "파일이 성공적으로 데이터베이스에 삽입되었습니다.";
} else {
    echo "오류: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>