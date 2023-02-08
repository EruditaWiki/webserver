<?php

require_once('config.php');
require_once('functions.php');
require_once('bootstrap.php');
require_once('scrollbar.php');


session_start();

if (isset($_SESSION['user'])) {
  $user = getUser($_SESSION['user']);
}

?>

<head>
  <link rel="shortcut icon" type="image/x-icon" href="assets/v2.png">
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <div class="navbar-brand">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="navbar-brand" href="index.php">
            <img src="assets/v2_round.png" alt="Logo" class="mr-2" width="32" height="32">
            Erudita
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php">Kategorien</a>
        </li>
        <?php if (isset($_SESSION['user'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="edit.php">Erstellen</a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link" href="about.php">Über uns</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="faq.php">FAQ</a>
        </li>
      </ul>
    </div>
    <ul class="navbar-nav ml-auto">
      <?php if (isset($_SESSION['user'])): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="index.php" id="navbarDropdownMenuLink" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php if (isset($user['profile_image'])): ?>
              <img src="<?php echo $user['profile_image']; ?>" width="32" height="32">
            <?php endif; ?>
            <?php echo htmlspecialchars($user['username']); ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="profile.php">Profil</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Sign In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Sign Up</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

