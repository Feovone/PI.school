<?php


namespace Week1;


class ConverterString
{
    private $articleArray = array();

    public function getArticleArray()
    {
        return $this->articleArray;
    }

    public function __construct($data)
    {
        $articleCount = substr_count($data, 'Article'); // 1
        $parsedArray = explode("Article:\r\n", $data);
        for ($i = 1; $i <= $articleCount; $i++) {
            $parseExplode = explode("\r\n", $parsedArray[$i]);
            array_push($this->articleArray, $this->getParsedArticle($parseExplode));
        }
    }

    private function getParsedArticle($parse)
    {
        $header = $this->arraySearch($parse, "Header: ", false,false);
        $body = $this->arraySearch($parse, "Body: ", false,false);
        $changeMap = $this->arraySearch($parse, "ChangeMap:", true,true);
        $tags = $this->arraySearch($parse, "Tags: ", false,true);
        return new Article($header, $body, $changeMap, $tags);
    }

    private function arraySearch($array, $needele, $isList, $isArray)
    {
        //Разделение строки на элемент/массив
        $arrayElement = "";
        $arrayList = array();
        foreach ($array as $key => $element) {
            $pos = strripos($element, $needele);
            if ($pos != false) {
                /*Если значение состоит из нескольких подпунктов $isList == true;
                    Value:
                        firstElement;
                        secondElement;
                */
                if ($isList == true) {
                     if($pos = stripos($array[$key + 1], "        ") === 0) {
                        $i = $key;
                        $i++;
                        while ($pos = stripos($array[$i], "        ") === 0) {
                            array_push($arrayList, ltrim($array[$i]));
                            $i++;

                        }
                    }
                    return $arrayList;
                }
                /*Если значение состоит из нескольких значений которые разделены "," $isArray == true;
                  Value: firstElement, secondElement
                 */
                elseif($isArray == true){
                        $pos = strpos($element, $needele);
                        $element = substr($element, $pos + strlen($needele));
                        $arrayList = explode(", ", $element);
                        return $arrayList;
                }
                $arrayElement = ltrim($element);
                break;
            }
        }
        $pos = strpos($arrayElement, $needele);
        return substr($arrayElement, $pos + strlen($needele));
    }
}
