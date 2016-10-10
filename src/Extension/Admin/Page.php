<?php 

namespace Spark\Extension\Admin;

use Spark\Extension\Extension;
use Spark\Support\View;

/**
 * Adds an admin page
 * 
 * @author Cyrus
 *
 */
abstract class Page implements Extension, View
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
                    $this->prepare();
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
     
    public function cleanup() {}
}

?>