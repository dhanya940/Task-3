<?php
include 'db.php';
session_start();

// --- Redirect if not logged in ---
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// --- Search functionality ---
$search = isset($_GET['q']) ? $_GET['q'] : "";

// --- Pagination setup ---
$perPage = 3; // Show 3 posts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $perPage;

// Count total posts (with search filter)
$countSql = "SELECT COUNT(*) AS total FROM posts 
             WHERE title LIKE ? OR content LIKE ?";
$stmt = $conn->prepare($countSql);
$like = "%$search%";
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$countResult = $stmt->get_result()->fetch_assoc();
$totalPosts = $countResult['total'];
$totalPages = ceil($totalPosts / $perPage);

// Fetch posts (with search + pagination)
$sql = "SELECT * FROM posts 
        WHERE title LIKE ? OR content LIKE ?
        ORDER BY created_at DESC 
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $like, $like, $offset, $perPage);
$stmt->execute();
$result = $stmt->get_result();

// Store results in array
$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

// Return data
return [
    "posts" => $posts,
    "totalPages" => $totalPages,
    "page" => $page,
    "search" => $search
];
