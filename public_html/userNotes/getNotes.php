<?
    include("../link.php");
    if(isset($_COOKIE) && array_key_exists('id', $_COOKIE)) {
        $query = "SELECT * FROM `notes` WHERE userId = '".mysqli_real_escape_string($link, $_COOKIE['id'])."' "; 
    }

    else if(isset($_GET) && array_key_exists('id', $_GET)) {
        $query = "SELECT * FROM `notes` WHERE userId = '".mysqli_real_escape_string($link, $_GET['id'])."' "; 
    }

    $result = mysqli_query($link, $query);
    while($row = mysqli_fetch_array($result)) {
        echo "<div id='note".$row['id']."' class='note card animated bounceInDown ".$row['noteColor']."' data-toggle='modal' data-target='#focused-note' name='".$row['noteColor']."'><i id='checkIcon".$row['id']."' class='checkIcon unchecked-icon fa fa-square-o' aria-hidden='true' '></i><div class='card-block'><h3 class='card-title' id='title".$row['id']."'>".$row['title']."</h3><p class='card-text' id='content".$row['id']."'>".$row['content']."</p></div></div>" ;
    }
?>