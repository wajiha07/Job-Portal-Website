<?php

function calculate_difference_between ( $date1, $date2 ) {
    $diff = abs(strtotime($date2) - strtotime($date1));

    $years   = floor($diff / (365*60*60*24));
    $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

    $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));

    $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

    $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));

    return printf("%d years, %d months, %d days, %d hours, %d minuts\n, %d seconds\n", $years, $months, $days, $hours, $minuts, $seconds);
}

# to get the regions
function get_regions(){
    $jobsApiConfigurations = \JobDesk\Classes\Database::getJobsApiConfigurations();
    if ($jobsApiConfigurations->code_table_endpoint) {
        $url =  $jobsApiConfigurations->code_table_endpoint . '?' . http_build_query([
            'ClientKey' => $jobsApiConfigurations->client_key,
            'id' => '5',
            'LanguageCode' => 'de'
        ]);
        $RegionsUnparsed = file_get_contents($url);
        return json_decode($RegionsUnparsed);
    } else {
        return [];
    }
}

# to get the contract types
function get_contract_types(){
    $jobsApiConfigurations = \JobDesk\Classes\Database::getJobsApiConfigurations();
    if ($jobsApiConfigurations->code_table_endpoint) {
        $url =  $jobsApiConfigurations->code_table_endpoint . '?' . http_build_query([
            'ClientKey' => $jobsApiConfigurations->client_key,
            'id' => '6',
            'LanguageCode' => 'de'
        ]);
        $ContractTypesUnparsed = file_get_contents($url);
        return json_decode($ContractTypesUnparsed);
    } else {
        return [];
    }
}

# to get the sectors
function get_sectors(){
    $jobsApiConfigurations = \JobDesk\Classes\Database::getJobsApiConfigurations();
    if ($jobsApiConfigurations->code_table_endpoint) {
        $url =  $jobsApiConfigurations->code_table_endpoint . '?' . http_build_query([
            'ClientKey' => $jobsApiConfigurations->client_key,
            'id' => '4',
            'LanguageCode' => 'de'
        ]);
        $SectorsUnparsed = file_get_contents($url);
        return json_decode($SectorsUnparsed);
    } else {
        return [];
    }
}

# to get current uri
function get_current_uri()
{
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return $actual_link;
}

