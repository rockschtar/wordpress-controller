<?php
/**
 * @author: StefanHelmer
 */

namespace Rockschtar\WordPress\Controller;

abstract class Controller {

    private function __construct() {
        $this->hooks();
    }

    abstract public function hooks(): void;

    /**
     * @return static
     */
    public static function &init() {
        static $instance = null;
        /** @noinspection ClassConstantCanBeUsedInspection */
        $class = \get_called_class();
        if($instance === null) {
            $instance = new $class();
        }
        return $instance;
    }


}