<?php
/**
* This page allows to add or edit a book
* Library Management example app using PDO
*/
// Don't forget the include
include('common.inc.php');

// See if we have the author ID passed in the request
$id = (int)$_REQUEST['author'];
if($id) {
  // We have the ID, get the book details from the table
  $q = $conn->query("SELECT * FROM authors WHERE id=$id");
  $author = $q->fetch(PDO::FETCH_ASSOC);
  $q->closeCursor();
  $q = null;
}
else {
  // We are creating a new book
  $author = array();
}
// Now see if the form was submitted
if($_POST['submit']) {
  // Validate every field
  $warnings = array();
  // First name should be non-empty
  if(!$_POST['firstName'])
  {
    $warnings[] = 'Please enter first name';
  }
  // Last name should be non-empty
  if(!$_POST['lastName'])
  {
    $warnings[] = 'Please enter last name';
  }
  // Bio should be non-empty
  if(!$_POST['bio'])
  {
    $warnings[] = 'Please enter bio';
  }
  // If there are no errors, we can update the database
  // If there was author ID passed, update that author
  if(count($warnings) == 0) {
    if(@$author['id']) {
      $sql = "UPDATE authors SET firstName=" . $conn>quote($_POST['firstName']) .
      ', lastName=' . $conn->quote($_POST['lastName']) .
      ', isbn=' . $conn->quote($_POST['isbn']) .
      ', bio=' . $conn->quote($_POST['bio']) .
      " WHERE id=$author[id]";
    }
    else {
      $sql = "INSERT INTO authors(firstName, lastName, bio) VALUES(" .
      $conn->quote($_POST['firstName']) .
      ', ' . $conn->quote($_POST['lastName']) .
      ', ' . $conn->quote($_POST['bio']) .
      ')';
    }
    $conn->query($sql);
    header("Location: authors.php");
    exit;
  }
}
else {
// Form was not submitted.
// Populate the $_POST array with the author's details
  $_POST = $author;
}
// Display the header
showHeader('Edit Author');
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
      <form role="form" action="editAuthor.php" method="post">
      <table class="table" cellpadding="3">
        <tr>
          <td>First Name</td>
          <td>
            <input class="form-control" type="text" name="firstName"
            value="<?=htmlspecialchars($_POST['firstName'])?>">
          </td>
        </tr>
        <tr>
          <td>Last Name</td>
          <td>
            <input class="form-control" type="text" name="lastName"
            value="<?=htmlspecialchars($_POST['lastName'])?>">
          </td>
        </tr>
        <tr>
          <td>Bio</td>
          <td>
            <textarea class="form-control" name="bio"><?=htmlspecialchars(
            $_POST['bio'])?></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input class="btn btn-default" type="submit" name="submit" value="Save">
          </td>
        </tr>
      </table>
      <?php if(@$author['id']) { ?>
        <input type="hidden" name="author" value="<?=$author['id']?>">
      <?php } ?>
      </form>
    </div>
  </div>
</div>
<?php
// Display footer
showFooter();
