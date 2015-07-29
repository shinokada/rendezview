<?php

return array(
 
    'driver' => 'smtp',
 
    'host' => 'box1003.bluehost.com',
 
    'port' => 465,
 
    'from' => array('address' => 'hello@evan.so', 'name' => 'RendezView'),
 
    'encryption' => 'ssl',
 
    'username' => 'hello@evan.so',
 
    'password' => 'any6r3jh',
 
    'sendmail' => '/usr/sbin/sendmail -bs',
 
    'pretend' => false,
 
);