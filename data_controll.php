<?php
    $connection = mysqli_connect("localhost", "root", "", "verif");
    session_start();

    $error = array();
// signup
if(isset($_POST['signup'])){
    $name = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // hooson baigaa talbariig shalgah
    if(!empty($name) && !empty($email) && !empty($password)){
        // email helbertei bichigdsen esehiig shalgah
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $error['email_type_wrong'] = "Email buruu bn";
        }

        $query = "SELECT * FROM users WHERE email = '$email'";
        $res = mysqli_query($connection, $query);

        // ogodliin sand mail davhtsaj baigaa esehiig shalgah
        if(mysqli_num_rows($res) > 0){
            $error['email_exist'] = 'Ene mail deer ali hediin burtgel uussen bn';
        }

        // aldaa baihgui tohioldold ogodliin san ruu ogogdloo oruulah
        if(count($error) === 0){
            $insert_data = "insert into users(username, email, password) values('$name', '$email', '$password');";
            $id_insert = mysqli_query($connection, $insert_data);
            if($id_insert){
                // ogogdol orson tohioldold welcome.php ruu shiljih
                header('location: welcome.php');
            } else {
                $error['insert_data_error'] = "Database error";
            }
        }

    } else {
        $error['empty'] = "Hooson talbar uldeej bolohgui!";
    }
}


// signin

if(isset($_POST['signin'])){
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $query = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    

    if($row['email'] === $email){
        if($row['password'] === $password){
            $_SESSION['username'] = $email;
            header("location: welcome.php");

        } else {
            echo "password buruu bn";
        }
    } else {
        echo "Account butrgelgui bn";
    }

}






    // aldaanuudiig hevlej haruulah
    if(count($error) >= 1){
        foreach($error as $showerror){
            echo $showerror . '<br>';
    }

}
?>