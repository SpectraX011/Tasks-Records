<?php
require_once 'config/database.php';
include_once 'includes/header.php';

$tasks = [];

$sql = "SELECT * FROM tasks ORDER BY created_at DESC";

try {
    $result = $conn->query($sql);
    if ($result === false) {
        throw new Exception("Error executing query: " . $conn->error);
    }
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
?>

<div class="row mb-4">
    <div class="col-md-8">
        <h4>
            Task Records
        </h4>
    </div>
    <div class="col-md-4 text-end">
        <a href="create.php" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New Task
        </a>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <?php if (empty($tasks)): ?>
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i> No tasks found. 
                <a href="create.php" class="alert-link">Add your first task</a>.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td>
                                    <?php 
                                        $desc = htmlspecialchars($task['description']);
                                        echo (strlen($desc) > 100) ? substr($desc, 0, 100) . '...' : $desc; 
                                    ?>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($task['created_at'])); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="update.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="delete.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-outline-danger delete-task">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>