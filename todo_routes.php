<?php
// GET All Todos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include '../config/database.php';
    $query = "SELECT * FROM todo_list";
    $result = $conn->query($query);
    $todos = array();
    while ($row = $result->fetch_assoc()) {
        array_push($todos, $row);
    }
    echo json_encode($todos);
}

// GET Single Todo
elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    include '../config/database.php';
    $query = "SELECT * FROM todo_list WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $todo = $result->fetch_assoc();
    echo json_encode($todo);
}

// POST Create Todo
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../config/database.php';
    $data = json_decode(file_get_contents("php://input"));
    $task_name = $data->task_name;
    $status = $data->status;
    $query = "INSERT INTO todo_list (task_name, status) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $task_name, $status);
    $stmt->execute();
    echo json_encode(array('message' => 'Todo Created'));
}

// PUT Update Todo
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    include '../config/database.php';
    $data = json_decode(file_get_contents("php://input"));
    $task_name = $data->task_name;
    $status = $data->status;
    $query = "UPDATE todo_list SET task_name = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $task_name, $status, $id);
    $stmt->execute();
    echo json_encode(array('message' => 'Todo Updated'));
}

// DELETE Todo
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    include '../config/database.php';
    $query = "DELETE FROM todo_list WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(array('message' => 'Todo Deleted'));
} else {
    echo json_encode(array('message' => 'Invalid Request'));
}
?>
