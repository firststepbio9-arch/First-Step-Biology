<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'config.php';
$message = "";

// Handle Add/Edit/Delete
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $stmt = $conn->prepare("INSERT INTO courses (title, description, category_id, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssid", $_POST['title'], $_POST['description'], $_POST['category_id'], $_POST['price']);
        $stmt->execute();
        $message = "Course added.";
    } elseif (isset($_POST['edit'])) {
        $stmt = $conn->prepare("UPDATE courses SET title=?, description=?, category_id=?, price=? WHERE id=?");
        $stmt->bind_param("ssidi", $_POST['title'], $_POST['description'], $_POST['category_id'], $_POST['price'], $_POST['id']);
        $stmt->execute();
        $message = "Course updated.";
    } elseif (isset($_GET['delete'])) {
        $conn->query("DELETE FROM courses WHERE id=" . $_GET['delete']);
        $message = "Course deleted.";
    }
}

$courses = $conn->query("SELECT c.*, cat.name AS category FROM courses c JOIN categories cat ON c.category_id = cat.id");
$categories = $conn->query("SELECT * FROM categories");
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <nav class="bg-dark text-white" style="width: 250px; min-height: 100vh;">
            <!-- Same sidebar -->
        </nav>
        <div class="flex-grow-1 p-4">
            <h2>Manage Courses</h2>
            <?php if ($message): ?><div class="alert alert-success"><?php echo $message; ?></div><?php endif; ?>
            <form method="POST" class="mb-4">
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-md-3"><input type="text" name="title" id="title" class="form-control" placeholder="Title" required></div>
                    <div class="col-md-3"><textarea name="description" id="description" class="form-control" placeholder="Description"></textarea></div>
                    <div class="col-md-2"><select name="category_id" id="category_id" class="form-control" required><option value="">Category</option><?php while ($cat = $categories->fetch_assoc()): ?><option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option><?php endwhile; ?></select></div>
                    <div class="col-md-2"><input type="number" step="0.01" name="price" id="price" class="form-control" placeholder="Price" required></div>
                    <div class="col-md-2"><button type="submit" name="add" class="btn btn-success">Add</button> <button type="submit" name="edit" class="btn btn-warning">Edit</button></div>
                </div>
            </form>
            <table class="table table-striped">
                <thead><tr><th>ID</th><th>Title</th><th>Description</th><th>Category</th><th>Price</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php while ($row = $courses->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td>$<?php echo $row['price']; ?></td>
                            <td><button class="btn btn-sm btn-primary" onclick="editCourse(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['description']); ?>', <?php echo $row['category_id']; ?>, <?php echo $row['price']; ?>)">Edit</button> <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function editCourse(id, title, desc, cat, price) {
            document.getElementById('id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('description').value = desc;
            document.getElementById('category_id').value = cat;
            document.getElementById('price').value = price;
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>
