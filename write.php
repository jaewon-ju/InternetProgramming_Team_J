<!DOCTYPE html>
<html>
<head>
    <title>게시글 작성</title>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[name="author"] {
            width: 15%; /* 작성자 입력란 너비 조정 */
        }
        .submit-button {
            background-color: #FF7F50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            margin-right: 5px;
        }
        .back-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        .submit-button:hover {
            background-color: red;
        }
        .back-button:hover {
            background-color: #45a049;
        }
        
    </style>
</head>
<body>
<h1>게시글 작성</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <label for="author">작성자:</label>
    <input type="text" name="author" id="author"><br>
    <label for="title">제목:</label>
    <input type="text" name="title" id="title"><br>
    <label for="content"></label>
    <textarea name="content" id="content" rows="10" cols="80"></textarea><br>
    <label for="file">파일 첨부:</label>
    <input type="file" name="file[]" id="file" multiple><br>
    <input type="submit" class="back-button" onclick="goBack()" value="뒤로가기">
    <input type="submit" name="submit" class="submit-button" value="올리기">
</form>

<script>
    CKEDITOR.replace('content'); // CKEditor를 content ID의 textarea에 적용

    function goBack() {
        window.history.back(); // php에서는 새로고침, 뒤로가기 기능 X
    }
</script>

    <?php
    // (미구현)세션으로 홈페이지에서 (선생님)이름 가져와서 '작성자'에 default값으로 기록되게 
    $servername = "localhost";
    $username = "phpadmin";
    $password = "phpadmin";
    $dbname = "goods";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("연결 실패: " . $conn->connect_error);
    }
    // 20231201 update: db에 테이블 없을시 자동 생성하는 코드 추가 + 한국어 encoding 코드 추가.
    // 제 노트북에서는 1) '파일 첨부'를 하지 않고 게시물 업로드시 게시물이 업로드 되지 않는 오류
    // 2) 파일 여러개 올렸을 시 오류
    // 2가지 오류가 발생합니다. 2번째 오류는 파일을 여러개 올린 경우 처리를 board.php에서 해줘야 하는데, 제가 파일을 하나만 올린다 가정하고 board.php 코드를 작성해서 오류가 나는 것 같습니다.

    mysqli_set_charset($conn, "utf8mb4");

    $tableCheckQuery = "SHOW TABLES LIKE 'board'";
    $tableCheckResult = $conn->query($tableCheckQuery);

    if ($tableCheckResult->num_rows == 0) {
        // 'board' table does not exist, create it
        $createTableQuery = "
        CREATE TABLE board (
            id INT AUTO_INCREMENT PRIMARY KEY,
            author VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            content LONGTEXT NOT NULL,
            file_path VARCHAR(255)
        )";

        if ($conn->query($createTableQuery) === FALSE) {
            echo "Error creating table: " . $conn->error;
        }
    }
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author = $_POST['author'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // 파일 업로드 처리
    $targetDir = "uploads/"; // 파일이 저장될 디렉토리 경로
    $uploadOk = 1;

    foreach( $_FILES['file']['name'] as $key => $filename) {
        $targetFile = $targetDir. basename($filename);
        $fileSize = $_FILES['file']['size'][$key];
        // 파일 크기 제한 설정 (100MB)
        $maxFileSize = 100 * 1024 * 1024; // 100MB를 바이트 단위로 변환

        // 파일 크기 유효성 검사
        if ($fileSize > $maxFileSize) {
            echo " 100MB 이하의 파일만 업로드 가능합니다.";
            $uploadOk = 0;
            break; // 파일 용량 초과 시 반복문 중단
        }

        if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFile)) {
            // 파일 업로드 성공 시 게시글을 board 테이블에 삽입
            $sql = "INSERT INTO board (author, title, content, file_path) VALUES ('$author', '$title', '$content', '$targetFile')";
            
            if ($conn->query($sql) === TRUE) {
                //(미구현)성공적으로 게시글 작성 시 homepage.php로 이동 
                echo "게시글이 성공적으로 작성되었습니다.";
            } else {
                echo "에러: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "파일 업로드에 실패했습니다.";
        }
    }
}
    
$conn->close();
?>

</body>
</html>