<?php
require "database.php";
$connection = get_connection();

if (isset($_GET['id'])) {
    $productID = $_GET['id'];

    // Retrieve the product information from the database
    $query = "SELECT * FROM products WHERE id = $productID";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        $_SESSION["message"] = "Product not found.";
        exit();
    }
} else {
    $_SESSION["message"] = "Invalid product ID.";
    exit();
}

// Check if the delete button is clicked
if (isset($_POST['delete'])) {
    // Delete the product from the database
    $query = "DELETE FROM products WHERE id = $productID";
    $deleteResult = mysqli_query($connection, $query);

    if ($deleteResult) {
        $_SESSION["message"] = "Product deleted successfully!";
        header("Location: productsAdmin.php");
        exit();
    } else {
        $_SESSION["message"] = "Error deleting product.";
    }
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $quantity = $_POST['quantity'];

    // Update the product information in the database
    $query = "UPDATE products SET name = '$name', price = '$price', image = '$image', quantity = '$quantity' WHERE id = $productID";
    $updateResult = mysqli_query($connection, $query);

    if ($updateResult) {
        $_SESSION["message"] = "Product updated successfully!";
    } else {
        $_SESSION["message"] = "Error updating product.";
    }
    header("Location: productsAdmin.php");
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
      <a href="index.php"><button>Logout</button></a>
    </nav>
    <b></b>
    
    <div class="form-container2">
    <h2>Product Details</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>

        <label for="image">Image link:</label>
        <textarea name="image" id="image" required><?php echo htmlspecialchars($product['image']); ?></textarea><br>

        <label for="quantity">Quantity:</label>
        <input type="number" step="1" name="quantity" id="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required><br>

        <input type="submit" name="submit" value="Save Changes">
    </form>

    <form action="" method="POST">
        <input type="submit" name="delete" value="Delete Product" class="delete-btn">
    </form>
    </div>
</body>
</html>
