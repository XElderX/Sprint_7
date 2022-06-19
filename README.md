# Sprint project 7:
<h2>Project managament application</h2>
## About The Project

This is practical assignment. App was made based on PHP programming language. Main focus for this assignment was comunication with database - MySQL :
Task requirements:
* With MySQL Workbench create database schema providing necessary data of tables and its columns.  
* Make them relate with each other.  
* Create the app. Which render that data.
* Implement functionalities such as add, remove or update.
* Application have to update, remove or update any commited changes into database.
* *Use pre-Prepered statement concept of SQL in code

### Built With

This app was developed with raw php, css and MySQL.

## Getting Started

<li>There are instructions on setting up this project.</li>
<li>To get a local copy up and running follow these simple steps:</li>
<li>You have to clone the repository https://github.com/XElderX/Sprint6.git e.g On Visual Studio Code using git bash command line : <code> git clone https://github.com/XElderX/Sprint_7.git </code> </li>
<li>Congratulation now you have this project locally </li>
<li>However, since its a server side app you have to make some additional steps to make it working. You have to install<b>  PHP development Web server. e.g XAMPP</b> and <b>MySQL Workbench</b></li>


### Installation

* XAMPP's instaliation;

1. Go to "https://www.apachefriends.org/"
2. Download it, and start the server
3. On XAMPP's instalation location find dir with a name: htdocs
4. Put there content that you have cloned before.

* MySQL instaliation and and settin-up database;

1. Go to "https://dev.mysql.com/downloads/installer/"
2. Download it, then start <b> XAMPP control Panel</b>
3. On XAMPP's control panel start <code>Apache</code> and <code>MySQL</code> by pressing start;
<img src="https://user-images.githubusercontent.com/99712528/174490083-4c198c6f-ee57-4470-a7e6-2922db5bd6fe.png" alt="XAMPPcp">
4. Open <code> MySQL Workbench </code> Create MySQL Connection (if it's your first time) set username and password(by default just leave username as root and not set any password); <img src="https://user-images.githubusercontent.com/99712528/174490079-1d58c653-ad9d-4e5a-88f7-2f24aff64697.png" alt="newSQlConn">   
5. As your connected into your MySQL click <code>Server -> Data import </code><img src="https://user-images.githubusercontent.com/99712528/174490085-a95eedbf-ea86-4c80-80d3-e5b6dc26edba.png" alt="import"> check <b>Import from Self-Contained File </b>  and select <code>p_managament.sql</code> then create <b>new Schema</b> by clicking <code>New...</code> name it as <code>personel_management</code> and finally click<b> Start Import</b>. <img src="https://user-images.githubusercontent.com/99712528/174490089-29a3fcae-4a4a-4b7b-9925-d22f767bac6b.png" alt="importSettings">   <img src="https://user-images.githubusercontent.com/99712528/174490091-b788185c-9165-417f-96c2-4d9075b94ae4.png" alt="importSettings2">
6. If all thes steps were made correct.. you should have database created. You can click <b> refresh SCHEMAS button</b> on left side Navigator box.
7. *If your MySQL username is not named rood and you have set up password you have to do one additional step. Go to project directory click on <b>config</b> open <b>ConnectionDb.php</b> and edit <code>$username and $password </code> providing with correct info. <img src="https://user-images.githubusercontent.com/99712528/174490092-1bc9ded5-57c3-496a-8f15-286fa0ffcb27.png" alt="configChange">
8. In your web browser(e.g Chrome, Firefox etc.) onto url field enter http://localhost/sprint_7/index.php


## Contact

<span><strong>Project developed by: </strong> Dalius Kriaučiūnas <a href="https://www.linkedin.com/in/dalius-kriauciunas/">Link to Linked In </a></span>

Project Link: https://github.com/XElderX/Sprint_7
