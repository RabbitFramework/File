<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 01/12/2018
 * Time: 10:37
 */

namespace Rabbit\File\Drivers;

use Rabbit\File\File;

/**
 * Class Ini
 * @package Rabbit\File\Drivers
 */
class Ini implements DriverInterface
{

    /**
     * @var string
     */
    public $path;
    /**
     * @var array
     */
    public $keys;

    /**
     * Ini constructor.
     *
     * @throws DriverException
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        $this->keys = $this->parse();
    }

    public function setPath(string $path) {
        $this->path = $path;
        return $this;
    }

    public function getPath() : string {
        return $this->path;
    }

    /**
     * @throws DriverException;
     * @return array
     */
    public function parse() {
        if(File::isFile($this->path) && File::getExtension($this->path) === 'ini') {
            $content = File::getContent($this->path);
            $keys = [];
            preg_match_all('/^(.*=.*[^=]*)$/m', $content, $lineMatches);
            foreach ($lineMatches[0] as $lineMatch) {
                preg_match('/([\w]+)=([\w]*)/', $lineMatch, $valuesMatch);
                if(isset($valuesMatch[1]) && isset($valuesMatch[2])) {
                    $keys[$valuesMatch[1]] = $valuesMatch[2];
                }
            }
            return $keys;
        } else {
            throw new DriverException("[Rabbit => File->Ini::parse()] The given file with the path $this->path is not a file or is not an ini file");
        }
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function setKey(string $name, $value, bool $quote = true) {
        $this->keys[$name] = ($quote) ? '"'.$value.'"' : $value;
        $this->updateKeys();
        return $this;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getKey(string $name) {
        if($this->hasKey($name)) {
            return $this->keys[$name];
        }
    }

    public function updateKeys() {
        $keys = '';
        foreach ($this->keys as $name => $value) {
            $keys .= $name.'='.$value."\n";
        }
        $this->setContent($keys);
        return $this;
    }

    /**
     * @param string|array $content
     */
    public function setContent($content) {
        File::putContent($this->path, $content);
    }

    /**
     * @param string $name
     * @return bool
     */public function hasKey(string $name) {
        return isset($this->keys[$name]);
    }

}