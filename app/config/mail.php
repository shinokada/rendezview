<?php

return array(

    'driver' => 'smtp',

    'host' => 'box1003.bluehost.com',

    'port' => 465,

    'from' => array('address' => 'hello@evan.so', 'name' => 'RendezView'),

    'encryption' => 'ssl',

    'username' => 'hello@evan.so',

    'password' => '',

    'sendmail' => '/usr/sbin/sendmail -bs',

    'pretend' => false,

);
