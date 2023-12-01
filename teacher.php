<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher 페이지</title>
    <link rel="stylesheet" href="choose_button_style.css">
</head>
<body>
    <div class="header">
        <h1>관리자 페이지</h1>
    </div>
        <div class="button-container">
            <!-- 데이터 관리 버튼 -->
            <form action="control_data.php" method="post">
                <input class="data-control-button" type="submit" value="">
                <div class="button-text">데이터베이스 관리</div>
            </form>

            <!-- 자료 제작 버튼 -->
            <form action="make_file.php" method="post">
                <input class="make-file-button" type="submit" value="">
                <div class="button-text">자료 제작</div>
            </form>
        </div>
    <div class="footer">
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
    </div>
</body>
</html>
