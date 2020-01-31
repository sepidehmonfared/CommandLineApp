<?php
/**
 * Sanitize a input string and post it
 * php version 7.4.1
 * 
 * @category LevelUp
 * @package  Sanitizer
 * @author   Sepideh <monfared.sepideh@gmail.com>
 * @license  MIT 
 * @link     https://github.com/sepidehmonfared
 */

require_once 'Filter.php';
require_once 'Event.php';

$input = $argv[1];

$filter = new SpecialCharsFilter(new PlainTextFilter(new XSSFilter(new Input)));
$clean_input  = $filter->filterText($input);
echo $clean_input;die;
try{
    echo Event::create()->post(['body' => $clean_input]);
}catch(Exception $e){
    echo $e->getMessage();
}



