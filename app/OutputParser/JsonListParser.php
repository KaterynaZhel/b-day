<?php

namespace App\OutputParser;

use Stringable;

class JsonListParser implements Stringable
{
    public function __toString()
    {
        return <<<TEXT
RESPONSE FORMAT INSTRUCTIONS
----------------------------
When responding to me please, please output the response in the following format:

{{{{
    "data": array
    {
        "id": 1,
        "gift name": "",
    }
}}}}
All responses must adhere to the format of RESPONSE FORMAT INSTRUCTIONS.
The first key must be "id", value "1"
The next value of key "id" should increase by 1.
The second key must be "gift name".
Add a specific gift option in the key "gift name".
All values in "gift name" should be in the ukrainian language
The number of gift options should not be less than 7. 
Remember to respond with a json blob with a few key, and NOTHING else.
TEXT;
    }
}