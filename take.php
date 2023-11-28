<?php
// MariaDB에서 txt 파일을 읽어와서 내용을 출력하는 코드 (take.php)

$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 데이터베이스에서 파일 데이터 읽기
$sql = "SELECT file_data FROM test_TABLE WHERE id = ?"; // 적절한 id를 사용하여 데이터를 가져옵니다.
$stmt = $conn->prepare($sql);
$id = 3; // 적절한 id 값을 설정하세요.
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($fileData);
    $stmt->fetch();

    // 파일 데이터 출력
    header("Content-Type: text/plain"); // 텍스트 파일로 설정
    echo $fileData;
} else {
    echo "파일을 찾을 수 없습니다.";
}

$stmt->close();
$conn->close();
?>
