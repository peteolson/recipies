<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>recipies</title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
   <link rel="stylesheet" href="skeleton.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
 

</head>
<body>
<div class="container">
    <div class="row">
      <div class="one-half column" style="margin-top: 5%">

<a style=color:green href="index.php?recipie_list">Home</a><br><br>

<a style=color:green href="process.php?meal_list">Meal list</a><br><br>	        

<a style=color:green href="process.php?meal_list_view.php">Meal list view</a><br><br>

<a style=color:green href="process.php?meal_list_shopping.php">Shopping list</a><br><br>

<a style=color:green href="recipie.php">Add new recipie</a><br><br>

<p>Click on a recipie and select add to meal list</p>

<form id="search" action="process.php?search" method="post" name="search">

<p><input id="search" name="search" type="text" size="20" placeholder="search" maxlength="45">

<input type="submit" value="submit">

</p>

</form>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
