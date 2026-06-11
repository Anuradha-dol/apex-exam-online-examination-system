<?php
include "../includes/auth_check.php";
checkRole('admin');
include "../config/db.php";

$pageTitle = "Manage Modules | Apex Exam";
$editModule = null;

if (isset($_POST['add_module']) || isset($_POST['update_module'])) {
    $module_code = trim($_POST['module_code'] ?? '');
    $module_name = trim($_POST['module_name'] ?? '');
    $lecturer_id = (int)($_POST['lecturer_id'] ?? 0);

    if ($module_code !== '' && $module_name !== '' && $lecturer_id > 0) {
        if (isset($_POST['update_module']) && isset($_POST['module_id'])) {
            $module_id = (int)$_POST['module_id'];
            $stmt = $conn->prepare("UPDATE modules SET module_code=?, module_name=?, lecturer_id=? WHERE module_id=?");
            $stmt->bind_param("ssii", $module_code, $module_name, $lecturer_id, $module_id);
            $stmt->execute();
        } else {
            $stmt = $conn->prepare("INSERT INTO modules (module_code,module_name,lecturer_id) VALUES (?,?,?)");
            $stmt->bind_param("ssi", $module_code, $module_name, $lecturer_id);
            $stmt->execute();
        }
    }

    header("Location: manage_modules.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM modules WHERE module_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header("Location: manage_modules.php");
    exit();
}

if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    if ($edit_id > 0) {
        $stmt = $conn->prepare("SELECT * FROM modules WHERE module_id=?");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $editModule = $stmt->get_result()->fetch_assoc();
    }
}

$lecturers = $conn->query("SELECT user_id,name FROM users WHERE role='lecturer' ORDER BY name");
$modules = $conn->query("SELECT m.*, u.name AS lecturer_name FROM modules m LEFT JOIN users u ON m.lecturer_id=u.user_id ORDER BY m.module_code, m.module_name");
include "../includes/header.php";
?>
<div class="card">
    <h2>Manage Modules</h2>
    <form method="POST" class="form-grid">
        <?php if ($editModule): ?>
            <input type="hidden" name="module_id" value="<?= htmlspecialchars($editModule['module_id']) ?>">
        <?php endif; ?>
        <div class="form-group">
            <label>Module Code</label>
            <input type="text" name="module_code" placeholder="Module Code" value="<?= htmlspecialchars($editModule['module_code'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Module Name</label>
            <input type="text" name="module_name" placeholder="Module Name" value="<?= htmlspecialchars($editModule['module_name'] ?? '') ?>" required>
        </div>
        <div class="form-group span-2">
            <label>Lecturer</label>
            <select name="lecturer_id" required>
                <option value="">Select Lecturer</option>
                <?php while($l = $lecturers->fetch_assoc()): ?>
                    <option value="<?= (int)$l['user_id'] ?>" <?= (isset($editModule['lecturer_id']) && $editModule['lecturer_id'] == $l['user_id']) ? 'selected' : '' ?>><?= htmlspecialchars($l['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="action-row span-2">
            <?php if ($editModule): ?>
                <button name="update_module">Update Module</button>
                <a href="manage_modules.php" class="btn btn-outline">Cancel</a>
            <?php else: ?>
                <button name="add_module">Add Module</button>
            <?php endif; ?>
            <a href="dashboard.php" class="btn btn-outline">Back</a>
        </div>
    </form>

    <div class="table-wrap mt-4">
        <table>
            <thead>
                <tr><th>Code</th><th>Name</th><th>Lecturer</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php while($m = $modules->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($m['module_code']) ?></td>
                    <td><?= htmlspecialchars($m['module_name']) ?></td>
                    <td><?= htmlspecialchars($m['lecturer_name']) ?></td>
                    <td>
                        <div class="action-row">
                            <a class="btn" href="?edit=<?= (int)$m['module_id'] ?>">Edit</a>
                            <a class="btn danger" href="?delete=<?= (int)$m['module_id'] ?>" onclick="return confirm('Delete module?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
