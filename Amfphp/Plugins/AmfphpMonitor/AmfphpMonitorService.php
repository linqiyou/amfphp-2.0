<?php

/**
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 * @package Amfphp_Plugins_Monitor

/**
 * monitoring service. controls logging, qnd provides method to fetch data.
 *
 * @package Amfphp_Plugins_Monitor
 * @author Ariel Sommeria-klein
 */
class AmfphpMonitorService {
    public static $logPath;

    
    /**
     * parse logged data and return it. 
     * the format is 
     * obj -> sortedDatas ( array ( uri => times (array (name => array of times)) 
     * obj -> timeNames 
     * 
     * note: timeNames are needed for rendering on the client side, to make sure that each series has the same times.
     * This could be done on the client side, but is faster to do here.
     * 
     * @todo calculate averages per service instead of just returning the data raw.
     * @param boolean $flush get rid of the logged data 
     * @return array 
     */
    public function getData($flush){
        if(!file_exists(self::$logPath)){
            return null;
        }
        $fileContent = file_get_contents(self::$logPath);
        //ignore "php exit " line
        $loggedData = substr($fileContent, 16);
        if($flush){
            file_put_contents(self::$logPath, "<?php exit();?>\n");
        }
        $exploded = explode("\n", $loggedData);
        
        //data is sorted by target uri
        $sortedData = array();
        //use associative array to avoid duplicating time  names, then return keys.
        $timeNamesAssoc = array();
        foreach($exploded as $serializedRecord){
            $record = unserialize($serializedRecord); 
            if(!$record){
                continue;
            }
            $uri = $record->uri;
            if(!isset($sortedData[$uri])){
                $sortedData[$uri] = array();
            }
            $uriData = &$sortedData[$uri];
            //sort times
            foreach($record->times as $timeName => $timeValue){
                if(!isset ($uriData[$timeName])){
                    $uriData[$timeName] = array();
                }
                $uriData[$timeName][] = $timeValue;
                $timeNamesAssoc[$timeName] = '';
            }
            
        }
        $ret = new stdClass();
        $ret->sortedData = $sortedData;
        $ret->timeNames = array_keys($timeNamesAssoc);
        return $ret;
    }

}

?>
