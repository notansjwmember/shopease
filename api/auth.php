<?php

require_once "../config/config.php";
require_once "../db.php";


// for login

if ($_SERVER['REQUEST_METHOD' === 'POST']) {
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // check if user exists first
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

      // if we actually get to login, create a session
      session_start();
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['user_type'] = $user['user_type'];

      echo json_encode(["message" => "Login successful", "user" => $user]);
    } else {
      echo json_encode(["error" => "Invalid username or password"]);
    }
  } else {
    echo json_encode(["error" => "Bad request. No credentials found."]);
  }
}


// for registration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['username'], $_POST['password'], $_POST['name'], $_POST['email'], $_POST['user_type'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type']; // default value is customer

    // verify if all data are given
    $stmt = $pdo->prepare("INSERT INTO users (username, password, name, email, user_type)  VALUES (:username, :password, :name, :email, :user_type)");

    // group up all data 
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_type', $user_type);

    // then finally execute the post/insertion
    if ($stmt->execute()) {
      echo json_encode(["message" => "User registered successfully"]);
    } else {
      echo json_encode(["error" => "Registration failed"]);
    }
  } else {
    echo json_encode(["error" => "Missing required fields"]);
  }
}

