<?php
namespace Week1;

class View
{
    private $array = array();
    private $tags = array();
    private $numberOfArticle = array();

    public function __construct($data)
    {
        $this->array = $data->getArray();
        $this->tags = $data->getTags();
        $this->numberOfArticle = $data->getNumberOfArticle();
    }

    public function htmlPost()
    {
        echo "<html>
                <body>
                    <table-of-content>
                    <div>";
        foreach ($this->numberOfArticle as $element) {
            echo $this->array[$element]->GetHeader()." ";
        }
        echo "</div>
       </table-of-content>
                    <content>";
        foreach ($this->numberOfArticle as $element) {
            echo "<article>
                    <h1>".$this->array[$element]->GetHeader()."</h1>
                    <p>".$this->array[$element]->GetBody()."</p>
                  </article>";
        }
        echo "</content><tags>";
        foreach ($this->tags as $tag) {
            echo $tag.", ";
        }
        echo "</tags> 
                </body>
            </html>";
    }
}