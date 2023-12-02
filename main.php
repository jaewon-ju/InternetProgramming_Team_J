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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/styles.css">
    <title>홈페이지</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            color: black;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        tr:hover {
            cursor: pointer;
            background-color: #ccc;
        }
        .btn{
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            margin-top: 10px;
            margin-bottom: 30px;
            transition: background-color 0.3s;
            background-color: #45a049; /* Start button color */
        }

        .btn:hover {
            background-color: #FF6347;
        }
        .search-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 8px;
            transition-duration: 0.4s;
        }
        .search-button:hover {
            background-color: #45a049;
        }
    </style>
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
                    <button type="button" class="btn" onclick="location.href='./word_quiz_main.php'">Quiz</button>
                </div>
                <?php if(isTeacher()) : ?>
                    <div class = "teacher_button">
                        <button type="button" class="btn" onclick="location.href='./teacher.php'">Teacher</button>
                    </div>
                    <div class="write_button">
                        <button type="button" class="btn" onclick="location.href='write.php'">글쓰기</button>
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
        <form method="post" action="">
            <div class="board-container">
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
                    $searchType = isset($_GET['search_type']) ? $_GET['search_type'] : '';

                    // 쿼리 작성 및 실행
                    $sql = "SELECT id, author, title, content, file_path FROM board";
                    if (!empty($searchTerm)) {
                        $sql .= " WHERE";
                    
                        // 각 검색 유형에 대한 OR 조건 추가
                        $conditions = [];
                        switch ($searchType) {
                            case 'title':
                                $conditions[] = "title LIKE '%$searchTerm%'";
                                break;
                            case 'author':
                                $conditions[] = "author LIKE '%$searchTerm%'";
                                break;
                            case 'content':
                                $conditions[] = "content LIKE '%$searchTerm%'";
                                break;
                        }
                    
                        // 조건들을 OR로 연결
                        $sql .= " " . implode(" OR ", $conditions);
                    }
                    $result = $conn->query($sql);
        
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_selected']) && !isset($_POST['refreshed'])) {
                        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
                            // 선택된 항목을 삭제
                            $selectedItems = implode(',', $_POST['delete_ids']);
                            $sql_delete_data = "DELETE FROM board WHERE id IN ($selectedItems)";
                            if ($conn->query($sql_delete_data) === TRUE) {
                                echo "<p>선택된 게시글이 삭제되었습니다.</p>";
                    
                                // Redirect to the same page after successful deletion
                                header("Location: ".$_SERVER['PHP_SELF']);
                                exit();
                            } else {
                                echo "<p>삭제 중 오류가 발생했습니다: " . $conn->error . "</p>";
                            }
                        } else {
                            echo "<p>선택된 게시글이 없습니다.</p>";
                        }
                    }
        

                    // 결과가 있는 경우에만 출력
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr style='cursor: pointer;' onclick='if(event.target.type !== \"checkbox\") location.href=\"board.php?id=" . $row['id'] . "\";'>";
                            echo "<td><input type='checkbox' name='delete_ids[]' value='" . $row['id'] . "'></td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td>" . $row['author'] . "</td>";
                            $content = $row['content'];
                            $changedContent = strip_tags($content);
                            $changedStr = (mb_strlen($changedContent, 'UTF-8') > 20 ? htmlspecialchars(mb_substr($changedContent, 0, 20, 'UTF-8')) . "..." : htmlspecialchars($changedContent));
                            echo "<td>" . $changedStr . "</td>";
                            echo "<td>" . ($row['file_path'] ? "있음" : "없음") . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                    ?>
                </table>
                <?php if(isTeacher())  : ?>
                <button type="submit" name="delete_selected" id="deleteButton">선택한 항목 삭제</button>
                <?php endif; ?>
                </div>
                </form>
            </div>
            
    </div>
    <div class="footer">
            <p>&copy; 2023 홈페이지. All rights reserved.</p>
    </div>
</body>
</html>
<?php
$conn->close();
?>
