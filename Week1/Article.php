<?php


namespace Week1;


class Article
{
    private $header;
    private $body;
    private $changeMap;
    private $tags;

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getChangeMap()
    {
        return $this->changeMap;
    }


    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function __construct($header, $body, $changeMap, $tags)
    {
        $this->header = $header;
        $this->body = $body;
        $this->changeMap = $changeMap;
        $this->tags = $tags;
    }


}