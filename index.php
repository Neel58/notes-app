<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM notes WHERE user_id = '$user_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Your Notes</h1>
    <a href="create_note.php">Create New Note</a>
    

    <ul>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <li>
                <a href="view_note.php?id=<?php echo $row['note_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                <a href="edit_note.php?id=<?php echo $row['note_id']; ?>">Edit</a>
                <a href="delete_note.php?id=<?php echo $row['note_id']; ?>">Delete</a>
            </li>
        <?php } ?>
    </ul>
</body>
</html>
