
 <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db="bd_stagiaire";
            $port = 0;
            $socket = NULL;
            $flags = 0;
            
           
            
          $con = mysqli_init();
          if (!$con)
           {
          die("mysqli_init failed");
           }

// Specify connection timeout

 mysqli_options($con, MYSQLI_OPT_CONNECT_TIMEOUT, 10);

// Specify read options from named file instead of my.cnf

mysqli_options($con, MYSQLI_READ_DEFAULT_FILE, "myfile.cnf");

//Check connection

if (!mysqli_real_connect($con, $servername, $username, $password, $db, $port, $socket, $flags)) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

            
        ?>


