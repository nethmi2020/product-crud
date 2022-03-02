
<?php


$errors= [];
$pdo =new PDO('mysql:host=localhost;dbname=product_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id=$_GET['id']?? null;


if(!$id){
    header('Location:index.php');
    exit();
}


$statement=$pdo->prepare('SELECT * FROM products WHERE id =:id');
$statement->bindValue(':id', $id);
$statement->execute();
$product= $statement->fetch(PDO::FETCH_ASSOC);

    // echo '<pre>';
    //   var_dump($product);
    // echo '</pre>';

$title=$product['title'] ;
$description=$product['description'] ;
$price=$product['price'] ;
// $date= '';

// var_dump($_FILES);


if($_SERVER['REQUEST_METHOD']=== 'POST'){

$title=$_POST['title'];
$description=$_POST['description'];
$price=$_POST['price'];



if(!$title){

    $errors[]='Product Title is required';
}

if(!$price){

  $errors[]='Product Price is required';
}

if(!is_dir('images')){
  mkdir('images');
}

if(empty($errors)){
 
  $image=$_FILES['image'] ?? null;
  $imgPath=$product['image'];

//   if we updte a new image, previous image should be removed
if($product['image']){
    unlink($product['image']);
}

  if($image && $image['tmp_name']){

      $imgPath= 'images/'.randomString(8) .'/'.$image['name'];
      // echo '<pre>';
      // var_dump($imgPath);
      // echo '</pre>';
      mkdir(dirname($imgPath));
      move_uploaded_file($image['tmp_name'], $imgPath);
  }


$statement=$pdo->prepare("UPDATE  products SET 
title=:title, 
description=:description,
image=:image,
price=:price
WHERE id=:id");

$statement->bindValue(':title', $title);
$statement->bindValue(':image', $imgPath);
$statement->bindValue(':description', $description);
$statement->bindValue(':price', $price);
$statement->bindValue(':id', $id);

$statement->execute();
header('Location:index.php');
}
}
// $products=$statement->fetchAll(PDO::FETCH_ASSOC);

function randomString($n){
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $str='';

  for($i=0; $i<$n; $i++){
    $index=rand(0,strlen($characters)-1);
    $str.=$characters[$index];
  }
  return $str;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>Update Product</title>
  </head>
  <body class="container">
    <h1 class="mt-5"> Update Product</h1>
    <a href="index.php" class="btn btn btn-primary">Go back to products</a>  

    <form action="" class="mb-5  p-5" method="post" enctype="multipart/form-data"> 


    <?php if($product['image']):?>

        <img style="width:113px; height:102px" src="<?php echo $product['image']  ?>" alt="">
    <?php endif; ?>

    <?php if(!empty($errors)):?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <div class=""><b>*</b> &nbsp &nbsp<?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
    <?php endif;  ?>

        <div class="mb-3">
            <label >Product Image</label>
            <br>
            <input type="file" class="form-control"  name="image">
        </div>
  
 
        <div class="mb-3">
            <label >Product Title</label>
            <br>
            <input type="text" class="form-control"  name="title" autocomplete  value="<?php echo $title ?>" >
        </div>

        <div class="mb-3">
            <label >Product Description</label>
            <br>
            <textarea name="description" id="" cols="30" rows="4"><?php echo $description ?></textarea>
        </div>

        <div class="mb-3">
            <label >Product Price</label>
            <br>
            <input type="text" class="form-control"  name="price" value="<?php echo $price ?>">
        </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
    
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>


