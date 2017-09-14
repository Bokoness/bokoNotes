<?
    include('../link.php');
    
    if(array_key_exists('userId', $_POST)) {
        $query = "INSERT INTO `notes` (userId, title, content, noteColor)
        VALUES ('".mysqli_real_escape_string($link, $_POST['userId'])."' , '".mysqli_real_escape_string($link, $_POST['title'])."' , '".mysqli_real_escape_string($link, $_POST['content'])."' , '".mysqli_real_escape_string($link, $_POST['chosenColor'])."' )";           
        mysqli_query($link, $query);
    }

    //getting the last id
    $lastId = array();
    $i = 0;
    $query = "SELECT * FROM `notes`";   
    $result = mysqli_query($link, $query);
    while($row = mysqli_fetch_array($result)){
        $lastId[$i] = $row['id'];
    } 

    echo $lastId[$i];
   
?>