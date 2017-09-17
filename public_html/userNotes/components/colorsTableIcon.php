<style>
    #colorsTableIcon {
        position: absolute;
        display: flex;
        display: none;
        flex-direction: column;
        left: 110%;
        border: 5px solid #2A2C2D;
        border-radius: 15px;
        padding: 5px;
    }

    .fixed-color-icon-button {
        border: 1px solid grey;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        margin: 2px;
        cursor: pointer;
        float: left;
    }

    .fixed-color-icon-button:hover {
        border: 2px solid #2A2C2D;
    }

</style>

<span id="fixed-color-icon" class="fixed-icon fa-stack fa-lg animated bounceInDown">
    <i class="fixed-icon-circle fa fa-circle-o fa-stack-2x"></i>
    <i class="fixed-icon-icon fa fa-paint-brush fa-stack-1x" aria-hidden="true"></i>
</span>

<div id="colorsTableIcon" class="animated fadeInLeft fast-animation">
    <div class="fixed-color-icon-button orange" id="orange"></div>
    <div class="fixed-color-icon-button white" id="white"></div>
    <div class="fixed-color-icon-button green" id="green"></div>
    <div class="fixed-color-icon-button yellow" id="yellow"></div>
    <div class="fixed-color-icon-button pink" id="pink"></div>
    <div class="fixed-color-icon-button blue" id="blue"></div>
    <div class="fixed-color-icon-button purple" id="purple"></div> 
</div>

<script>
$(document).ready(function() {

    //fixed-color-icon - click
    $("#fixed-color-icon").click(function() {

        if( $('#colorsTableIcon').is(":visible") ) {
            $("#colorsTableIcon").addClass('fadeOutLeft'); 
            $("#colorsTableIcon").fadeOut();
        }
        else {
            $("#colorsTableIcon").removeClass('fadeOutLeft'); 
            $("#colorsTableIcon").show(); 
        }
            
    })

    $(".fixed-color-icon-button").click(function() {
        changeNotesColor(chosenNotes, $(this).attr('id'));
    })

     // ---------------- functions ----------------//

    const updateDBColor = (id, newColor) => {
        $.ajax({
            method: "POST",
            url: "updateDB.php",
            data: { 
                id: id,
                chosenColor: newColor
            }
        });
    }

    const changeNotesColor = (notes, newColor) => {
        for(let i = 0; i < notes.length; i++) {
            note = "#note" + notes[i];
            oldColor = $(note).attr('name');
            $(note).removeClass(oldColor);
            $(note).addClass(newColor);
            $(note).attr('name', newColor);
            updateDBColor(notes[i], newColor);
        }
    }

})
</script>