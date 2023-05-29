<?php

    // Database connection
    include('../config/db.php');

    if(isset($_POST["dir_path"])) {
        $dir = $_POST["dir_path"];
        $root_dir = "../";
        $dir_path = $root_dir . $dir . '/';
        $files = scandir($dir_path);


        if (selectOldDirRecord($dir, $connection)) {
            // Delete Old Directory Record
            deleteOldDirRecord($dir,$connection);
        };

        $file_info = [];
        $sql = '';
        $i = 0;
        foreach ($files as $file) {
            if($sql != '') $sql .= ',';
            $file_path = $dir_path.$file;
            if ($file != "." && $file != "..") {
                $file_info[$i]['dir_path'] = $dir;
                $file_info[$i]['name'] = $file;
                $file_info[$i]['size'] = filesize($file_path);
                $file_info[$i]['modified'] = date("Y-m-d", filemtime($file_path));
                $sql .= '("'. $file_info[$i]['dir_path'] .'","'. $file_info[$i]['name'] .'", "'. $file_info[$i]['size'] .'", "'. $file_info[$i]['modified'] .'")';
                $i++;
            }
        }

        if($sql != '') {
            $sql = "INSERT INTO file_data (dir_path, name, size, modified) VALUES " . $sql;
        }

        // Create mysql query
        $sqlQuery = mysqli_query($connection, $sql);

        if(!$sqlQuery){
            die("MySQL query failed!" . mysqli_error($connection));
        }

    }

    function selectOldDirRecord($dir, $connection): bool
    {
        $sql = "SELECT dir_path FROM file_data WHERE dir_path = '$dir'" ;
        $query = mysqli_query($connection, $sql);
        $rowCount = mysqli_num_rows($query);
        if ($rowCount == 0) {
            return false;
        } else {
            return true;
        }
    }

    function deleteOldDirRecord($dir, $connection){
        $sql = "DELETE FROM file_data WHERE dir_path = '$dir'" ;
        mysqli_query($connection, $sql);
    }

?>

<!DOCTYPE html>
<html>
    <body>
        <table border = "1">
            <tr>
                <td>Directory Path</td>
                <td>File Name</td>
                <td>File Size</td>
                <td>File Modified</td>
            </tr>
            <?php
            foreach ($file_info as $value){
                echo "<tr>";
                    echo "<td>";
                        echo $value['dir_path'];
                    echo "</td>";
                    echo "<td>";
                        echo $value['name'];
                    echo "</td>";
                    echo "<td>";
                        echo $value['size'];
                    echo "</td>";
                    echo "<td>";
                        echo $value['modified'];
                    echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </body>
</html>


