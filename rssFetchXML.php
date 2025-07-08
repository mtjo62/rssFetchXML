<?php

/**
 * RSS aggregator utilizing libxml and cURL
 *
 * @package rssFetchXML
 * @version 1.0
 * @author MT Jordan <mtjo62@gmail.com>
 * @copyright 2025
 * @license MIT
 */

class rssFetchXML
{
    /**********************************************
     * Private Class Properties
     *********************************************/

    private $rss_cache_xml = false;
    private $rss_cache_file;
    private $rss_fetch_url;
    private $rss_str_xml = false;

    /**********************************************
     * Public Class Properties
     *********************************************/

    public $rss_xml_cache = ""; //Must be set
    public $rss_xml_expire = 864e2;
 
    /**********************************************
     * Public methods
     *********************************************/

    public function __construct() {}

    /* Set RSS URL and cache file name
     * Load unexpired XML file or fetch
     * RSS feed and return XML object
     */
    public function rss_xml_fetch($rss_url) {
        //set private properties
        $this->rss_fetch_url = $rss_url;
        $this->rss_cache_file =
            $this->rss_xml_cache .
            str_replace(
                " ",
                "",
                preg_replace("/[^A-Za-z0-9 ]/", "", $rss_url) . ".xml"
            );

        if ($this->rss_xml_cache()) {
            return $this->rss_cache_xml;
        }

        if ($this->rss_xml_str()) {
            return $this->rss_str_xml;
        } else {
            return false;
        }
    }

    /**********************************************
     * Private methods
     *********************************************/

    /* Load unexpired XML cache file */
    private function rss_xml_cache()
    {
        if (
            file_exists($this->rss_cache_file) &&
            time() - filemtime($this->rss_cache_file) < $this->rss_xml_expire
        ) {
            $this->rss_cache_xml = simplexml_load_file($this->rss_cache_file);
        }

        if (is_object($this->rss_cache_xml)) {
            return true;
        }
    }

    /* Fetch RSS XML, cache XML file and return XML object */
    private function rss_xml_str()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->rss_fetch_url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, @$_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $curl_result = curl_exec($curl);
        $curl_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        $this->rss_str_xml = simplexml_load_string($curl_result);
        
        curl_close($curl);
        
        //Sanity check for valid simplexml object - helps prevent fatal errors
        //triggered by asXML by invalid RSS URLs - not 100% accurate
        if (!is_object($this->rss_str_xml) || $curl_code !== 200) {
            return false;
        }
            
        if ($this->rss_str_xml->asXML($this->rss_cache_file)) {
            return true;
        }
    }
}
/* EOF rssFetchXML.php */
/* Location: ./rssFetchXML.php */
