<?php
require_once("c_transactions.php");
 $db = new db_transactions();
?>
<!DOCTYPE html>
    <!--
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    -->
    <html>
        <head>
            <meta charset="UTF-8">
            <title></title>
        </head>
        <body>
            <form method="post">
                <button type="submit" name="btn_export">Data Export</button>
                <button type="submit" name="btn_import">Data Import</button>
            </form>
            <?php
            $host = "localhost";
            $uname = "root";
            $pass = "";
            $database = "demo"; //Change Your Database Name
            $conn = new mysqli($host, $uname, $pass, $database)or die("No Connection");
            echo mysql_error();
    //MYSQL MYADDMINPHP TO CSV
            if (isset($_REQUEST['btn_export']))
            {
                $data_op = "";
                $sql = $conn->query("select * from users"); //Change Your Table Name          
                while ($row1 = $sql->fetch_field())
                {
                    $data_op .= '"' . $row1->name . '",';
                }
                $data_op .="\n";
                while ($row = $sql->fetch_assoc())
                {
                    foreach ($row as $key => $value)
                    {
                        $data_op .='"' . $value . '",';
                    }
                    $data_op .="\n";
                }
                $filename = "Database.csv"; //Change File type CSV/TXT etc
                header('Content-type: application/csv'); //Change File type CSV/TXT etc
                header('Content-Disposition: attachment; filename=' . $filename);
                echo $data_op;
                exit;
            }
    //CSV To MYSQL MYADDMINPHP
            if (isset($_REQUEST['btn_import']))
            {
                define('CSV_PATH','/var/www/html/gae/csv/'); // specify CSV file path
                $filename = 'demographic.csv';
                $csv_file = CSV_PATH . $filename; // Name of your CSV file
                $csvfile = fopen($csv_file, 'r');
                $sqlinsert = "INSERT INTO demographics (study_id, abs_date, facility_id, anc_id, psc_id, visit_count, "
                        . "anc_visit_date, birth_date, residence, parity, gravida, gestational_period, lmp, edd,"
                        . " marital_status, hiv_status, initial_hiv_status, hiv_retest, woman_haart, haart_regimen, "
                        . "counselling, hiv_status_partner, return_date, user_initial) ";
                $result = $db->importFromCSV($csvfile, $sqlinsert);
                if ($result > 0)
                {
                    echo $result." Total results imported successfully";
                }
              
                fclose($fp);
                /*if (!unlink($csv_file))
                  {
                    echo ("\nError Removing $filename. The file may not exist on the server");
                  }
                else
                  {
                    echo ("\nThe file $filename has been removed from the server");
                  }*/
            }
            ?>
        </body>
    </html>