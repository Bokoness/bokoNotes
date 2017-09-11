<?
    //TODO: Delete Note
    //TODO: when hovering a note - add shadow like google chrome and select icon

    session_start();
    $_SESSION['id'] = $_COOKIE['id'];
    include("../header.php");
?>
<style>
    html, body {
        height: 100%;
        background-color: #E8E8E8;
        font-size: 25px;
    }

    a:link {
        text-decoration: inherit;
        color: inherit;
    }

    a:visited {
        text-decoration: inherit;
        color: inherit;
    }

    .fa-sign-out:hover {
        color: red;
    }

    .cards-table {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-bottom: 200px;
        padding: 50px;
    }

    .card {
        margin: 10px;
        width: 350px;
        height: 500px;
        border-radius: 1px;     
        box-shadow: 5px 5px 15px #B2B2B2;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 25px;
        word-wrap: break-word; 
    }

    /*Check icon */
    .fa-circle-o, .fa-check-circle {
        position: absolute;
        top: 3px;
        right: 3px;
    }

    /* focused-note */

    #focused-note {
        display: flex;
    }

    .modal-header {
        padding: 0;
    }

    .modal-body {
        padding: 0;
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
        height: 90%;
        font-size: 25px;   
        opacity: 0.6;
        resize: none;
    }

    .fa-trash-o {
        font-size: 30px;
    }

    .fa-trash-o:hover {
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

    i {
        margin-left: 15px;
        cursor: pointer;
    }
</style>

<body>
    <? include("mainHeader.php"); ?>
    <? include("addNote.php") ?>

    <div class="modal" id="focused-note" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

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
    
</body>

<? include("../footer.php"); ?>

<script>var userId = <?php echo $_SESSION['id']; ?>;</script>
<script src="notesTable.js"></script>
