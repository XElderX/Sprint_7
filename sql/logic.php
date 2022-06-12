<?php
require './config/config.php';
//conection to db
$connection = connOpen();
if (!$connection) { 
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

//function for personell data render
function personell($connection){
    $sql = "SELECT
    personell.id, personell.First_name, personell.Last_name, projects.Project_name
    FROM personell
    left join projects
    ON projects.Project_id = personell.Project_id";
$result = mysqli_query($connection, $sql);
echo "<br><tr><th>id</th><th>name</th><th>lastname</th><th>Projects</th><th>Actions</th></tr>";

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo ("<tr><td>" . $row['id'] . "</td><td> ". $row['First_name'] . "</td> <td>" . $row['Last_name'] . "</td><td>" . $row['Project_name'] . "</td><td>". "</td></tr> <br>");
    }
} else {
    echo "0 results";
}

}
//function To render project lists 
function project($connection){
    $sql = "SELECT 
    projects.Project_id, projects.Project_name, group_concat(Concat_ws(' ', personell.First_name, Personell.Last_Name) separator ',') AS assigned 
    From projects
    Left join personell
    ON projects.Project_id = personell.Project_id
    GROUP BY Project_name;
";
$result = mysqli_query($connection, $sql);
echo "<br><tr><th>Project</th><th>Assigned</th><th>Actions</th></tr>";

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        echo ("<tr><td>" . $row['Project_name'] .  "</td><td>". $row['assigned'] . "</td><td>" ."</td></tr> <br>");
    }
} else {
    echo "0 results";
}

mysqli_close($connection);


}

?>
