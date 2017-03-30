
<?php
  require_once('../private/initialize.php');

  $errors = array();
  $netid = '';
  $pwd = '';
  $jscriptOn = 'yes';

  if(is_post_request()) {

    if(isset($_POST['netid'])) {
      $netid = $_POST['netid'];
    }
    if(isset($_POST['pwd'])) {
      $pwd = $_POST['pwd'];
    }
    if(isset($_POST['jscriptOn'])) {
      $jscriptOn = $_POST['jscriptOn'];
    }

    //Validate input
    if(is_blank($netid) || is_blank($pwd)) {
      $errors[] = "Net ID/Password cannot be empty.";
    }

    //check if javascript is on browser
    if($jscriptOn === 'no') {
      //emulate client side hash
      $pwd = $pwd + $netid + DOMAIN_NAME;
      $pwd = hash("sha256", $pwd);
    }

    $salt = getSaltFor($netid);

    if($salt === false) {
      $errors[] = "Invalid username/password."
    }

    $pwdhash = pbkdf2("sha256", $pwd, $salt, HASH_ITERATION_COUNT, strlen($pwd), false);
  }
?>
<!DOCTYPE html>

<html lang="en">
  <head>
    <title>RCC Scheduler Login Page</title>
    <meta charset="utf-8">
    
    <link rel="shortcut icon" href="favicon.png" />
    <link rel="stylesheet" href="./css/login.css">

    <script type="text/javascript" src="../private/sjcl.js"></script>

    <script type="text/javascript">
      <!--
      function hashPass(usernameSalt, passwordToHash) {
        
        var passPlusSalt = passwordToHash + usernameSalt + "<?php echo DOMAIN_NAME ?>";

        console.log(passPlusSalt);

        document.getElementById("pwd").value = sjcl.codec.hex.fromBits(sjcl.hash.sha256.hash(passPlusSalt));

        return true;
      }
      //-->
    </script>
  </head>

  <body>

    <div class='accountinfo'>
    </div>

    <div class='site'>
      <div class='header'>
    
        <div class='banner'>
          <img src="sbulogo.jpeg" alt="SBU Logo Unavailable" />
        </div>
      </div>

      <div class='main'>
        <table>
          <tr>
            <td class='sidebar'>
              <b class="sideHeading">Main Menu</b><br />
              <a class="navItem" href="https://sites.google.com/a/stonybrook.edu/rcc/">Home</a><br />
              <a class="navItem" href="https://sites.google.com/a/stonybrook.edu/rcc/services">Services</a><br />
              <a class="navItem" href="https://sites.google.com/a/stonybrook.edu/rcc/rules">Rules</a><br />
              <a class="navItem" href="https://sites.google.com/a/stonybrook.edu/rcc/employees">Employees</a><br />
              <a class="navItem" href="https://sites.google.com/a/stonybrook.edu/rcc/contact-us">Contact Us</a><br />
              <a class="navItem selectedItem" href="./index.php">Scheduling</a><br />
              <br />
              <a class="issue" href="https://sites.google.com/a/stonybrook.edu/rcc/report-an-issue">Report an Issue</a><br />
              <br />
              <b class="sideHeading">HELPFUL LINKS</b><br />
              <ul>
                <li><a class="navItem" href="http://studentaffairs.stonybrook.edu/res/">Campus Residences</a></li>
                <li><a class="navItem" href="https://blackboard.stonybrook.edu/webapps/login/">Blackboard</a></li>
                <li><a class="navItem" href="https://it.stonybrook.edu/services/solar">Solar</a></li>
              </ul>
            </td>
            <td>
              <h3>RCC Scheduling Log In</h3>
              <form method="post" action="index.php" onsubmit="hashPass(document.getElementById('netid').value , document.getElementById('pwd').value)">
        
                <div>
                  <label for="netid">Net ID</label>
                  <input name="netid" type="text" id="netid" placeholder="Net ID" required>
                </div>

                <div>
                  <label for="pwd">Password</label>
                  <input name="pwd" type="password" id="pwd" placeholder="Password" required>
                </div>

                <noscript>
                  <input id="jscriptOn" value="no" style="display: none;" />
                </noscript>

                <button type="submit">Sign In</button>
              </form>
            </td>
          </tr>
        </table>
      </div>

      <div class='footer'>
      </div>
    </div>
  </body>

</html>