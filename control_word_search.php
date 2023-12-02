<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>단어검색</title>
        <link rel="stylesheet" href="./CSS/styles.css">
</head>
<body>
    <div class = "container">
<?php
$servername = "localhost";
$username = "phpadmin";
$password = "phpadmin";
$dbname = "goods";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['search_word'])) {
    $searchTerm = $_GET['search_word'];

    $sql = "SELECT * FROM english_word WHERE word LIKE '%$searchTerm%' OR meaning LIKE '%$searchTerm%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='container mt-4'>";
        echo "<h2>검색 결과</h2>";
        echo "<ul class='list-group'>";
        while ($row = $result->fetch_assoc()) {
            $word_id = $row['turn'];
            $word = $row['word'];
            $meaning = $row['meaning'];

            echo "<li class='list-group-item'>$word - $meaning ";
            echo "<form method='post' style='display:inline;'>";
            echo "<input type='hidden' name='delete_word_id' value='$word_id'>";
            echo "<button type='submit' name='delete_word_btn' class='btn btn-danger btn-sm'>삭제</button>";
            echo "</form> ";
            echo "<button onclick='editWord($word_id, \"$word\", \"$meaning\")' class='btn btn-primary btn-sm'>수정</button>";
            echo "</li>";
        }
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<p class='mt-4'>검색 결과가 없습니다.</p>";
    }
}

// 단어 삭제
if (isset($_POST['delete_word_btn'])) {
    $wordIdToDelete = $_POST['delete_word_id'];
    $deleteQuery = "DELETE FROM english_word WHERE turn = '$wordIdToDelete'";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<p class='mt-4'>단어가 삭제되었습니다. 새로고침을 눌러주세요.</p>";
    } else {
        echo "Error: " . $deleteQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>
</div>

<!-- 단어 수정 모달 -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>단어 수정</h2>
        <form id="editForm" method="post">
            <input type="hidden" id="editWordId" name="edit_word_id">
            <input type="text" id="editWord" name="edited_word" placeholder="수정할 단어" class="form-control mb-2">
            <input type="text" id="editMeaning" name="edited_meaning" placeholder="수정할 뜻" class="form-control mb-2">
            <button type="submit" name="submit_edit" class="btn btn-success">수정 완료</button>
        </form>
    </div>
</div>

<button onclick="goBack()" class="btn btn-secondary mt-4">뒤로가기</button>

<script>
    function goBack() {
        window.location.href = 'control_word.php';
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function editWord(id, word, meaning) {
        const modal = document.getElementById('editModal');
        const editForm = document.getElementById('editForm');
        const editWordId = document.getElementById('editWordId');
        const editWord = document.getElementById('editWord');
        const editMeaning = document.getElementById('editMeaning');

        modal.style.display = 'block';
        editWordId.value = id;
        editWord.value = word;
        editMeaning.value = meaning;

        editForm.onsubmit = function() {
            const editedWord = editWord.value;
            const editedMeaning = editMeaning.value;
            window.location.href = `edit_word.php?turn=${id}&word=${editedWord}&meaning=${editedMeaning}`;
            modal.style.display = 'none';
            return false;
        }
    }
</script>
