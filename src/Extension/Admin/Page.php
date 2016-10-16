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
        return add_action( 'admin_menu', [$this, 'init'] );
    }
    
    public function init()
    {
        $hook = $this->registerPage();
        if ( $hook ) {
            add_action( 'load-' . $hook, [$this, 'prepare'] );
            $this->hook = $hook;
        }
        return $hook;
    }

    abstract protected function registerPage();
    
    public function getType() { return 'AdminPage'; }
        
    public function isRegistered()
    {
        return isset( $GLOBALS['admin_page_hooks'][$this->menu_slug] );
    }
     
    public function cleanup() {}
}

?>