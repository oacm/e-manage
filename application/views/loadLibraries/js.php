<script>
    var branch = "DESARROLLO";
            
    switch (branch) {
        case "DESARROLLO":
            var __urlRoot    = location.origin + "/e-manage/index.php/";
            var __urlRootImg = location.origin + "/e-manage/";
            break;

        default:
            var __urlRoot    = location.origin + "/";
            var __urlRootImg = location.origin + "/";
            break;
    }
</script>
<?php
foreach ($dependences as $value) {
    
    if (preg_match("/https/", $value)) {
        ?>
        <script src="<?php echo $value ?>"></script>
        <?php
    } else {
        ?>
        <script src="<?php echo base_url() . $value ?>"></script>
        <?php
    }
}

?>

<script>
    $(document).ready(function(){
        
        if(typeof ModalObj != "undefined"){
        
            var modalClose = new ModalObj("modal-win-info-logout");
            modalClose.init();
            modalClose.jQueryObj.find("button[type='button']").click(function(){
                var logOutAjax = {
                    url        : "session/loginctr/logout",
                    success    : function(data){

                        if(data.error){
                            $("#modal-win-alert .modal-header").addClass("modal-header-alert");
                            $("#modal-win-alert .modal-header h2").html("Error");
                            $("#modal-win-alert .close").html("<i class='fa fa-exclamation-circle'></i>");
                            $("#modal-win-alert .modal-body").html("<p>¡Ocurrio un error, comunicate con el administrador!</p>");
                            setTimeout(function(){
                                $("#modal-win-alert").css("display", "none");
                                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                            }, 1000);
                            return;
                        }
                        location.reload();
                    }
                };

                var configAjax = ajaxJquery(logOutAjax.url, {}, logOutAjax, "POST");
                $.ajax(configAjax);
            });        
            $("#log-out").find("a").click(function(){
                modalClose.showModal();
            });
        
        }
        
    });
    
</script>