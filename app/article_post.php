<?php

require_once('./components/navbar.php');
require_once('../vendor/erusev/parsedown/Parsedown.php'); // parsedown importieren

$id = intval($_GET['id']);
$article = getArticle($id);

if (is_array($article)) {
  // The article data is valid, so we can access its elements
  $title = htmlspecialchars($article['title']);
  $content = htmlspecialchars($article['content']); // Markdown-Text speichern, ohne HTML-Entities zu escapen
  $author_id = intval($article['author_id']);
  $category_id = intval($article['category_id']);
  $cover_image_url = ($article['cover_image_url']);
  $views = intval($article['views']);
  $created_at = $article['created_at'];
  $updated_at = $article['updated_at'];

  $author = getUserByID($author_id);
  $category = getCategoryByID($category_id);
} else {
  // The article data is not valid, so we need to handle the error or provide a default value
  echo 'The article data is not valid';
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>
    <?php echo $title; ?> - Erudita
  </title>
</head>

<body>
  <div class="container mt-3">
    <div class="row">
      <div class="col-12 text-center">
        <img src="<?php echo $cover_image_url; ?>" alt="Cover image" class="mb-3 border border-warning rounded p-1 col-md-4">
      </div>
      <div class="col-12 mt-3">
        <h1 class="display-4 mb-3 text-center">
          <?php echo $title; ?>
          <a class="link-warning" href="edit.php?p=<?php echo $id; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="bi bi-pencil" viewBox="0 0 16 16">
              <path
                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
            </svg>
          </a>
        </h1>
        <p class="lead mb-3 text-center">
          Author: <span class="text-warning">
            <?php echo $author['username']; ?>
          </span>
        </p>

        <hr class="my-4">

        <div>
          <?php
          // markdown parser
          echo Parsedown::instance()
            ->setSafeMode(true)
            ->text($content);
          ?>
        </div>
      </div>
    </div>

    <hr class="my-4">
    <div class="row mt-3">
      <div class="col-12 col-md-8">
        <span class="badge badge-secondary mr-1">
          <?php echo $category['name']; ?>
        </span>
        <span class="badge badge-secondary mr-1"><?php echo $views; ?> views</span>
      </div>
      <div class="col-12 col-md-4 text-right">
        <small>Created at: <?php echo date('M j, Y', strtotime($created_at)); ?></small><br>
        <small>Updated at: <?php echo date('M j, Y', strtotime($updated_at)); ?></small>
      </div>
    </div>
  </div>
</body>

<?php require_once('./components/footer.php'); ?>

</html>
