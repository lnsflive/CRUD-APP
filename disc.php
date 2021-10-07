<?php
//session start
if (!isset($_SESSION)) {
    session_start();
}

//connect db
require_once('mysqli/mysqli_connect.php');

$user_name = $_SESSION['username'];

if ($user_name == 'stripes') {
    $tasks = mysqli_query($mysqli, "SELECT * FROM discrepancies");
} else {
    $tasks = mysqli_query($mysqli, "SELECT * FROM discrepancies WHERE user='$user_name'");
}
if (mysqli_num_rows($tasks) > 0) {
    while ($row = mysqli_fetch_assoc($tasks)) {
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
}
