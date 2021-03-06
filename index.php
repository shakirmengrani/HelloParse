<?php
error_reporting(0);
session_start();
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
        $query = new ParseQuery("AuthObject");
        $query->equalTo("username", $_POST['txt_user']);
        $data = $query->find();
        if (count($data) > 0) {
            $err = "<h3>Already registered !</h3>";
        } else {
            $testObject = ParseObject::create("AuthObject");
            $testObject->set("username", $_POST['txt_user']);
            $testObject->set("Password", md5($_POST['txt_pwd']));
            $testObject->set("emailaddress", $_POST['txt_email']);
            $testObject->save();
            $err = "<h3>Sign up successfully !</h3>";
        }
    } catch (Exception $ex) {
        $err = $ex->getMessage();
    }
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['log_Form'] == true) {
    try {
        $query = new ParseQuery("AuthObject");
        $query->equalTo("username", $_POST['txt_user']);
        $data = $query->find();
        for ($i = 0; $i < count($data); $i++) {
            $obj = $data[$i];
            $_SESSION['username'] = $_POST['txt_user'];
            $err = "<h3>" . ( $obj->get("Password") == md5($_POST['txt_pwd']) ? "Welcome from Parse.com Api" : "In-valid authentication !") . "</h3>";
        }
    } catch (Exception $ex) {
        $err = $ex->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['txt_class'])) {
    $new = true;
    try {
        $query = new ParseQuery("YogaObject");
        $query->equalTo("username", $_SESSION['username']);
        $data = $query->find();
        if (count($data) > 0) {
            for ($i = 0; $i < count($data); $i++) {
                $obj = $data[$i];
                if ($obj->get("classname") == $_POST['txt_class']) {
                    $new = false;
                    $err = "<h3>Class already created !</h3>";
                }
            }
        }
        if ($new) {
            $testObject = ParseObject::create("YogaObject");
            $testObject->set("username", $_SESSION['username']);
            $testObject->set("classname", $_POST['txt_class']);
            $testObject->set("colA", $_POST['txt_col1']);
            $testObject->set("colB", $_POST['txt_col2']);
            $testObject->set("colC", $_POST['txt_col3']);
            $testObject->set("colD", $_POST['txt_col4']);
            $testObject->save();
            $err = "<h3>Created successfully !</h3>";
        }
    } catch (Exception $ex) {
        $err = $ex->getMessage();
    }
}

if (isset($_SESSION['username'])) {
    try {
        $query = new ParseQuery("YogaObject");
        $query->equalTo("username", $_SESSION['username']);
        $list = $query->find();
    } catch (Exception $ex) {
        $err = $ex->getMessage();
    }
}
if (isset($_GET['logout'])) {
    $_SESSION['username'] = null;
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
            <div class="row">
                <div class="col-lg-12">
                    <?php echo isset($err) ? "<div class=\"alert alert-info\">" . $err . "</div>" : "" ?>
                </div>
            </div>
            <?php if (!isset($_SESSION['username'])): ?>
                <fieldset>
                    <legend>Login Form</legend>
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" name="txt_user" class="form-control" placeholder="username" value="" required />
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="password" name="txt_pwd" class="form-control" placeholder="password" value="" required />
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
                                <input type="text" name="txt_user" class="form-control" placeholder="username" value="" required />
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="password" name="txt_pwd" class="form-control" placeholder="password" value="" required />
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
            <?php else: ?>
                <style>
                    ul li{
                        border: solid thin #ccc;
                        border-radius: 5px;
                    }
                    #row1 li{
                        margin-top: 100px;
                    }

                    #row2{
                        margin-bottom: 100px;
                    }
                    #row2 li{
                        padding: 5px;
                    }
                </style>
                <div>
                    <h3 class="pull-left">Yoga List</h3>
                    <h3 class="pull-right"><a href="index.php?logout=1"><?php echo $_SESSION['username'] . " "; ?>Sign out</a></h3>                
                    <form method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" name="txt_class" class="form-control" placeholder="New Class" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="txt_col1" class="form-control" placeholder="Field 1" required />                                
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="txt_col2" class="form-control" placeholder="Field 2" required />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="txt_col3" class="form-control" placeholder="Field 3" required /> 
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="txt_col4" class="form-control" placeholder="Field 4" required />    
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-lg-12 pull-right" style="text-align: right">
                                <input type="submit" value="Create" class="btn btn-primary" />
                            </div>
                        </div>
                    </form>
                    <h2>Example 1</h2>
                    <hr />
                    <ul class="row" id="row1">
                        <?php for ($i = 0; $i < count($list); $i++): ?>
                            <?php $obj = $list[$i]; ?>
                            <li class="thumbnail col-lg-3"><h3><a href="#"><?php echo $obj->get("classname"); ?></a></h3>
                                <img src="http://placehold.it/200" class="media" />
                                <?php echo "<b>Field 1 : </b>" . $obj->get("colA"); ?> <br />
                                <?php echo "<b>Field 2 : </b>" . $obj->get("colB"); ?> <br />
                                <?php echo "<b>Field 3 : </b>" . $obj->get("colC"); ?> <br /> 
                                <?php echo "<b>Field 4 : </b>" . $obj->get("colD"); ?>
                            </li>
                        <?php endfor; ?>
                    </ul>
                    <h2>Example 2</h2>
                    <hr />
                    <ul class="nav nav-pills nav-stacked" id="row2">
                        <?php for ($i = 0; $i < count($list); $i++): ?>
                            <?php $obj = $list[$i]; ?>
                            <li><h3><a href="#"><?php echo $obj->get("classname"); ?></a></h3></li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>