<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Violet Uploads Pictures</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .upload-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
        .image-card:hover {
            transform: scale(1.05);
            transition: transform 0.3s;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg mx-auto p-6 rounded-lg shadow-lg upload-card">
        <h1 class="text-4xl font-bold mb-6 text-center text-purple-700">Violet Uploads Pictures</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["picture"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["picture"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                echo "<p class='text-red-500'>File is not an image.</p>";
                $uploadOk = 0;
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "<p class='text-red-500'>Sorry, file already exists.</p>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "<p class='text-red-500'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<p class='text-red-500'>Sorry, your file was not uploaded.</p>";
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    echo "<p class='text-green-500'>The file ". htmlspecialchars(basename($_FILES["picture"]["name"])). " has been uploaded.</p>";
                } else {
                    echo "<p class='text-red-500'>Sorry, there was an error uploading your file.</p>";
                }
            }
        }
        ?>
        <form action="index.php" method="post" enctype="multipart/form-data" class="mb-6">
            <input type="file" name="picture" class="block w-full mb-3 border border-gray-300 p-2 rounded-lg" required>
            <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition duration-200">Upload</button>
        </form>
        <h2 class="text-2xl font-semibold mb-4 text-purple-700">Uploaded Pictures</h2>
        <?php
        $directory = 'uploads/';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        $images = array_diff(scandir($directory), array('..', '.'));
        $image_count = count($images);
        echo "<p class='text-lg mb-4'>Number of pictures: <strong>$image_count</strong></p>";
        ?>
        <div id="pictures-list" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php
            foreach ($images as $image) {
                echo '<div class="border border-gray-300 p-2 rounded-lg shadow image-card transition-transform"><img src="' . $directory . $image . '" alt="' . $image . '" class="w-full h-auto rounded"></div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
