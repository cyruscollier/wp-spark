<?php

namespace Spark\Extension\Admin;

abstract class MenuPage extends Page
{

    protected $icon_url;
    
    protected $menu_position;
    
    protected function registerPage()
    {
        return add_menu_page(
            $this->page_title, 
            $this->menu_title, 
            $this->capability, 
            $this->menu_slug,
            function() { $this->renderView(); },
            $this->icon_url,
            $this->menu_position
        );
    }
    
    public function deregister()
    {
        remove_menu_page( $this->menu_slug );
    }
}