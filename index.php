<?php require 'sql/logic.php';
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
       <?php personell($connection);
       
       ?>
        
    </table>
</div>
<div> 
<div id="add_person" style="display:none;">
<form action="" method="POST"> 
    <label>Name</label>
    <input type="text" name="First_name" required><br>
    <label>Last Name</label>
    <input type="text" name="Last_name" required><br>
    <select name="projectList"><br>
  <option value="NULL">--Please select project--></option>
  <?php selectProject($connection) ?>
</select>
  <br><input type="submit" name="Add_personell" value="Add">
</form>
</div>
<input id="NewPersonOn" type="button"  value="New Person" onclick="showAdd()" />
<input id="NewPersonOff" style="display:none" type="button"  value="Hide" onclick="hideAdd()" />
</div>


<script> 
function showAdd() {
   document.getElementById('add_person').style.display = "block";
   document.getElementById('NewPersonOff').style.display = "block";
   document.getElementById('NewPersonOn').style.display = "none";
}
function hideAdd() {
   document.getElementById('add_person').style.display = "none";
   document.getElementById('NewPersonOn').style.display = "block";
   document.getElementById('NewPersonOff').style.display = "none";
}
</script>




   
</section>
</body>
</html>