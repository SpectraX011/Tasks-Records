<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once 'config/database.php';


$task = null;


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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        
        if (empty(trim($_POST['title']))) {
            throw new Exception("Task title is required");
        }
        
        
        $title = $conn->real_escape_string(trim($_POST['title']));
        $description = $conn->real_escape_string(trim($_POST['description']));
        $sql = "UPDATE tasks 
        SET title = '$title', 
            description = '$description' 
        WHERE id = $id";

      
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Task updated successfully!";
            header("Location: index.php");
            exit();
        } else {
            throw new Exception("Error updating task: " . $conn->error);
        }
        
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}


try {
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result === false) {
        throw new Exception("Error fetching task: " . $conn->error);
    }
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Task not found";
        header("Location: index.php");
        exit();
    }
    
    $task = $result->fetch_assoc();
    
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
    exit();
}

include_once 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h1>
            <i class="fas fa-edit me-2"></i> Update Task
            <small class="text-muted fs-6">Edit task details</small>
        </h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Tasks
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>" method="POST" class="needs-validation" novalidate>
                    
                   
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo htmlspecialchars($task['title']); ?>"
                               required>
                        <div class="invalid-feedback">
                            Please provide a task title.
                        </div>
                    </div>
                    
                   
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
                    </div>
                    
                    
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="text-muted mb-0">
                                <small>Created: <?php echo date('M d, Y H:i', strtotime($task['create_at'])); ?></small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-0">
                                <small>Last Updated: <?php echo date('M d, Y H:i', strtotime($task['updated_at'])); ?></small>
                            </p>
                        </div>
                    </div>
                    
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save me-2"></i> Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

include_once 'includes/footer.php';
?>