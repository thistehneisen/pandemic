<?php
require_once 'init.php';

if (!empty($_POST)) {
    $action = $_POST['action'];
    $errors = array();

    header('Content-Type: application/json');

    if ($action == 'add') {
        if (empty($_SESSION['facebook']['id']))
        $errors[] = 'Please, log in first.';
        if (strlen($_POST['title']) > 80)
        $errors[] = 'The title is too long.';
        if (strlen($_POST['description']) > 360)
        $errors[] = 'Description is too long.';
        if (strlen($_POST['title']) < 4)
        $errors[] = 'Title should have at least 4 symbols.';
        if (strlen($_POST['description']) < 10)
        $errors[] = 'Description should have at least 10 symbols.';
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = 'Specified e-mail address isn\'t valid.';
        if (!in_array($_POST['category'], array_keys($settings['categories'])))
        $errors[] = 'Please choose a category from the list.';

        if (empty($errors)) {
            $db->insert('classifieds', array(
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'price' => str_replace(',', '.', $_POST['price']),
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'category' => $_POST['category'],
                'photos' => json_encode($_SESSION['images']),
                'user' => $_SESSION['facebook']['id'],
                'latitude' => $_POST['latitude'],
                'longitude' => $_POST['longitude']
            ));

            unset($_SESSION['images']);

            die(json_encode(array('id' => $db->insertid)));
        } else {
            die(json_encode(array('errors' => $errors)));
        }
    } else if ($action == 'userlocations') {
        $output = array();
        $locations = $db->getRows("SELECT * FROM %s", $db->locations);
        foreach ((array)$locations as $location) {
            $userdata = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->users, $location['fbid']);
            $output[] = [
                'id' => $location['fbid'],
                'lat' => $location['latitude'],
                'lng' => $location['longitude'],
                'img' => $userdata['picture'],
                'name' => $userdata['name'],
                'status' => 'No status available.',
                'category' => 'isolating'
            ];
        }
        
        die(json_encode(array('locations' => $output)));
    } else if ($action == 'retrieve') {
        $output = array();
        $classifieds = $db->getRows("SELECT * FROM %s WHERE `latitude`!='' AND `longitude`!=''", $db->classifieds);
        $photopath = $settings['fullAddress'].$settings['upload']['path']['images'];
        $category = (isset($_POST['category']) ? $_POST['category'] : '');

        foreach ((array)$classifieds as $classified) {
            if (!empty($category) && $category != $classified['category'])
            continue;
            $gallery = array();
            $delete = '';
            $classified['photos'] = json_decode($classified['photos']);
            foreach ((array)$classified['photos'] as $id => $photo) {
                if ($id === 0)
                    $classified['icon'] = $photopath.$photo->name.'_c300.'.$photo->ext;
                $gallery[] = '<a href="'.($photopath.$photo->name.'.'.$photo->ext).'"><img src="'.($photopath.$photo->name.'_c300.'.$photo->ext).'" alt="'.(htmlspecialchars($classified['title'])).' #'.($id+1).'"></a>';
            }

            if ($classified['user'] == $_SESSION['facebook']['id'])
            $delete = '<br/><p><a href="'.$settings['fullAddress'].'?delete='.$classified['id'].'" onclick="return confirm(\'Are you sure you want to remove this area? This action cannot be undone..\');" style="color: red;">Delete area</a></p>';

            $output[] = array(
                'id' => $classified['id'],
                'title' => $classified['title'],
                'description' => nl2br(htmlspecialchars($classified['description'])).$delete,
                'price' => $classified['price'],
                'subtitle' => 'E-mail: <a href="mailto:'.$classified['email'].'">'.$classified['email'].'</a>'.(!empty($classified['phone']) ? '<br/>Phone: '.$classified['phone'] : ''),
                'gallery' => join("", $gallery),
                'icon' => $classified['icon'],
                'latitude' => $classified['latitude'],
                'longitude' => $classified['longitude']
            );
        }

        die(json_encode(array('classifieds' => $output)));
    } else if ($action == 'location') {
        if (empty($_POST['classified']) || !is_numeric($_POST['classified']))
        $errors[] = 'Can\'t identify the specified classified.';
        if (empty($_POST['lat']) || empty($_POST['lng']))
        $errors[] = 'Specified location has incorrect format.';
        if (empty($_SESSION['facebook']['id']))
        $errors[] = 'Please, log in first.';

        $classified = $db->getRow("SELECT * FROM %s WHERE `id`='%d'", $db->classifieds, $_POST['classified']);
        if (empty($classified))
        $errors[] = 'No classified with such ID.';
        if ($classified['user'] != $_SESSION['facebook']['id'])
        $errors[] = 'Not your classified. Developer/hacker? Write to us info@pandemic.lv';

        if (empty($errors)) {
            $db->update('classifieds', array(
                'latitude' => $_POST['lat'],
                'longitude' => $_POST['lng']
            ), array(
                'id' => $_POST['classified'],
                'user' => $_SESSION['facebook']['id']
            ));

            die(json_encode(array('result' => 'success')));
        } else {
            die(json_encode(array('errors' => $errors)));
        }
    } else if ($action == 'newlocation') {
        $db->insert('locations', [
            'fbid' => $_SESSION['facebook']['id'],
            'latitude' => $_POST['lat'],
            'longitude' => $_POST['lng']
        ], true);
    } else {
        die(json_encode(array('errors' => 'Unknown action')));
    }
}
