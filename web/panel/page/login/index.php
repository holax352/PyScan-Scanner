    <?php
    require('config/config.php');

    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password= $_POST['password'];

        if($username != NULL && $password != NULL)
        {
            $encode  = md5($password);
            $select_users = $bdd->prepare("SELECT username,password FROM utilisateurs WHERE username = :username AND password = :password");
            $select_users->bindParam(':username', $username);
            $select_users->bindParam(':password', $encode);
            $select_users->execute();
            
            $fetch = $select_users->fetch();
            if($fetch['username'] != NULL)
            {
                $_SESSION['login'] = $username;
                echo "<div class='alert'>Success login Click <a href='index.php'>here</a></div>";
            }
            else
                echo "<div class='alertred'>Users not found .</div>";
        }
        else
            echo "<div class='alertred'>Field empty .</div>";
    }
    ?>
    <form action="#" method="post">
        <input type="text" name="username" placeholder="login" />
        <input type="password" name="password" placeholder="password" />
        <input type="submit" name="login" value="login" />
    </form>