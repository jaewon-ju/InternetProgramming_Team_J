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
        echo "<h2>검색 결과</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $word_id = $row['turn'];
            $word = $row['word'];
            $meaning = $row['meaning'];

            echo "<li>$word - $meaning ";
            echo "<form method='post' style='display:inline;'>";
            echo "<input type='hidden' name='delete_word_id' value='$word_id'>";
            echo "<button type='submit' name='delete_word_btn'>삭제</button>";
            echo "</form> ";
            echo "<button onclick='editWord($word_id, \"$word\", \"$meaning\")'>수정</button>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>검색 결과가 없습니다.</p>";
    }
}
    
// 단어 삭제
if (isset($_POST['delete_word_btn'])) {
    $wordIdToDelete = $_POST['delete_word_id'];
    $deleteQuery = "DELETE FROM english_word WHERE id = '$wordIdToDelete'";
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<p>단어가 삭제되었습니다: $wordIdToDelete</p>";
    } else {
        echo "Error: " . $deleteQuery . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- 단어 수정 모달 -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>단어 수정</h2>
        <form id="editForm" method="post">
            <input type="hidden" id="editWordId" name="edit_word_id">
            <input type="text" id="editWord" name="edited_word" placeholder="수정할 단어">
            <input type="text" id="editMeaning" name="edited_meaning" placeholder="수정할 뜻">
            <button type="submit" name="submit_edit">수정 완료</button>
        </form>
    </div>
</div>

<script>
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

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    }
</script>

<button onclick="goBack()">뒤로가기</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
