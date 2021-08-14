<!-- Navbar Template * -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">TRUC<sapn style="color: #5352ed;">TRY</sapn></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./index.php"><?php echo lang("home_admin") ?></a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?php 
              $cats = showCat();
              foreach($cats as $cat){
                echo "<li><a class='dropdown-item' href='categories.php?catid=" . $cat['ID'] . "&catname=" . str_replace(" ", "-", $cat['Name']) . "'>" . $cat['Name'] . "</a></li>";
              } 
            ?>
          </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="items.php"><?php echo lang("items") ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="members.php">Contact</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
              if(isset($_SESSION['username'])){
                echo $_SESSION['username'];
              } else {
                echo "Account";
              }
            ?>
          </a>
          <?php 
            if(isset($_SESSION['username'])){
              echo "<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>";
                echo "<li><a class='dropdown-item' href='#'>Edit Profil</a></li>";
                echo "<li><a class='dropdown-item' href='profile.php'>My Profile</a></li>";
                echo "<li><hr class='dropdown-divider'></li>";
                echo "<li><a class='dropdown-item' href='logout.php'>Logout</a></li>";
              echo "</ul>";
            } else {  
              echo "<ul class='dropdown-menu' aria-labelledby='navbarDropdown'>";
                echo "<li><a class='dropdown-item' href='login.php'>Login</a></li>";
                echo "<li><hr class='dropdown-divider'></li>";
                echo "<li><a class='dropdown-item' href='singUp.php'>Create Account</a></li>";
              echo "</ul>";
          
            }
          ?>
          </li>
      </ul>
    </div>
  </div>
</nav>