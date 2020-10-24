<?php

namespace App\Helpers;

class JsonStackerHelper
{
    function __construct($request)
    {
        $this->request = $request;
    }

    public function stack()
    {
        $body = $this->request->getBody();
        $size = $body->getSize();

        echo "Size is ${size} bytes. \n";

        $data = $body->read($size);
        $data_json = json_decode($data, true);
        $stack = [];
        foreach ($data_json as $data) {
            array_push($stack, $data);
        }

        if (count($stack) > 0) {
            return $stack;
        } else {
            echo 'No properties or values found in request!';
            return;
        }
    }
}
