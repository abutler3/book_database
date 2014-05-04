<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
* List all books
*/
include('common.inc.php');

// Issue the query
$q = $conn->query("SELECT * FROM books ORDER BY title");

// Display the header
showHeader('Books');

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped" width="80%" cellpadding="5">
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
        while($r = $q->fetch(PDO::FETCH_ASSOC))
        {
          ?>
          <tr>
            <td><?=htmlspecialchars($r['title'])?></td>
            <td><?=htmlspecialchars($r['isbn'])?></td>
            <td><?=htmlspecialchars($r['publisher'])?></td>
            <td><?=htmlspecialchars($r['year'])?></td>
            <td><?=htmlspecialchars($r['summary'])?></td>
            <td>
              <a href="editBook.php?book=<?=$r['id']?>">Edit</a>
            </td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>
  <br>
  <div class="row">
    <div class="col-md-3">
      <a class="btn btn-primary btn-lg active" href="editBook.php">Add book...</a>
    </div>
  </div>
</div>
<?php
// Display footer
showFooter();
