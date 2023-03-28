<?php

use Shuchkin\SimpleXLSX;

include 'db.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

require_once __DIR__ . '/../src/SimpleXLSX.php';

echo '<h1>XLSX to Mysql database</h1>';

if (isset($_FILES['file'])) {
    if ($xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name'])) {
        echo '<h2>Parsing Result</h2>';
        echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';

        $dim = $xlsx->dimension();
        $cols = $dim[0];
        mysqli_query($conn, "delete from ntask");

        foreach ($xlsx->readRows() as $k => $r) {
            //      if ($k == 0) continue; // skip first row
            echo '<tr>';
            for ($i = 0; $i < $cols; $i++) {
                echo '<td>' . (isset($r[$i]) ? $r[$i] : '&nbsp;') . '</td>';
            }
            echo '</tr>';
            if ($r[0] != "Activity ID") {

                $sql = "INSERT into ntask (
                `Activity_ID`, 
                `Activity_Name`, `Activity_Status`, `Activity_Type`, `WBS`, `Werkpakket`, `Start`, `Finish`, `Actual_Start`, `Actual_Finish`, `BL_Project_Start`,
                `BL_Project_Finish`,
                `Resources`,
                `Groep1`,
                `Groep2`,
                `Groep3`,
                 `Groep4`,
                 `Groep5`,
                 `Groep6`,
                 `Groep7`,
                 `Groep8`,
                 `UDF_CRIT`,
                 `UDF-LAH`,
                 `Discipline`,
                 `Budgeted_Labor_Units`,
                 `BL_Project_Labor_Units`,
                 `Actual_Labor_Units`,
                 `Planned_Value_Labor_Units`,
                 `Earned_Value_Labor_Units`,
                 `Schedule_Variance_-_Labor_Units`,
                 `Remaining_Labor_Units`,
                 `Duration_%_complete`,
                 `Original_Duration`,
                 `Remaining_Duration`
                ) values('$r[0]','$r[1]','$r[2]','$r[3]','$r[4]','$r[5]','$r[6]','$r[7]','$r[8]','$r[9]','$r[10]','$r[11]','$r[12]','$r[13]','$r[14]','$r[15]','$r[16]','$r[17]','$r[18]','$r[19]','$r[20]','$r[21]','$r[22]','$r[23]','$r[24]','$r[25]','$r[26]','$r[27]','$r[28]','$r[29]','$r[30]','$r[31]','$r[32]','$r[33]')";

                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    echo "<script type=\"text/javascript\">
                                alert(\"Invalid File:Please Upload CSV File.\");
                                window.location = \"index.php\"
                            </script>";
                }
            }
        }
        echo '</table>';
        echo "<script type=\"text/javascript\">
                    alert(\"Xlsx File has been successfully Imported.\");
                    </script>";

    } else {
        echo SimpleXLSX::parseError();
    }
}
echo '<h2>Upload form</h2>
<form method="post" enctype="multipart/form-data">
*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="Parse" />
</form>';