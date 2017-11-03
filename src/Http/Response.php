<?php
namespace ASCII\Http;

class Response
{

    private
        $status, //int
        $reason, //string
        $header, //array
        $body; //string

    public function __construct()
    {
        $this->status = 200;
        $this->reason = "OK";
        $this->header = [];
        $this->body = "";
    }
        
    public function setStatus(int $status, string $reason)
    {
        $this->status = $status;
        $this->reason = $reason;
    }
    public function setBody(string $body)
    {
        $this->body = $body;
    }
    public function setHeader(string $header)
    {
        $this->header = $header;
    }
    public function addHeader(string $name, string $value)
    {
        $this->header[$name] = $value;
    }
  
    public function getStatus()
    {
        return "HTTP/1.1 "
            . (string) $this->status
            . " "
            . (string) $this->reason;
    }
    public function getBody()
    {
        return $this->body;
    }
    public function getHeader()
    {
        return $this->header;
    }

}
