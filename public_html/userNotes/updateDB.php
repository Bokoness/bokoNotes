<?php
    include('../link.php');
    print_r($_POST);
    if(array_key_exists('delete', $_POST)) {
        
        $query = "DELETE FROM `notes` WHERE id ='".mysqli_real_escape_string($link, $_POST['id'])."'";
    }

    else {

        //updating the note's title
        if(array_key_exists('title', $_POST)) {
            $query = "UPDATE `notes` SET `title` = '".mysqli_real_escape_string($link, $_POST['title'])."' WHERE id ='".mysqli_real_escape_string($link, $_POST['id'])."' LIMIT 1";
            mysqli_query($link, $query);
        }

        //updating the note's content
        if(array_key_exists('content', $_POST)) {
            $query = "UPDATE `notes` SET `content` = '".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id ='".mysqli_real_escape_string($link, $_POST['id'])."' LIMIT 1";
            mysqli_query($link, $query);
        }

        //updating the note's color
        if(array_key_exists('chosenColor', $_POST)) {
            $query = "UPDATE `notes` SET `noteColor` = '".mysqli_real_escape_string($link, $_POST['chosenColor'])."' WHERE id ='".mysqli_real_escape_string($link, $_POST['id'])."' LIMIT 1";
            mysqli_query($link, $query);
        }
    }
?>
