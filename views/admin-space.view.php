<?php
session_start();
require '../models/db.model.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../views/login.view.php");
    exit();
}

//
$stmt = $pdo->prepare("SELECT user_id, first_name, last_name FROM Users WHERE role_id = (SELECT role_id FROM Roles WHERE role_name = 'employee')");
$stmt->execute();
$employees = $stmt->fetchAll();

//
$stmt = $pdo->prepare("SELECT title, content, u.username AS author_name FROM News n
                          INNER JOIN Users u ON n.author_id = u.user_id
                          ORDER BY author_id DESC, news_id DESC");
$stmt->execute();
$news = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>ADMIN SPACE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .welcome {
            color: yellow;
        }
        .container {
            display: flex;
        }
        .sidebar {
            width: 25%;
            padding: 10px;
            background-color:#262835;
            border: 1px solid transparent;
            /* border-radius: 7%; */
            margin-right: 40px;
        }
        .sidebar h2 {
            color: orange;
        }
        .sidebar ul {
            list-style: none;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
        }
        .sidebar a:hover {
            color: dodgerblue;
        }
        .content {
            width: 75%;
            padding: 10px;
        }
        .content h2 {
            color: orange;
            cursor: default;
        }
        .news {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .news h3 {
            color: dodgerblue;
        }
        .news h5 {
            color:chartreuse;
        }
        .news.pinned {
            background-color: #fff7e6;
        }
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
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
    </style>
</head>
<body>
    <h1>Welcome, <span class="welcome"><?php echo htmlspecialchars($_SESSION['username']); ?></span> </h1>
    <br><br>
    <nav class="nav">
        <ul>
            <li><button style="background-color: green;"><a href="../controllers/logout.controller.php">ADD A COMMENT</a></button></li>
            <li><button style="background-color: dodgerblue;"><a href="../controllers/logout.controller.php">ADD AN EMPLOYEE</a></button></li>
            <li><button style="background-color: red;"><a href="../controllers/logout.controller.php">LOG OUT</a></button></li>
        </ul>
    </nav>
    <hr>
    <br>
    <div class="container">
        <div class="sidebar">
            <h2>Employees</h2>
            <ul>
                <?php foreach ($employees as $employee): ?>
                    <li><a href="employee.view.php?id=<?php echo $employee['user_id']; ?>"><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="content">
            <h2>News</h2>
            <?php foreach ($news as $item): ?>
            <div class="news">
                <h5><?php echo htmlspecialchars($item['author_name']); ?></h5>  <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                <p><?php echo htmlspecialchars($item['content']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
