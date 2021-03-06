<?php
/**
 *  This file is part of amfPHP
 *
 * LICENSE
 *
 * This source file is subject to the license that is bundled
 * with this package in the file license.txt.
 * @package Amfphp_Examples_ExampleService
 */


namespace NService;


/**
 * simple service for testing namespace support
 *
 * @package Amfphp_Examples_ExampleService
 * @author Ariel Sommeria-klein
 */
class NamespaceTestService {
    /**
     * bla function, dummy
     * @return string 
     */
    function bla(){
        return "bla";
    }
    /**
     *
     * @param type $vo example:  {"_explicitType":"NamespaceTestVo", "dummyData":"blabla"}
     * @return type 
     */
    function useVo(\NVo\NamespaceTestVo $vo){
        return $vo;
        
    }
}

?>
