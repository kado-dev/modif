<?php
include"config/koneksi.php";
$filename = "tes_tbasuransi_excel";         //File Name
/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/    
//create MySQL connection   
$sql = "SELECT * FROM `tbasuransi`";
$query = mysqli_query($koneksi,$sql);    
$file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields

while ($property = mysqli_fetch_field($query)) {
    echo $property->name . "\t";
}

print("\n");    
//end of printing column names  
//start while loop to get data
    while($row = mysqli_fetch_row($query))
    {
        $schema_insert = "";
        for($j=0; $j<mysqli_num_fields($query);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }   
?>