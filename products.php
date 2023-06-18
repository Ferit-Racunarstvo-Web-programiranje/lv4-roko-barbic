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
    <?php
      session_start();
      if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        echo "<script language='javascript'>";
        echo "alert('$message')";
        echo "</script>";
        unset($_SESSION['message']);
      }
      if(!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
      }
      else{
        $cart_count = 0;
      }
    ?>
    <nav>
        <a href="index.php"><button>Home</button></a>
      <a href="products.php"><button>Browse shop</button></a>
      <a href="cart.php"><button>Cart<span class="cart-badge"><?php echo $cart_count; ?></span></button></a>
      <a href="order.php"><button>Order information</button></a>
      <a href="admin.php"><button>Admin Login</button></a>
    </nav>
    <div class="info">
     
      <h2>Products</h2>
    </div>
    <div class="items-grid">
      <?php
        require "database.php";
        $conn = get_connection();
        $result = mysqli_query($conn, "SELECT * FROM products");
		    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<div class=item>";
            echo "<img src=$row[image] alt='Missing'>";
            echo "<h2>$row[name]</h2>";
            echo "<h3>Price: $row[price]$</h3>";
            echo "<form method='POST'>";
            echo "<div class='form-row'>";
            echo "<label for=$row[name]-quantity>Quantity: </label>";
            echo "<input type='number' name=$row[name]-quantity min='1' max='50' value='1'>";
            echo "</div>";
            echo "<input type='submit' value='Add to cart' class='add-to-cart-btn' name=$row[name]-insert>";
            echo "</form>";
            echo "</div>";
          
            if (isset($_POST[$row["name"]."-insert"])) {
                $quantity = (int)$_POST[$row["name"]."-quantity"];
                $db_quantity = $row["quantity"];
          
                if ($quantity <= $db_quantity) {
                  $itemArray = array(
                    $row["name"] => array(
                      'id' => $row["id"],
                      'name' => $row["name"],
                      'image' => $row["image"],
                      'price' => $row["price"],
                      'quantity' => $quantity, // Store entered quantity
                    ),
                  );
          
                  if (empty($_SESSION["shopping_cart"])) {
                    $_SESSION["shopping_cart"] = $itemArray;
                    $_SESSION["message"] = "Product added successfully.";
                  } else {
                    $array_keys = array_keys($_SESSION["shopping_cart"]);
                    if (in_array($row["name"], $array_keys)) {
                      $_SESSION["message"] = "Product is already in your cart.";
                    } else {
                      $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $itemArray);
                      $_SESSION["message"] = "Product added successfully.";
                    }
                  }
                } else {
                  $itemArray = array(
                    $row["name"] => array(
                      'id' => $row["id"],
                      'name' => $row["name"],
                      'image' => $row["image"],
                      'price' => $row["price"],
                      'quantity' => $db_quantity, // Store available quantity
                    ),
                  );
          
                  if (empty($_SESSION["shopping_cart"])) {
                    $_SESSION["shopping_cart"] = $itemArray;
                    $_SESSION["message"] = "Product added successfully, but the quantity is $db_quantity because that is all we have.";
                  } else {
                    $array_keys = array_keys($_SESSION["shopping_cart"]);
                    if (in_array($row["name"], $array_keys)) {
                      $_SESSION["message"] = "Product is already in your cart.";
                    } else {
                      $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $itemArray);
                      $_SESSION["message"] = "Product added successfully, but the quantity is $db_quantity because that is all we have.";
                    }
                  }
                }
            header("Location: products.php");
          }
        }

        mysqli_free_result($result);
        mysqli_close($conn);
        session_write_close();
      ?>
    </div>
  </body>
</html>