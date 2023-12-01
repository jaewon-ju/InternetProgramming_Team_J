<?php
// 세션 시작
session_start();

// 세션에 저장된 역할을 확인
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

// 함수: 선생님 여부 확인
function isTeacher() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'teacher';
}

?>
<!DOCTYPE html>
<html lang="kr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>홈페이지</title>
</head>
<body>
    <div class="header">
        <h1>온라인 학습실</h1>
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
                <div class = "quiz_button">
                    <button onclick="location.href='./word_quiz_main.php'"></button>
                </div>
                <?php if(isTeacher())  : ?>
                <div class = "teacher_button">
                    <button type="button" class="btn" onclick="location.href='./teacher.php'">Teacher</button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="right-panel">
        <div class="search-container">
        <form method="get" action="">
            <select name="search_type" class="search-dropdown">
                <option value="title">제목</option>
                <option value="author">작성자</option>
                <option value="content">내용</option>
            </select>
            <input type="text" name="search" class="search-input" placeholder="검색어를 입력하세요">
            <button type="submit" class="search-button">검색</button>
        </form>
        </div>
            <div class="board-container">
            <form method="post" action="">
                <table>
                    <tr>
                        <th></th>
                        <th>제목</th>
                        <th>작성자</th>
                        <th>내용</th>
                        <th>첨부 파일</th>
                    </tr>

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
        
                    // 검색어 가져오기
                    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
        
                    // 쿼리 작성 및 실행
                    $sql = "SELECT id, author, title, content, file_path FROM board";
                    if (!empty($searchTerm)) {
                        $sql .= " WHERE title LIKE '%$searchTerm%' OR author LIKE '%$searchTerm%' OR content LIKE '%$searchTerm%'";
                    }
                    $result = $conn->query($sql);
        
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_selected'])) {
                        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
                            // 선택된 항목을 삭제
                            $selectedItems = implode(',', $_POST['delete_ids']);
                            $sql_delete_data = "DELETE FROM board WHERE id IN ($selectedItems)";
                        } else {
                            echo "<p>선택된 게시글이 없습니다.</p>";
                        }
                    }
        

                    // 결과가 있는 경우에만 출력
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><input type='checkbox' name='delete_ids[]' value='" . $row['id'] . "'></td>";
                            echo "<td onclick='location.href=\"board.php?id=" . $row['id'] . "\";'>" . $row['title'] . "</td>";
                            echo "<td>" . $row['author'] . "</td>";
                            echo "<td>" . (mb_strlen($row['content'], 'UTF-8') > 20 ? mb_substr($row['content'], 0, 20, 'UTF-8') . "..." : $row['content']) . "</td>";
                            echo "<td>" . ($row['file_path'] ? "있음" : "없음") . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "검색 결과가 없습니다.";
                    }

                    // 연결 종료
                    $conn->close();
                    ?>
                </table>
                <button type="submit" name="delete_selected" id="deleteButton">선택한 항목 삭제</button>
                </form>
            </div>
            <?php if(isTeacher())  : ?>
            <div class="write_button">
                <button type="button" class="btn" onclick="location.href='./write.php'">글쓰기</button>
            </div>
            <?php endif; ?>
            </div>
            
    </div>
    <div class="footer">
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
    </div>
</body>
</html>
