<?php

if (!isset($_SESSION)) {
    session_start();
}


require_once 'config/database.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "Task ID is required";
    header("Location: index.php");
    exit();
}


$id = $_GET['id'];
if (!is_numeric($id)) {
    $_SESSION['error'] = "Invalid task ID";
    header("Location: index.php");
    exit();
}


$id = $conn->real_escape_string($id);

try {
    
    $check_sql = "SELECT id, title FROM tasks WHERE id = $id";
    $result = $conn->query($check_sql);
    
    if ($result === false) {
        throw new Exception("Error checking task: " . $conn->error);
    }
    
    if ($result->num_rows === 0) {
        throw new Exception("Task not found");
    }
    
   
    $task = $result->fetch_assoc();
    $task_title = $task['title'];
    
   
    $delete_sql = "DELETE FROM tasks WHERE id = $id";
    
   
    if ($conn->query($delete_sql) === TRUE) {
        $_SESSION['success'] = "Task '" . htmlspecialchars($task_title) . "' deleted successfully!";
    } else {
        throw new Exception("Error deleting task: " . $conn->error);
    }
    
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}


header("Location: index.php");
exit();
?>