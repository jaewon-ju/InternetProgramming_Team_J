<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher 페이지</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction : column;
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
            justify-content: center;
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            margin: 0 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h2>Teacher 페이지</h2>

<!-- DB에 지문 추가 버튼 -->
<form action="add_passage.php" method="post">
    <input type="submit" value="DB에 지문 추가">
</form>

<!-- 자료 제작 버튼 -->
<form action="make_file.php" method="post">
    <input type="submit" value="자료 제작">
</form>

<!-- 게시판 글쓰기 버튼 -->
<form action="write_post.php" method="post">
    <input type="submit" value="게시판 글쓰기">
</form>

</body>
</html>
