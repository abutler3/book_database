<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
* List all books
*/
include('common.inc.php');

// Get the author
$id = (int)$_REQUEST['id'];
// Issue the query
$q = $conn->query("SELECT * FROM authors WHERE id=$id");
$author = $q->fetch(PDO::FETCH_ASSOC);
$q->closeCursor();

//See if author is valid. If not, show invalid ID
if (!$author) {
  showHeader('Error');
  echo "Invalid Author ID supplied";
  showFooter();
  exit;
}
// Display the header
showHeader("Author: $author[firstName] $author[lastName]");

//Fetch all of their books
$q = $conn->query("SELECT * FROM books WHERE author=$id ORDER BY title");
$q->setFetchMode(PDO::FETCH_ASSOC);
?>
<h2>Author</h2>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <table class="table" width="60%" cellpadding="5">
        <tr style="font-weight: bold">
          <td>First Name</td>
          <td><?=htmlspecialchars($author['firstName'])?></td>
        </tr>
        <tr style="font-weight: bold">
          <td>Last Name</td>
          <td><?=htmlspecialchars($author['lastName'])?></td>
        </tr>
        <tr style="font-weight: bold">
          <td>Bio</td>
          <td><?=htmlspecialchars($author['bio'])?></td>
        </tr>
      </table>
    </div>
  </div>
</div>

<h2>Books</h2>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <table class="table" width="80%" border="1" cellpadding="5">
        <tr style="font-weight: bold">
          <td>Title</td>
          <td>ISBN</td>
          <td>Publisher</td>
          <td>Year</td>
          <td>Summary</td>
          <td></td>
        </tr>
        <?php
        //Iterate over each row and display it
        while($r = $q->fetch())
        {
          ?>
          <tr>
            <td><?=htmlspecialchars($r['title'])?></td>
            <td><?=htmlspecialchars($r['isbn'])?></td>
            <td><?=htmlspecialchars($r['publisher'])?></td>
            <td><?=htmlspecialchars($r['year'])?></td>
            <td><?=htmlspecialchars($r['summary'])?></td>
          </tr>
          <?php
        }
      ?>
      </table>
    </div>
  </div>
</div>

<?php
// Display footer
showFooter();
