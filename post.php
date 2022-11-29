<?php
    session_start();
    include('./includes/connect.php');

    if(isset($_GET['id'])) {
    $postid = $_GET['id'];

    $results = pg_query($dbConn, "SELECT title, content, cover, views, author FROM public.posts WHERE id=$postid");
    
  $row = pg_fetch_assoc($results);

  $views = $row['views'];

  $newViews = $views+1;

  $cover = $row['cover'];
  $authorid = $row['author'];

  $getAuthor = pg_query($dbConn, "SELECT username FROM public.users WHERE id = '$authorid'");

  $cardAuthor = pg_fetch_assoc($getAuthor);

 pg_query($dbConn, "UPDATE public.posts SET views=$newViews WHERE id=$postid");

  } else {
    return;
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyWiki | <?php echo $row['title'];?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>

  <?php include('./components/navbar.php'); ?>

<div class="container">
<br>
<div class="card rounded mx-auto d-block img-thumbnail w-25 p-3" style="width: 18rem;">
  <img src="./img/<?php echo $row['cover']; ?>" class="card-img-top" style="height: 18rem; object-fit: cover;" alt="./img/<?php echo $row['cover']; ?>">
  <div class="card-body">
    <p class="card-text">Veröffentlicht von <a href="home.php?authorid=<?php echo $row['author'];?>"><?php echo $cardAuthor['username'];?></a></p>
  </div>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col"><h1><?php echo $row['title'];?></h1></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><md-block><?php echo $row['content']; ?></md-block></td>
    </tr>
  </tbody>
</table>
<?php include('./components/footer.php'); ?>


</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script> 
  </body>
</html>

<?php while ($row = pg_fetch_assoc($results)) { ?>

<a href="post.php?id=<?php echo $row['id'] ?>">  <?php echo $row['title']; ?></a><br>

<?php  } ?>