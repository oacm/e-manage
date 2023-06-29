<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function getMailManageMail(){
    return array(
        "user_id"        => "soporte@fenixenergia.com.mx",
        "process_folder" => "AAMkADAxZDI1NGQ0LTZiM2YtNDg4NS04MTA2LTc4ZDJkNDBhMDE5ZgAuAAAAAAC4dXtTH6aGS48SKkh7CrgHAQCMolyLKdTbRa7eEf4Rj3vvAABUfDAMAAA=",
        "inbox_folder"   => "AQMkADAxZDI1NGQ0LTZiM2YtNDg4ADUtODEwNi03OGQyZDQwYTAxOWYALgAAA7h1e1MfpoZLjxIqSHsKuAcBAIyiXIsp1NtFrt4R-hGPe_8AAAIBDAAAAA=="
    );
}

//function getMailManageMail(){
//    return array(
//        "user_id" => "manage.mail@fenixenergia.com.mx",
//        "process_folder" => "AQMkADQ5MmQ2OTRkLTI1ZmUtNDk1Zi05NDk0LWUwNTk0Y2Y1ZDNmNwAuAAADwcLW056bPkWZsVxWNhyi0gEAAADKjKmgpjNPuZpHGn6jpK4AAAIBWAAAAA==",
//        "inbox_folder" => "AQMkADQ5MmQ2OTRkLTI1ZmUtNDk1Zi05NDk0LWUwNTk0Y2Y1ZDNmNwAuAAADwcLW056bPkWZsVxWNhyi0gEAAADKjKmgpjNPuZpHGn6jpK4AAAIBDAAAAA=="
//    );
//}

function getConfigVars365(){
    
    $o365Config     = array(
        "clientId"     => "b4faf5dd-a5cc-4eb8-a004-13e267264cdf",
        "clientSecret" => "7Sm77X5kCTJk397zOzREkia",
        "tenant"       => "c3360e7a-6fcc-4f04-b461-db479f5aa83c"
    );

    $o365Urls       = array(
        "session"      => "https://login.microsoftonline.com",
        "token"        => "/%1s/oauth2/v2.0/token",
        "adminconsent" => '/common/adminconsent?client_id=%1$s&state=12345&redirect_uri=%2$s',
        "graphApi"     => "https://graph.microsoft.com/v1.0",
        "redirect"     => "module/manage_email/o365ctr/o365Manage"
    );

    $headersDefault = array(
        "Accept: application/json"
    );
    
    return array(
        "o365Config"     => $o365Config,
        "o365Urls"       => $o365Urls,
        "headersDefault" => $headersDefault
    );
}