<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO notes (user_id, title, content) VALUES ('$user_id', '$title', '$content')";
    if (mysqli_query($conn, $sql)) {
        $note_id = mysqli_insert_id($conn); 
        
        if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
            $allowed_types = ['image/jpeg', 'image/png', 'application/pdf', 'text/plain'];
            $target_dir = "uploads/";
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $file_count = count($_FILES['files']['name']);
            for ($i = 0; $i < $file_count; $i++) {
                if ($_FILES['files']['error'][$i] == 0) {
                    if (!in_array($_FILES['files']['type'][$i], $allowed_types)) {
                        $message = "Invalid file type for " . htmlspecialchars($_FILES['files']['name'][$i]) . ". Only JPEG, PNG, PDF, and text files are allowed.";
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

        if (empty($message)) {
            $message = "Note created successfully.";
        }
    } else {
        $message = "Error creating note: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Note</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Create Note</h2>
    <?php if($message) echo "<div class='message'>$message</div>"; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="content" placeholder="Content" rows="5" required></textarea><br>
        <input type="file" name="files[]" multiple><br><br>
        <button type="submit">Create Note</button>
    </form>
    <p><a href="view_notes.php">Back to Notes</a></p>
    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>