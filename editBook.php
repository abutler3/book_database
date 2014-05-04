<?php
/**
* This page allows to add or edit a book
* Library Management example app using PDO
*/
// Don't forget the include
include('common.inc.php');
// See if we have the book ID passed in the request
$id = (int)$_REQUEST['book'];
if($id) {
  // We have the ID, get the book details from the table
  $q = $conn->query("SELECT * FROM books WHERE id=$id");
  $book = $q->fetch(PDO::FETCH_ASSOC);
  $q->closeCursor();
  $q = null;
  }
  else {
  // We are creating a new book
  $book = array();
}
// Now get the list of all authors' first and last names
// We will need it to create the dropdown box for author
$authors = array();
$q = $conn->query("SELECT id, lastName, firstName FROM authors ORDER
BY lastName, firstName");
$q->setFetchMode(PDO::FETCH_ASSOC);
while($a = $q->fetch())
{
  $authors[$a['id']] = "$a[lastName], $a[firstName]";
}
// Now see if the form was submitted
if($_POST['submit']) {
  // Validate every field
  $warnings = array();
  // Title should be non-empty
  if(!$_POST['title'])
  {
    $warnings[] = 'Please enter book title';
  }
  // Author should be a key in the $authors array
  if(!array_key_exists($_POST['author'], $authors))
  {
    $warnings[] = 'Please select author for the book';
  }
  // ISBN should be a 10-digit number
  if(!preg_match('~^\d{10}$~', $_POST['isbn'])) {
    $warnings[] = 'ISBN should be 10 digits';
  }
  // Published should be non-empty
  if(!$_POST['publisher']) {
    $warnings[] = 'Please enter publisher';
  }
  // Year should be 4 digits
  if(!preg_match('~^\d{4}$~', $_POST['year'])) {
    $warnings[] = 'Year should be 4 digits';
  }
  // Sumary should be non-empty
  if(!$_POST['summary']) {
    $warnings[] = 'Please enter summary';
  }
  // If there are no errors, we can update the database
  // If there was book ID passed, update that book
  if(count($warnings) == 0) {
  if(@$book['id']) {
    $sql = "UPDATE books SET title=" . $conn>quote($_POST['title']) .
    ', author=' . $conn->quote($_POST['author']) .
    ', isbn=' . $conn->quote($_POST['isbn']) .
    ', publisher=' . $conn->quote($_POST['publisher']) .
    ', year=' . $conn->quote($_POST['year']) .
    ', summary=' . $conn->quote($_POST['summary']) .
    " WHERE id=$book[id]";
  }
  else {
    $sql = "INSERT INTO books(title, author, isbn, publisher,
    year,summary) VALUES(" .
    $conn->quote($_POST['title']) .
    ', ' . $conn->quote($_POST['author']) .
    ', ' . $conn->quote($_POST['isbn']) .
    ', ' . $conn->quote($_POST['publisher']) .
    ', ' . $conn->quote($_POST['year']) .
    ', ' . $conn->quote($_POST['summary']) .
    ')';
  }
// Now we are updating the DB.
// We wrap this into a try/catch block
// as an exception can get thrown if
// the ISBN is already in the table
  try
  {
    $conn->query($sql);
    // If we are here that means that no error
    // We can return back to books listing
    header("Location: books.php");
    exit;
  }
  catch(PDOException $e)
  {
    $warnings[] = 'Duplicate ISBN entered. Please correct';
  }
}
}
else {
// Form was not submitted.
// Populate the $_POST array with the book's details
  $_POST = $book;
}
// Display the header
showHeader('Edit Book');
// If we have any warnings, display them now
if(count($warnings)) {
  echo "<b>Please correct these errors:</b><br>";
  foreach($warnings as $w)
    {
    echo "- ", htmlspecialchars($w), "<br>";
    }
}
// Now display the form
?>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form role="form" action="editBook.php" method="post">
      <table class="table" cellpadding="3">
        <tr>
          <td>Title</td>
          <td>
            <input class="form-control" type="text" name="title"
            value="<?=htmlspecialchars($_POST['title'])?>">
          </td>
        </tr>
        <tr>
          <td>Author</td>
          <td>
            <select class="form-control" name="author">
              <option value="">Please select...</option>
              <?php foreach($authors as $id=>$author) { ?>
              <option value="<?=$id?>"
              <?= $id == $_POST['author'] ? 'selected' : ''?>>
              <?=htmlspecialchars($author)?>
              </option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>ISBN</td>
          <td>
            <input class="form-control" type="text" name="isbn"
            value="<?=htmlspecialchars($_POST['isbn'])?>">
          </td>
        </tr>
        <tr>
          <td>Publisher</td>
          <td>
          <input class="form-control" type="text" name="publisher"
          value="<?=htmlspecialchars($_POST['publisher'])?>">
          </td>
        </tr>
        <tr>
          <td>Year</td>
          <td>
          <input class="form-control" type="text" name="year"
          value="<?=htmlspecialchars($_POST['year'])?>">
          </td>
        </tr>
        <tr>
          <td>Summary</td>
          <td>
            <textarea class="form-control" name="summary"><?=htmlspecialchars(
            $_POST['summary'])?></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input class="btn btn-default" type="submit" name="submit" value="Save">
          </td>
        </tr>
      </table>
      <?php if(@$book['id']) { ?>
        <input type="hidden" name="book" value="<?=$book['id']?>">
      <?php } ?>
      </form>
    </div>
  </div>
</div>
<?php
// Display footer
showFooter();
