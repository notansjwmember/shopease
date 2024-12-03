<?php
include_once "../db.php";


// fetch all the customers

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $cus_id = $_GET['cus_id'] ?? '';
  $sql = "SELECT * FROM customer_profile WHERE cus_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$cus_id]);

  $customer = $stmt->fetch(PDO::FETCH_ASSOC);

  echo json_encode($customer);
}


// to create a customer

elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $data = json_decode(file_get_contents("php://input"), true);

  $cus_id = $data['cus_id'];
  $name = $data['name'];
  $gender = $data['gender'];

  $sql = "UPDATE customer_profile SET name = ?, gender = ? WHERE cus_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$name, $gender, $cus_id]);

  echo json_encode(['message' => 'Customer profile updated successfully!']);
}
