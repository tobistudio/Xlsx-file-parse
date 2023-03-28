<?php
$conn = mysqli_connect("detraasjes.nl", "traasjes_test", "jDtNQRSfH", "traasjes_test");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>