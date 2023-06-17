<?php

require_once('DatabaseHelper.php');
$database = new DatabaseHelper();

$searchResults = [];

//https://www.w3schools.com/php/php_superglobals_server.asp
// we have multiple buttons. So we need a switch case to know which button was pressed

// i know... this is a buggy mess
// when 2 or more forms are posted at once, strange things can happen.
if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'delete'){
    if (isset($_POST['deletePlayer'])){
        $userName = $_POST['deletePlayer'];
        $errorcode = $database->deletePlayer($userName);

        if($errorcode == 0){
            echo "Player {$userName} banished";
        } else {
            echo "There is nobody with the name {$userName} that you can banished dear admin :'(";
        }
    } else {
        echo "You did not gave me a name to banish";
    }
} else if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'update') {
    if(isset($_POST['updatePlayer'], $_POST['newUsername'], $_POST['newEmail'])){
        $oldUserName = $_POST['updatePlayer'];
        $newUserName = $_POST['newUsername'];
        $newEmail = $_POST['newEmail'];
        if (empty($newEmail)){
            $newEmail = null;
        }
        $success = $database->updatePlayer($newUserName, $oldUserName, $newEmail);

        if($success){
            echo "Your wish to update {$oldUserName} to {$newUserName} was granted!";
        } else {
            echo "Your wish to update {$oldUserName} could not be done!";
        }
    } else {
        echo "You did not gave me anything to update :'(";
    }
} else if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = '';
    if(isset($_POST['name'])){
        $name = $_POST['name'];
        $searchResults = $database->selectPlayer($name);
    } else {
        echo "Name is required.";
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
                <a class="navbar-brand" href="index.php">Dungeon and Dragons Database</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!--Search Player-->
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

                        <!--Search Dungeonmaster-->
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
        
        <div class="container">

        <!--Container for the forms-->
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2>Delete Player</h2>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label for="deletePlayer" class="form-label">Player Username:</label>
                            <input type="text" class="form-control" id="deletePlayer" name="deletePlayer" required>
                        </div>
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn btn-danger">Delete Player</button>
                    </form>
                </div>
                
                <div class="col">
                    <h2>Update Player</h2>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="mb-3">
                            <label for="updatePlayer" class="form-label">Player Username:</label>
                            <input type="text" class="form-control" id="updatePlayer" name="updatePlayer" required>
                        </div>
                        <div class="mb-3">
                            <label for="newUsername" class="form-label">New Username:</label>
                            <input type="text" class="form-control" id="newUsername" name="newUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="newEmail" class="form-label">New Email address:</label>
                            <input type="email" class="form-control" id="newEmail" name="newEmail">
                        </div>
                        <input type="hidden" name="action" value="update">
                        <button type="submit" class="btn btn-success">Update Player</button>
                    </form>
                </div>
                
            </div>


        </div>
            Search results
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Player Name</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($searchResults as $index => $player) { ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $player['USER_NAME'] ?></td>
                                <td><?= $player['E_MAIL'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
