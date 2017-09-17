<style>
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

    #me span {
        cursor: pointer;
    }

    #me span:hover {
        text-decoration: underline;
    }

    #contactMe-icons-container {
        position: fixed;
        display: flex;
        flex-direction: column;
        left: 0;
        bottom: 5%;
        z-index: 2;
        font-size: 20px;
    }

    .fa-envelope-o{
        font-size: 18px;
    }
</style>

<div id='me' class='footer'><span class='animated'><strong>&copy Made by Ness Bokobza</strong></span></div>

<div id="contactMe-icons-container" class="animated bounceInUp">

        <a target="_blank" href="mailto:bokoness@gmail.com ?Subject=BokoNotes">
            <span id="fixed-uncheck-icon" class="fixed-icon fa-stack fa-lg">
                <i class="fixed-icon-circle fa fa-circle-o fa-stack-2x"></i>
                <i class="fixed-icon-icon fa fa-envelope-o fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>

        <a target="_blank" href="https://www.facebook.com/bokoness">
            <span id="fixed-uncheck-icon" class="fixed-icon fa-stack fa-lg">
                <i class="fixed-icon-circle fa fa-circle-o fa-stack-2x"></i>
                <i class="fixed-icon-icon fa fa-facebook fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>

        <a target="_blank" href="https://www.linkedin.com/in/ness-bokobza-890262136/">
            <span id="fixed-uncheck-icon" class="fixed-icon fa-stack fa-lg">
                <i class="fixed-icon-circle fa fa-circle-o fa-stack-2x"></i>
                <i class="fixed-icon-icon fa fa-linkedin fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>
        
        <a target="_blank" href='https://twitter.com/BokobzaNess'>
            <span id="fixed-remove-icon" class="fixed-icon fa-stack fa-lg">
                <i class="fixed-icon-circle fa fa-circle-o fa-stack-2x"></i>
                <i class="fixed-icon-icon fa fa-twitter fa-stack-1x" aria-hidden="true"></i>
            </span>
        </a>
</div>

<script>
$("#contactMe-icons-container").hide();

$(document).ready(function(){

    $("#me span").click(function() {
        if( $("#contactMe-icons-container").is(":visible") ) {
            $("#contactMe-icons-container").fadeOut();
        }
        else {
            $("#contactMe-icons-container").show();
        }
    })  

    $("#me span").mouseenter(function() {
        $("#me span").addClass('flip');
    })  
})
</script>
