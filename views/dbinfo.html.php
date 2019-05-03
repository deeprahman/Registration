<?php require $root_dir."/views/header.html.php"?>
<div class="container">
    <form class="reg-form" action="<?= $actual_link?>" method="post">
        <h1>Database Information</h1>
        <div class="frm-text">
            <label for="input-hostname">hostname:</label>
            <input type="text" id="input-hostname" name="hostname" placeholder="Enter Hostname Name">
        </div>
        <div class="frm-text">
            <label for="input-database">databasename:</label>
            <input type="text" id="input-database" name="database" placeholder="Enter Database Name">
        </div>
        <div class="frm-text">
            <label for="input-port">Port:</label>
            <input type="text" id="input-port" name="port" placeholder="Enter port">
        </div>
        <div class="frm-text">
            <label for="input-username">Username:</label>
            <input type="text" id="input-username" name="db_username" placeholder="Enter Username">
        </div>
        <div class="frm-text">
            <label for="input-password">Password:</label>
            <input type="password" id="input-password" name="db_password" placeholder="Enter Password">
        </div>

        <div class="frm-btn">
            <button type="submit" name="db_info">Submit</button>
        </div>
    </form>
</div>
<?php require $root_dir."/views/footer.html.php"?>