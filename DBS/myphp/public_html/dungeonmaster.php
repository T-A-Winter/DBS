<?php
// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

// TODO: BUG, when only username is submitted, email changes to null
if (isset($_POST['submit'])){
    $username = '';
    if(isset($_POST['username'])){
        $username = $_POST['username'];
    }

    $email = '';
    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }

    $adventure = '';
    if(isset($_POST['adventure'])){
        $adventure = $_POST['adventure'];
    }

    $level = '';
    if(isset($_POST['level'])){
        $level = $_POST['level'];
    }

    if (!empty($username) && !empty($email)) {
        $success = $database->insertIntoDungeonMaster($username, $email, $adventure, $level);

        if ($success) {
            echo "Data successfully inserted!";
        } else {
            echo "Failed to insert data.";
        }
    } else {
        echo "Username and Email are required.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>DnD DB</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Dungeon and Dragons Database</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!--Search Session-->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                
                                <form method="Post" action="searchPlayerResults.php">
                                    <label for="new_name">Search Player:</label>
                                    <input id="new_name" name="name" type="text" maxlength="20">
                                    <button id="search_button" type="submit" class="btn btn-outline-secondary">
                                        <svg id="search_button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                                            <path d="M10.68 11.74a6 6 0 0 1-7.922-8.982 6 6 0 0 1 8.982 7.922l3.04 3.04a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215ZM11.5 7a4.499 4.499 0 1 0-8.997 0A4.499 4.499 0 0 0 11.5 7Z"></path>
                                        </svg>
                                    </button>
                                </form>

                            </a>
                        </li>

                        <!--Search Adventure search-->
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <form method="Post" action="searchDungeonMasterResults.php">
                                    <label for="new_name">Search Dungeon Master:</label>
                                    <input id="new_name" name="name" type="text" maxlength="20">
                                    <button id="search_button" type="submit" class="btn btn-outline-secondary">
                                        <svg id="search_button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                                            <path d="M10.68 11.74a6 6 0 0 1-7.922-8.982 6 6 0 0 1 8.982 7.922l3.04 3.04a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215ZM11.5 7a4.499 4.499 0 1 0-8.997 0A4.499 4.499 0 0 0 11.5 7Z"></path>
                                        </svg>
                                    </button>
                                </form>
                            </a>
                        </li>

                        <!--Dropdown Menu-->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Inserts</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="dungeonmaster.php">Dungeonmaster</a></li>
                                <li><a class="dropdown-item" href="player.php">Player</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php">Home</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>
        <!--Page Content-->
        <div class="container">

            
            <form action="dungeonmaster.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">User Name:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="adventure" class="form-label">Please share with us your homebrew Adventure name:</label>
                            <input type="text" class="form-control" id="adventure" name="adventure">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="level" class="form-label">Recommended Level:</label>
                            <input type="number" class="form-control" id="level" name="level">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>


        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>