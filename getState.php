<?php
//Array with possible states
$s[]= "AL";
$s[]= "AK";
$s[]= "AZ";
$s[]= "AR";
$s[]= "CA";
$s[]= "CA";
$s[]= "CT";
$s[]= "DE";
$s[]= "FL";
$s[]= "GA";
$s[]= "HI";
$s[]= "ID";
$s[]= "IL";
$s[]= "IN";
$s[]= "IA";
$s[]= "KS";
$s[]= "KY";
$s[]= "LA";
$s[]= "ME";
$s[]= "MD";
$s[]= "MA";
$s[]= "MI";
$s[]= "MN";
$s[]= "MS";
$s[]= "MO";
$s[]= "MT";
$s[]= "NE";
$s[]= "NV";
$s[]= "NH";
$s[]= "NJ";
$s[]= "NM";
$s[]= "NY";
$s[]= "NC";
$s[]= "ND";
$s[]= "OH";
$s[]= "OK";
$s[]= "OR";
$s[]= "PA";
$s[]= "RI";
$s[]= "SC";
$s[]= "SD";
$s[]= "TN";
$s[]= "TX";
$s[]= "UT";
$s[]= "VT";
$s[]= "VA";
$s[]= "WA";
$s[]= "WV";
$s[]= "WI";
$s[]= "WY";

$q = $_REQUEST["q"];
$suggest = "";

//serach through array to find similar
if ($q !== "") {
    $q = strtoupper($q);
    $len=strlen($q);
    foreach($s as $state){
        if (stristr($q, substr($state, 0, $len))) {
            if ($suggest === "") {
                $suggest = $state;
            } else {
                $suggest .= ", $state";
            }
        }
    }
}

//no suggestions
echo $suggest === "" ? "no suggesetion" : $suggest;
?>