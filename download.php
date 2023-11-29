<?php
// download.php

if (isset($_GET['file'])) {
    $file_path = $_GET['file'];

    // 파일이 존재하는지 확인
    if (file_exists($file_path)) {
        // 다운로드 헤더 설정
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        ob_clean();
        flush();
        readfile($file_path);
        exit;
    } else {
        echo "파일이 존재하지 않습니다.";
    }
} else {
    echo "파일 정보가 전달되지 않았습니다.";
}
?>
