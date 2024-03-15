<?php
#require $_SERVER['DOCUMENT_ROOT']."Datenbank";
    $db = new mysqli('localhost', 'root', '', 'uni');
    return $db;
?>