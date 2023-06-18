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

    <div class="info">
    
      <h2>Products</h2>
    </div>

    <div class="items-grid">
      <?php
        require "database.php";
        $conn = get_connection();

        if (!isset($_COOKIE['user_logged_in'])) {
          header("Location: admin.php"); 
          exit();
      }
      
        $result = mysqli_query($conn, "SELECT * FROM products");
        
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          echo "<div class=item>";
          echo "<img src=$row[image] alt='Missing'>";
          echo "<h2>$row[name]</h2>";
          echo "<h3>Price: $row[price]$</h3>";
          echo "<h2>In stock: $row[quantity]</h2>";
          echo "<a href='update_product.php?id=$row[id]'><button class='update-btn'>Update</button></a>";
          echo "</div>";
        }

        mysqli_free_result($result);
        mysqli_close($conn);
        session_write_close(); 
      ?>
    </div>
    
    
  </body>
</html>
