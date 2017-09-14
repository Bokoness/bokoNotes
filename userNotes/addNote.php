<!-- TODO: add colors table to new note -->
<style>
  	#newNote {
        width: 40%;
        padding: 6px;
        margin: 0 auto;
        margin-top: 8%;
        background-color: #FAFAFA;
        text-align: center;
        border: 1px solid #E4E4E4;
        border-radius: 5px;     
        box-shadow: 5px 5px 15px #B2B2B2;
    }
    #newNoteContent , #newNoteTitle {
        background-color:#FAFAFA;
        width: 100%;
        border: 0;
        border: none;
        font-size: 25px;
    }
    #newNoteContent , #newNoteTitle:hover {
        border: 0;
        border: none;
    }
  
    #newNoteContent {
        display: none;
        height: 300px;
    }

    #newNoteTitle {
        width: 100%;
        height: 50px;
        border-radius: 5px;  
        padding-left: 20px;
    }
  
  	#note-color-table {
        bottom: 48px;
        right: 30px;
        width: 200px;
        height: 40px;
      	margin: 0 auto;
        display: flex;
  	}
  
</style>
<div id="newNote" class="animated bounceInRight">
    <h5><input id="newNoteTitle" type="text" placeholder="Add new note..."></h5>
    <textarea class="form-control" rows="5" id="newNoteContent"></textarea>
    <footer id="note-color-table">
        <div class="color new-note-color orange" id="orange"></div>
        <div class="color new-note-color white" id="white"></div>
        <div class="color new-note-color green" id="green"></div>
        <div class="color new-note-color yellow" id="yellow"></div>
        <div class="color new-note-color pink" id="pink"></div>
        <div class="color new-note-color blue" id="blue"></div>
        <div class="color new-note-color purple" id="purple"></div>   
    </footer>
</div>

<? include("../footer.php") ?>
<script>
    $(document).ready(function(){
        var chosenColorName;
        var chosenColorVal;
      	$("#note-color-table").hide();
        
        //when clicking the new note element
        $("#newNote").click(function(){
            event.stopPropagation();
            $("#newNoteContent").show();
          	$("#note-color-table").show();
        })

        //when choosing new note's color
        $(".new-note-color").click(function() {
            chosenColorName = $(this).attr('id');
            chosenColorVal = getColor(chosenColorName);
            $("#newNote").css("background-color", chosenColorVal);
            $("#newNote textarea").css("background-color", chosenColorVal);
        })

        //when clicking outside of newNote
        $(window).click(function() {
            //restoring addNote element's colors to white
            $("#newNote").css("background-color", getColor("white"));
            $("#newNote input").css("background-color", getColor("white"));
            $("#newNote textarea").css("background-color", getColor("white"));

            var id;
            if($("#newNoteTitle").css('display') != 'none') {
                $("#newNoteContent").hide();
                $("#note-color-table").hide();
              
                var userId = <?php echo $_SESSION['id']; ?>;
                title = $("#newNoteTitle").val();
                content = $("#newNoteContent").val();
               
            
     
                //if newNote isn't empty
                if(title != '' || content != '') {
                    
                    //creating new note in DB
                    $.ajax({
                        method: "POST",
                        url: "addToDB.php",
                        data: { 
                            userId: userId,
                            title: title,
                            content: content,
                            chosenColor: chosenColorName
                        }
                    });

                    //gets lass note id
                    $.get("addToDB.php", function (data) {
                        id = data;
                        $(".cards-table").append("<div id='note" + id + "' class='note card animated bounceInDown " + chosenColorName +"' data-toggle='modal' data-target='#focused-note' name='" + chosenColorName +"'><i id='checkIcon" + id + "' class='checkIcon unchecked-icon fa fa-square-o' aria-hidden='true' '></i><div class='card-block'><h3 class='card-title' id='title" + id + "'>" + title + "</h3><p class='card-text' id='content" + id +"'>" + content +"</p></div></div>");  
                    })                           
                }

                $("#newNoteTitle").val('');
                $("#newNoteContent").val('');
            }
        });
    })

    function getColor(color) {
        let bgcolor;
        switch(color) {
            case "orange": bgcolor =  "#F0AD4E";
            break;
            case "white": bgcolor =  "#FAFAFA";
            break;
            case "green": bgcolor =  "#99cc00";
            break;
            case "yellow": bgcolor =  "#dcc66b";
            break;
            case "pink": bgcolor =  "#dd8c88";
            break;
            case "blue": bgcolor =  "#596fb7";
            break;
            case "purple": bgcolor =  "#8672c2";
            break;
        }
        return bgcolor;
    }
</script> 