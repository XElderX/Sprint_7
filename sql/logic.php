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
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();

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
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();

}

//function for project selection options
function selectProject($connection){
    $sql="SELECT project_id, project_name
    FROM projects";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        if(isset($_GET['action']) and $_GET['action'] == 'personell_update'){
             $returnas="";
            while($row = mysqli_fetch_assoc($result)) {
                $returnas .= "<option value='" . $row['project_id'] . "'" . ">" . $row['project_name'] .  "</option>";
        }
        return $returnas;
    }
            while($row = mysqli_fetch_assoc($result)) {
                print ("<option value='" . $row['project_id'] . "'" . ">" . $row['project_name'] .  "</option>");
            }

        
    } else {
        echo "none";
    };
    

}
//update personel logic

If(isset($_POST['update_personell'])){
    $idx = $_POST['_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $assignedProject = $_POST['projectList'];
    $sql = "UPDATE personell
    SET
    First_name = '$firstName',
    Last_name = '$lastName',
    Project_id = $assignedProject
    Where id = $idx ";
   
    if (mysqli_query($connection, $sql)){
        echo "done";
    } else {
        echo "Error: " . "<br>" . mysqli_error($connection);
    };
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();

}
// update project logic


If(isset($_POST['update_project'])){
    var_dump ($_POST['_id']);
    $p_idx = $_POST['_p_id'];
    $projectName = $_POST['projectName'];


    $sql = "UPDATE projects
    SET
    Project_name = '$projectName'
    Where Project_id = $p_idx ";
   
    if (mysqli_query($connection, $sql)){
        echo "done";
    } else {
        echo "Error: " . "<br>" . mysqli_error($connection);
    };
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();

}




//function for personell data render
function personell($connection){
    $sql = "SELECT
    personell.id, personell.First_name, personell.Last_name, projects.Project_id, projects.Project_name
    FROM personell
    left join projects
    ON projects.Project_id = personell.Project_id
    ORDER BY id ";
$result = mysqli_query($connection, $sql);
echo "<br><tr><th>id</th><th>name</th><th>lastname</th><th>Projects</th><th>Actions</th></tr>";

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        if(isset($_GET['action']) and $_GET['action'] == 'personell_update' and $row['id'] == $_GET['update_id'] ){
            echo ("<tr>
            <form method='post' action='index.php'>
            <td>" . $row['id'] . "<input type='hidden' name='_id' required value='" . $row['id'] . "'>" . "</td>
            <td>" . "<input type='text' name='firstName' required value='" . $row['First_name'] . "'>" . "</td> 
            <td>" . "<input type='text' name='lastName' required value='" . $row['Last_name'] . "'>" ."</td>
            <td>" . "<select name='projectList'>" . "<option value=" . $row['Project_id'] .">" . $row['Project_name'] . "</option>" .
             selectProject($connection) . "</select>" . "</td>
           <td>" . "<input type='submit' name='update_personell' value='update'>" . "</td></form></tr> <br>");
            //  . '<a href="?action=saveUpdate&update_id=' . $row['id'] . '">Save</a></input>' . "</td></tr> <br>");
             continue;
        }
        echo ("<tr><td>" . $row['id'] . "</td><td> ". $row['First_name'] . "</td> <td>" . $row['Last_name'] . "</td><td>" . $row['Project_name'] . "</td><td>" ."<button>" . '<a href="?action=delete&id=' . $row['id'] . '">Delete</a></button>' . "<button>" . '<a href="?action=personell_update&update_id=' . $row['id'] . '">Update</a></button>' . "</td></tr> <br>");
    }
} else {
    echo "0 results";
}

}
//function To render projects
function project($connection){
    $sql = "SELECT 
    projects.Project_id, projects.Project_name, group_concat(Concat_ws(' ', personell.First_name, Personell.Last_Name) separator ',') AS assigned
    From projects
    Left join personell
    ON projects.Project_id = personell.Project_id
    GROUP BY Project_name
    ORDER BY Project_id;
";
$result = mysqli_query($connection, $sql);
echo "<br><tr><th>Project id</th><th>Project</th><th>Assigned Employees</th><th>Actions</th></tr>";

if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        if(isset($_GET['action']) and $_GET['action'] == 'project_update' and $row['Project_id'] == $_GET['Project_idx'] ){
            echo ("<tr>
            <form method='post' action='projects.php'>
            <td>" . $row['Project_id'] . "<input type='hidden' name='_p_id' required value='" . $row['Project_id'] . "'>" . "</td>
            <td>" . "<input type='text' name='projectName' required value='" . $row['Project_name'] . "'>" . "</td>
            <td>" . $row['assigned'] . "</td>
            <td>" . "<input type='submit' name='update_project' value='update'>" . "</td></form></tr> <br>");
            continue;

        }

        echo ("<tr><td>" . $row['Project_id'] . "</td><td>" . $row['Project_name'] .
          "</td><td>". $row['assigned'] . "</td><td>" ."<button>" . '<a href="?action=project_delete&Project_id=' . $row['Project_id'] . '">Delete</a></button>' . "<button>" . '<a href="?action=project_update&Project_idx=' . $row['Project_id'] . '">Update</a></button>' . "</td></tr> <br>");
    }
} else {
    echo "0 results";
}

mysqli_close($connection);


}

?>
