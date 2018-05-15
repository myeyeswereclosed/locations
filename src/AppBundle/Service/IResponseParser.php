<?php
/**
 * Created by PhpStorm.
 * User: belov
 * Date: 13.05.18
 * Time: 18:47
 */

namespace AppBundle\Service;


interface IResponseParser
{
    /**
     * @param string $data
     * @return mixed
     */
    public function parse(string $responseData);
}