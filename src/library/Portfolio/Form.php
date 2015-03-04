<?php 

/**
 * Custom Form Class extending Zend Form
 */
class Portfolio_Form extends Zend_Form
{

    /**
     * Prefix path configuration
     * @var array
     */
    public static $prefixPaths = array();


    public function __construct()
    {

        if (! empty(self::$prefixPaths) ) {
            foreach (self::$prefixPaths as $type => $options) {

                foreach ($options as $namespace => $path) {
                    $this->addPrefixPath($namespace, $path, $type);
                }
            }
        }

        parent::__construct();
    }
}