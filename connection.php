<?php include('functions.php') ?>
<!DOCTYPE html>
<html>
<head>
        <title>CASInpt, s'inscrire</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
        <img src="images/icon1.png" alt="Logo" width="50" height="50" style="display: inline-block; vertical-align: middle;">
        <h2 style="display: inline-block; vertical-align: middle; margin-top: -5px;">Create Account</h2>
</div>
<form method="post" action="connection.php">
        <?php echo display_error(); ?>
        <div class="input-group" style="margin-bottom: 15px;">
                 <label style="display: block; margin-bottom: 5px; font-weight: bold;">Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>" style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div class="input-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div class="input-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Password</label>
                <input type="password" name="password_1" style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div class="input-group" style="margin-bottom: 15px;">
                 <label style="display: block; margin-bottom: 5px; font-weight: bold;">Confirm Password</label>
                 <input type="password" name="password_2" style="padding: 8px; width: 100%; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div class="input-group" style="margin-top: 20px;">
                <button type="submit" class="btn" name="register_btn" style="background-color: #5D8AA8; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
                         Finish
                </button>
        </div>
        <p>
                Already a member? <a href="login.php" style="text-decoration: none; color: #5D8AA8; font-weight: bold; font-family: Arial, sans-serif;">Sign in</a>

        </p>
</form>
</body>
</html>