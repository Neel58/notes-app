<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = '';

if (isset($_GET['id'])) {
    $note_id = intval($_GET['id']);
    $sql = "SELECT * FROM notes WHERE id='$note_id' AND user_id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $note = mysqli_fetch_assoc($result);

    if (!$note) {
        header("Location: view_notes.php");
        exit();
    }
}

if (isset($_GET['delete_file'])) {
    $file_id = intval($_GET['delete_file']);
    $file_sql = "SELECT file_path FROM note_files WHERE id='$file_id' AND note_id='$note_id'";
    $file_result = mysqli_query($conn, $file_sql);
    $file = mysqli_fetch_assoc($file_result);

    if ($file) {
        if (file_exists($file['file_path'])) {
            unlink($file['file_path']); // Delete file from server
        }
        mysqli_query($conn, "DELETE FROM note_files WHERE id='$file_id'");
        $message = "File deleted successfully.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    // Update note details
    $sql = "UPDATE notes SET title='$title', content='$content' WHERE id='$note_id' AND user_id='$user_id'";
    if (mysqli_query($conn, $sql)) {
        // Handle new file uploads
        if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf', 'text/plain'];
            $target_dir = "Uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_count = count($_FILES['files']['name']);
            for ($i = 0; $i < $file_count; $i++) {
                if ($_FILES['files']['error'][$i] == 0) {
                    if (!in_array($_FILES['files']['type'][$i], $allowed_types)) {
                        $message = "Invalid file type for " . htmlspecialchars($_FILES['files']['name'][$i]) . ".";
                        continue;
                    }

                    $filename = basename($_FILES['files']['name'][$i]);
                    $target_file = $target_dir . time() . "_" . $filename;

                    if (move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file)) {
                        $file_path = mysqli_real_escape_string($conn, $target_file);
                        $file_sql = "INSERT INTO note_files (note_id, file_path) VALUES ('$note_id', '$file_path')";
                        mysqli_query($conn, $file_sql);
                    } else {
                        $message = "Error uploading file: " . htmlspecialchars($_FILES['files']['name'][$i]);
                    }
                }
            }
        }
        $message = empty($message) ? "Note updated successfully." : $message;
    } else {
        $message = "Error updating note: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Note</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Note</h2>
        <?php if($message) echo "<div class='message'>$message</div>"; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="title" value="<?php echo htmlspecialchars($note['title']); ?>" required><br>
            <textarea name="content" rows="5" required><?php echo htmlspecialchars($note['content']); ?></textarea><br>
            <label>Current Files:</label><br>
            <?php
            $file_sql = "SELECT * FROM note_files WHERE note_id='$note_id'";
            $file_result = mysqli_query($conn, $file_sql);
            if (mysqli_num_rows($file_result) > 0) {
                while ($file = mysqli_fetch_assoc($file_result)) {
                    echo '<p>' . htmlspecialchars(basename($file['file_path'])) . ' <a href="?id=' . $note_id . '&delete_file=' . $file['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a></p>';
                }
            } else {
                echo '<p>No files uploaded.</p>';
            }
            ?>
            <input type="file" name="files[]" multiple><br><br>
            <button type="submit">Update Note</button>
        </form>
        <p><a href="view_notes.php">Back to Notes</a></p>
    </div>
</body>
</html>