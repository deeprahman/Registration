<?php require $root_dir."/views/header.html.php"?>
    <div class="container">
        <form class="reg-form" action="<?= $actual_link?>" method="post">
            <h1>Registration Form</h1>
            <div class="frm-text">
                <label for="input-name">Username:</label>
                <input type="text" id="input-name" name="usrname" placeholder="Enter User Name">
            </div>
            <div class="frm-text">
                <label for="input-pass">Password:</label>
                <input type="password" id="input-pass" name="password" placeholder="Enter User Name">
            </div>
            <div class="frm-text">
                <label for="input-cpass">Confirm Password:</label>
                <input type="password" id="input-cpass" name="con_pass" placeholder="Enter User Name">
            </div>
            <div class="frm-text">
                <label for="input-email">Email</label>
                <input type="email" id="input-email" name="email">
            </div>
            <div class="frm-btn">
                <button type="submit" name="register">Register</button>
            </div>
        </form>
    </div>
<?php require $root_dir."/views/footer.html.php"?>