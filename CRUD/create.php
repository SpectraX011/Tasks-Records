<?php

if (!isset($_SESSION)) {
    session_start();
}


require_once 'config/database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
       
        if (empty(trim($_POST['title']))) {
            throw new Exception("Task title is required");
        }
        
        
        $title = $conn->real_escape_string(trim($_POST['title']));
        $description = $conn->real_escape_string(trim($_POST['description']));
        
        
       
        $sql = "INSERT INTO tasks (title, description) 
                VALUES ('$title', '$description')";
        
        
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Task created successfully!";
            header("Location: index.php");
            exit();
        } else {
            throw new Exception("Error creating task: " . $conn->error);
        }
        
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}


include_once 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h1>
            <i class="fas fa-plus-circle me-2"></i> Create New Task
            <small class="text-muted fs-6">Add a new task to your list</small>
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
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation" novalidate>
                    
           
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>"
                               required>
                        <div class="invalid-feedback">
                            Please provide a task title.
                        </div>
                    </div>
                    
                  
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                    </div>
                  
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i> Create Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
