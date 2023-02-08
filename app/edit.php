<?php

require_once('./components/navbar.php');

$isEditMode = isset($_GET['id']) ? true : false; // TODO: validate article id
$keyword = $isEditMode ? 'Edit' : 'Create';

if (!isset($_SESSION['user'])) {
    echo '<div class="alert alert-warning" role="alert">You must be <a href="login.php">logged in</a> to ' . strtolower($keyword) . ' an article.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['id'])) { // TODO: validate article id
        $article_id = $_GET['id'];
    } else {
        $article_id = null;
    }

    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $cover_image_url = $_FILES['cover_image_url'];
    $author_id = $user['id'];
    $category_id = $_POST['category_id'];

    try {
        // Validate input
        if (empty($title) || empty($content) || empty($author_id) || empty($category_id)) {
            throw new Exception("All fields are required.");
        }

        // Check if cover image is valid
        if (!empty($cover_image_url['tmp_name']) && (!is_uploaded_file($cover_image_url['tmp_name']) || !exif_imagetype($cover_image_url['tmp_name']))) {
            throw new Exception("Invalid cover image.");
        }

        // Check if author ID is valid
        if (!isValidAuthorId($author_id)) {
            throw new Exception("Invalid author ID.");
        }

        // Check if category ID is valid
        if (!isValidCategoryId($category_id)) {
            throw new Exception("Invalid category ID.");
        }

        if (!empty($cover_image_url)) {
            // Move cover image to uploads folder and rename it
            $cover_image_name = "./uploads/article-" . uniqid() . '.' . pathinfo($cover_image_url['tmp_name'], PATHINFO_EXTENSION);
            move_uploaded_file($cover_image_url['tmp_name'], $cover_image_name);
        } else {
            $cover_image_name = $article['cover_image_url'];
        }

        if ($article_id) {
            updateArticle($article_id, $title, $content, $cover_image_name, $author_id, $category_id);
            header('Location: article_post.php?id=' . $article_id);
            exit;
        } else {
            // Create article
            $article_id = createArticle($title, $content, $cover_image_name, $author_id, $category_id);
            header('Location: article_post.php?id=' . $article_id);
            exit;
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">' . $e->getMessage() . '</div>';
    }

} else {
    if ($isEditMode) {
        $article = getArticle($_GET['id']);
        $cover_image_url = $article['cover_image_url'];
        $title = $article['title'];
        $content = $article['content'];
        $category_id = $article['category_id'];
    } else {
        $title = '';
        $content = '';
        $category_id = '';
    }
}

$categories = getCategories();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        <?php echo $keyword ?> Article - Erudita
    </title>
</head>

<body>
    <div class="container">
        <section class="py-5 text-center container">
            <div class="row">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <img src="./assets/v2_round.png" class="rounded mx-auto d-block" height="100px"><br>
                    <h1 class="fw-light">
                        <?php echo $keyword ?> your article
                    </h1>
                </div>
            </div>
        </section>
        <form method="post" action="edit.php" class="container" enctype="multipart/form-data">
            <?php if (isset($cover_image_url) && $isEditMode) { ?>
                <div class="col-12 text-center">
                    <img id="cover-image" src="<?php echo $cover_image_url; ?>" alt="Cover image"
                        class="mb-3 border border-warning rounded p-1 col-md-4">
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="cover_image_url">Cover Bild</label>
                <input type="file" name="cover_image_url" id="cover_image_url" accept="image/*" class="form-control">
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="<?php echo $title; ?>" required class="form-control">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" required class="form-control"><?php echo $content; ?></textarea>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" required class="form-control">
                    <?php
                    foreach ($categories as $category) {
                        echo '<option value="' . $category['id'] . '" ' . ($category['id'] === $category_id ? 'selected' : '') . '>' . $category['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-warning" <?php if (!isset($_SESSION['user'])): ?>disabled<?php endif; ?>>
                <?php echo $keyword ?>
            </button>
        </form>
    </div>
    </div>

    <script>
        // Get the input field for the cover image
        var coverImageInput = document.getElementById("cover_image_url");
        // Add an event listener for when the file is selected
        coverImageInput.addEventListener("change", function () {
            // Get the selected file
            var file = coverImageInput.files[0];
            // Get the image element to update
            var coverImage = document.getElementById("cover-image");
            // Create a new URL object for the selected file
            var url = URL.createObjectURL(file);
            // Update the image source to the new URL
            coverImage.src = url;
        });
    </script>

    <?php require_once('./components/footer.php'); ?>
</body>

</html>