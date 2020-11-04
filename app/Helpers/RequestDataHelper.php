<?php

namespace App\Helpers;

class RequestDataHelper
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

        if ($data_json) {
            return $data_json;
        } else {
            echo 'No properties or values found in request!';
            return;
        }
    }
}
