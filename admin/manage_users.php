<?php
include "../includes/auth_check.php";
checkRole('admin');
include "../config/db.php";

if (isset($_POST['add_user'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $allowedRoles = ['student', 'lecturer', 'admin'];
    $role = in_array($_POST['role'], $allowedRoles, true) ? $_POST['role'] : 'student';

    $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$users = $conn->query("SELECT * FROM users ORDER BY user_id DESC");
include "../includes/header.php";
?>
<div class="card">
    <h2>Manage Users</h2>
    <form method="POST" class="form-grid">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
            <label>Role</label>
            <select name="role" required>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="action-row span-2">
            <button name="add_user">Add User</button>
            <a href="dashboard.php" class="btn btn-outline">Back</a>
        </div>
    </form>

    <div class="table-wrap mt-4">
        <table>
            <thead>
                <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php while($u = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= (int)$u['user_id'] ?></td>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><span class="status-pill status-neutral"><?= htmlspecialchars($u['role']) ?></span></td>
                    <td><a class="btn danger" href="?delete=<?= (int)$u['user_id'] ?>" onclick="return confirm('Delete user?')">Delete</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include "../includes/footer.php"; ?>
