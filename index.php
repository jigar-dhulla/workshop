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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-blue-500 p-4 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">TODO App</h1>
            <!-- Add any additional navbar elements or links here -->
        </div>
    </nav>
    <div class="container mx-auto mt-8">
        <!-- Add a new task form -->
        <form method="post" class="my-4">
            <div class="flex">
                <input type="text" name="task" placeholder="Enter a new task" class="px-2 py-1 border rounded-l w-full" required>
                <button type="submit" name="addTask" class="bg-blue-500 text-white px-4 py-1 rounded-r hover:bg-blue-600">Add</button>
            </div>
        </form>
        <?php
        // Display tasks
        $sql = "SELECT * FROM todos";
        $stmt = $conn->query($sql);
        if ($stmt->rowCount() > 0) {
            echo "<ul class='my-4'>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $task = $row['task'];
                $taskId = $row['id'];
                $completed = $row['completed'] ? 'checked' : '';
        
                echo "<li class='flex items-center justify-between px-2 py-1 border-b'>
                        <label class='flex items-center space-x-2'>
                            <input type='checkbox' $completed onchange='toggleComplete($taskId)' class='form-checkbox'>
                            <span class='text-lg'>$task</span>
                        </label>
                    </li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='text-gray-600'>No tasks found.</p>";
        }
        ?>
    </div>

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
