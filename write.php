<!DOCTYPE html>
<html>
<head>
    <title>게시글 작성</title>
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }
        h1 {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background-color: #fff; /* White background */
            border-radius: 8px; /* Add rounded corners for a nicer look */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            text-align: center;
        }
        form {
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
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            margin-right: 5px;
        }
        .submit-button:hover {
            background-color: #FF6347;
        }
        .write_container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            height: 100%;
            background-color: #fff; /* White background */
            border-radius: 8px; /* Add rounded corners for a nicer look */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
        }
        label{
            color: black
        }
        .return-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            margin-right: 5px;
        }
        .return-button:hover {
            background-color: #FF6347;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
            height: 100%;
            width: 60%;
            background-color: #333;
            border-radius: 5px;
        }
        .footer {
            color: white;
        }
        span{
            max-width: 1000px;
            margin-bottom: 20px;
        }
    </style>
    
</head>
<body>
<span>게시글을 업데이트 하려는 경우, 작성자와 제목은 이전과 동일하게 작성하고 내용만 변경해서 올리면 자동으로 업데이트 됩니다</span>
    <div class = "container">
    <h1>게시글 작성</h1>
    <div class="write_container">

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <label for="author">작성자:</label>
            <input type="text" name="author" id="author"><br>
            <label for="title">제목:</label>
            <input type="text" name="title" id="title"><br>
            <label for="content"></label>
            <textarea name="content" id="content" rows="10" cols="80"></textarea><br>
            <label for="file">파일 첨부:</label>
            <input type="file" name="file[]" id="file" multiple><br>
            <input type="submit" name="submit" class="submit-button" value="올리기">
            <a href="main.php" style="float: right; margin-right: 5px; text-decoration: none;">
                <button type="button" class="return-button">페이지로 돌아가기</button></a>
        </form>

        <script>
            CKEDITOR.replace('content'); // CKEditor를 content ID의 textarea에 적용

            function goBack() {
                window.history.back(); // php에서는 새로고침, 뒤로가기 기능 X
            }
        </script>

            <?php
            $servername = "localhost";
            $username = "phpadmin";
            $password = "phpadmin";
            $dbname = "goods";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("연결 실패: " . $conn->connect_error);
            }
            mysqli_set_charset($conn, "utf8mb4");

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $author = $_POST['author'];
                $title = $_POST['title'];
                $content = $_POST['content'];
            
                // 이미 존재하는 게시글 확인
                $check_query = "SELECT * FROM board WHERE title='$title' AND author='$author'";
                $check_result = $conn->query($check_query);
            
                if ($check_result->num_rows > 0) {
                    // 이미 존재하는 경우, 해당 글의 내용을 업데이트
                    $check_row = $check_result->fetch_assoc();
                    $edit_id = $check_row['id'];
            
                    $update_query = "UPDATE board SET content='$content' WHERE id='$edit_id'";
                    if ($conn->query($update_query) === TRUE) {
                        echo "<script>alert('게시글이 성공적으로 수정되었습니다.');</script>";
                        echo "<script>window.location.href = 'main.php';</script>";
                        exit();
                    } else {
                        echo "에러: " . $update_query . "<br>" . $conn->error;
                    }
                } else {
                    // 존재하지 않는 경우, 새로운 게시글 작성
                    $targetDir = "uploads/";
                    $uploadOk = 1;
            
                    if (!empty($_FILES['file']['name'][0])) {
                        foreach ($_FILES['file']['name'] as $key => $filename) {
                            $targetFile = $targetDir . basename($filename);
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
                                    echo "<script>alert('게시글이 성공적으로 작성되었습니다.');</script>";
                                    echo "<script>window.location.href = 'main.php';</script>";
                                    exit();
                                } else {
                                    echo "에러: " . $sql . "<br>" . $conn->error;
                                }
                            } else {
                                echo "파일 업로드에 실패했습니다.";
                            }
                        }
                    } else {
                        // 파일 첨부가 없는 경우에도 게시글을 작성
                        $sql = "INSERT INTO board (author, title, content) VALUES ('$author', '$title', '$content')";
                        
                        if ($conn->query($sql) === TRUE) {
                            echo "<script>alert('게시글이 성공적으로 작성되었습니다.');</script>";
                            echo "<script>window.location.href = 'main.php';</script>";
                            exit();
                        } else {
                            echo "에러: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }
            }
            
        $conn->close();
        ?>
        </div>
        <div class="footer">
                <p>&copy; 2023 홈페이지. All rights reserved.</p>
        </div>
        </div>
</body>
</html>