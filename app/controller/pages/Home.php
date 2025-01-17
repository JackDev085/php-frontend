<?php

namespace App\Controller\Pages;
use App\Utils\View;
use App\models\Entity\Organization;

/**
 * Método responsável por retornar o conteúdo (view) da nossa home
 * @return string
 */
class Home extends Page{
    public static function getHome(){
        $user = new Organization();
        $content =  View::render("pages/home",[
            "name"=>$user->name,
            "description"=>$user ->description
            
        ]);
        return parent::getPage("teste",$content);
    }

}