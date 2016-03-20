<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 20/03/16
 * Time: 2:03 PM
 */

use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;

require __DIR__.'/vendor/autoload.php';

//$driver = new GoutteDriver();
$driver = new Selenium2Driver();

$session = new Session($driver);
//required for selenium
$session->start();

$session->visit('https://en.wikipedia.org/wiki/Main_Page');

var_dump($session->getCurrentUrl());

//Doc Element
$page = $session->getPage();

//var_dump(substr($page->getText(), 0 , 75));

//Node Element
$header = $page->find('css', '#p-interaction .body');

var_dump($header->getHtml());

$find = $header->find('css', 'ul li a');

//will grab the text from the first instance
var_dump($find->getText());

//get the href of the link by looking for the links text
$linkEl = $page->findLink('Help');
var_dump($linkEl->getAttribute('href'));

//click the link
$linkEl->click();

var_dump($session->getCurrentUrl());

$session->stop();

