<?php

namespace ManiaLivePlugins\eXpansion\Core;

use \ManiaLive\Event\Dispatcher;
use \ManiaLive\Features\Tick\Listener as TickListener;
use \ManiaLive\Features\Tick\Event as TickEvent;
use \ManiaLive\Application\Event as AppEvent;
use ManiaLive\Utilities\Console;
use ManiaLivePlugins\eXpansion\Core\Structures\HttpQuery;
use ManiaLivePlugins\eXpansion\Core\Classes\Webaccess;

/**
 * Description of DataStorage
 *
 * @author Reaby
 */
class DataAccess extends \ManiaLib\Utils\Singleton implements \ManiaLive\Application\Listener, \ManiaLive\Features\Tick\Listener {

    /** \Webaccess */
    private $webaccess;
// these are used for async webaccess 
    private $read;
    private $write;
    private $except;

    public function __construct() {
        $this->read = array();
        $this->write = array();
        $this->except = array();
        $this->webaccess = new Webaccess();
    }

    public function start() {
//Dispatcher::register(TickEvent::getClass(), $this);
        Dispatcher::register(AppEvent::getClass(), $this);
    }

    public function onTick() {
        
    }

    function __destruct() {
        $this->webaccess = null;
        Dispatcher::unregister(TickEvent::getClass(), $this);
    }

    /**
     * Asynchromous httpGetter
     * 
     *
     * use callback function like below: <br><br>
     * function xcallback(string $data, int $http_code, $callparams1, $callparams2...) {
     * 
     * }
     * 
     * @param string $url usage: http://www.example.com?param=value
     * @param array $callback usage: array($this, "xCallback")
     * @param array $callparams usage: array($param1, $param2)
     * @param string $userAgent userAgent to be sent
     * @param string $mimeType header mimetype request -> defaults to "text/html"
     * @throws Exception
     */
    final public function httpGet($url, $callback, $callparams = array(), $userAgent = "ManiaLive - eXpansionPluginPack", $mimeType = "text/html") {
        if (!is_callable($callback))
            throw new Exception("Invalid Callback!");

        $this->_get(new HttpQuery($url, $callback, $callparams, $userAgent, $mimeType));
    }

    private function _get(HttpQuery $query) {
        $this->webaccess->request($query->baseurl . "?" . $query->params, array(array($this, "_process"), $query), null, false, 20, 3, 5, $query->userAgent, $query->mimeType);
    }

    /** @todo make queue and process it onPostLoop */
    final public function save($filename, $data) {
        clearstatcache();
        if (!is_file($filename)) {
            if (!touch($filename)) {
                chmod($filename, 0755);
                return false;
            }
        }
        clearstatcache();
        if (is_writable($filename)) {
            try {
                return file_put_contents($filename, $data, LOCK_EX);
            } catch (\Exception $e) {
                \ManiaLive\Utilities\Console::println("File write exception:" . $e->getMessage());
                return false;
            }
        }
    }

    /** @todo make queue and process it onPostLoop */
    final public function load($filename) {
        clearstatcache();
        if (!is_file($filename)) {
            return false;
        }
        if (is_readable($filename)) {
            try {
                return file_get_contents($filename);
            } catch (\Exception $e) {
                \ManiaLive\Utilities\Console::println("File read exception:" . $e->getMessage());
                return false;
            }
        }
    }

    public function _process($data, HttpQuery $query) {
        if (!is_callable($query->callback)) {
            \ManiaLive\Utilities\Console::println("[DataAccess Error] Callback-function is not valid!");
            return;
        }
        if ($data['Code'] == 301) {
            Console::println("[DataAccess] webRequest to " . $query->baseurl . " is permanently moved.");
            $args = $query->callparams;
            array_unshift($args, null, $data['Code']);
            call_user_func_array($query->callback, $args);

            if (!isset($data['Headers']['location'][0]))
                return;
// set new redirected address
            $query->baseurl = $data['Headers']['location'][0];

            $query->redirectCount++;

            if ($query->redirectCount < 3) {
                Console::println("[DataAccess] request redirection to " . $query->baseurl);
                $this->_get($query);
            } else {
                Console::println("[DataAccess] webRequest redirected more than 3 times, canceling request.");
            }
            return;
        }
// moved temporarily
        if ($data['Code'] == 302) {
            Console::println("[DataAccess] webRequest to " . $query->baseurl . " is temporarily moved.");
            
            $args = $query->callparams;
            array_unshift($args, null, $data['Code']);
            call_user_func_array($query->callback, $args);
            if (!isset($data['Headers']['location'][0]))
                return;
// set new redirected address
            $query->baseurl = $data['Headers']['location'][0];
            $query->redirectCount++;
            if ($query->redirectCount < 3) {
                Console::println("[DataAccess] request redirection to " . $query->baseurl);
                $this->_get($query);
            } else {
                Console::println("[DataAccess] webRequest redirected more than 3 times, canceling request.");
            }
            return;
        }
// access ok

        if ($data['Code'] == 200) {
            $outData = $data['Message'];

            $args = $query->callparams;
            array_unshift($args, $outData, $data['Code']);
            call_user_func_array($query->callback, $args);
        } else {
            $args = $query->callparams;
            array_unshift($args, null, $data['Code']);
            call_user_func_array($query->callback, $args);
        }
    }

    public function onInit() {
        
    }

    public function onPostLoop() {
        try {
            $this->webaccess->select($this->read, $this->write, $this->except, 0, 0);
        } catch (\Exception $e) {
            Console::println("[DataAccess] OnTick Update failed: " . $e->getMessage() . "\n file " . $e->getFile() . ":" . $e->getLine());
        }
    }

    public function onPreLoop() {
        
    }

    public function onRun() {
        
    }

    public function onTerminate() {
        
    }

}