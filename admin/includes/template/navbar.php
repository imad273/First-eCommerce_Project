<!-- Navbar Template * -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">TRUC<sapn style="color: #5352ed;">TRY</sapn></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php"><?php echo lang("home_admin") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="categories.php"><?php echo lang("categories") ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="items.php"><?php echo lang("items") ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="members.php"><?php echo lang("members") ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><?php echo lang("statistics") ?></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['admin']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="members.php?action=edit&id=<?php echo $_SESSION['ID']; ?>"><?php echo lang("edit Profil") ?></a></li>
            <li><a class="dropdown-item" href="#"><?php echo lang("settings") ?></a></li>
            <li><a class="dropdown-item" href="../index.php">Visite Site</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="./logout.php"><?php echo lang("logout") ?></a></li>
          </ul>
        </li>
        
      </ul>
    </div>
  </div>
</nav>