<?php

namespace App\OutputParser;

use Stringable;

class JsonPromParser implements Stringable
{
    public function __toString()
    {
        return <<<TEXT
RESPONSE FORMAT INSTRUCTIONS
----------------------------
When responding to me, please output the response in the format of array that contains only ids values without any keys.
The id is a serial number of gift in source json and begins from 0. 
For example: [0,3,5,7,8];
All responses must adhere to the format of RESPONSE FORMAT INSTRUCTIONS. 
Remember to respond with a json blob with a few values, and NOTHING else.
TEXT;
    }
}