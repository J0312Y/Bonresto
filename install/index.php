<?php 
// session start
ini_set('session.use_trans_sid', false);
ini_set('session.use_cookies', true);
ini_set('session.use_only_cookies', true);

$https = false;

if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}

if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off') $https = true;
$dirname = rtrim(dirname($_SERVER['PHP_SELF']), '/').'/';
$installerurl=$protocol.$_SERVER['HTTP_HOST'].$dirname;

session_name('ci_installer');
session_set_cookie_params(0, $dirname, $_SERVER['HTTP_HOST'], $https, true);
session_start();

// Include helper
require_once __DIR__.'/php/Helper.php';
require_once __DIR__.'/vendor/autoload.php';

use Php\Requirements;
use Php\Validation;
use Php\DbImport;
use Php\FileWrite;
use Php\Verification;

// Create object for each class
$Requirements = new Requirements();
$Validation   = new Validation();
$DbImport     = new DbImport();
$FileWrite    = new FileWrite(); 
$Verification = new Verification(); 

// Set the path of files
$path = [
    'sql_path'      => 'sql/install.sql',
    'template_path' => 'php/Database.php',
    'output_path'   => '../application/config/database.php',
    'config_path'   => '../application/config/config.php',
];

$message      = null; 
$activeClass  = null; 

$_SESSION['purchase_key_used'] = false;

if (empty($_SESSION['_token'])) {
    $_SESSION['_token'] = gen_csrf_token();
}
$token = $_SESSION['_token']; 

// Step 3: launch app
if (isset($_GET['launchapp']) && $Validation->checkEnvFileExists() === false) {
    $launch = $Verification->launch_application($_GET); 
    if($launch){
        $FileWrite->createEnvFile();
        session_destroy();
        $Validation->checkEnvFileExists();
    } else {
        $message .= '<li>Failed! Please check your internet connection and try again.</li>';
    } 
} else {
    $Validation->checkEnvFileExists();
}

// Purchase key validation
if (!empty($_GET['user_id']) || !empty($_GET['purchase_key'])) {
    $result = $Validation->validate($_GET);
    if ($result === TRUE) {
        $validdata = $Verification->verify_purchase($_GET);
        if($validdata == 'yes'){
            header('location: index.php?step2=true');
        } else {
            $message .= $validdata;
        }
    } else {
        $message .= $result;
    }
}

// Submit form data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $lresult = $Validation->validate_login($_POST);
        if ($lresult===TRUE) {
            if($DbImport->insert_login($_POST)){
                header('location: index.php?complete=true');
            } else{
                $message .= "<li>Failed! Please try again.</li>";
            }
        } else {
            $message .= $lresult;
        }
    } else {
        $dbvalid = $Validation->run($_POST);
        if ($dbvalid===true) {
            if ($Validation->checkFileExists($path['sql_path'])==false) {
                $message .= "<li>install.sql file is missing in the sql/ directory!</li>";
            } else {
                if ($FileWrite->databaseConfig($path,$_POST) === false) {
                    $message .= "<li>Could not write database configuration file. Please chmod application/config/database.php to 777</li>";
                } elseif ($DbImport->createDatabase($_POST) === false) {
                    $message .= "<li>Could not create database. Please verify your settings.</li>";
                } elseif ($DbImport->createTables($_POST) === false) {
                    $message .= "<li>Could not create database tables. Please verify your settings.</li>";
                } else { 
                    header('location: index.php?step4=true');
                }   
            }
        } else {
            $message .= $dbvalid;
        }
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="<?php echo $installerurl;?>assets/img/favicon.png" sizes="32x32">
<base href="<?php echo $installerurl; ?>">
<title>Bonresto Application Installer</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=EB+Garamond&display=swap" rel="stylesheet">
<link href="<?php echo $installerurl;?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $installerurl;?>assets/css/style.min.css" rel="stylesheet">
</head>
<body>

<div class="page-wrapper">
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">

<header class="header">
<h1 class="header-title">Lamuka Tech Software Installer</h1>
</header>

<div class="page-content">
<div class="outer-container">
<div id="wizard" class="aiia-wizard">

<!-- STEP 1: Welcome -->
<?php 
if (isset($_GET['step1']) || (!isset($_GET['step1']) && !isset($_GET['step2']) && !isset($_GET['step3']) && !isset($_GET['step4']) && !isset($_GET['complete']))) {
    $activeClass = 'active';
} 
?>
<div class="aiia-wizard-step <?php echo $activeClass ?>">
<h1>Welcome</h1>
<form id="welcomeForm" class="form-horizontal">
<?php if (!empty($message)) echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>"; ?>
<div class="step-content step-one">
<div class="row">
<div class="col-sm-8">
<div class="form-group">
<p>Welcome to your special platform 🎉</p>
<p class="text-muted">Click <strong>Next</strong> to start the setup.</p>
</div>
</div>
</div>
</div>
<div class="row action_btns">
<button type="button" id="nextBtn" class="btn btn-success pull-right">Next</button>
</div>
</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('nextBtn').addEventListener('click', function() {
        alert('Welcome! Let’s proceed with the platform setup 🚀');
        window.location.href = "<?php echo $installerurl; ?>index.php?step2=true";
    });
});
</script>

<!-- STEP 2: Configurations -->
<div class="aiia-wizard-step <?php echo (isset($_GET['step2'])?'active':'') ?>">
<h1>Configurations</h1>
<div class="step-content step-two">
<div class="app_content">
<div class="row">
<div class="col-sm-12">
<h3 class="title text-center"><strong>Directory permissions & requirements</strong></h3>
<?= $Requirements->directoriesAndPermission(); ?>
<div class="height"></div>
<?= $Requirements->server(); ?>
</div>
</div>
</div>
</div>
<div class="row action_btns">
<button class='btn btn-success pull-left aiia-wizard-button-previous prev_action'>Previous</button>
<a href="<?php echo $installerurl;?>index.php?step3=true" class='btn btn-success pull-right'>Next</a>
</div>
</div>

<!-- STEP 3: Database Setup -->
<div class="aiia-wizard-step <?php echo (isset($_GET['step3'])?'active':'') ?>">
<h1>Database Setup</h1>
<?php if (!empty($message)) echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>"; ?>
<form action="<?php echo $installerurl;?>index.php?step3=true" method="post" name="step3">
<div class="step-content step-three">
<input type="hidden" name="_token" value="<?= (!empty($token)?$token:null) ?>"/>
<div class="form-group">
<label for="database">Database Name</label>
<input type="text" name="database" class="form-control" id="database" placeholder="Enter your database name" value="">
</div>
<div class="form-group">
<label for="username">Database Username</label>
<input type="text" name="username" class="form-control" id="username" placeholder="Enter your database username" value="">
</div>
<div class="form-group">
<label for="password">Database Password</label>
<input type="text" name="password" class="form-control" id="password" placeholder="Enter your database password" value="">
</div>
<div class="form-group">
<label for="hostname">Host Name 
<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="Use 'localhost' by default, or your server IP/domain if needed"></span>
</label>
<input type="text" name="hostname" class="form-control" id="hostname" placeholder="Enter your host name" value="localhost">
</div>
</div>
<div class="row action_btns">
<button class='btn btn-success pull-left aiia-wizard-button-previous prev_action'>Previous</button>
<button type="submit" class='btn btn-success pull-right'>Next</button>
</div>
</form>
</div>

<!-- STEP 4: User Credentials -->
<div class="aiia-wizard-step <?php echo (isset($_GET['step4'])?'active':'') ?>">
<h1>User Credentials</h1>
<div class="text-center" id="wait_div">
<br>
<h3 id="wait_msg">&nbsp;</h3>
</div>
<div class="logininfo hide" id="logininfo">
<p class="text-center">Please create your initial account. You can change your email and password later.</p>
<?php if (!empty($message)) echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>"; ?>
<form action="<?php echo $installerurl;?>index.php?step4=true" method="post" class="form-horizontal" name="step4">
<div class="step-content step-four">
<div class="row">
<div class="col-sm-7">
<div class="form-group">
<label for="email" class="col-sm-4 col-form-label">Email Address</label>
<div class="col-sm-8">
<input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
</div>
</div>
<div class="form-group">
<label for="pass" class="col-sm-4 col-form-label">Password</label>
<div class="col-sm-8">
<input type="password" name="password" class="form-control" placeholder="Enter a secure password" id="pass" required>
</div>
</div>
</div>
</div>
</div>
<div class="row action_btns">
<button class='btn btn-success pull-left aiia-wizard-button-previous prev_action'>Previous</button>
<button type="submit" class='btn btn-success pull-right'>Next</button>
</div>
</form>
</div>
</div>

<!-- STEP 5: Complete -->
<div class="aiia-wizard-step <?php echo (isset($_GET['complete'])?'active':'') ?>">
<h1>Complete</h1>
<div class="step-content step-five">
<div class="col-sm-12">
<?php if (!empty($message)) {
    echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>";
} else { ?>
<h3 class="title text-center margin">Installation Complete</h3>
<div class="alert alert-success">
<strong>Your application has been successfully installed!</strong>
</div>
<?php } ?>
<div class="divider"></div>
<div class="text-center hide" id="btn-complete">
<a href="<?php echo $installerurl;?>index.php?complete=true&launchapp=true" class="btn btn-block cbtn">Finish Installation Process</a>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>

<footer class="footer text-center">
<div class="container fText">
<div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
<div class="row">
<div class="col-sm-6 text-left">Developed by <a target="_blank" href="#">Lamuka Tech</a></div>
<div class="col-sm-6 text-right"><a target="_blank" href="#"><span class="glyphicon glyphicon-user"></span> Installation Support</a></div>
</div>
</div>
</div>
</footer>

<script src="<?php echo $installerurl;?>assets/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo $installerurl;?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo $installerurl;?>assets/js/script.js"></script>
<script src="<?php echo $installerurl;?>assets/js/ajax.js"></script>

</body>
</html>
