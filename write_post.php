<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 글쓰기</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        textarea {
            width: 300px;
            height: 150px;
            margin-bottom: 16px;
            resize: none;
        }

        input[type="file"] {
            margin-bottom: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .delete-form {
            margin-top: 20px;
        }

        .delete-form input[type="submit"] {
            background-color: #dc3545;
        }

        .delete-form input[type="submit"]:hover {
            background-color: #bd2130;
        }
    </style>
</head>
<body>

    <?php
    // 게시판에 글 등록
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_post'])) {
        $content = $_POST['content'];

        // 파일 업로드 처리
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // 파일 업로드 유효성 검사
        if ($_FILES["file"]["size"] > 500000) {
            echo "파일이 너무 큽니다.";
            $uploadOk = 0;
        }

        // 텍스트 파일만 허용 (확장자 .txt)
        if ($imageFileType != "txt") {
            echo "텍스트 파일(.txt)만 허용됩니다.";
            $uploadOk = 0;
        }

        // 파일 업로드 실행
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                echo "파일 " . basename($_FILES["file"]["name"]) . "이(가) 업로드되었습니다.";
            } else {
                echo "파일 업로드 중 문제가 발생했습니다.";
            }
        }
        
        // 여기서는 데이터베이스에 저장하는 부분이 없으므로, 실제로는 데이터베이스에 저장하는 코드를 추가해야 합니다.
        // 예시로 게시글 내용과 파일 경로를 출력합니다.
        echo "<h3>게시글 내용:</h3>";
        echo "<p>$content</p>";
        echo "<h3>파일 경로:</h3>";
        echo "<p>$targetFile</p>";
    }

    // 게시글 삭제
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_post'])) {
        // 여기에 게시글 삭제 코드를 추가하세요.
        // 삭제하는 방식은 게시글을 식별할 수 있는 정보를 기반으로 구현합니다.
        // 여기서는 예시로 "게시글이 삭제되었습니다." 메시지만 출력합니다.
        echo "<p>게시글이 삭제되었습니다.</p>";
    }
    ?>

    <!-- 게시글 작성 폼 -->
    <h2>게시판 글쓰기</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="content">게시글 내용:</label>
        <textarea name="content" required></textarea>

        <label for="file">파일 업로드 (선택):</label>
        <input type="file" name="file">

        <input type="submit" name="submit_post" value="글 등록">
    </form>

    <!-- 게시글 삭제 폼 -->
    <form action="" method="post" class="delete-form">
        <label for="delete_post">게시글 삭제 (게시글이 삭제된 경우, 파일도 함께 삭제됩니다.):</label>
        <input type="submit" name="delete_post" value="글 삭제">
    </form>

</body>
</html>
