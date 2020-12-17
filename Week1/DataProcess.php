<?php
namespace Week1;

class DataProcess
{
    private $array = array();
    private $tags = array();
    private $numberOfArticle = array();

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->array;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return array
     */
    public function getNumberOfArticle(): array
    {
        return $this->numberOfArticle;
    }

    public function __construct($array, $query)
    {
        $this->array = $array;
        $this->replaceMap();
        $this->selectArticles($query);
    }

    private function replaceMap()
    {
        foreach ($this->array as $element) {
            if ($element->GetChangeMap() !== false) {
                foreach ($element->GetChangeMap() as $arrayElement) {
                    $temp = explode(": ", $arrayElement);
                    $tempBody = $element->getBody();
                    $tempBody = str_replace($temp[0], $temp[1], $tempBody);
                    $element->setBody($tempBody);

                }
            }
        }
    }

    private function selectArticles($query)
    {
        $selectedTags = array();
        foreach ($this->array as $key => $element) {
            $tags = $element->getTags();
            if (in_array($query, $tags)) {
                array_push($this->numberOfArticle, $key);
                foreach ($tags as $tag) {
                    array_push($selectedTags, $tag);
                }
            }
        }
        $selectedTags = array_unique($selectedTags);
        sort($selectedTags);
        $this->tags = $selectedTags;
    }
}
