<?php require 'model/logic.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Project Manager</title>
</head>

<body>
  <section>
    <nav>
      <div class="navContainer">
        <button class="navButton"><a href="index.php">Personalas</a></button>
        <button class="navButton"><a href="projects.php">Projektai</a></button>
      </div>
    </nav>
    <div class="tableContainer personell">
      <div><?php echo "<p style='color:#a7fc00'>  $connStatus </p>" ?> </div>
      <h2>Project manager</h2>
      <div class='tableBox'>
        <table class='table'>
          <?php personell($connection);
          ?>
        </table>
      </div>
    </div>
    <div class='formContainer'>
      <div>
        <div><?php
              if (isset($_SESSION['negative'])) {
                print "<p class='note' id='notification'>" . $_SESSION['note'] . "</p>";
              } else if (isset($_SESSION['positive'])) {
                print "<p class='notePositive' id='notification'>" . $_SESSION['note'] . "</p>";
              }
              session_destroy();
              ?></div>
        <input id="NewPersonOn" type="button" value="New Person" onclick="showAdd()" />
        <input id="NewPersonOff" style="display:none" type="button" value="Hide" onclick="hideAdd()" />
      </div>
      <div id="add_person" style="display:none;">
        <form class='personellForm' action="" method="POST">
          <label>Name</label>
          <input class='inputField' type="text" name="First_name" required><br>
          <label>Last Name</label>
          <input class='inputField' type="text" name="Last_name" required><br>
          <select class='select' name="projectList"><br>
            <option value=''>--Please select project--></option>
            <?php selectProject($connection) ?>
          </select>
          <input class='btn-add' style='float:right' type="submit" name="Add_personell" value="Add">
        </form>
      </div>
    </div>
    <script>
      function showAdd() {
        document.getElementById('add_person').style.display = "block";
        document.getElementById('NewPersonOff').style.display = "block";
        document.getElementById('NewPersonOn').style.display = "none";
        var e = document.getElementById("notification")
        if (e) {
          e.parentElement.removeChild(e)
        }
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