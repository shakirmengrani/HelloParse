<?php
 error_reporting(0);
require './vendor/autoload.php';

use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;

$app_id = "QKMQ9NZElGL5P44CIITG5xRProExriy2mkoXGD8l";
$rest_key = "rAdhoMDa5NU7gF20Jvg5mcp5uEK6DOGfgBrtmoZX";
$master_key = "MYufHyS6aQFkoqQNwCMUNmm2qChrK3fVSlOvV9H1";
ParseClient::initialize($app_id, $rest_key, $master_key);


if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['Reg_Form'] == true) {
    try {
        $testObject = ParseObject::create("AuthObject");
        $testObject->set("username", $_POST['txt_user']);
        $testObject->set("Password", md5($_POST['txt_pwd']));
        $testObject->set("Password", md5($_POST['txt_email']));
        $testObject->save();
        echo "Saved !";
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['log_Form'] == true) {
    $query = new ParseQuery("AuthObject");
    $query->equalTo("username", "shakirmengrani");
    $data = $query->find();
    for($i =0; $i < count($data);$i++){
        echo $data->get("username");
    }
    echo $data->get("username");
}
?>
<html>
    <head>
        <title>Hello Parse</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">            
            <fieldset>
                <legend>Login Form</legend>
                <form method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" name="txt_user" class="form-control" placeholder="username" value="" />
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="password" name="txt_pwd" class="form-control" placeholder="password" value="" />
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12" style="text-align: right">
                            <input type="submit" class="btn btn-primary" value="Sign in" />
                        </div>
                    </div>
                    <input type="hidden" name="log_Form" value="true" />
                </form>
            </fieldset>

            <fieldset>
                <legend>Registration Form</legend>
                <form method="post">
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" name="txt_user" class="form-control" placeholder="username" value="" />
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="password" name="txt_pwd" class="form-control" placeholder="password" value="" />
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="email" name="txt_email" class="form-control" placeholder="email address" value="" />
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-lg-12" style="text-align: right">
                            <input type="submit" class="btn btn-primary" value="Sign up" />
                        </div>
                    </div>
                    <input type="hidden" name="Reg_Form" value="true" />
                </form>
            </fieldset>
        </div>


    </body>
</html>