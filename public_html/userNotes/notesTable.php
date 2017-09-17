<?
	//TODO: When clicking 'Ness Bokobza' on bottom - contact me icons appare (such as - facebook, twitter, email, etc..)
    //TODO: user can uploads photos to note
    session_start();
    $_SESSION['id'] = $_COOKIE['id'];
    include("../header.php");
?>

<style>
    html, body {
        height: 100%;
        background-color: #E8E8E8;
        font-size: 15px;
    }

    a:link {
        text-decoration: inherit;
        color: inherit;
    }

    a:visited {
        text-decoration: inherit;
        color: inherit;
    }

    .fa {
        cursor: pointer;
    }

    .fa-sign-out:hover {
        color: red;
    }

    .cards-table {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 200px;
        padding: 3% 100px 100px 100px;
    }

    .card {
        margin: 20px;
        width: 250px;
        height: 350px;
        border-radius: 1px;     
        box-shadow: 5px 5px 15px #B2B2B2;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 25px;
        word-wrap: break-word; 
        z-index: 1;
    }

    .hoveredNote {
      	box-shadow: -12px 0 25px grey, 0 12px 25px grey, 12px 0 25px grey, 0 -12px 25px grey;
    }

    .chosenNote {
        border: 5px solid #1d1d1d;
    }

    /*Check icon */
    .unchecked-icon {
        position: absolute;
        top: 1px;
        right: 3px;
        font-size: 30px;
        z-index: 1;
        display: none; 
    }

    /* focused-note */

    #focused-note {
        display: flex;
    }

    .modal-header {
        padding: 0;
    }

    .modal-body {
        padding: 20px;
    }

    #focused-note-content, #focused-note-title {
        border: 0;
        border: none;
    }

    #focused-note-title {
        width: 498px;
        text-align: center;
        border-radius: 5px 5px 0px 0px;
        padding: 5px;
    }

    #focused-note-content {
        width: 100%; 
        height: 70%;
        font-size: 25px;   
        opacity: 0.6;
        resize: none;
    }

    #removeIcon {
        font-size: 30px;
    }

    #removeIcon:hover {
        color: red;
    }

    #colors-table {
        position: relative;
        margin-right: 17%;
        float: left;
    }

    .color{
        border: 1px solid grey;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin: 2px;
        cursor: pointer;
        float: left;
    }
    /* Card colors */
    .orange {
        background-color: #F0AD4E;
    }
    .white {
        background-color: #FAFAFA;  
    }
    .green {
        background-color: #99cc00;
    }
    .yellow {
        background-color: #dcc66b;
    }
    .pink {
        background-color: #dd8c88;
    }
    .blue {
        background-color: #596fb7;
    }
    .purple {
        background-color: #8672c2;
    }

    .fast-animation {
        -moz-animation-duration: 0.5s;
        -webkit-animation-duration: 0.5s;
    }

</style>

<body>
    <? include("mainHeader.php"); ?>
    <? include("addNote.php") ?>

    <div class="modal animated zoomin fast-animation" id="focused-note" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><input id="focused-note-title" type="text"></h5>
                    </button>
                </div>

                <div class="modal-body">
                    <textarea class="form-control" rows="5" id="focused-note-content"></textarea>
                </div>

                <div class="modal-footer">
                    <div id="colors-table">
                        <div class="color focused-note-color orange" id="orange"></div>
                        <div class="color focused-note-color white" id="white"></div>
                        <div class="color focused-note-color green" id="green"></div>
                        <div class="color focused-note-color yellow" id="yellow"></div>
                        <div class="color focused-note-color pink" id="pink"></div>
                        <div class="color focused-note-color blue" id="blue"></div>
                        <div class="color focused-note-color purple" id="purple"></div> 
                    </div>
                    <i class="fa fa-trash-o" id="removeIcon" aria-hidden="true" data-dismiss="modal"></i> 
                </div>

            </div>
        </div>
    </div>

    <div class="cards-table"></div> 

    <? include("iconsContainer.php") ?>
    <? include("mainFooter.php") ?>
    
</body>

<? include("../footer.php"); ?>

<script>
$("#icons-container").hide();
var userId = <?php echo $_SESSION['id']; ?>;
var chosenNotes = [];
id = 0, title = "", content = "",chosenColorName = "white", chosenColorVal = getColor(chosenColorName);

$(document).ready(function() { 

    loadNotes();

    $('#focused-note').hide().on('hide', function() { 
        $('#focused-note').modal('hide') 
    });

    $("body").on('mouseenter', '.note', function() {
        $(this).addClass('hoveredNote');
        id = $(this).attr('id').slice(4, $(this).attr('id').length);
        $("#checkIcon" + id).show();
    })

    $("body").on('mouseleave', '.note', function() {
        if(!$("#note" + id + " i").hasClass('fa-check-square-o')) 
            $("#checkIcon" + id).hide();
        $(this).removeClass('hoveredNote');
    })

    //-------- Bootstrap modal - when openning a note --------//

    //When user clicks a note
    $("body").on('click', '.note', function(event) {
        id = $(this).attr('id').slice(4, $(this).attr('id').length);
        title = $("#title" + id).text();
        content = $("#content" + id).text();
        chosenColorName = $(this).attr('name');
        chosenColorVal = getColor(chosenColorName);

        $("#note" + id).css('visibility', 'hidden');
        $(".modal-body").addClass(chosenColorName);

        focusedNote(id, title, content, chosenColorName, chosenColorVal);
    });           

    //when user deletes note
    $("#removeIcon").click(function() {
        deleteFromDB(id);
    })

    //when user change the note's color
    $('.focused-note-color').click(function() {
        //removing current color           
        $(".modal-body").removeClass(chosenColorName);
        $("#focused-note-content").removeClass(chosenColorName);
        $("#note" + id).removeClass(chosenColorName);
        //picking up the next color
        chosenColorName = $(this).attr('id');

        //updating note's color
        $("#note" + id).addClass(chosenColorName);
        $("#note" + id).attr('name', chosenColorName);
        //updating modal color
        $('.modal-body').addClass(chosenColorName);
        $("#focused-note textarea").addClass(chosenColorName);
    })

    //when closing modal (focused-note)
    $("#focused-note").on('hidden.bs.modal', function (e) {
        $(".modal-body").removeClass(chosenColorName);
        $("#focused-note-content").removeClass(chosenColorName);
        $("#note" + id).css('visibility', 'visible');
        unfocusedNote();
    })
})

// ---------------- functions ----------------//

const loadNotes = () => {
    
    $("#refreshNotes").addClass('fa-spin');

    $(".cards-table").load("getNotes.php?id=" + userId);

    $('.cards-table').one('webkitAnimationEnd mozAnimationEnd animationend', function() {
        $("#refreshNotes").fadeOut('fast');
        setTimeout(function() {
            $("#refreshNotes").removeClass('fa-spin');
            $("#refreshNotes").fadeIn('fast');
        }, 200);
    });
}

//updating DB
const updateDB = (newNote, id, title, content, chosenColorName) => {
    $.ajax({
        method: "POST",
        url: "updateDB.php",
        data: { 
            id: id,
            title: title,
            content: content,
            chosenColor: chosenColorName
        }
    });
}

const deleteFromDB = (id) => {
    $("#note" + id).removeClass('fast-animation flip');
    $("#note" + id).addClass('bounceOutUp');
    //when animation ends
    $('#note' + id).one('webkitAnimationEnd mozAnimationEnd animationend', function() {
        $("#note" + id).hide()
    });

    $.ajax({
        method: "POST",
        url: "deleteFromDB.php",
        data: { 
            id: id,
        }
    });
}

const focusedNote = (id, title, content, chosenColorName, chosenColorVal) => {
    //updating modal with note's details
    $("#focused-note input").val(title);
    $("#focused-note textarea").val(content);
}

const unfocusedNote = () => {
    title = $("#focused-note input").val();
    content = $("#focused-note textarea").val();
    $("#note"+id).css('visibility', 'visible');

    updateDB(newNote, id, title, content, chosenColorName);
    
    //updating the notes on the board
    $("#title" + id).html(title);
    $("#content" + id).html(content);    

    title = "";
    content = "";
}
</script>

