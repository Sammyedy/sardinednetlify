<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_FILES["imageFile"]["error"] === UPLOAD_ERR_OK) {
        $tempName = $_FILES["imageFile"]["tmp_name"];
        $targetPath = "uploads/image.jpg"; // Overwrite to image.jpg

        if (move_uploaded_file($tempName, $targetPath)) {
            echo $targetPath; // Send the updated image URL back to the editor page
        } else {
            echo "Error occurred during image upload.";
        }
    } else {
        echo "Error occurred during image upload.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Editor</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #f4f4f9;
      color: #333;
    }

    h1 {
      font-size: 1.8rem;
      margin-bottom: 1rem;
      text-align: center;
    }

    form {
      width: 90%;
      max-width: 400px;
      padding: 20px;
      border-radius: 10px;
      background: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    #preview {
      margin-top: 20px;
      text-align: center;
    }

    #preview img {
      max-width: 100%;
      border-radius: 10px;
      margin-top: 10px;
    }

    .message {
      margin-top: 10px;
      color: red;
      font-size: 0.9rem;
    }

    #progressContainer {
      width: 100%;
      background-color: #f0f0f0;
      border-radius: 5px;
      margin-top: 15px;
      display: none;
    }

    #progressBar {
      width: 0%;
      height: 20px;
      background-color: #4CAF50;
      border-radius: 5px;
      transition: width 0.5s ease-in-out;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 1.5rem;
      }

      button {
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <h1>Upload and Edit Image</h1>
  <form id="imageForm" enctype="multipart/form-data">
    <input type="file" name="imageFile" id="imageFileInput" accept="image/*">
    <button type="submit">Upload Image</button>
    <div id="progressContainer">
      <div id="progressBar"></div>
    </div>
    <div class="message" id="message"></div>
  </form>

  <div id="preview">
    <h3>Preview</h3>
    <img id="previewImage" src="#" alt="Image preview" style="display: none;">
  </div>

  <script>
    document.getElementById("imageFileInput").addEventListener("change", function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          const previewImage = document.getElementById("previewImage");
          previewImage.src = e.target.result;
          previewImage.style.display = "block";
        };
        reader.readAsDataURL(file);
      }
    });

    document.getElementById("imageForm").addEventListener("submit", function(event) {
      event.preventDefault();
      const formData = new FormData(this);
      const message = document.getElementById("message");
      const progressContainer = document.getElementById("progressContainer");
      const progressBar = document.getElementById("progressBar");

      // Reset progress bar
      progressContainer.style.display = "block";
      progressBar.style.width = "0%";

      const xhr = new XMLHttpRequest();
      xhr.open("POST", "", true);

      // Track upload progress
      xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
          const percentComplete = (e.loaded / e.total) * 100;
          progressBar.style.width = percentComplete + "%";
        }
      };

      xhr.onload = function() {
        const imageUrl = xhr.responseText;
        
        if (imageUrl === "uploads/image.jpg") {
          progressBar.style.width = "100%";
          message.style.color = "green";
          message.textContent = "Image uploaded successfully!";
          const previewImage = document.getElementById("previewImage");
          previewImage.src = imageUrl + "?t=" + new Date().getTime(); // Prevent caching
          
          // Hide progress bar after a short delay
          setTimeout(() => {
            progressContainer.style.display = "none";
          }, 1000);
        } else {
          progressContainer.style.display = "none";
          message.style.color = "red";
          message.textContent = imageUrl || "An error occurred.";
        }
      };

      xhr.onerror = function() {
        progressContainer.style.display = "none";
        message.style.color = "red";
        message.textContent = "Network error occurred.";
      };

      xhr.send(formData);
    });
  </script>
</body>
</html>