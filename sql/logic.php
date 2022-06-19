<?php
 require_once './config/ConnectionDb.php';
//conection to db
$conn = new Connection;
$connection = $conn->getConnection();
($connection) ? $connStatus = "Connected to database successfully"
: $connStatus = "Connection failed";
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
    var_dump($p_project);
    (!$p_project) ? $p_project = NULL : null;
    var_dump($p_project);
    $sql = "INSERT INTO personell
    (First_name, Last_name, project_id)
    VALUES (?, ? , ? )";
    $stmt = $connection->prepare($sql);
    try{
        $stmt->bind_param('ssi', $p_name, $p_nameL, $p_project);
        $res = $stmt->execute();
        $stmt->close();
        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        die();
    }
        catch(Exception $e){
            $note = 'Unable to add new person!';

    }
}
//add project logic
If(isset($_POST['Add_project'])){
    $project_name = $_POST['projectName'];
    $sql = "INSERT INTO projects
    (Project_name)
    VALUES (?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $project_name);
try{
    $res = $stmt->execute();
    $stmt->close();
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();
}
catch(Exception $e){
    $note = 'Unable to add new project!';
  
}}

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
    First_name = ?,
    Last_name = ?,
    Project_id = ?
    Where id = ? ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ssii', $firstName, $lastName, $assignedProject, $idx);
    try{
    $res = $stmt->execute();
    $stmt->close();
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    die();
    }
    catch(Exception $e){
        $note = 'Unable to save chages!';
    }
}
// update project logic

If(isset($_POST['update_project'])){
    var_dump ($_POST['_id']);
    $p_idx = $_POST['_p_id'];
    $projectName = $_POST['projectName'];
    $sql = "UPDATE projects
    SET
    Project_name = ?
    Where Project_id = ? ";
   $stmt = $connection->prepare($sql);
    $stmt->bind_param('si', $projectName, $p_idx  );
    $res = $stmt->execute();
    $stmt->close();
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
echo "<tr><th>No.</th><th>Name</th><th>Last name</th><th>Projects</th><th>Actions</th></tr>";

if (mysqli_num_rows($result) > 0) {
    $personellCount = 0 ;
    while($row = mysqli_fetch_assoc($result)) {
        if(isset($_GET['action']) and $_GET['action'] == 'personell_update' and $row['id'] == $_GET['update_id'] ){
            $personellCount++;
            echo ("<form method='post' action='index.php'><tr>
            <td>" . $personellCount . "<input type='hidden' name='_id' required value='" . $row['id'] . "'>" . "</td>
            <td>" . "<input class='editInput' type='text' name='firstName' required value='" . $row['First_name'] . "'>" . "</td> 
            <td>" . "<input class='editInput' type='text' name='lastName' required value='" . $row['Last_name'] . "'>" ."</td>
            <td>" . "<select class='editInput'  name='projectList'>" . "<option value=" . $row['Project_id'] .">" . $row['Project_name'] . "</option>" .
             selectProject($connection) . "</select>" . "</td>
           <td>" . "<div class='btn-container'><input type='submit' class='btn-green' name='update_personell' value='Save'></div>" . "</td></tr></form> ");
             continue;
        }
        $personellCount++;
        echo ("<tr><td>" . $personellCount . "</td><td> ". $row['First_name'] . "</td> <td>" . $row['Last_name'] . "</td><td>" . $row['Project_name'] . "</td><td>" ."<div class='btn-container'><button class='btn-red'>" . '<a href="?action=delete&id=' . $row['id'] . '">Delete</a></button>' . "<button class='btn-green'>" . '<a href="?action=personell_update&update_id=' . $row['id'] . '">Edit</a></button></div>' . "</td></tr> ");
    }
}

}
//function to render projects
function project($connection){
    $sql = "SELECT 
    projects.Project_id, projects.Project_name, group_concat(Concat_ws(' ', personell.First_name, Personell.Last_Name) separator ', ') AS assigned
    From projects
    Left join personell
    ON projects.Project_id = personell.Project_id
    GROUP BY Project_name
    ORDER BY Project_id;
";
$result = mysqli_query($connection, $sql);
echo "<tr><th>No.</th><th>Project</th><th>Assigned Employee(s)</th><th>Actions</th></tr>";

if (mysqli_num_rows($result) > 0) {
    $projectsCount= 0 ;
    while($row = mysqli_fetch_assoc($result)) {
        if(isset($_GET['action']) and $_GET['action'] == 'project_update' and $row['Project_id'] == $_GET['Project_idx'] ){
            $projectsCount++;
            echo ("<form method='post' action='projects.php'><tr>
            <td>" . $projectsCount . "<input type='hidden' name='_p_id' required value='" . $row['Project_id'] . "'>" . "</td>
            <td>" . "<input class='editInput' type='text' name='projectName' required value='" . $row['Project_name'] . "'>" . "</td>
            <td>" . $row['assigned'] . "</td>
            <td>" . "<div class='btn-container'><input type='submit' class='btn-green' name='update_project' value='Save'></div>" . "</td></tr></form>");
            continue;

        }
        $projectsCount++;
        echo ("<tr><td>" . $projectsCount . "</td><td>" . $row['Project_name'] .
          "</td><td>". $row['assigned'] . "</td><td>" ."<div class='btn-container'><button class='btn-red'>" . '<a href="?action=project_delete&Project_id=' . $row['Project_id'] . '">Delete</a></button>' . "<button class='btn-green'>" . '<a href="?action=project_update&Project_idx=' . $row['Project_id'] . '">Edit</a></button></div>' . "</td></tr>");
    }
}
}

?>
