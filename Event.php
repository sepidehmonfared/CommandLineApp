<?php

/**
 * Event Class 
 */
/* 

fetch('https://jsonplaceholder.typicode.com/posts', {
    method: 'POST',
    body: JSON.stringify({
      title: 'foo',
      body: 'bar',
      userId: 1
    }),
    headers: {
      "Content-type": "application/json; charset=UTF-8"
    }
  })
   */
class Event
{
    const URL = "https://jsonplaceholder.typicode.com/comments"; 

    /**
     * Create self 
     * 
     * @return Event
     */
    public static function create() 
    {
        return new self;
    }

    /**
     * Post Data
     * 
     * @param $data array
     * 
     * @return mixed
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