<?php
    // English
    function lang( $phrase ){        
        static $mix = array(

            // navbar links
            'home_admin'    => 'Home',
            'categories'    => 'Categories',
            'items'         => 'Items',
            'members'       => 'Members',
            'edit Profil'   => 'Edit Profil',
            'settings'      => 'Settings',
            'logout'        => 'Logout',
            'statistics'    => 'Statistics',
            "" => ""
        
        );
        return $mix[$phrase];
    }
?>


