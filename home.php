<?php

require_once('mysqli/mysqli_connect.php');

if (!isset($_SESSION)) {
  session_start();
}

$user_name = $_SESSION['username'];
$id = $_SESSION['id'];

if (empty($user_name)) {

  header('location:login.php');
}


if ($user_name == 'stripes') {
  $tasks = mysqli_query($mysqli, "SELECT * FROM discrepancies");
} else {
  $tasks = mysqli_query($mysqli, "SELECT * FROM discrepancies WHERE user='$user_name'");
}

//Pull Next AUTO_INCREMENT
$sql2 = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "servicenow" AND TABLE_NAME = "discrepancies"';
$result = mysqli_query($pdo,$sql2);
$lastID = mysqli_fetch_assoc($result);
$lastID = implode(',', $lastID);

// function debug_to_console($data) {
//   $output = $data;
//   if (is_array($output))
//       $output = implode(',', $output);

//   echo "<script>console.log($output);</script>";
// }

//debug_to_console($lastID);

?>




<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title></title>
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="scripts/style.css" />
  <script type="text/javascript" src="scripts/jquery-3.4.1.js" defer></script>
  <script type="text/javascript" src="https://kit.fontawesome.com/33507cf65a.js" crossorigin="anonymous" defer></script>
  <script type="text/javascript" src="scripts/jquery-ui.js" defer></script>
  <script type="text/javascript" src="scripts/jquery.maskedinput.min.js" defer></script>
  <script type="text/javascript" src="scripts/jquery.sortElements.js" defer></script>
  <script>
    var sessionUser= "<?php echo $_SESSION['username'];?>";
  </script>
  <script type="text/javascript" src="scripts/script.js" defer></script>
  <link rel="icon" href="../../img/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="scripts/jquery-ui.css" />
</head>

<body>
  <!--[if lt IE 7]>
      <p class="browsehappy">
        You are using an <strong>outdated</strong> browser. Please
        <a href="#">upgrade your browser</a> to improve your experience.
      </p>
    <![endif]-->

  <div class="navpage-layout">
    <div class="alert">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      <p>This is an alert box.</p>
    </div>
    <header class="navpage-header" role="banner">
      <div class="navbar">
        <div class="navbar-icon"><a href="#"><span class="white">SERVICE </span><span class="red">NOW</span></a></div>
        <div class="navbar-footer">

          <ul class="changeStatus">
            <li>
              <a href="#" class="online">Online</a>
            </li>
            <li>
              <a href="#" class="away">Away</a>
            </li>
            <li>
              <a href="#" class="busy">Busy</a>
            </li>
            <li>
              <a href="#" class="offline">Offline</a>
            </li>
          </ul>
          <span class="user_name"><?php echo strtoupper($user_name)    ?></span>
          <div class="onlineStatus">
          </div>
          <a href="#" class="avatarStatus" title="Change Online Status">
            <?php
            if ($id == 1) {
              echo ' <img src="images/profile_' . $id . '.jpg" alt="Avatar" class="avatar">';
            } else {
              echo '<img src="images/default.svg" alt="Avatar" class="avatar">';
            }
            ?>
          </a>
          <a href="#" class="comments" title="No New Messages"><i class="far fa-comments fa-lg"></i></a>
          <a href="#" class="help" title="Help"><i class="far fa-question-circle fa-lg"></i></a>
          <a href="#" id="settings" class="settings" title="Account Settings"><i class="fas fa-cog fa-lg settings"></i></a>
          <div class="search-box">
            <input class="search-txt" type="text" name="" placeholder="Type to search">
            <a href="#" class="search-btn" title="Search this page"><i class="fas fa-search fa-lg"></i></a>
          </div>
          <ul class="changeSettings">
            <li>
              <a href="#" class="profile">My Profile</a>
            </li>
            <li>
              <a href="logout.php" class="logout">Logout</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="navbar-divider"></div>
    </header>
    <nav class="navpage-nav" id="navpage-nav" aria-label="Primary">
      <ul id="nav-icons">
        <h2>Sidebar</h2><span onclick="toggleSidebar();"><i id="rotateBars" class="fas fa-bars fa-2x"></i></span>
        <li><a href="#" id="home"><i class="fas fa-home"></i>HOME</li>
        <li><a href="#" id="issues"><i class="fas fa-exclamation-triangle"></i>ISSUES</a></li>
        <li><a href="#" id="guides"><i class="fas fa-question-circle"></i>GUIDES</a></li>
        <li><a href="#" id="contacts"><i class="fas fa-address-book"></i>CONTACT</a></li>
        <div class="navpage-nav-footer">
          <div id="creditName">Created by: Jaime Gonzalez</div>
          <div id="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-arrow-circle-right fa-2x"></i>
          </div>
        </div>
      </ul>
    </nav>
    <main class="navpage-main" id="navpage-main">
      <div class="navpage-main-header" id="navpage-main-header">
        <div class="pageTitle">Home</div>
        <div class="btnControls">
          <button class="checkAll" onclick="selectAll();">Select all</button>
          <button class="add">Add</button>
          <button class="delete">Delete</button>
        </div>
      </div>
      <div class="navpage-main-left">
        <div class="home">
          <div class="home-content">
            <div class="home-nav">
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-cogs fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Guided Setup</div>
                  <div class="home-nav-btn-desc">Guided Setup tools to help you set up ServiceNow</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-shield-alt fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">System Security</div>
                  <div class="home-nav-btn-desc">Configure and monitor instance security settings</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-sign-in-alt fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Business Logic</div>
                  <div class="home-nav-btn-desc">Manage workflow and behavior of applications</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-cubes fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Create and Deploy</div>
                  <div class="home-nav-btn-desc">Create, modify and deploy applications to your instances</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-th fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Data Management</div>
                  <div class="home-nav-btn-desc">Manage the way data is stored and displayed</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-laptop-medical fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Diagnostics</div>
                  <div class="home-nav-btn-desc">Perform, development and debugging tools</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-envelope-open-text fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Email</div>
                  <div class="home-nav-btn-desc">Customize behavior of inboud and outbound email</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-laptop-code fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Homepages</div>
                  <div class="home-nav-btn-desc">Configure homepages for Service desk and Self Service users</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-object-group fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Integration</div>
                  <div class="home-nav-btn-desc">Integrate with 3rd-party systems and data sources</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-chart-pie fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">Reporting and Analytics</div>
                  <div class="home-nav-btn-desc">Create visual representations of your data</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-user-edit fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">User Administration</div>
                  <div class="home-nav-btn-desc">Manage users, groups and their roles</div>
                </div>
              </div>
              <div class="home-nav-btn">
                <div class="left">
                  <div class="home-nav-btn-logo"><i class="fas fa-sitemap fa-4x"></i></div>
                </div>
                <div class="right">
                  <div class="home-nav-btn-title">User Interface</div>
                  <div class="home-nav-btn-desc">Control the look and feel of applications</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="guides"></div>
        <div class="contacts">
          <div class="card">
            <p>Jaime Gonzalez</p>
            <i class="fas fa-phone"></i>
            <p>(956) 607-8788</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>
          <div class="card">
            <p>Stephanie Trevino</p>
            <i class="fas fa-phone"></i>
            <p>(956) 358-0981</p>
          </div>

        </div>
        <div id="chat">
          <div id="messages"></div>
          <form id="msgForm">
            <input type=" text" id="message" autocomplete="off" autofocus placeholder="Type message..">
            <input type="submit" value="Send" id="sendMSG">
          </form>
        </div>

        <div class="issues">
          <template id="template-tr">
            <tr class="edit mainTR" id="<?php echo $lastID; ?>" >
              <td>
                <div class="checkParent">
                  <label class="checker">
                    <input type="checkbox" name="acs" class="checkers">
                    <span class="checkmark"></span>
                  </label></div>
              </td>
              <td class="btnReplace"><a href="#" class="editOrder noedit"><i class="fas fa-pen fa-lg"></i></a><a href="#" name="onSave" class="saveOrder edit"><i class="fas fa-save fa-lg"></i></a><a href="#" class="cancelOrder edit"><i class="fas fa-window-close fa-lg"></i></a></td>
              <td>
                <p>
                  <span class="noedit accession">{{accession}}</span>
                  <input class="edit accession input-custom" size="9" max-lenth="9">
                </p>
              </td>
              <td>
                <p>
                  <span class="noedit mrn">{{mrn}}</span>
                  <input class="edit mrn" size="6" maxlength="6">
                </p>
              </td>
              <td>
                <p>
                  <span class="noedit pName">{{pName}}</span>
                  <input class="edit pName">
                </p>
              </td>
              <td>
                <p>
                  <span class="noedit pDOB">{{pDOB}}</span>
                  <input class="edit pDOB" size="10" placeholder="01/01/2019">
                </p>
              </td>
              <td>
                <p>
                  <span class="noedit pDOS">{{pDOS}}</span>
                  <input class="edit pDOS" size="10" placeholder="01/01/2019">
                </p>
              </td>
              <td>
                <p>
                  <span class="noedit doctor">{{doctor}}</span>
                  <input class="edit doctor">
                </p>
              </td>
              <td>
                <p>
                  <span class="noedit desc">{{desc}}</span>
                  <input class="edit desc">
                </p>
              </td>
            </tr>
          </template>
          <table id="myTable">
            <thead>
              <tr>
                <th><a href="#" onclick="selectAll();" class="notfirst"><i class="fas fa-cog"></i></th>
                <th><a><i class="fas fa-bars"></i> Edit</a></th>
                <th id="accession"><a href="#"><i class="fas fa-bars"></i> Accession</a></th>
                <th id="mrn"><a href="#"><i class="fas fa-bars"></i> MRN</a></th>
                <th id="pName"><a href="#"><i class="fas fa-bars"></i> Name</a></th>
                <th id="pDOB"><a href="#"><i class="fas fa-bars"></i> DOB</a></th>
                <th id="pDOS"><a href="#"><i class="fas fa-bars"></i> DOS</a></th>
                <th id="doctor"><a href="#"><i class="fas fa-bars"></i> Doctor</a></th>
                <th id="desc"><a href="#"><i class="fas fa-bars"></i> Description</a></th>
              </tr>
            </thead>
            <tbody id="tableBody">

              <?php while ($row = mysqli_fetch_assoc($tasks)) {
                echo '<tr class="mainTR" id="';
                echo $row['id'];
                echo '">';
                echo '<td>';
                echo '<div class="checkParent">';
                echo '<label class="checker">';
                echo '<input type="checkbox" name="acs" class="checkers">';
                echo '<span class="checkmark">';
                echo '</span>';
                echo '</label></div>';
                echo '</td>';
                echo '<td class="btnReplace"><a href="#" class="editOrder noedit"><i class="fas fa-pen fa-lg"></i></a><a href="#" name="onSave" class="saveOrder edit"><i class="fas fa-save fa-lg"></i></a><a href="#" class="cancelOrder edit"><i class="fas fa-window-close fa-lg"></i></a></td>';
                echo '<td>';
                echo '<p>';
                echo '<span class="noedit accession">' . $row['accession'] . '</span>';
                echo '<input class="edit accession input-custom" size="9" max-lenth="9">';
                echo '</p>';
                echo '</td>';
                echo '<td>';
                echo '<p>';
                echo '<span class="noedit mrn">' . $row['mrn'] . '</span>';
                echo '<input class="edit mrn" size="6" maxlength="6">';
                echo '</p>';
                echo '</td>';
                echo '<td>';
                echo '<p>';
                echo '<span class="noedit pName">' . $row['pName'] . '</span>';
                echo '<input class="edit pName">';
                echo '</p>';
                echo '</td>';
                echo '<td>';
                echo '<p>';
                echo '<span class="noedit pDOB">';
                echo $row['pDOB'];
                echo '</span>';
                echo '<input class="edit pDOB" size="10" placeholder="01/01/2019">';
                echo '</p>';
                echo '</td>';
                echo '<td>';
                echo '<p>';
                echo '<span class="noedit pDOS">' . $row['pDOS'] . '</span>';
                echo '<input class="edit pDOS" size="10" placeholder="01/01/2019">';
                echo '</p>';
                echo '</td>';
                echo '<td>';
                echo '<p>';
                echo '<span class="noedit doctor">' . $row['doctor'] . '</span>';
                echo '<input class="edit doctor">';
                echo '</p>';
                echo '</td>';
                echo '<td>';
                echo '<p>';
                echo '<span class="noedit desc">' . $row['description'] . '</span>';
                echo '<input class="edit desc">';
                echo '</p>';
                echo '</td>';
                echo '</tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>

</html>