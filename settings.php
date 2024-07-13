<!DOCTYPE html>
<html lang="en">
<?php
session_start();  
include('config.php');
$langrow = $defaultLang;
include('lang.php');



if ($useSQL == true) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['logged_in_user']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc())
    {   
        $pwrow = $row['password'];
    }
    if ($_SESSION['hashed_pass'] == $pwrow) {
    } else {
        session_destroy();
    }
} else {
    session_destroy();
}

$nothing = "";

$dbsenduser = $_SESSION['logged_in_user'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['logged_in_user']))
{
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
$stmt->bind_param("s", $_SESSION['logged_in_user']);
$stmt->execute();
$result = $stmt->get_result();
$numrows = $result->num_rows;
while ($row = $result->fetch_assoc())
{
    $themerow = $row['theme'];
    $langrow = $row['lang'];
    $vidshadowrow = $row['videoshadow'];
    $proxyrow = $row['proxy'];
    $regionrow = $row['region'];
    $loadcommentsrow = $row['loadcomments'];
    $customthemeplayerrow = $row['customtheme_player_url'];
    $customthemehomerow = $row['customtheme_home_url'];
}
$numrows = $result->num_rows;
}
?>

<title>Liberatube · <?php echo $translations[$langrow]['settings']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="Liberatube">
<link rel="apple-touch-icon" href="favicon.ico">
<link rel="stylesheet" href="/styles/-w3.css">
<link rel="stylesheet" href="/styles/-bootstrap.min.css">



<div class="w3-sidebar w3-bar-block w3-collapse w3-card sidebar" style="width:55px;" id="mySidebar">
  <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">&times;</button>
  <a href="/" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">home</span><span class="tooltiptext"><?php echo $translations[$langrow]['home']; ?></span></a>
  <a href="/history.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">history</span><span class="tooltiptext"><?php echo $translations[$langrow]['watch_history']; ?></span></a>
  <a href="/playlist/playlists.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">list_alt</span><span class="tooltiptext"><?php echo $translations[$langrow]['playlists']; ?></span></a>
  <a href="/subscriptions.php" class="w3-bar-item sidebarbtn awhitesidebar"><span class="material-symbols-outlined">subscriptions</span><span class="tooltiptext"><?php echo $translations[$langrow]['subscriptions']; ?></span></a>
  <a href="/settings.php" class="w3-bar-item sidebarbtn awhitesidebar sidebarbtn-selected"><span class="material-symbols-outlined">settings</span><span class="tooltiptext"><?php echo $translations[$langrow]['settings']; ?></span></a>
</div>

<div class="w3-main" style="margin-left:55px">
<div class="w3-tssseal">
  <button class="w3-button w3-darkgrey w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
  <div class="w3-container">
  <div class="topbar">
    <div class="topbarelements topbarelements-center">
    <h3 class="title-top topbarelements"><?php echo $translations[$langrow]['settings']; ?></h3>
    </div>
    <div class="topbarelements topbarelements-right">
    <h4> <?php echo $_SESSION['logged_in_user']; ?>
    <?php if(isset($_SESSION['logged_in_user']))
    {
        echo '<a class="button awhite login-item" href="/auth/logout.php"><span class="material-symbols-outlined login-item-icon">logout</span><h5 class="login-item-text">'.$translations[$langrow]['logout'].'</h5></a>';
    }
    else
    {
        echo '<a class="button awhite login-item" href="/auth/login.html"><span class="material-symbols-outlined login-item-icon">login</span><h5 class="login-item-text">'.$translations[$langrow]['login-signup'].'</h5></a>';
    }
    ?>
    </div>
    </div>
  </div>
<script src="/scripts/sidebar.js"></script>
<div class="tenborder">
<?php
$dbsenduser = $_SESSION['logged_in_user'];
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if (isset($_SESSION['logged_in_user']))
{
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
$stmt->bind_param("s", $_SESSION['logged_in_user']);
$stmt->execute();
$result = $stmt->get_result();
$numrows = $result->num_rows;
while ($row = $result->fetch_assoc())
{
    $themerow = $row['theme'];
}
$numrows = $result->num_rows;
}
if(strcmp($themerow, 'blue') == 0) {
    echo '<link rel="stylesheet" href="../styles/playerblue.css">';
} elseif(strcmp($themerow, 'ultra-dark') == 0) {
    echo '<link rel="stylesheet" href="../styles/playerultra-dark.css">';
} elseif ($themerow == "custom") {
    echo '<link rel="stylesheet" href="'.$customthemeplayerrow.'">';
} else {
    echo '<link rel="stylesheet" href="../styles/player'.$defaultTheme.'.css">';
} 

if(isset($_SESSION['logged_in_user'])) {
  if($vidshadowrow == "on") {
    $checked1 = "checked";
  } else {
    $checked1 = "";
  }

  if($proxyrow == "on") {
    $checked2 = "checked";
  } else {
    $checked2 = "";
  }

  if ($loadcommentsrow == "showall") {
    $checked4a = "checked";
    $checked4b = "";
    $checked4c = "";
  } elseif ($loadcommentsrow == "noreplies") {
    $checked4a = "";
    $checked4b = "checked";
    $checked4c = "";
  } elseif ($loadcommentsrow == "nothing") {
    $checked4a = "";
    $checked4b = "";
    $checked4c = "checked";
  }

  $theme = $_POST['theme'] ?? "";
$lang = $_POST['lang'] ?? "";
$uregion = $_POST['region'] ?? "";
$torfproxy = $_POST['proxy'] ?? "";
$uplayertype = $_POST['player'] ?? "";
$uvideoshadow = $_POST['vidshadow'] ?? "";
$uloadcomments = $_POST['loadcomments'] ?? "";
$customthemehomerow = $_GET['customthemehomerow'] ?? $_POST['customthemehomerow'] ?? $customthemehomerow;
$customthemeplayerrow = $_GET['customthemeplayerrow'] ?? $_POST['customthemeplayerrow'] ?? $customthemeplayerrow;

$dbsenduser = $_SESSION['logged_in_user'];
if($theme != "")
{
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
$stmt->bind_param("s", $_POST['name']);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows) {
}
$stmt = $conn->prepare("UPDATE login SET customtheme_player_url = ?, customtheme_home_url = ?, theme = ?, lang = ?, region = ?, proxy = ?, videoshadow = ?, loadcomments = ? WHERE username = ?");
$stmt->bind_param("sssssssss", $customthemeplayerrow, $customthemehomerow, $theme, $lang, $uregion, $torfproxy, $uvideoshadow, $uloadcomments, $dbsenduser);
if ($stmt->execute() === TRUE) {   
} else {
  echo "Error: <br>" . $conn->error;
}
$conn->close();
} 



if($_GET['customthemeplayerrow']) {
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
  $stmt->bind_param("s", $_POST['name']);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result->num_rows) {
  }
  $stmt = $conn->prepare("UPDATE login SET customtheme_player_url = ?, customtheme_home_url = ? WHERE username = ?");
  $stmt->bind_param("sss", $customthemeplayerrow, $customthemehomerow, $dbsenduser);
  if ($stmt->execute() === TRUE) {   
  } else {
    echo "Error: <br>" . $conn->error;
  }
  $conn->close();
}



  if ($allowProxy == "true") {} 
  elseif ($allowProxy == "false" or $allowProxy == "downloads"){
    $instanceProxyText = ' <label style="color: red;">'.$translations[$langrow]['disabled_by_instance'].'</label>';
    if ($allowProxy == "downloads") {
      $instanceProxyText .= ' <label style="color: orange;">'.$translations[$langrow]['downloads_allowed'].'</label>';
    }
  }
echo '
<form action="" method="post" id="form">
  <div class="settingsdiv"><h4>'.$translations[$langrow]['visual_prefs'].'</h4>
  <label for="theme">'.$translations[$langrow]['theme'].':</label>
  <select class="formsel" style="border-radius: 6px;" id="theme" name="theme" value="--Please Select--">
  <option class="formsel" value="'.$themerow.'">'.$translations[$langrow]['selected'].': '.$themerow.'</option>
  <option class="formsel" disabled value="">----------</option>
    <option class="formsel" value="blue">Blue</option>
    <option class="formsel" value="ultra-dark">Ultra-Dark</option>
    <option class="formsel" value="custom">Custom</option>
  </select><a class="label" href="https://liberatube-pluginstore.epicsite.xyz/" for="theme">'.$translations[$langrow]['custom_themes'].'</a><br>
  ';
  if ($themerow == "custom") {
    echo '
    <label for="customthemeplayerrow">Custom player css file:</label>
    <input name="customthemeplayerrow" value="'.$customthemeplayerrow.'">
    <label for="customthemehomerow">Custom home css file:</label>
    <input name="customthemehomerow" value="'.$customthemehomerow.'">';
  }
  echo '
  <label for="vidshadow">'.$translations[$langrow]['video_shadow'].':</label>
  <input type="checkbox" id="vidshadow" name="vidshadow" '.$checked1.'>
  </div>
  <br>
  <div class="settingsdiv"><h4>'.$translations[$langrow]['regional_prefs'].'</h4>
  <label for="lang">'.$translations[$langrow]['language'].':</label>
  <select class="formsel" style="border-radius: 6px;" id="lang" name="lang" value="--Please Select--">
  <option class="formsel" value="'.$langrow.'">'.$translations[$langrow]['selected'].': '.$langrow.'</option>
  <option class="formsel" disabled value="">----------</option>
      <option class="formsel" value="en">English (en)</option>
      <option class="formsel" value="es">Español (es)</option>
      <option class="formsel" value="pl">Polski (pl)</option>
      <option class="formsel" value="de">Deutsch (de)</option>
      <option class="formsel" value="zh-CN">简体中文 (zh-CN)</option>
      <option class="formsel" value="fi">Suomi (fi)</option>
      <option class="formsel" value="fr">Français (fr)</option>
  </select>

  <br>
  <label for="region">'.$translations[$langrow]['region'].':</label>
  <select class="formsel" style="border-radius: 6px;" id="region" name="region" value="--Please Select--">
  <option class="formsel" value="'.$regionrow.'">'.$translations[$langrow]['selected'].': '.$regionrow.'</option>
  <option class="formsel" disabled value="">----------</option>
                        <option value="AE">AE</option>
                        <option value="AR">AR</option>                    
                        <option value="AT">AT</option>                    
                        <option value="AU">AU</option>                   
                        <option value="AZ">AZ</option>                   
                        <option value="BA">BA</option>                   
                        <option value="BD">BD</option>
                        <option value="BE">BE</option>                  
                        <option value="BG">BG</option>               
                        <option value="BH">BH</option>         
                        <option value="BO">BO</option>                  
                        <option value="BR">BR</option>                   
                        <option value="BY">BY</option>                   
                        <option value="CA">CA</option>                   
                        <option value="CH">CH</option>                   
                        <option value="CL">CL</option>                   
                        <option value="CO">CO</option>                    
                        <option value="CR">CR</option>                 
                        <option value="CY">CY</option>                
                        <option value="CZ">CZ</option>                
                        <option value="DE">DE</option>                 
                        <option value="DK">DK</option>                 
                        <option value="DO">DO</option>                
                        <option value="DZ">DZ</option>                
                        <option value="EC">EC</option>                
                        <option value="EE">EE</option>
                        <option value="EG">EG</option>
                        <option value="ES">ES</option>                 
                        <option value="FI">FI</option>                
                        <option value="FR">FR</option>           
                        <option value="GB">GB</option>           
                        <option value="GE">GE</option>     
                        <option value="GH">GH</option>           
                        <option value="GR">GR</option>             
                        <option value="GT">GT</option>             
                        <option value="HK">HK</option>              
                        <option value="HN">HN</option>              
                        <option value="HR">HR</option>              
                        <option value="HU">HU</option>               
                        <option value="ID">ID</option>                
                        <option value="IE">IE</option>               
                        <option value="IL">IL</option>              
                        <option value="IN">IN</option>           
                        <option value="IQ">IQ</option>      
                        <option value="IS">IS</option>       
                        <option value="IT">IT</option>              
                        <option value="JM">JM</option>                   
                        <option value="JO">JO</option>                   
                        <option value="JP">JP</option>                   
                        <option value="KE">KE</option>                   
                        <option value="KR">KR</option>                    
                        <option value="KW">KW</option>                   
                        <option value="KZ">KZ</option>                  
                        <option value="LB">LB</option>                  
                        <option value="LI">LI</option>                  
                        <option value="LK">LK</option>                  
                        <option value="LT">LT</option>                 
                        <option value="LU">LU</option>                  
                        <option value="LV">LV</option>                   
                        <option value="LY">LY</option>                   
                        <option value="MA">MA</option>                   
                        <option value="ME">ME</option>                  
                        <option value="MK">MK</option>                    
                        <option value="MT">MT</option>             
                        <option value="MX">MX</option>
                        <option value="MY">MY</option>
                        <option value="NG">NG</option>
                        <option value="NI">NI</option>
                        <option value="NL">NL</option>
                        <option value="NO">NO</option>
                        <option value="NP">NP</option>
                        <option value="NZ">NZ</option>
                        <option value="OM">OM</option>
                        <option value="PA">PA</option>
                        <option value="PE">PE</option>                  
                        <option value="PG">PG</option>
                        <option value="PH">PH</option>
                        <option value="PK">PK</option>
                        <option value="PL">PL</option>
                        <option value="PR">PR</option>
                        <option value="PT">PT</option>
                        <option value="PY">PY</option>
                        <option value="QA">QA</option>
                        <option value="RO">RO</option>
                        <option value="RS">RS</option>
                        <option value="RU">RU</option>
                        <option value="SA">SA</option>
                        <option value="SE">SE</option>
                        <option value="SG">SG</option>
                        <option value="SI">SI</option>
                        <option value="SK">SK</option>
                        <option value="SN">SN</option>
                        <option value="SV">SV</option>
                        <option value="TH">TH</option>
                        <option value="TN">TN</option>
                        <option value="TR">TR</option>
                        <option value="TW">TW</option>
                        <option value="TZ">TZ</option>
                        <option value="UA">UA</option>
                        <option value="UG">UG</option>
                        <option value="US">US</option>
                        <option value="UY">UY</option>
                        <option value="VE">VE</option>
                        <option value="VN">VN</option>
                        <option value="YE">YE</option>
                        <option value="ZA">ZA</option>
                        <option value="ZW">ZW</option>
                </select>
  </div>
  <br>
  <div class="settingsdiv"><h4>'.$translations[$langrow]['player_prefs'].'</h4>

    <label for="proxy">'.$translations[$langrow]['proxy_video'].':</label>
    <input name="proxy" type="checkbox" id="proxy"'.$checked2.'>'.$instanceProxyText.'</input><br>


    <label>'.$translations[$langrow]['comments'].':</label><br>
    <input type="radio" id="showall" name="loadcomments" value="showall" '.$checked4a.'></input><label class="label" for="showall">'.$translations[$langrow]['comments_showall'].'</label><br>
    <input type="radio" id="noreplies" name="loadcomments" value="noreplies" '.$checked4b.'></input><label class="label" for="noreplies">'.$translations[$langrow]['comments_noreplies'].'</label><br>
    <input type="radio" id="nothing" name="loadcomments" value="nothing" '.$checked4c.'></input><label class="label" for="nothing">'.$translations[$langrow]['comments_nothing'].'</label>

  </div>
  <br>
  <div class="settingsdiv"><h4>'.$translations[$langrow]['account_prefs'].'</h4>
  <a disabled type="button" class="btn btn-warning" style="margin-bottom: 5px; color: black;">'.$translations[$langrow]['clear_watch_history'].'</a><br>
  <a type="button" href="/account.php/?r=password" class="btn btn-primary">'.$translations[$langrow]['change_your_password'].'</a>
  <a type="button" href="/account.php/?r=delete" class="btn btn-danger">'.$translations[$langrow]['delete_your_account'].'</a>
  </div>
  
  ';
if ($_SESSION['logged_in_user'] == $adminuser) {
                        ?>
                        <br>
                        <div class="settingsdiv"><h4><?php echo $translations[$langrow]['admin_prefs']; ?></h4>
                            <p><?php echo $translations[$langrow]['update_inv_used']; ?></p>
                            <label for="InvCServer">InvCServer: </label>
                            <input type="text" value="<?php echo $_POST['InvCServer'] ?? $InvCServer; ?>" name="InvCServer" id="InvCServer">
                            <br><label for="InvVIServer">InvVIServer: </label>
                            <input type="text" value="<?php echo $_POST['InvVIServer'] ?? $InvVIServer; ?>" name="InvVIServer" id="InvVIServer">
                            <br><label for="InvTServer">InvTServer: </label>
                            <input type="text" value="<?php echo $_POST['InvTServer'] ?? $InvTServer; ?>" name="InvTServer" id="InvTServer">
                            <br><label for="InvSServer">InvSServer: </label>
                            <input type="text" value="<?php echo $_POST['InvSServer'] ?? $InvSServer; ?>" name="InvSServer" id="InvSServer">
                            </div>
                            
                        <?php

                        if(isset($_POST['InvCServer']) && isset($_POST['InvVIServer']) && isset($_POST['InvTServer']) && isset($_POST['InvSServer'])) {

                            $newInvCServer = $_POST['InvCServer'];
                            $newInvVIServer = $_POST['InvVIServer'];
                            $newInvTServer = $_POST['InvTServer'];
                            $newInvSServer = $_POST['InvSServer'];

                            $configContent = file_get_contents("config.php");

                            $patterns = array(
                                '/\$InvCServer\s*=\s*".*?";/',
                                '/\$InvVIServer\s*=\s*".*?";/',
                                '/\$InvTServer\s*=\s*".*?";/',
                                '/\$InvSServer\s*=\s*".*?";/'
                            );

                            $replacements = array(
                                '$InvCServer = "' . $newInvCServer . '";',
                                '$InvVIServer = "' . $newInvVIServer . '";',
                                '$InvTServer = "' . $newInvTServer . '";',
                                '$InvSServer = "' . $newInvSServer . '";'
                            );

                            $newConfigContent = preg_replace($patterns, $replacements, $configContent);

                            file_put_contents("config.php", $newConfigContent);

                        }
          }
    echo'
    <br>
  <div class="settingsdiv" style="background-color: transparent; border: none; text-align: right; padding-top: 0px; padding-right: 0px;">
  <button type="" class="btn btn-success" id="submitButton">'.$translations[$langrow]['save'].'</button>
  </div>
</form>
<script src="/scripts/formxhr.js"></script>
</div>';
} else {
echo '<h4 style="text-align: center;">You are not logged in.</h4>';
}

?>
</html>