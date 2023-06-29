<?php

if($module == "")
    $view = "$view";
else
    $view = "$module/$view";

$this->load->view($view, $data);