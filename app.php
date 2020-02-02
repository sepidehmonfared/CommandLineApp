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

require_once 'src/Filter.php';
require_once 'src/Event.php';

$input = readline();

$filter = new SpecialCharsFilter(new PlainTextFilter(new XSSFilter(new Input)));
$clean_input  = $filter->filterText($input);

echo "\033[33m Posting String... \n\e[0;34;42m".$clean_input."\e[0m\n";

try{
    echo "\033[33m Response: \n";
    echo "\033[32m".Event::create()->post(['body' => $clean_input]);
}catch(Exception $e){
    echo $e->getMessage();
}

exit;



