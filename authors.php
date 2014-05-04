<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
/**
* List all books
*/
include('common.inc.php');

// Issue the query
$q = $conn->query("SELECT * FROM authors ORDER BY lastName, firstName");
// Display the header
showHeader('Authors');

?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <table class="table table-striped" width="80%" cellpadding="5">
        <tr style="font-weight: bold">
          <td>First Name</td>
          <td>Last Name</td>
          <td>Bio</td>
          <td></td>
        </tr>

        <?php
        //Iterate over each row and display it
        while($r = $q->fetch(PDO::FETCH_ASSOC))
        {
          ?>
          <tr>
            <td><?=htmlspecialchars($r['firstName'])?></td>
            <td><?=htmlspecialchars($r['lastName'])?></td>
            <td><?=htmlspecialchars($r['bio'])?></td>
            <td>
              <a href="editAuthor.php?author=<?=$r['id']?>">Edit</a>
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
      <a class="btn btn-primary btn-lg active" href="editAuthor.php">Add Author...</a>
    </div>
  </div>
</div>
<?php
// Display footer
showFooter();
