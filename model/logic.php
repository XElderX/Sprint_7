<?php
require 'model\functions.php';
session_start();
//delete personell logic
if (isset($_GET['action']) and $_GET['action'] == 'delete') {
    $sql = 'DELETE FROM personell WHERE id = ?';
    $stmt = $connection->prepare($sql);
    try {
        $stmt->bind_param('i', $_GET['id']);
        $res = $stmt->execute();
        $stmt->close();
        $_SESSION['positive'] = 'notePositive';
    $_SESSION['note'] = 'You have removed Personell from the database';
    } 
    catch (Exception $e) {
        $_SESSION['negative'] = 'note';
        $_SESSION['note'] = 'Person deletion wasn\'t sucessfully!';
    }
    redirect();
}
//delete project logic
if (isset($_GET['action']) and $_GET['action'] == 'project_delete') {
    $sql = 'DELETE FROM projects WHERE Project_id= ?';
    $stmt = $connection->prepare($sql);
    try {
        $stmt->bind_param('i', $_GET['Project_id']);
        $res = $stmt->execute();
        $stmt->close();
        $_SESSION['positive'] = 'notePositive';
        $_SESSION['note'] = 'You have taken off the project from the database successfully!';
    } catch (Exception $e) {
        $_SESSION['negative'] = 'note';
        $_SESSION['note'] = 'Project deletion wasn\'t sucessfully!';
    }
    redirect();
}
//add personell logic 
if (isset($_POST['Add_personell'])) {
    $p_name = $_POST['First_name'];
    $p_nameL = $_POST['Last_name'];
    $p_project = $_POST['projectList'];
    personelValidation($p_name, $p_nameL);
    (!$p_project) ? $p_project = NULL : null;
    $sql = "INSERT INTO personell
    (First_name, Last_name, project_id)
    VALUES (?, ? , ? )";
    $stmt = $connection->prepare($sql);
    try {
        $stmt->bind_param('ssi', $p_name, $p_nameL, $p_project);
        $res = $stmt->execute();
        $stmt->close();
        $_SESSION['positive'] = 'notePositive';
        $_SESSION['note'] = 'You have added a new Person into database!';
    } catch (Exception $e) {
        $_SESSION['negative'] = 'note';
        $_SESSION['note'] = 'Unable to add Personel!';
    }
    redirect();
}
//add project logic
if (isset($_POST['Add_project'])) {
    $project_name = $_POST['projectName'];
    projectNameValidation($project_name);
    $sql = "INSERT INTO projects
    (Project_name)
    VALUES (?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $project_name);
    try {
        $res = $stmt->execute();
        $stmt->close();
        $_SESSION['positive'] = 'notePositive';
        $_SESSION['note'] = 'You have been added a new project into the database';
    } catch (Exception $e) {
        $_SESSION['negative'] = 'note';
        $_SESSION['note'] = 'Unable to add new project!';
    }
    redirect();
}
//update personel logic

if (isset($_POST['update_personell'])) {
    $idx = $_POST['_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $assignedProject = $_POST['projectList'];
    personelValidation($firstName, $lastName);
    (!$assignedProject) ? $assignedProject = NULL : null;
    $sql = "UPDATE personell
    SET
    First_name = ?,
    Last_name = ?,
    Project_id = ?
    Where id = ? ";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('ssii', $firstName, $lastName, $assignedProject, $idx);
    try {
        $res = $stmt->execute();
        $stmt->close();
        $_SESSION['positive'] = 'notePositive';
        $_SESSION['note'] = 'You have updated Personell details!';
    } catch (Exception $e) {
        $_SESSION['negative'] = 'note';
        $_SESSION['note'] = 'Unable to update Personel details!';
    }
    redirect();
}
// update project logic

if (isset($_POST['update_project'])) {
    var_dump($_POST['_id']);
    $p_idx = $_POST['_p_id'];
    $projectName = $_POST['projectName'];
    projectNameValidation($projectName);
    $sql = "UPDATE projects
    SET
    Project_name = ?
    Where Project_id = ? ";
    $stmt = $connection->prepare($sql);
    try {
        $stmt->bind_param('si', $projectName, $p_idx);
        $res = $stmt->execute();
        $stmt->close();
        $_SESSION['positive'] = 'notePositive';
        $_SESSION['note'] = 'You have updated the project successfully!';
    } catch (Exception $e) {
        $_SESSION['negative'] = 'note';
        $_SESSION['note'] = 'Unable to update the Project!';
    }
    redirect();
}

