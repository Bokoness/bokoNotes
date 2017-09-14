<?
    include('../link.php');
    
    if(array_key_exists('id', $_POST)) {
        $query = "DELETE FROM `notes`
        WHERE id ='".mysqli_real_escape_string($link, $_POST['id'])."' ";
        mysqli_query($link, $query);
    }
 
?>