<?php
namespace Kanxpack\RapidAPIClient;

use Kanxpack\CurlGet\CurlGet;
use Kanxpack\RapidAPIClient\HttpResponseMessage;

class RapidAPIClient {

	private static $instance;
	protected static $httpResponseMessage;
    protected static $url;
    protected static $host;
    protected static $key;
    protected static $options;

    public static function getInstance() : self
    { 
    	return empty(self::$instance) ? (new self()) : self::$instance; 
    }

    protected static function setHttpResponseMessage(array $httpResponseMessage) : self
    {
        self::$httpResponseMessage = HttpResponseMessage::set($httpResponseMessage);        
        return self::getInstance();
    }

    public static function setUrl(string $url) : self
    {
        self::$url = $url;
        return self::getInstance();
    }

    public static function getUrl() : string
    {
        return self::$url;
    }

    public static function setKey(string $key) : self
    {
        self::$key = $key;
        return self::getInstance();
    }

    public static function getKey() : string
    {
        return self::$key;
    }

    public static function setHost(string $host) : self
    {
        self::$host = $host;
        return self::getInstance();
    }

    public static function getHost() : string
    {
        return self::$host;
    }

    public static function setOptions() : self
    {
        self::$options = [
            CURLOPT_URL => self::getUrl(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: " . self::getHost() ."",
                "x-rapidapi-key: " . self::getKey() .""
            ],
        ];

        return self::getInstance();
    }

    public static function getOptions() : array
    {
        return self::$options;
    }

	public static function get() : self
	{
        self::setOptions();
        self::setHttpResponseMessage(CurlGet::get(self::getUrl(), array(), self::getOptions())->getResultArray());
		return self::getInstance();
	}

    public static function getHttpResponseMessage()
    {
        return self::$httpResponseMessage;
    }

    public static function getResult() : array
    {
        return self::getHttpResponseMessage()->getResult();
    }

    public static function getResponse() : array
    {
        return self::getHttpResponseMessage()->getResponse();
    }

    public static function getError() : string
    {
        return self::getHttpResponseMessage()->getError();
    }

    public static function getMessage() : string
    {
        return self::getHttpResponseMessage()->getMessage();
    }

    public static function getStatus() : string
    {
        return self::getHttpResponseMessage()->getStatus();
    }

    public static function isStatus200() : bool
    {
        if (self::getStatus() == '200') {
            return true;
        }
        return false;
    }

    public static function isStatus404() : bool
    {
        if (self::getStatus() == '404') {
            return true;
        }
        return false;
    }

    public static function isStatusSuccess() : bool
    {
        return self::isStatus200();
    }

    public static function isStatusNotFound() : bool
    {
        return self::isStatus404();
    }

    public static function isStatus(string $status) : bool
    {
        if (self::getStatus() == $status) {
            return true;
        }
        return false;
    }
}