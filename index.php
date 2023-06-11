<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Bare - Start Bootstrap Template</title>
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
                                
                                <form method="Post" action="searchResults.php">
                                    <label for="new_name">Search Sessions:</label>
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
                                <form method="Post" action="searchResults.php">
                                    <label for="new_name">Search Adventure:</label>
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
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Inserts/Deletes</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Into Dungeonmaster</a></li>
                                <li><a class="dropdown-item" href="#">Into Player</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container">
        
            <div class="text-center mt-5">
                <div class="row align-item-end">
                    <div class="col">
                        <label for="customRange1" class="form-label">Characters</label>
                        <input type="range" class="form-range" id="#chars">
                        Richest Characters
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Character Name</th>
                                        <th scope="col">Player Name</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="col">
                        <label for="customRange2" class="form-label">Partys</label>
                        <input type="range" class="form-range" id="#party_level">
                        Highest level partys
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Party Name</th>
                                        <th scope="col">Avg. level</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="col">
                        <label for="customRange3" class="form-label">Partys</label>
                        <input type="range" class="form-range" id="#party_gold">
                        Richest partys
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Party Name</th>
                                        <th scope="col">Gold</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
