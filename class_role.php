<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of role_class
 *  The primary focus of the Role class is to return a role object that is
 *  populated with each roles corresponding permissions. This will allow you to easily 
 * check whether a permission is available without having to perform redundant SQL queries with every request.
 * @author echiteri
 */
require_once("config.php");

class Role
{
function set_rights($menus, $menuRights, $topmenu) {
    $data = array();

    for ($i = 0, $c = count($menus); $i < $c; $i++) {

        $row = array();
        for ($j = 0, $c2 = count($menuRights); $j < $c2; $j++) {
            if ($menuRights[$j]["rr_modulecode"] == $menus[$i]["mod_modulecode"]) {
                if ($this->authorize($menuRights[$j]["rr_create"]) || $this->authorize($menuRights[$j]["rr_edit"]) ||
                        $this->authorize($menuRights[$j]["rr_delete"]) || $this->authorize($menuRights[$j]["rr_view"])
                ) {

                    $row["menu"] = $menus[$i]["mod_modulegroupcode"];
                    $row["menu_name"] = $menus[$i]["mod_modulename"];
                    $row["page_name"] = $menus[$i]["mod_modulepagename"];
                    $row["create"] = $menuRights[$j]["rr_create"];
                    $row["edit"] = $menuRights[$j]["rr_edit"];
                    $row["delete"] = $menuRights[$j]["rr_delete"];
                    $row["view"] = $menuRights[$j]["rr_view"];
                    
                    $data[$menus[$i]["mod_modulegroupcode"]][$menuRights[$j]["rr_modulecode"]] = $row;
                    $data[$menus[$i]["mod_modulegroupcode"]]["top_menu_name"] = $menus[$i]["mod_modulegroupname"];
                }
            }
        }
    }

    return $data;
}

// this function is used by set_rights() function
function authorize($module) {
    return $module == "yes" ? TRUE : FALSE;
    }
}
