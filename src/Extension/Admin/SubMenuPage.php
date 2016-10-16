<?php

namespace Spark\Extension\Admin;

abstract class SubMenuPage extends Page
{
    protected $parent_slug;
    
    protected function registerPage()
    {
        return add_submenu_page(
            $this->parent_slug, 
            $this->page_title, 
            $this->menu_title, 
            $this->capability, 
            $this->menu_slug,
            [$this, 'render']
        );
    }
    
    public function deregister()
    {
        return (bool) remove_submenu_page( $this->menu_slug );
    }
}