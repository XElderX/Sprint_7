<?php require 'sql/logic.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <section>
<nav> 
<div class="navContainer">
<button class="navButton"><a href="index.php">Personalas</a></button>
<button class="navButton"><a href="projects.php">Projektai</a></button>
</div>
</nav>
<div class="tableContainer">

    <table class='table'>
       <?php project($connection)
       ?>
        
    </table>
</div>



    
</section>
</body>
</html>