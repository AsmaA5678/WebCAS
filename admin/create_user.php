<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
        <title>CASInpt_Create member</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
        <style>
                .header {
                        background: #5D8AA8;
                }
                button[name=register_btn] {
                        background: #5D8AA8;
                }
        </style>
</head>
<body>
<div class="header">
        <img src="../images/icon1.png" alt="Logo" width="50" height="50" style="display: inline-block; vertical-align: middle;">
        <h2 style="display: inline-block; vertical-align: middle; margin-top: -5px;">Add a new member</h2>
</div>
        
        <form method="post" action="create_user.php">

                <?php echo display_error(); ?>

                <div class="input-group">
                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                </div>
                <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="input-group">
                        <label>User type</label>
                        <select name="user_type" id="user_type" >
                                <option value=""></option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                        </select>
                </div>
                <div class="input-group">
                        <label>Password</label>
                        <input type="password" name="password_1">
                </div>
                <div class="input-group">
                        <label>Confirm password</label>
                        <input type="password" name="password_2">
                </div>
                <div class="input-group">
                        <button type="submit" class="btn" name="register_btn"> + Create user</button>
                </div>
        </form>
</body>
</html>