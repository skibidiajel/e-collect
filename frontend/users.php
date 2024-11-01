<?php  
  session_start();
  include '../backend/connection.php';
  include './functions/dbFunction.php';
  include './functions/fetchFromApi.php';

  // FETCHING NOTIFICATION RECORDS
  $users = getDataUsers($conn);
  // GETTING DATA FROM THINKSPEAK
  fetchDataFrmApi($conn);
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>CEWMO - e-collect</title>
    <link rel="icon" type="image/x-icon" href="../pictures/cewmo logo.png">
    <link rel="stylesheet" href="./CSS/users.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60;URL=users.php">
  </head>
  <body>
    <header>
      <div class="ham-menu" onclick="hamMenuActive()">
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="icon-name head-container">
        <img src="../pictures/cewmo logo.png" alt="CEWMO Logo">
        <h1 class="header-title">CEWMO E-COLLECT</h1>
      </div>
      <div class="login-logout head-container">
        <div class="head-container">
          <img src="../pictures/login icon.png" alt="Login Icon">
          <h4><?= $_SESSION['usern']; ?></h4>
        </div>
        <div class="logout-hover head-container" onclick="logout()">
          <img src="../pictures/logout icon.png" alt="Logout Icon">
          <h4>Logout</h4>
        </div>
      </div>
    </header>
    <div class="nav-main-container">
      <nav class="navigation-list">
        <ul class="nav-list">
          <a class="nav-link" href="dashboard.php">
            <li class="nav-item">
              Dashboard
            </li>
          </a>
          <a class="nav-link" href="transactions.php">
            <li class="nav-item">
              Transaction Records
            </li>
          </a>
          <a class="nav-link" href="coin.php">
            <li class="nav-item">
              Coin Records
            </li>
          </a>
          <a class="nav-link" href="notification.php">
            <li class="nav-item">
              Notifications
            </li>
          </a>
          <a class="nav-link" href="users.php">
            <li class="nav-item active">
              Users
            </li>
          </a>
          <a class="nav-link" href="logs.php">
            <li class="nav-item">
              Logs
            </li>
          </a>
        </ul>
      </nav>
      <main>
        <table class="users-data">
          <caption>Users</caption>
          <tr>
            <th>
              Username
            </th>
            <th>
              Pasword
            </th>
            <th>
              Actions
            </th>
          </tr>
          <?php
            if($users != NULL){
              foreach($users as $data){
                echo "<tr>";
                echo "<td>". $data['Username'] ."</td>";
                echo "<td>". $data['Password'] ."</td>";
                echo "<td>
                        <button class='edit-delete' onclick='showEditModal(\"".$data['Username']."\",\"".$data['Password']."\",".$data['ID'].")'><img src='../pictures/editicon.png'></button>
                        <button class='edit-delete' onclick='showDeleteModal(".$data['ID'].")'><img src='../pictures/trashbin.png'></button>
                      </td>";
              echo "</tr>";
              }
            }else{
              echo "<tr>";
                echo "<td colspan=3>No Data Found!</td>";
              echo "</tr>";
            }
          ?>
          <tr style="background-color: var(--highlighterColor);">
            <td colspan="3" style="text-align: right;">
              <button onclick="addUser()" class="add-user">Add User</button>
            </td>
          </tr>
        </table>
      </main>
    </div>
    <!-- FOR MODAL/POPUP -->
    <div class="modal" id="modal">
      <div class="modal-container">
        <div class="modal-items-add" id="add-modal">
          <h1>Add New User</h1>
          <form action="users.php" method="POST">
            <div class="input-container">
              <input type="text" name="username" placeholder="Enter Username">
              <input type="password" name="password" placeholder="Enter Password">
            </div>
            <div>
              <button class="confirm" name="confirm">Confirm</button>
              <button onclick='userAddCancel()' class="cancel")>Cancel</button>
            </div>
          </form>
        </div>
        <div class="modal-items-edit" id="edit-modal">
          <h1>Edit User</h1>
          <form action="users.php" method="POST">
            <div class="input-container">
              <input type="hidden" id="edit-id" name="userID">
              <input type="text" id="edit-username" name="userEdit">
              <input type="text" id="edit-password" name="userPass">
            </div>
            <div>
              <button class="confirm" name="confirm-edit">Confirm</button>
              <button onclick='userAddCancel()' class="cancel")>Cancel</button>
            </div>
          </form>
        </div>
        <div class="modal-items-delete" id="delete-modal">
          <h1>Delete User</h1>
          <form action="users.php" method="POST">
            <input type="hidden" id="delete-id" name="userID">
            <button class="confirm" name="confirm-delete">Confirm</button>
            <button onclick='userAddCancel()' class="cancel")>Cancel</button>
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="./javascript/frontendFunc.js"></script>
  </body>
</html>
<?php
  // FOR ADD MODAL/POPUP
  $usernameLogs  = $_SESSION['usern'];
  if(isset($_POST['confirm'])){
    if($_POST['username'] == NULL || $_POST['password'] == NULL){
      die("<script>alert('Please fillup all the input box. Thanks!')</script>");
    }else{
      $username = $_POST['username'];
      $password = $_POST['password'];
      setDataUsers($username,$password, $conn, $usernameLogs);
    }
  }
  // FOR EDIT MODAL/POPUP
  if(isset($_POST['confirm-edit'])){
    if($_POST['userEdit'] == NULL || $_POST['userPass'] == NULL){
      die("<script>alert('Please fillup all the input box. Thanks!')</script>");
    }else{
      $userID = $_POST['userID'];
      $userEdit = $_POST['userEdit'];
      $userPass = $_POST['userPass'];
      setDataUsersEdit($userID, $userEdit, $userPass, $conn, $usernameLogs);
    }
  }
  // FOR DELETE MODAL/POPUP
  if(isset($_POST['confirm-delete'])){
    $userID = $_POST['userID'];
    deleteUserData($userID, $conn, $usernameLogs);
  }
?>
<!--
[√] - TRY EDIT AND DELETE ICON
[√] - EDIT ICON FUNCTIONALITY (THINK OF ANOHTER WAY TO NOT TO HAVE THE SAME USER)
[√] - DELETE ICON FUNCTIONALITY
[√] - ADD USER FUNCTIONALITY
-->