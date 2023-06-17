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
      if (!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
      } else {
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
    <div class="gridrow2">

        <div class="cart-items">
        <?php
            if (empty($_SESSION["shopping_cart"])) {
            echo "<script language='javascript'>";
            echo "alert('Cart is empty.')";
            echo "</script>";
            session_write_close();
            exit;
            }
            $total_cart_price = 0;
            foreach ($_SESSION["shopping_cart"] as $key => $item) {
            $total_price = $item["quantity"] * $item["price"];
            $total_cart_price+=$total_price;
            echo "<div class=cart-item>";
            echo "<h2>$item[quantity]x $item[name]</h2>";
            echo "<h3>Total price: $total_price$</h3>";
            echo "</div>";
            }
            echo "<h2 class=cart-totatal-price>Cart total price: $total_cart_price$</h2>";
            session_write_close();
        ?>
        </div>


        <div class="order">
        <form class="form-container" method="POST">
            <label for="order-first-name">First name: </label>
            <input type="text" name="order-first-name" id="order-first-name" required>
            
            <label for="order-last-name">Last name: </label>
            <input type="text" name="order-last-name" id="order-last-name" required>

            <label for="order-address">Address: </label>
            <input type="text" name="order-address" id="order-address" required>

            <input type="submit" name="order-submit" value="Order">
        </form>
        <?php
           if (isset($_POST["order-submit"])) {
            require "database.php";
        
            if (empty($_SESSION["shopping_cart"])) {
                echo "<script language='javascript'>";
                echo "alert('Cart is empty.')";
                echo "</script>";
                session_write_close();
                exit;
            }
        
            $conn = get_connection();
            $first_name = $_POST["order-first-name"];
            $last_name = $_POST["order-last-name"];
            $address = $_POST["order-address"];
            $total_cart_price = 0;
            $products = "";
        
            foreach ($_SESSION["shopping_cart"] as $key => $item) {
                $product_id = $item["id"];
                $quantity = $item["quantity"];
                $product_name = $item["name"];
                $total_price = $item["price"] * $quantity;
                $total_cart_price += $total_price;
        
                $products .= "Product id: $product_id, Product name: $product_name, Quantity : $quantity ||";

                mysqli_query($conn, "UPDATE products SET quantity = quantity - $quantity WHERE id = $product_id");
                
            }
        
            mysqli_query($conn, "INSERT INTO orders (user_id, first_name, last_name, address, products, total_price)
                                VALUES (1, '$first_name', '$last_name', '$address', '$products', $total_cart_price)");

session_start();    
            unset($_SESSION["shopping_cart"]);
            $_SESSION["message"] = "Your order was requested successfully.";
            header("Location: index.php");
        }
        session_write_close();
        ?>
        </div>
    </div>
  </body>
</html>