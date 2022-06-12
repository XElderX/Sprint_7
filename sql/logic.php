<?php
require './config/config.php';
//conection to db
$connection = connOpen();
if (!$connection) { 
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
//delete personell logic
if(isset($_GET['action']) and $_GET['action'] == 'delete'){
    $sql = 'DELETE FROM personell WHERE id = ?';
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('i', $_GET['id']);
    $res = $stmt->execute();  
    $stmt->close();
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();
}
//delete project logic
if(isset($_GET['action']) and $_GET['action'] == 'project_delete'){
    $sql = 'DELETE FROM projects WHERE Project_id= ?';
    $stmt = $connection->prepare($sql);
    var_dump($stmt);
    $stmt->bind_param('i', $_GET['Project_id']);
    $res = $stmt->execute();
    $stmt->close();
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();
}
//add personell logic 
If(isset($_POST['Add_personell'])){
    $p_name = $_POST['First_name'];
    $p_nameL = $_POST['Last_name'];
    $p_project = $_POST['projectList'];
    $sql = "INSERT INTO personell
    (First_name, Last_name, project_id)
    VALUES ('$p_name', '$p_nameL' , $p_project )";

    if (mysqli_query($connection, $sql)){
        echo "done";
    } else {
        echo "Error: " . "<br>" . mysqli_error($connection);
    };

}
//add project logic
If(isset($_POST['Add_project'])){
    $project_name = $_POST['projectName'];
    $sql = "INSERT INTO projects
    (Project_name)
    VALUES ('$project_name')";

    if (mysqli_query($connection, $sql)){
        echo "done";
    } else {
        echo "Error: " . "<br>" . mysqli_error($connection);
    };

}

//function for project selection options
function selectProject($connection){
    $sql="SELECT project_id, project_name
    FROM projects";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            print ("<option value='" . $row['project_id'] . "'" . ">" . $row['project_name'] .  "</option>");
        }
    } else {
        echo "none";
    }

}
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
        echo ("<tr><td>" . $row['id'] . "</td><td> ". $row['First_name'] . "</td> <td>" . $row['Last_name'] . "</td><td>" . $row['Project_name'] . "</td><td>" ."<button>" . '<a href="?action=delete&id=' . $row['id'] . '">Delete</a></button>' . "</td></tr> <br>");
    }
} else {
    echo "0 results";
}

}
//function ro render project lists 
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
        echo ("<tr><td>" . $row['Project_name'] .  "</td><td>". $row['assigned'] . "</td><td>" ."<button>" . '<a href="?action=project_delete&Project_id=' . $row['Project_id'] . '">Delete</a></button>' . "</td></tr> <br>");
    }
} else {
    echo "0 results";
}

mysqli_close($connection);


}

?>
