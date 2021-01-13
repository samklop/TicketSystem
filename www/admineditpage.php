<?php
    require 'php/autoloader.php';
    $accounts = new Accounts();
    if(!isset($_SESSION['userID']) || $accounts->getUserAdmin($_SESSION['userID']) == 0)
    {
        header('location: index.php', true);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="css/normalize.css">
        <title>Admin Edit Page</title>
    </head>
    <body>
        <header>
            <h1>Admin edit page</h1>
            <a href="admin.php">Head back to admin</a>

            <a href="viewticket.php">Head back to tickets</a>

        </header>
        <?php
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $userInfo = $accounts->getUserInfo($id);
        ?>
        <div id="boxbox">
        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">

        <!-- dynamically inputs all data from the database into the form -->
            <input type="Text" name="name" value="<?= $userInfo[1] ?>" id="name"> <label for="name">Name</label><br>
            <br>
            <input type="Text" name="email" value="<?= $userInfo[2] ?>" id="email"> <label for="email">Email</label><br>
            <br>
            <input type="Text" name="password" id="password"> <label for="password">Password</label><br>
            <br>
            <input type="Text" name="adminlevel" value="<?= $userInfo[4] ?>" id="adminlevel"> <label for="adminlevel" title="0 - regular, 1 - admin">Admin level</label><br>
            <br>
            <input type="Text" name="approved" value="<?= $userInfo[5] ?>" id="approved"> <label for="approved" title="0 - not approved, 1 - approved">Approved</label><br>
            <br>
            <input type="Submit" name="submit" value="Submit">

        </form>
        </div>

        <?php
        //filters all data and edits the database on submit to what was entered in the form
        if(isset($_POST["submit"]))
        {
            $name = filter_input(INPUT_POST , "name" , FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST , "email" , FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password');
            $adminlevel = filter_input(INPUT_POST , 'adminlevel' , FILTER_SANITIZE_STRING);
            $approved = filter_input(INPUT_POST , 'approved' , FILTER_SANITIZE_STRING);

            if(!empty($password))
                $password = password_hash($password, PASSWORD_DEFAULT);
            else
                $password = $userInfo[3];

            $accounts->editAccounts($id, $name, $email, $password, $adminlevel, $approved);
            header('location: admin.php', true);
        }
        ?>
    </body>
</html>



