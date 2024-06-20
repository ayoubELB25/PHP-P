<?php
session_start();
require '../models/db.model.php';

// Ensure the user is logged in and is an employee
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'employee') {
  header("Location: ../views/login.view.php");
  exit();
}

// Fetch the logged-in employee's details
$stmt = $pdo->prepare("SELECT first_name, last_name FROM Users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$employee = $stmt->fetch();

// Fetch news with author names
$stmt = $pdo->prepare("SELECT title, content, u.username AS author_name FROM News n
                          INNER JOIN Users u ON n.author_id = u.user_id
                          ORDER BY news_id DESC");
$stmt->execute();
$news = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Employee Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .welcome {
      color: red;
    }
    .container {
      display: flex;
    }
    .content {
      width: 100%;
      padding: 10px;
    }
    .container h2 {
        color: orange;
    }
    .news {
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }
    .logout {
      position: absolute;
      top: 10px;
      right: 10px;
    }

    .news h5 {
      color: chartreuse;
      /* margin-bottom: 5px; */
    }
    .news h3 {
        color: dodgerblue;
    }
    .nav {
      display: flex; 
      list-style: none; 
      padding: 0; 
      margin: 0;
      font-family:Arial, Helvetica, sans-serif;
      margin-left: 18vw;
    }

    .nav ul {
      display: flex; 
      list-style: none; 
    }

    .nav li {
      margin-right: 1rem; 
    }

    .nav li button {
      background: none; 
      border: none; 
      padding: 0.5rem 1rem; 
      cursor: pointer; 
      color: inherit;
      text-decoration: none; 
      display: flex; 
      align-items: center;
    }

    .nav li button a {
      color: inherit; 
      text-decoration: none; 
    }

    .nav li button:hover {
      background-color: rgba(0, 0, 0, 0.1); 
    }

    .add-comment {
      background-color: green;
      color: white;
    }

  </style>
</head>
<body>
  <h1>Welcome, <span class="welcome"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></span></h1>
  <br><br>
    <nav class="nav">
        <ul>
            <li><button style="background-color: green;"><a href="../controllers/logout.controller.php">ADD A COMMENT</a></button></li>
            <li><button style="background-color: dodgerblue;"><a href="../controllers/logout.controller.php">EDIT MY ACCOUNT</a></button></li>
            <li><button style="background-color: red;"><a href="../controllers/logout.controller.php">LOG OUT</a></button></li>
        </ul>
    </nav>
    <br>
  <div class="container">
    <div class="content">
      <h2>News</h2>
      <hr>
      <?php foreach ($news as $item): ?>
        <div class="news">
          <h5><?php echo htmlspecialchars($item['author_name']); ?></h5>  <h3><?php echo htmlspecialchars($item['title']); ?></h3>
          <p><?php echo htmlspecialchars($item['content']); ?></p>
        </div>
      <?php endforeach; ?>
      <hr>
    </div>
  </
