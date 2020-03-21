<?php
if (empty($_POST)) exit;

header('Content-Type: application/json');
require_once 'init.php';

$actions[] = [
                'chat' => ['send', 'msgs', 'rooms'], 
                'places' => ['create', 'location'],
                'people' => ['locations']
            ];

$a          = $_POST['a']; // action
$m          = $_POST['m']; // method
$errors     = [];
if (in_array($a, array_keys($actions)) && in_array($m, $actions[$a])) {

    /* PLACES */
    if ($a === 'places') {
        /* Create a new place */
        if ($m === 'create') {
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
                $db->insert('places', array(
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone'],
                    'website' => $_POST['website'],
                    'category' => $_POST['category'],
                    'photos' => json_encode($_SESSION['images']),
                    'user' => $_SESSION['facebook']['id'],
                    'latitude' => $_POST['latitude'],
                    'longitude' => $_POST['longitude']
                ));

                unset($_SESSION['images']);

                jD('id', $db->insertid);
            } else {
                jD('errors', $errors);
            }
        }

        /* Set location for the newly created place */
        if ($m === 'location') {
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
                ], [ 'id' => $_POST['place'], 'user' => $_SESSION['facebook']['id'] ];

                jD('result', 'success');
            } else {
                jD('errors', $errors);
            }
        }
    } else if ($a === 'people') {
        if ($m === 'locations') {
            $output = [];
            $locations = $db->getRows("SELECT * FROM %s WHERE `fbid` != 0", $db->table('locations'));

            foreach ((array)$locations as $location) {
                $userData = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->users, $location['fbid']);

                $nameDetails = explode(" ", trim($userdata['name']));
                $namePut = $nameDetails[0].'&nbsp;'.mb_substr((string)$nameDetails[1],0,1,"UTF-8").'.';

                $output[] = [
                    'id' => $location['fbid'],
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                    'img' => $userData['picture'],
                    'name' => htmlspecialchars($userData['pseudo'] ?? $namePut),
                    'status' => htmlspecialchars($userData['status']),
                    'category' => $userData['category'],
                    'seen' => $userData['lastlogin']
                ];
            }

            die(json_encode(array('locations' => $output)));
        }
    } else if ($action == 'retrieve') {
        $output = array();
        $places = $db->getRows("SELECT * FROM %s WHERE `latitude`!='' AND `longitude`!=''", $db->places);
        $photopath = $settings['fullAddress'].$settings['upload']['path']['images'];
        $category = (isset($_POST['category']) ? $_POST['category'] : '');

        foreach ((array)$places as $place) {
            if (!empty($category) && $category != $place['category'])
                continue;
            
            $gallery = array();
            $delete = '';
            $place['photos'] = json_decode($place['photos']);
            foreach ((array)$place['photos'] as $id => $photo) {
                if ($id === 0)
                    $place['icon'] = $photopath.$photo->name.'_c300.'.$photo->ext;
                $gallery[] = '<a href="'.($photopath.$photo->name.'.'.$photo->ext).'"><img src="'.($photopath.$photo->name.'_c300.'.$photo->ext).'" alt="'.(htmlspecialchars($place['title'])).' #'.($id+1).'"></a>';
            }

            if ($place['user'] == $_SESSION['facebook']['id'])
                $delete = '<br/><p><a href="'.$settings['fullAddress'].'?delete='.$place['id'].'" onclick="return confirm(\'Are you sure you want to remove this area? This action cannot be undone..\');" style="color: red;">Delete area</a></p>';

            $output[] = array(
                'id' => $place['id'],
                'title' => $place['title'],
                'description' => nl2br(htmlspecialchars($place['description'])).$delete,
                'price' => $place['price'],
                'subtitle' => 'E-mail: <a href="mailto:'.$place['email'].'">'.$place['email'].'</a>'.(!empty($place['phone']) ? '<br/>Phone: '.$place['phone'] : ''),
                'gallery' => join("", $gallery),
                'icon' => $place['icon'],
                'latitude' => $place['latitude'],
                'longitude' => $place['longitude']
            );
        }

        die(json_encode(array('places' => $output)));
    } else if ($action == 'newlocation') {
        $db->insert('locations', [
            'fbid' => $_SESSION['facebook']['id'],
            'latitude' => $_POST['lat'],
            'longitude' => $_POST['lng']
        ], true);
    } else {

        //my small world seperated from all other stuff
        $response = array();

        switch ($action) {
            case 'chat':
                
                $response = ['status' => 1];

                $channel = 'default';

                if (isset($_POST['channel']) && trim($_POST['channel']) != ''){
                    $channel = $_POST['channel'];
                }

                $db->insert('messages', [
                    'fbid' => $_SESSION['facebook']['id'],
                    'message' => $_REQUEST['message'],
                    'channel' => $channel
                ], true);

                break;

            case 'chat_items':

                // chat_items
                $response = ['status' => 1];

                $channel = 'default';

                if (isset($_POST['channel']) && trim($_POST['channel']) != ''){
                    $channel = $_POST['channel'];
                }

                $response['items'] = $db->getRows("SELECT * FROM %s WHERE channel = '%s'", "messages" , $channel);

                break;
            
            default:
                $response = array('errors' => 'Unknown action');
                break;
        }


        die(json_encode($response));
    }
}
