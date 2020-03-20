
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
        'quarantine' => 'Quarantine',
        'isolating' => 'Isolation',
        'volunteer' => 'Volunteering',
        'services' => 'Services',
        'other' => 'Other'
    )
);

$host = $_SERVER['HTTP_HOST'];
if (!isset($host) || !in_array($host, array_keys($settings['hosts']))) {
    header($_SERVER['SERVER_PROTOCOL'].' 400 Bad Request');
    exit;
} else {
    $settings['host'] = $host;
    $settings['fullAddress'] = 'https://'.$host.'/';
    if ($host == 'pandemic.lv') {
        $settings['country'] = $config['hosts'][$host];
        if ($settings['country'] == 'Latvia') {
            $settings['latitude'] = '56.946618';
            $settings['longitude'] = '24.097274';
        } else if ($settings['country'] == 'Lithuania') {
            $settings['latitude'] = '55.256577354959624';
            $settings['longitude'] = '24.17143171484375';
        }
    }
}
die(print_r($settings['latitude']));