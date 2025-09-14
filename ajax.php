<?php
header("Content-Type: application/json");
require './includes/db.php';

// Insert Data
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'insert') {
    // print_r($_REQUEST);
    $name = $_REQUEST['name'] ?? '';
    $email = $_REQUEST['email'] ?? '';
    $gender = $_REQUEST['gender'] ?? '';
    $city = $_REQUEST['city'] ?? '';

    $checkEmail = "SELECT id FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($checkEmail);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo json_encode(['code' => 409, 'msg' => 'You are already registered']);
        exit;
    }

    $check_stmt->close();

    $sql = "INSERT INTO users (name, email, gender, city) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $gender, $city);

    if ($stmt->execute()) {
        echo json_encode(['code' => 200, 'msg' => 'User added successfully']);
    } else {
        echo json_encode(['code' => 400, 'msg' => 'Error: ' . $stmt->error]);
    }


    $stmt->close();
}


// Update Data
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'update') {

    $id = $_REQUEST['id'];
    $name = $_REQUEST['name'] ?? '';
    $email = $_REQUEST['email'] ?? '';
    $gender = $_REQUEST['gender'] ?? '';
    $city = $_REQUEST['city'] ?? '';

    $sql = "UPDATE users SET name = ?, email = ?, gender = ?, city = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $gender, $city, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['code' => 200, 'msg' => 'Updated successfully']);
    } else {
        echo json_encode(['code' => 400, 'msg' => 'Error: ' . $stmt->error]);
    }

    $stmt->close();
}


// Search Data
if(isset($_REQUEST['action']) && $_REQUEST['action'] === 'search') {

    $query = "%" . $_REQUEST['query'] . "%";

    $sql = "SELECT * FROM users WHERE name LIKE ? OR email LIKE ? OR city LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $query, $query, $query);

    $stmt->execute();

    $result = $stmt->get_result();
    $results = [];

    while($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    echo json_encode($results);

    $stmt->close();
}


// Delete Data
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete') {

    $id = $_REQUEST['id'];
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        echo json_encode(['code' => 200, 'msg' => 'Deleted successfully']);
    } else {
        echo json_encode(['code' => 400, 'msg' => 'Error: ' . $stmt->error]);
    }

    $stmt->close();
}