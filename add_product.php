<?php
require "database.php";
$connection = get_connection();

if (!isset($_COOKIE['user_logged_in'])) {
    header("Location: admin.php"); 
    exit();
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];

    $query = "INSERT INTO products (name, price, image, quantity) VALUES ('$name', '$price', '$image', '$quantity')";
    $insertResult = mysqli_query($connection, $query);

    if ($insertResult) {
        $_SESSION["message"] = "New item added successfully!";
        header("Location: productsAdmin.php");
        exit();
    } else {
        $_SESSION["message"] = "Error adding new item.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <title>Web Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1>Web Shop</h1>
    <nav>
    <a href="dashboard.php"><button>Home</button></a>
      <a href="productsAdmin.php"><button>Browse products</button></a>
      <a href="add_product.php"><button>Add new product</button></a>
      <a href="logout.php"><button>Logout</button></a>
    </nav>
    <div class="form-container2">
    <h2>Add New Item</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="price">Price:</label>
        <input type="number" min="0" step="0.01" name="price" id="price" required><br>

        <label for="image">Image link:</label>
        <textarea name="image" id="image" required></textarea><br>

        <label for="quantity">Quantity:</label>
        <input type="number" min="0" step="1" name="quantity" id="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required><br>

        <input type="submit" name="submit" value="Add Item">
    </form>
    </div>
</body>
</html>
