<?php
session_start();
ob_start();

define('G9C8O7N6N5T4I', true);

require './vendor/autoload.php';
$home = new Core\ConfigController();
$home->loadPage();
