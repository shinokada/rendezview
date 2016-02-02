<?php

return array(

    'driver' => 'smtp',

    'host' => 'smtp.mandrillapp.com',

    'port' => 465,

    'from' => array('address' => '', 'name' => 'RendezView'),

    'encryption' => 'ssl',

    'username' => '',

    'password' => '',

    'sendmail' => '/usr/sbin/sendmail -bs',

    'pretend' => false,

);
