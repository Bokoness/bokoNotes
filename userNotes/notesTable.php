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
        border: 5px solid #B2B2B2;
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

    #fixed-remove-icon {
        position: fixed;
        left: 25px;
        bottom: 48%;
        z-index: 2;
        font-size: 30px;
    }

    .fast-animation {
        -moz-animation-duration: 0.5s;
        -webkit-animation-duration: 0.5s;
    }

    #me {
        background-color: #F5B400;
        color: #030303;
        box-shadow: 5px 5px 15px #B2B2B2;
        border-top: 1px solid #B2B2B2;
        width: 100%;
        position: fixed;
        z-index: 1000;
        bottom: 0;
        left: 0;
        padding-left:10px;
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

    <span id="fixed-remove-icon" class="fa-stack fa-lg animated bounceInDown">
        <i id="fixed-remove-icon-circle" class="fa fa-circle-o fa-stack-2x"></i>
        <i id='fixed-remove-icon-icon' class="fa fa-trash-o fa-stack-1x" aria-hidden="true"></i>
    </span>

    <div id='me' class='footer'><strong>&copy Made by Ness Bokobza</strong></div>

    
</body>

<? include("../footer.php"); ?>

<script>
var userId = <?php echo $_SESSION['id']; ?>;
var chosenNotes = [];
id = 0, title = "", content = "",chosenColorName = "white", chosenColorVal = getColor(chosenColorName);

$(document).ready(function() { 

    loadNotes();

    $("#fixed-remove-icon").hide();

    $('#focused-note').hide().on('hide', function() { 
        $('#focused-note').modal('hide') 
    });

    $("body").on('mouseenter', '.note', function() {
        $(this).addClass('hoveredNote');
        id = $(this).attr('id').slice(4, $(this).attr('id').length);
        $("#checkIcon" + id).show();
    })

    $("body").on('mouseleave', '.note', function() {
        if(!$("#note" + id + " i").hasClass('fa-check-square-o')) {
            $(this).removeClass('hoveredNote');
            $("#checkIcon" + id).hide();
        }
    })

    //when clicking on check icon
    $("body").on('click', '.checkIcon', function(e) {
        e.stopPropagation();
        id = $(this).parent().attr('id').slice(4, $(this).attr('id').length);

        //if check icon was unchecked
        if($(this).hasClass('fa-square-o')) {
            $(this).removeClass('fa-square-o ');
            $(this).addClass('fa-check-square-o');

            $(this).parent().css('z-index', chosenNotes.length + 2); //chosen Note is alwasy on top for the annimation
            $(this).parent().removeClass('bounceInDown');
            $(this).parent().addClass('chosenNote fast-animation flip');
            chosenNotes.push(id);
            toggleRemoveIcon(chosenNotes);
        }

        else {
            $(this).removeClass('fa-check-square-o');
            $(this).addClass('fa-square-o');
            $(this).parent().removeClass('chosenNote fast-animation flip');
            $(this).parent().css('z-index', '1');
            chosenNotes = removeFromChosnNotes(chosenNotes.indexOf(id));
            toggleRemoveIcon(chosenNotes);
        }
    })

    //fixed-remove-icon - mouse enter
    $("#fixed-remove-icon").mouseenter(function() {
        $('#fixed-remove-icon-circle').removeClass('fa-circle-o');
        $('#fixed-remove-icon-circle').addClass('fa-circle');
        $('#fixed-remove-icon-icon').addClass('fa-inverse');
    })

    //fixed-remove-icon - mouse leave
    $("#fixed-remove-icon").mouseleave(function() {
        $('#fixed-remove-icon-circle').removeClass('fa-circle');
        $('#fixed-remove-icon-circle').addClass('fa-circle-o');
        $('#fixed-remove-icon-icon').removeClass('fa-inverse');
    })

    //fixed-remove-icon - click
    $("#fixed-remove-icon").click(function() {
        for(let i = 0; i < chosenNotes.length; i++) {
            deleteFromDB(chosenNotes[i]);
        }
        chosenNotes = [];
        toggleRemoveIcon(chosenNotes);
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
        chosenColorVal = getColor(chosenColorName);
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

const removeFromChosnNotes = (val) => {
    let firstHalf, secondHalf;
    firstHalf = chosenNotes.slice(0, val);
    secondHalf = chosenNotes.slice(val + 1, chosenNotes.length);
    return firstHalf.concat(secondHalf);  
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

const toggleRemoveIcon = (notes) => {

    if(notes.length > 0) 
        $('#fixed-remove-icon').show();

    else 
        $('#fixed-remove-icon').hide();
    
}
</script>

