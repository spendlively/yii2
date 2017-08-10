<?php

namespace app\components;

use yii\web\UrlRule;
use app\models\Sef;

class SefRule extends UrlRule
{
    public $connectionID = 'db';

    public function init()
    {
        if($this->name === null){
            $this->name = __CLASS__;
        }
    }

    /**
     * Преобразует ссылки в чпу формат
     * (из site/sef в sef.html)
     *
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        //Мой костылек
        if($route == 'site/sef') return 'sef.html';

        if($route == 'site/index') return '';
        if($route == 'site/search') return 'search.html?q=' . $params['q'];
        $link = $route . '?';
        if(count($params)){
            foreach($params as $key => $value){
                $link .= "$key=$value&";
            }
            $link = substr($link, 0, -1);
        }

        $sef = Sef::find()->where(['link' => $link])->one();
        if($sef) return $sef->link_sef . 'html';
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        //Мой костылек
        if($pathInfo == 'sef.html') return ['site/sef', []];

        if(preg_match('%^(.*)\.html$%', $pathInfo, $matches)){
            $link_sef = $matches[1];
            $sef = Sef::find()->where(['link_sef' => $link_sef])->one();
            if($sef){
                $link_data = explode('?', $sef->link);
                $route = $link_data[0];
                $params = array();
                if($link_data[1]){
                    $temp = explode('&', $link_data[1]);
                    foreach($temp as $t){
                        $t = explode('=', $t);
                        $params[$t[0]] = $t[1];
                    }
                }
                return [$route, $params];
            }
        }
        return false;
    }
}
