<?php
namespace App;

class Currency
{
    protected $options;

    public function __construct($options = [])
    {
        $this->options = $options;
    }

    public function  calcCurrency()
    {
       //если отсутствует опция --from возвращаем курс к BYN
        if (!isset($this->options['from']) && isset($this->options['to'])) {
            $curAbbreviation2 = $this->options['to'];
            $cur2 = $this->getCurrencyFromAPI($curAbbreviation2);
            if($cur2) {
                return round($cur2, 2);
            } else {
                return "Неверно указан код валюты";
            }
        }

        //если поступили оба параметра получаем два курса и возвращаем их отношение
        if (isset($this->options['from']) && isset($this->options['to'])) {
            $curAbbreviation1 = $this->options['from'];
            $curAbbreviation2 = $this->options['to'];
            $cur1 = $this->getCurrencyFromAPI($curAbbreviation1);
            $cur2 = $this->getCurrencyFromAPI($curAbbreviation2);
            if (!$cur1) return "Неверно указан код валюты --from";
            if (!$cur2) return "Неверно указан код валюты --to";
            $result = $cur2 / $cur1;
            return round($result, 2);
        }

        return "Неверно указаны параметры используйте: \n php get_course.php [--from=ABB] --to=ABB";
    }

    public function  getCurrencyFromAPI($CurAbbreviation)
    {
        $info = file_get_contents("https://www.nbrb.by/api/exrates/rates/". $CurAbbreviation . "?parammode=2");
        $info = json_decode($info, true);
        if ($info) {
            return $info['Cur_OfficialRate'];
        }
            return false;
    }

}