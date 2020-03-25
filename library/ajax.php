<?php
if (empty($_POST)) exit;
use \League\Csv\Reader;

header('Content-Type: application/json');
require_once 'init.php';

$a          = $_POST['a']; // action
$m          = $_POST['m']; // method
$errors     = [];

if (in_array($a, array_keys($settings['xhr'])) && in_array($m, $settings['xhr'][$a])) {
    /* DATA */
    if ($a === 'data') {
        /* Fetch all data */
        if ($m === 'fetch') {
            $csv = Reader::createFromPath('../data.csv', 'r');
            $csv->setHeaderOffset(0);
            jD('data', $csv);
        } else if ($m === 'global') {
            $csv = Reader::createFromPath('../combined.csv', 'r');
            $csv->setHeaderOffset(0);
            jD('global', $csv);
        }
    /* PROFILES */
    } else if ($a === 'profile') {
        if ($m === 'save') {
        /* Save a profile */
            if (empty($_SESSION['facebook']['id']))
                $errors[] = 'You need to authorize first.';
            if (strlen($_POST['status']) > 25)
                $errors[] = 'Your status is too long, should be no more than 25 symbols.';
            if (strlen($_POST['description']) > 400)
                $errors[] = 'Description is too long.';
            if (!in_array($_POST['category'], array_keys($settings['categories'])))
                $errors[] = 'Please choose a category which best suits you.';

            if (empty($errors)) {
                $db->update('users', [
                    'pseudo' => $_POST['pseudo'],
                    'status' => $_POST['status'],
                    'category' => $_POST['category'],
                    'display' => $_POST['display'],
                    'description' => $_POST['description']
                ], ['id' => $_SESSION['facebook']['id']]);

                unset($_SESSION['images']);
                jD('id', $db->insertid);
            } else {
                jD('errors', $errors);
            }
        }
    /* PLACES */
    } else if ($a === 'places') {
        /* Fetch all places */
        if ($m === 'fetch') {
            $output     = [];
            $places     = $db->getRows("SELECT * FROM %s WHERE `latitude`!='' AND `longitude`!=''", $db->table('places'));
            $photopath  = $settings['fullAddress'].$settings['upload']['path']['images'];
            $category   = $_POST['category'] ?: NULL;
    
            foreach ((array)$places as $place) {
                if (!empty($category) && $category != $place['category'])
                    continue;
                
                $place['photos'] = json_decode($place['photos']);
                foreach ((array)$place['photos'] as $id => $photo) {
                    if ($id === 0) { $place['icon'] = $photopath.$photo->name.'_c300.'.$photo->ext; }
                    $gallery[] = '<a href="'.($photopath.$photo->name.'.'.$photo->ext).'"><img src="'.($photopath.$photo->name.'_c300.'.$photo->ext).'" alt="'.(htmlspecialchars($place['title'])).' #'.($id+1).'"></a>';
                }
    
                if ($place['user'] === $_SESSION['facebook']['id'])
                    $delete = '<br/><p><a href="'.$settings['fullAddress'].'?delete='.$place['id'].'" onclick="return confirm(\'Sure?\');" style="color: red;">Remove from map</a></p>';
    
                $output[] = [
                    'id'            => $place['id'],
                    'title'         => $settings['categories'][$place['category']],
                    'description'   => nl2br(htmlspecialchars($place['description'])).$delete,
                    'subtitle'      => $place['title'],
                    'gallery'       => join("", $gallery),
                    'img'           => $place['icon'],
                    'icon'          => $place['icon'],
                    'latitude'      => $place['latitude'],
                    'longitude'     => $place['longitude']
                ];
            }
    
            jD('places', $output);
        }
        /* Create a new place */
        else if ($m === 'create') {
            if (empty($_SESSION['facebook']['id']))
                $errors[] = 'You need to authorize first.';
            if (strlen($_POST['title']) > 25)
                $errors[] = 'Your title is too long, should be no more than 25 symbols.';
            if (strlen($_POST['description']) > 400)
                $errors[] = 'Description is too long.';
            if (strlen($_POST['title']) < 4)
                $errors[] = 'Title should consist from at least 4 symbols.';
            if (strlen($_POST['description']) < 10)
                $errors[] = 'Description should consist from at least 10 symbols.';
            if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
                $errors[] = 'The specified e-mail address is invalid. P.S. E-mail is optional.';
            if (!in_array($_POST['category'], array_keys($settings['categories'])))
                $errors[] = 'Please choose a category which best suits you.';

            if (empty($errors)) {
                $db->insert('places', [
                    'title'         => $_POST['title'],
                    'description'   => $_POST['description'],
                    'email'         => $_POST['email'],
                    'phone'         => $_POST['phone'],
                    'website'       => $_POST['website'],
                    'category'      => $_POST['category'],
                    'photos'        => json_encode($_SESSION['images']),
                    'user'          => $_SESSION['facebook']['id'],
                    'latitude'      => $_POST['latitude'],
                    'longitude'     => $_POST['longitude']
                ]);

                unset($_SESSION['images']);
                jD('id', $db->insertid);
            } else {
                jD('errors', $errors);
            }
        }
        /* Set location for the newly created place */
        else if ($m === 'location') {
            if (empty($_POST['place']) || !is_numeric($_POST['place']))
                $errors[] = 'Missing parameter.';
            if (empty($_POST['lat']) || empty($_POST['lng']))
                $errors[] = 'Not quite catching those coordinates.';
            if (empty($_SESSION['facebook']['id']))
                $errors[] = 'You need to authorize first.';

            $place = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->table('places'), $_POST['place']);
            if (empty($place))
                $errors[] = 'This place is unavailable, or has never existed.';
            if ($place['user'] != $_SESSION['facebook']['id'])
                $errors[] = 'Are you trying to h4ck? Hit us up @ info@pandemic.lv, we like those who break stuff.';

            if (empty($errors)) {
                $db->update('places', [
                    'latitude' => $_POST['lat'],
                    'longitude' => $_POST['lng']
                ], [
                    'id' => $_POST['place'],
                    'user' => $_SESSION['facebook']['id']
                ]);

                jD('result', 'success');
            } else {
                jD('errors', $errors);
            }
        }
    } else if ($a === 'people') {
        /* Fetch peoples locations */
        if ($m === 'fetch') {
            $output     = [];
            $locations  = $db->getRows("SELECT * FROM %s WHERE `fbid` != 0", $db->table('locations'));

            foreach ((array)$locations as $location) {
                $userData = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->table('users'), $location['fbid']);

                // If a category is set, filter out by it
                if (!$userData['display'] !== 1)
                    continue;
                else if (!empty($_POST['c']) && in_array($_POST['c'], array_keys($settings['categories'])) && $userData['category'] !== $_POST['c'])
                    continue;

                $nameDetails = explode(" ", trim($userData['name']));
                $namePublic = $nameDetails[0].'&nbsp;'.mb_substr((string)$nameDetails[1],0,1,"UTF-8").'.';

                $output[] = [
                    'id'        => $location['fbid'],
                    'latitude'  => $location['latitude'],
                    'longitude' => $location['longitude'],
                    'img'       => $userData['picture'],
                    'name'      => $userData['pseudo'] ?: $namePublic,
                    'status'    => $userData['status'],
                    'category'  => $userData['category'],
                    'seen'      => $userData['lastlogin']
                ];
            }

            jD('locations', $output);
        /* Update visitors coordinates in database */
        } else if ($m === 'set') {
            $db->insert('locations', [
                'fbid' => $_SESSION['facebook']['id'],
                'latitude' => $_POST['lat'],
                'longitude' => $_POST['lng']
            ], true);
        }
    /* Everything CHAT related start here */
    } else if ($a === 'chat') {
        switch ($m) {
            case 'send':
                // check if sender is not blocked by receiver, if private
                // check if sender has joined the room where he's sending
                // check if sender not banned from the room
                $type = $_POST['t'];

                if (!in_array($type, $settings['chatbox']['types']))
                    jD('error', 'Bad Request.');
                
                $lastMessage = $db->getRow("SELECT * FROM %s WHERE `sender`='%d' ORDER BY `time` DESC LIMIT 1", $db->table('messages'), $_SESSION['facebook']['id']);
                if ((strtotime("now") - strtotime($lastMessage['time']) / 1000) < $settings['chatbox']['antiFlood'][$type]) {
                    jD('warning', "Please wait more time, before sending another message.");
                }

                $db->insert('messages', [
                    'sender' => $_SESSION['facebook']['id'],
                    'receiver' => $_POST['r'],
                    'message' => $_POST['msg'],
                    'type' => $type
                ]);

                jD('success', time());
            break;

            case 'rooms':
                $output = [];
                $output['rooms'] = $db->getRows("SELECT * FROM %s WHERE `private`='0'", $db->table('chatrooms'));
                jD('rooms', $output['rooms']);
            break;

            case 'fetch':
                $output = [];
                $output['msgs'] = $db->getRows("SELECT * FROM %s WHERE `receiver`='%d'", $db->table('messages'), $_SESSION['facebook']['id']);
                jD('msgs', $output['msgs']);
            break;
        }
    }
}
