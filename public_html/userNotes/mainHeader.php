<style>
    .mainHeader {
        width: 100%;
        height: 60px;
        background-color: #F5B400;
        border-bottom: 1px solid #B2B2B2;
        box-shadow: 5px 5px 15px #B2B2B2;
        padding: 15px;
        position: fixed;
        z-index: 1000;
        top: 0;
        color: #414141;
    }

    .mainHeader .fa:hover {
        color: #030303;
        font-size: 35px;
    }
    
    .fa-sticky-note-o {
        float: left;
    }

    .display-5 {
        float: left;
        margin-left: 30px;
    }

    .fa-sign-out ,#refreshNotes {
        margin-right: 30px;
        float: right;
    }
</style>
<? include("../footer.php") ?>

<div class="mainHeader animated bounceInLeft">
    <i class="fa fa-sticky-note-o fa-2x" aria-hidden="true"></i>
    <h3 class="display-5 ">BokoNotes</h3>

    <a href="../index.php?logout='1'"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
    <i id="refreshNotes" class="fa fa-refresh fa-2x fa-fw"></i>
</div>

<script>
    $("#refreshNotes").click(function() {
        chosenNotes = [];
        toggleIconsContainer(chosenNotes);
        loadNotes();    
    })
</script>





