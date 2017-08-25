<?php
require_once './Action.php';

class ActionBuilder {
    static function build($action_str){
        $action = null;
        switch ($action_str){
            case "analize_domain":
                $action = new AnalizeDomainAction();
                break;
            default :
                $action = new DefaultAction();
        }
        return $action;
    }
}
