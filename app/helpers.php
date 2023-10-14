<?php


use App\Exceptions\DumpAPIException;

/**
 * @param mixed $data
 * @return mixed
 * @throws DumpAPIException
 */
function ddapi(mixed $data){
    throw new DumpAPIException($data);
}
