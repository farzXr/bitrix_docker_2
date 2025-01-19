<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Page\Asset;

$asset = Asset::getInstance();
$asset->addCss(SITE_TEMPLATE_ID.'styles.css');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>

    <?php $APPLICATION->ShowPanel();
    $APPLICATION->ShowHead();?>
</head>
<body>
<header>
    <h1>Book catalog</h1>
</header>
<main>
