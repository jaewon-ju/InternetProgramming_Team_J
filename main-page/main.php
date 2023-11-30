<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>홈페이지</title>
</head>
<body>
    <div class="header">
    </div>
    <div class="container">
        <div class="left-panel">
            <div class="login-form">
                <div class="user-info">
                    <h2>내 정보</h2>
                    <div class="custom-btn btn-1">
                        <button type="button" class="btn" onclick="location.href='./logout.php'">Logout</button>
                    </div>
                </div>
                <div class = "custom-btn btn-2">
                    <button type="button" class="btn" onclick="location.href='./game-main.php'">Game</button>
                </div>
                <div class = "custom-btn btn-3">
                    <button type="button" class="btn" onclick="location.href='./teacher_dashboard.php'">Teacher</button>
                </div>
            </div>
        </div>
        <div class="right-panel">
            <div class="board-container">
                <!-- 게시판 내용 추가 -->
            </div>
            <div class="custom-btn btn-4">
                <button type="button" class="btn" onclick="location.href='./write-main.php'">Write</button>
            </div>
        </div>
    </div>
    <div class="footer">
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
    </div>
</body>
</html>
