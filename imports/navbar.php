<?php
  include "./php/includes/settings.php";
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">404Chat</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo CHAT_FILENAME ?>">Chat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Change username</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" tabindex="-1" aria-disabled="true" id="navbar_username">Username: </a>
        </li>
				<li class="nav-item">
					<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true" id="navbar_room">Current room: </a>
				</li>
      </ul>
    </div>
  </div>
</nav>
