<?php
/**
* Common include fil for PDO Library Management example app
*
*
*/

// DB connection string and username/password
$connStr = 'mysql:host=localhost;dbname=pdo';
$user = 'root';
$pass = 'root';

/**
* The function will render the header on every page,
* including the opening html tag, the head section and
* the opening body tag. Called before any output of the page
*
*/
function showHeader($title)
{
  ?>
  <html>
  <head>
  <title><?=htmlspecialchars($title)?></title>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <style>
    td { padding: 5px; }
  </style>
  </head>
  <body>
    <h1><?=htmlspecialchars($title) ?></h1>
    <a href="books.php">Books</a>
    <a href="authors.php">Authors</a>
    <hr>
    <?php
}

/**
* Function will 'close' the body and html tags opened by the showHeader()
*/

function showFooter()
{
  ?>
  </body>
  </html>
  <?php
}

/**
* Function displays an error message, call showFooter and terminate
*/

function showError($message)
{
  echo "<h2>Error</h2>";
  echo n12br(htmlspecialchars($message));
  showFooter();
  exit();
}


// Create the connection object
try
{
  $conn = new PDO($connStr, $user, $pass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
  showHeader('Error');
  showError("Sorry, an error has occurred. Please try your request later\n" . $e->getMessage());
}
