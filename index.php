<?php
require './vendor/autoload.php';


use Parse\ParseObject; 
use Parse\ParseClient;
 $app_id = "QKMQ9NZElGL5P44CIITG5xRProExriy2mkoXGD8l";
 $rest_key = "rAdhoMDa5NU7gF20Jvg5mcp5uEK6DOGfgBrtmoZX";
 $master_key = "MYufHyS6aQFkoqQNwCMUNmm2qChrK3fVSlOvV9H1";
ParseClient::initialize($app_id, $rest_key, $master_key);


 
$testObject = ParseObject::create("TestObject");
$testObject->set("foo", "bar");
$testObject->save();