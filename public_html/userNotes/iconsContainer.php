<style>
    #icons-container {
        position: fixed;
        display: flex;
        flex-direction: column;
        left: 0;
        top: 10%;
        z-index: 2;
        font-size: 20px;
    }
</style>

<div id="icons-container">
        <span id="fixed-uncheck-icon" class="fixed-icon fa-stack fa-lg animated bounceInDown">
            <i class="fixed-icon-circle fa fa-circle-o fa-stack-2x"></i>
            <i class="fixed-icon-icon fa fa-thumbs-o-up fa-stack-1x" aria-hidden="true"></i>
        </span>

        <? include("components/colorsTableIcon.php"); ?>

        <span id="fixed-remove-icon" class="fixed-icon fa-stack fa-lg animated bounceInDown">
            <i class="fixed-icon-circle fa fa-circle-o fa-stack-2x"></i>
            <i class="fixed-icon-icon fa fa-trash-o fa-stack-1x" aria-hidden="true"></i>
        </span>
</div>

<script>
$(document).ready(function() {

    //$("#icons-container").hide();

    //when clicking on check icon
    $("body").on('click', '.checkIcon', function(e) {
        e.stopPropagation();
        id = $(this).parent().attr('id').slice(4, $(this).attr('id').length);
        handleNoteCheck(id);
    })

    //fixed-remove-icon - mouse enter
    $(".fixed-icon").mouseenter(function() {
        $('.fixed-icon-circle', this).addClass('fa-circle');
        $('.fixed-icon-icon', this).addClass('fa-inverse');
    })

    //fixed-remove-icon - mouse leave
    $(".fixed-icon").mouseleave(function() {
        $('.fixed-icon-circle', this).removeClass('fa-circle');
        $('.fixed-icon-icon', this).removeClass('fa-inverse');
    })

    //fixed-remove-icon - click
    $("#fixed-remove-icon").click(function() {
        for(let i = 0; i < chosenNotes.length; i++) {
            deleteFromDB(chosenNotes[i]);
        }
        chosenNotes = [];
        toggleIconsContainer(chosenNotes);
    })

    //fixed-uncheck-icon - click
    $("#fixed-uncheck-icon").click(function() {
        let length = chosenNotes.length;
        while(chosenNotes.length > 0){
            $("#checkIcon" + chosenNotes[0]).hide();
            handleNoteCheck(chosenNotes[0]);
        }
    })

})

   // ---------------- functions ----------------//

const handleNoteCheck = (id) => {
    if( $("#note" + id + " i").hasClass('fa-square-o')) {
        $("#note" + id + " i").removeClass('fa-square-o');
        $("#note" + id + " i").addClass('fa-check-square-o');

        $("#note" + id).css('z-index', chosenNotes.length + 2); //chosen Note is alwasy on top for the annimation
        $("#note" + id).removeClass('bounceInDown');
        $("#note" + id).addClass('chosenNote fast-animation flip');
        chosenNotes.push(id);
        toggleIconsContainer(chosenNotes);
    }
    else {
        $("#note" + id + " i").removeClass('fa-check-square-o');
        $("#note" + id + " i").addClass('fa-square-o');
        $("#note" + id).removeClass('chosenNote fast-animation flip hoveredNote');
        $("#note" + id).css('z-index', '1');
        chosenNotes = removeFromChosnNotes(chosenNotes.indexOf(id));
        toggleIconsContainer(chosenNotes);
    }
} 

const removeFromChosnNotes = (val) => {
    let firstHalf, secondHalf;
    firstHalf = chosenNotes.slice(0, val);
    secondHalf = chosenNotes.slice(val + 1, chosenNotes.length);
    return firstHalf.concat(secondHalf);  
}

const toggleIconsContainer = (notes) => {

    if(notes.length > 0) 
        $('#icons-container').show();

    else {
        $('#icons-container').fadeOut('fast');
        $("#colorsTableIcon").fadeOut('fast');
    }
        
    
}
</script>
