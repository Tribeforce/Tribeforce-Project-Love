<?php

/**
 * This class manages the status messages that appear on the top off the screen
 * @package Messages
 */
class Menu {

  /**
   * This function adds a message to the session using Session::flash()
   * @param string $type The menu type
   */
  public static function get($type = 'main') {
    switch($type) {
      case 'main':
        $menu = array(
          'goals'    => array(
            'uri' => '/goals',
            'icon' => 'target',
          ),
          'endorsements'  => array(
            'uri' => '/endorsements',
            'icon' => 'award',
          ),
          'circles'  => array(
            'uri' => '/circles',
            'icon' => 'users',
          ),
#          'admin'    => array(
#            'uri' => 'users',
#            'icon' => 'cog',
#          ),
          'settings'    => array(
            'uri' => URL::action('ApplicationController@getSettings'),
            'icon' => 'cog-alt',
          ),
          'logout'    => array(
            'uri' => URL::action('ApplicationController@getLogout'),
            'icon' => 'logout',
          ),
        );

        return $menu;

      default:
        throw new \InvalidArgumentException('The type argument is invalid.');
    }
  }

}
