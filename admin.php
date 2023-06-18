<!--  <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="index.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Admin Login</title>
</head>
<body>
    <h1>Web Shop</h1>
    <?php
        if (isset($_COOKIE['user_logged_in']) && $_COOKIE['user_logged_in'] === 'true') {
            // User is logged in based on the cookie, proceed to the dashboard
            header("Location: dashboard.php");
            exit();
        }
      session_start();
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
 <!--    <h2>Admin Login</h2>
    <form action="admin.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" name="submit" value="Login">
    </form>
 -->
    <div class="admin-login-container">
        <div class="admin-login-form">
        <h2>Admin Login</h2>
        <form action="admin.php" method="POST">
            <label for="email">Email:   </label>
            <input type="email" name="email" id="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" name="submit" value="Login">
        </form>
        </div>
    </div>
    <?php
   require "database.php";
   $connection = get_connection();
   

    
    function authenticateUser($connection, $email, $password) {
        
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

           
            if($password == $user['password']){
               
                return true;
            }
        }

       
        return false;
    }

   
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

      
        if (authenticateUser($connection, $email, $password)) {
          
            setcookie('user_logged_in', 'true', time() + 3600);
            header("Location: dashboard.php");
            exit();
        } else {
           
            echo "Invalid email or password.";
        }
    }

   
    mysqli_close($connection);
   
    ?>
</body>
</html>
