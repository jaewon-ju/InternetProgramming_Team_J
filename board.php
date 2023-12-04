<!-- board.php -->
<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: #333;
            border: 1px solid #ccc;
            border-radius: 10px; /* border radius 설정 */
            width: 50%;
            height: 80%;
            padding: 10px;
            display: flex; /* 추가: flex container로 설정 */
            flex-direction: column; /* 추가: 세로 방향으로 요소 배치 */
            text-align: center; /* content를 중앙에 배치하기 위해 추가 */
            overflow: auto;
        }

        .post_container {
            background-color: white;
            border-radius: 5px;
            text-align: center; /* content를 중앙에 배치하기 위해 추가 */
            height: 100%;
        }
        
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 10px; 
        }
        footer {
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            margin-top: auto;
            border-radius: 10px; 
        }
        .post {
            margin-top: 50px;
            text-align: center; /* content를 중앙에 배치하기 위해 추가 */
            height: 100%;
        }

        h1 {
            margin: 1px 1px;
        }
        h2 {
            font-size: 55px;
            color: #333;
            text-align: center; /* title을 중앙에 배치하기 위해 추가 */
        }

        p {
            margin: 5px 0;
        }

        .title {
            color: #fff;
            border-radius: 8px; /* border-radius 추가 */
        }

        .author,
        .file-download {
            color: black;
        }

        .content {
            background-color: #f2f2f2; /* 배경 색 변경 */
            padding: 10px;
            border-radius: 8px; /* border-radius 추가 */
            margin-top: 20px; /* content와 위쪽 간격을 조절 */
            text-align: left; /* 텍스트를 왼쪽 정렬 */
        }

        /* 추가된 스타일: 작성자와 파일 다운로드 위치 조정 */
        .author,
        .file-download {
            text-align: end;
            margin-top: 10px; /* 작성자와 파일 다운로드 간의 간격을 조절 */
        }

</style>

    </style>
    <title>인프 영어학원 게시판 - 게시물 상세 정보</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>인프 영어학원 게시판</h1>
        </div>
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

        // 게시물 ID 가져오기
        $postId = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$postId) {
            echo "게시물 ID가 유효하지 않습니다.";
        } else {
            // 쿼리 작성 및 실행
            $sql = "SELECT id, author, title, content, file_path FROM board WHERE id = $postId";
            $result = $conn->query($sql);

            // 결과가 있는 경우에만 출력
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div class='post_container'>";
                echo "<div class='post'>";
                echo "<div class='title'>";
                echo "<h2> " . $row['title'] . "</h2>";
                echo "</div>";
                echo "<p class='author'> 작성자: " . $row['author'] . "</p>";
                echo "<div class='content'>";
                echo "<p>" . $row['content'] . "</p>";
                echo "</div>";
                echo "<p class='file-download'>" . ($row['file_path'] ? "<a href='download.php?file=" . $row['file_path'] . "'>첨부파일 다운로드</a>" : "첨부파일 없음") . "</p>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "게시물이 없습니다.";
            }
        }

        // 연결 종료
        $conn->close();
        ?>

        <footer>
            <a href="main.php" style="color: white">메인으로</a>
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>
