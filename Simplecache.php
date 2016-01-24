<?php

class Simplecache{

    private $_memcache;
    private $_object;
    private $_ttl = 60;

    // -------------------------------------------------------------------
    // --------------------------------------------------------__construct
    /**
     * @param $object
     * @param int/null $ttl
     */
    public function __construct($object, $ttl = null)
    {
        $this->_memcache = new \Memcache();
        $this->_memcache->connect('localhost', 11211) or die ("Could not connect");

        $this->_object = $object;
        $this->set_ttl($ttl);
    }

    // -------------------------------------------------------------------
    // -------------------------------------------------------------__call
    /**
     * @param string $methodName
     * @param array $parameters
     * @return mixed
     */
    public function __call($methodName, $parameters)
    {
        // set cache_id
        $cache_id = md5($methodName . serialize($parameters));

        // check if cache id is valid
        if(($response = $this->_memcache->get($cache_id))===FALSE)
        {
            // if cache is not valid
            try
            {
                $class  = new ReflectionClass($this->_object);
                $method = $class->getMethod($methodName);
                $response = $method->invoke($this->_object, $parameters);

                // if response is given save to memcache
                if($response != false)
                    $this->_memcache->set($cache_id, $response, false, $this->get_ttl());
            }
            catch (ReflectionException $e)
            {
                // your exception
            }
        }

        return $response;
    }

    // -------------------------------------------------------------------
    // ----------------------------------------------------------------ttl
    /**
     * @param int $ttl
     */
    private function set_ttl($ttl)
    {
        if(is_int($ttl))
            $this->_ttl = $ttl;
    }

    // -------------------------------------------------------------------

    private function get_ttl()
    {
         return $this->_ttl;
    }

    // -------------------------------------------------------------------
}