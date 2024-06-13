<?php
if ($_FILES["imageFile"]["error"] === UPLOAD_ERR_OK) {
  $tempName = $_FILES["imageFile"]["tmp_name"];
  $targetPath = "uploads/image.jpg";

  if (move_uploaded_file($tempName, $targetPath)) {
    echo $targetPath; // Send the updated image URL back to the editor page
  } else {
    echo "Error occurred during image upload.";
  }
} else {
  echo "Error occurred during image upload.";
}
?>
