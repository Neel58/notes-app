<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $note_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];

    $file_sql = "SELECT file_path FROM note_files WHERE note_id='$note_id'";
    $file_result = mysqli_query($conn, $file_sql);
    while ($file = mysqli_fetch_assoc($file_result)) {
        if (file_exists($file['file_path'])) {
            unlink($file['file_path']);
        }
    }

    $sql = "DELETE FROM notes WHERE id='$note_id' AND user_id='$user_id'";
    mysqli_query($conn, $sql);
}

header("Location: view_notes.php");
exit();
?>