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
        <a href="ordersAdmin.php"><button>Orders</button></a>
        <a href="index.php"><button>Logout</button></a>
    </nav>

    <div class="orders-container">
        <h2>Orders</h2>

        <?php
        // Assuming you have a function to establish database connection called "get_connection()"
        require "database.php";
        $conn = get_connection();

        // Retrieve orders from the database
        $query = "SELECT * FROM orders";
        $result = mysqli_query($conn, $query);

        // Check if any orders exist
        if (mysqli_num_rows($result) > 0) {
            // Loop through each order and display the details
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='order-item'>";
                echo "<h3>Order ID: " . $row['id'] . "</h3>";
                echo "<p>Name: " . $row['first_name'] . " " . $row['last_name'] . "</p>";
                echo "<p>Address: " . $row['address'] . "</p>";
                echo "<p>Products: " . $row['products'] . "</p>";
                echo "<p>Total Price: $" . $row['total_price'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No orders found.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>

    </div>
  </body>
</html>
