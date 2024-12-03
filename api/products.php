<?php
include_once "../db.php";


// fetch all the products

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $sql = "SELECT * FROM items";
  $result = $pdo->query($sql);

  $products = $result->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($products);
}


// to create a product

elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
  $data = json_decode(file_get_contents("php://input"), true);

  $item_name = $data["item_name"];
  $item_desc = $data["item_desc"];
  $item_price = $data["item_price"];

  $sql = "INSERT INTO items (item_name, item_desc, item_price) VALUES (?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$item_name, $item_desc, $item_price]);

  echo json_encode(['message' => 'Product created successfully.']);
}


// to update a product

elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $data = json_decode(file_get_contents('php://input'), true);

  $item_id = $data["item_id"];
  $item_name = $data["item_name"];
  $item_desc = $data["item_desc"];
  $item_price = $data["item_price"];

  $sql = "UPDATE items SET item_name = ?, item_desc = ?, item_price = ? WHERE item_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$item_name, $item_desc, $item_price, $item_id]);

  echo json_encode(['message' => 'Product updated successfully.']);
}


// to delete a product

elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $data = json_decode(file_get_contents('php://input'), true);

  $item_id = $data['item_id'];

  $sql = "DELETE FROM items WHERE item_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$item_id]);

  echo json_encode(["message" => "Product deleted successfully."]);
}
