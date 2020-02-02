<?php

/**
 * Class Event
 */

class Event
{
    const URL = "https://jsonplaceholder.typicode.com/comments";

    /**
     * @return Event
     */
    public static function create() 
    {
        return new self;
    }

    /**
     * @param array $data
     *
     * @return bool|string
     * @throws Exception
     */
    public function post(array $data)
    {
        $payload = json_encode($data);
  
        $ch  = curl_init(self::URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        curl_setopt(
            $ch, 
            CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload)
            )
        );

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        return $result;
    }
}