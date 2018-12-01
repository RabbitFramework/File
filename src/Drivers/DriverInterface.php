<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 01/12/2018
 * Time: 17:40
 */

namespace Rabbit\File\Drivers;


interface DriverInterface
{

    public function __construct(string $path);

    public function setPath(string $path);

    public function getPath() : string;

    public function parse();

}