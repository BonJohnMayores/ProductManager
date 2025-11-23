<?php
session_start();
$title ='Products';
include 'functions/products.php';

if(isset($_POST['insert'])){
  $pcode = $_POST['pcode'];
  $desc = $_POST['desc'];
  $stocks = $_POST['stocks'];
  $price = $_POST['price'];

  if(addProduct($pcode, $desc, $stocks, $price)){
    $_SESSION['action']='Add';
    $_SESSION['msg']='Product added successfully!';
    header('location: products.php');
  }
}
?>
<!doctype html>
<html lang="en">
  <?php
    include 'components/head.php';
  ?>
  <body>
  <?php
    include 'components/nav-bar.php';
  ?>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar Menu -->
    <?php
      include 'components/side-bar.php';
    ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">New Product</h1>        
      </div>
<div class="col-md-6">
        <form method="post">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="code">Product Code</label>
              <input type="text" class="form-control" name="pcode">
            </div>
           
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="desc" placeholder="">
          </div>
      
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="price">Price</label>
              <input type="text" class="form-control" name="price">
            </div>
           
            <div class="form-group col-md-2">
              <label for="stocks">Stocks</label>
              <input type="text" class="form-control" name="stocks">
            </div>
          </div>
          <button type="reset" class="btn btn-secondary">Reset</button>
          <button type="submit" class="btn btn-primary" name="insert" >Save</button>
        </form>
      </div>
    </main>
  </div>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
        <script src="js/dashboard.js"></script>
  </body>
</html>