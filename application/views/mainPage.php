<!DOCTYPE html>
<html>
    <head>
        <style>
            .steps {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 2rem;
                position: relative;
            }
            .step-button {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                border: 2px;
                background-color: #95A5A6;
                color: white;
                transition: .4s;
            }
            .step-button[aria-expanded="true"] { 
                width: 60px;
                height: 60px;
                background-color: #3498DB;
                color: white;
            }
            .done {
                background-color: #225440;
                color: white;
            }
            .step-item {
                z-index: 10;
                text-align: center;
            }
            #progress {
            -webkit-appearance:none;
                position: absolute;
                width: 95%;
                z-index: 5;
                height: 10px;
                margin-left: 18px;
                margin-bottom: 18px;
            }
            /* to customize progress bar */
            #progress::-webkit-progress-value {
                background-color: #225440;
                transition: .5s ease;
            }
            #progress::-webkit-progress-bar {
                background-color: #95A5A6;

            }
        </style>

        <!-- Bootstrap 5 JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
        <!-- Stepper JavaScript -->
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fénix</title>

        <?php $this->load->view("loadLibraries/css", $css); ?>

    </head>
    <body <?php
    if (isset($content["bodyClass"])) {
        echo 'class="' . $content["bodyClass"] . '"';
    }
    ?>>

        <div class="container body">

            <div class="main_container">

                <?php
                if ($sideBar["render"])
                    $this->load->view("main/sideBar", $sideBar["data"]);
                ?>
                
                <?php
                if ($header["render"])
                    $this->load->view("main/header", $header["data"]);
                ?>

                <?php
                $this->load->view("main/modules", $content);
                ?>

                <?php
                if ($footer["render"])
                    $this->load->view("main/footer");
                ?>
                
            </div>

        </div>
        
        <?php
        $this->load->view("modal_windows/modalInformation", array(
            "idPanel"     => "logout",
            "module"      => "login",
            "title"       => "Cerrar Sesión",
            "classCss"    => "modal-content-alert",
            "classSec"    => "modal-body-alert",
            "tpl"         => "modals/logout",
            "enableClose" => TRUE,
            "showModal"   => FALSE
        ));
        
        $this->load->view("loadLibraries/js", $js);
        ?>
    </body>
</html>
