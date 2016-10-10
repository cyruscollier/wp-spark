<?php 

namespace Spark\Extension\Admin;

use Spark\Extension\Extension;

/**
 * Adds an admin page
 * 
 * @author Cyrus
 *
 */
abstract class Page implements Extension
{

    protected $page_title;
    
    protected $menu_title;
    
    protected $menu_slug;
    
    protected $capability = 'manage_options';

    protected $hook = '';
        
    public function register() {
        add_action( 'admin_menu', function() {
            $hook = $this->registerPage();
            if ( $hook ) {
                add_action( 'load-' . $hook, function() {
                    $this->prepareView();
                } );
                $this->hook = $hook;
            }
        } );
    }

    abstract protected function registerPage();
    
    public function getType() { return 'AdminPage'; }
        
    public function isRegistered()
    {
        global $admin_page_hooks;
        return isset( $this->menu_slug );
    }
    
    protected function prepareView() {}
    
    abstract protected function renderView();
    
}

?>