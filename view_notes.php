<?php
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM notes WHERE user_id='$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Notes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Your Notes</h2>
    <p><a href="create_note.php">Create New Note</a></p>
    <p><a href="logout.php">Logout</a></p>

    <?php while($note = mysqli_fetch_assoc($result)) { ?>
        <div class="note">
            <h3><?php echo htmlspecialchars($note['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>
            <?php
            $note_id = $note['id'];
            $file_sql = "SELECT * FROM note_files WHERE note_id='$note_id'";
            $file_result = mysqli_query($conn, $file_sql);
            if (mysqli_num_rows($file_result) > 0) {
                while ($file = mysqli_fetch_assoc($file_result)) {
                    echo '<p><a href="' . htmlspecialchars($file['file_path']) . '" download>Download ' . htmlspecialchars(basename($file['file_path'])) . '</a></p>';
                }
            }
            ?>
            <small>Created at: <?php echo $note['created_at']; ?></small><br><br>
            <small>Updated at: <?php echo $note['updated_at']; ?></small><br><br>
            <a href="edit_note.php?id=<?php echo $note['id']; ?>">Edit</a> |
            <a href="delete_note.php?id=<?php echo $note['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </div>
        <hr>
    <?php } ?>
</div>
</body>
</html>