<?php

require_once('DatabaseHelper.php');
$database = new DatabaseHelper();
if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] == 'delete'){
    echo "HI THERE";
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
            </div>
    </div>
    <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>