<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/css/style.css">
    <title>eShop</title>
  </head>
  <body>
    <nav>
      <h1>SI Online Shop</h1>
      <ul>
        <li><a href="/index.php">Home</a></li>
        <li><a href="/cart.php">Cart</a></li>
      <?php if (isset($_SESSION['login'])): ?>
        <li><a href="/user/user_info.php">Account</a></li>
        <li><a href="/logout.php">Log out</a></li>
      <?php else: ?>
        <li><a href="/login/login.php">Log in</a></li>
        <li><a href="/register/register_form.php">Register</a></li>
      <?php endif; ?>
        <li><a href="/contact.php">Contact</a></li>
      </ul>
    </nav>
