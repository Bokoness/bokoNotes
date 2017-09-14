$(document).ready(function() { 

    $('#focused-note').hide().on('hide', function() { 
        $('#focused-note').modal('hide') 
    });

    $(".cards-table").load("getNotes.php?id=" + userId);
    id = 0, title = "", content = "",chosenColorName = "white", chosenColorVal = getColor(chosenColorName);

    //When user clicks a note
    $("body").on('click', '.note', function(event) {
        id = $(this).attr('id').slice(4, $(this).attr('id').length);
        title = $("#title" + id).text();
        content = $("#content" + id).text();
        chosenColorName = $(this).attr('name');
        chosenColorVal = getColor(chosenColorName);

        console.log(id, title, content, chosenColorName);

        $(".modal-body").addClass(chosenColorName);
        //$("#focused-note-content").addClass(chosenColorName);

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
        unfocusedNote();
    })
})

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
    $("#note" + id).fadeOut("linear");
    $.ajax({s
        method: "POST",
        url: "deleteFromDB.php",
        data: { 
            id: id,
        }
    });
}

const focusedNote = (id, title, content, chosenColorName, chosenColorVal) => {
    //updating modal with note's details
    // $("#focused-note input").val(title);
    // $("#focused-note textarea").val(content);
    $("#focusedNote-title").text(title);
    $("#focusedNote-content").text(content);
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