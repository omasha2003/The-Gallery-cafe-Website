<?php
include("../components/db.php");

if (isset($_GET['id'])) {
  $id = $_GET['id'];


  $query = "DELETE FROM menu WHERE id = '$id'";
  $result = mysqli_query($con, $query);

  if ($result) {
    echo "food deleted succesfully.";
  }else {
    echo "Failed to delete the food.";
  }

  mysqli_close($con);
  header("Location: adminfoodmenu.php");
}else {
  echo "Invalid ID.";
}

?>