
<?php
$settings = array(
    'hosts' => ['pandemic.lv' => 'Latvia', 'pandemic.lt' => 'Lithuania', 'pandemic.ee' => 'Estonia'],
    'host' => 'pandemic.lv',
    'fullAddress' => 'https://pandemic.lv/',
    'documentRoot' => '/var/www/vhosts/pandemic.lv/httpdocs',
    'upload' => array(
        'path' => array(
            'images' => 'uploads/images/'
        )
    ),
    'database' => array(
        'hostname' => 'localhost',
        'username' => 'pandemic',
        'password' => 'qQd4q6$3qQd4q6$3',
        'database' => 'pandemic'
    ),
    'facebook' => array(
        'app' => array(
            'id' => '1978506749088526',
            'secret' => '2f77eaedb349d0e9010b193e5325b0f3'
        )
    ),
    'categories' => array(
        'penpals' => 'Pen-pals',
        'volunteer' => 'Ready to help',
        'delivery' => 'Delivery',
        'health' => 'Health',
        'fitness' => 'Fitness',
        'food' => 'Food',
        'entertainment' => 'Entertainment',
        'business' => 'Business',
        'services' => 'Services',
        'other' => 'Other'
    )
);

if(in_array($_SERVER['REMOTE_ADDR'], array('localhost'))){
    //localhost
    $settings = array(
        'hosts' => ['localhost' => 'Latvia', ],
        'host' => 'localhost',
        'fullAddress' => 'http://localhost/',
        'documentRoot' => '/var/www/public',
        'upload' => array(
            'path' => array(
                'images' => 'uploads/images/'
            )
        ),
        'database' => array(
            'hostname' => 'sovas.id.lv',
            'username' => 'newartic_pandemic',
            'password' => 'pandemic2012@',
            'database' => 'newartic_pandemic'
        ),
        'facebook' => array(
            'app' => array(
                'id' => '1978506749088526',
                'secret' => '2f77eaedb349d0e9010b193e5325b0f3'
            )
        ),
        'categories' => array(
            'penpals' => 'Pen-pals',
            'volunteer' => 'Ready to help',
            'delivery' => 'Delivery',
            'health' => 'Health',
            'fitness' => 'Fitness',
            'food' => 'Food',
            'entertainment' => 'Entertainment',
            'business' => 'Business',
            'services' => 'Services',
            'other' => 'Other'
        )
    );

    $settings['latitude'] = '56.946618';
    $settings['longitude'] = '24.097274'; 
}else{
    //production
    $host = $_SERVER['HTTP_HOST'];
    if (!isset($host) || !in_array($host, array_keys($settings['hosts']))) {
        header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request');
        exit;
    } else {
        $settings['host'] = $host;
        $settings['fullAddress'] = 'https://'.$host.'/';
        $settings['country'] = $settings['hosts'][$host];
        if ($settings['country'] == 'Latvia') {
            $settings['latitude'] = '56.946618';
            $settings['longitude'] = '24.097274';
        } else if ($settings['country'] == 'Lithuania') {
            $settings['latitude'] = '55.256577354959624';
            $settings['longitude'] = '24.17143171484375';
        }
    }
}



