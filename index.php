<?php
$data = include 'posts.php'; 
$posts = $data['posts'];
$totalPages = $data['totalPages'];
$page = $data['page'];
$search = $data['search'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body.dark-mode {
            background-color: #121212;
            color: white;
        }
        body.dark-mode .card {
            background-color: #1e1e1e;
            color: white;
        }
        .theme-toggle {
            cursor: pointer;
        }
    </style>
</head>
<body class="container mt-4">

    <!-- Top Navbar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📚 Blog Posts</h2>
        <div>
            <button class="btn btn-secondary theme-toggle">🌙 / ☀️</button>
            <a href="logout.php" class="btn btn-danger ms-2">🚪 Logout</a>
        </div>
    </div>

    <!-- Search Form -->
    <form method="get" class="d-flex mb-3">
        <input type="text" name="q" class="form-control me-2" placeholder="Search posts..."
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <?php if (count($posts) > 0): ?>
        <?php foreach ($posts as $row): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-title"><?= htmlspecialchars($row['title']) ?></h4>
                    <p class="card-text"><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                    <small class="text-muted">Posted on: <?= $row['created_at'] ?></small><br>
                    <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info mt-2">View</a>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning mt-2">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger mt-2">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Pagination -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&q=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    <?php else: ?>
        <div class="alert alert-info">No posts found.</div>
    <?php endif; ?>

    <a href="create.php" class="btn btn-success">➕ Add New Post</a>

    <script>
        const toggleBtn = document.querySelector(".theme-toggle");
        toggleBtn.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
        });
    </script>
</body>
</html>
