<!-- git init
git add README.md
git commit -m "first commit"
git branch -M master
git remote add origin https://github.com/nethmi2020/product-crud.git
git push -u origin master -->
<?php


$pdo =new PDO('mysql:host=localhost;dbname=product_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search=$_GET['search'] ?? '';
if($search){
  $statement=$pdo->prepare('SELECT * FROM products WHERE title LIKE  :title ORDER BY create_date DESC');
  $statement->bindValue(':title',"%$search%");
}
else{
  $statement=$pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
}

$statement->execute();
$products=$statement->fetchAll(PDO::FETCH_ASSOC);

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

    <title>Product Crud</title>
  </head>
  <body class="container">
    <h1 class="mt-5">Product Crud</h1>
    <p>
    <a  href="create.php" type="button" class="btn btn-success">Create Product</a>
    </p> 

    <form action=""  method="">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Search for products" 
        name="search" value=""<?php echo $search ?>>
          <button class="btn btn-outline-secondary" type="submit">Search </button>
        </div>
    </form>
    <table class="table mt-5">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Create Date</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    
  <?php 
  foreach($products as $i=>$p):  ?>
    <tr>
      <th scope="row"><?php echo $i +1 ?></th>
      <td><img  style="width:113px; height:102px" src="<?php echo  $p['image']  ?>"> </td>
      <td><?php echo $p['title'] ?></td>
      <td><?php echo $p['price'] ?></td>
      <td><?php echo $p['create_date'] ?></td>
      <td>
        <a href="edit.php?id=<?php echo $p['id'] ?> " type="button" class="btn btn-sm btn-outline-success">Edit</a>
        <form style="display:inline-block;"  action="delete.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $p['id'] ?>">
          <button  type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
        </form>
        </td>
    </tr>
    <?php endforeach ;  ?>
  </tbody>
</table>
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
