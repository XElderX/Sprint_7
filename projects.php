<?php require 'model/logic.php'
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
        <div class="tableContainer projects">
            <div><?php echo "<p style='color:#a7fc00'>  $connStatus </p>" ?> </div>
            <h2>Project manager</h2>
            <div class='tableBox'>
                <table class='table'>
                    <?php project($connection) ?>
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
                <input id="NewProjectOn" type="button" value="New Project" onclick="showAdd()" />
                <input id="NewProjectOff" style="display:none" type="button" value="Hide" onclick="hideAdd()" />
            </div>
            <div id="add_project" style="display:none;">
                <form class='projectForm' action="" method="POST">
                    <label>Project Name</label>
                    <input class='inputField' type="text" name="projectName" required><br>
                    <br><input type="submit" class='btn-add' name="Add_project" value="Add">
                </form>
            </div>
        </div>

        <script>
            function showAdd() {
                document.getElementById('add_project').style.display = "block";
                document.getElementById('NewProjectOff').style.display = "block";
                document.getElementById('NewProjectOn').style.display = "none";
                var e = document.getElementById("notification")
                if (e) {
                    e.parentElement.removeChild(e)

                };

            }

            function hideAdd() {
                document.getElementById('add_project').style.display = "none";
                document.getElementById('NewProjectOn').style.display = "block";
                document.getElementById('NewProjectOff').style.display = "none";
            }
        </script>


    </section>
</body>

</html>