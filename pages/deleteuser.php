<?php
include("../components/db.php");

if (isset($_GET['id'])) {
  $id = $_GET['id'];


  $query = "DELETE FROM userdetails WHERE id = '$id'";
  $result = mysqli_query($con, $query);

  if ($result) {
    echo "User deleted succesfully.";
  }else {
    echo "Failed to delete the user.";
  }

  mysqli_close($con);
  header("Location: users.php");
}else {
  echo "Invalid ID.";
}

?>
