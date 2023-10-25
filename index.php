<?php
    try {
        $db_host = "db";
        $db_name = "todoapp";
        $db_user = "root";
        $db_pass = "secret";

        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Add a new task
    if (isset($_POST['addTask'])) {
        $task = $_POST['task'];

        $sql = "INSERT INTO todos (task) VALUES (:task)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':task', $task, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header('Location: index.php');
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>TODO App</title>
</head>
<body>
    <h1>TODO App</h1>

    <!-- Add a new task form -->
    <form method="post">
        <input type="text" name="task" placeholder="Enter a new task" required>
        <button type="submit" name="addTask">Add Task</button>
    </form>
    <?
    // Display tasks
    $sql = "SELECT * FROM todos";
    $stmt = $conn->query($sql);

    if ($stmt->rowCount() > 0) {
        echo "<ul>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $task = $row['task'];
            $taskId = $row['id'];
            $completed = $row['completed'] ? 'checked' : '';

            echo "<li>
                    <input type='checkbox' $completed onchange='toggleComplete($taskId)'>
                    $task
                </li>";
        }
        echo "</ul>";
    } else {
        echo "No tasks found.";
    }
    ?>

    <script>
        // Toggle task completion
        function toggleComplete(taskId) {
            fetch(`toggle.php?id=${taskId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Refresh the page
                    } else {
                        console.error(data.message);
                    }
                });
        }
    </script>
</body>
</html>
