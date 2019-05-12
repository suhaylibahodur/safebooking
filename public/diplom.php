<?php
    echo "sdfsdf";
    //GET TOKEN
    /*$permissions = [
        'notify', 'friends', 'photos', 'audio', 'video', 'docs', 'notes',
        'pages', 'status', 'wall', 'groups', 'email', 'notifications',
        'stats', 'ads', 'market', 'offline'
    ];
    $request_params = [
        'client_id' => '6976005',
        'redirect_uri' => 'https://oauth.vk.com/blank.html',
        'response_type' => 'token',
        'display' => 'page',
        'scope' => implode(',', $permissions),
        'v' => '5.95',
    ];

    $url = 'https://oauth.vk.com/authorize?'.http_build_query($request_params);
    echo $url;*/

    //TOKEN-VK: 7b66bbc0eb05f4ee19941f5b9e616fd98c84831bbc068d742586969908e6b85584b4cadfb08a67e221445

    $metods = [
        'search' => 'newsfeed.search',
        'wall' => 'wall.get'
    ];
    $queryText = 'потому что я устал';

    $request_params = array(
//        'q' => $queryText,
        'owner_id' => '-83556825',
        'count' => 100,
        'offset' => 0,
        'v' => '5.95',
        'access_token' => '7b66bbc0eb05f4ee19941f5b9e616fd98c84831bbc068d742586969908e6b85584b4cadfb08a67e221445'
    );
    $get_params = http_build_query($request_params);
    $result = json_decode(file_get_contents('https://api.vk.com/method/'.$metods['wall'].'?'. $get_params));
    foreach ($result->response->items as $post) {
//        var_dump($post);
        $text = $post->text;
        $text = validText($text);
        if (isset($post->copy_history[0]->text)) {
            $historyText = $post->copy_history[0]->text;
            $historyText = validText($historyText);
            $text .= ' '.$historyText;
        }
        if ($text != "" and $text != " ") {
            echo $text . "<br><hr><br>";
//            $myfile = file_put_contents('suicide-dataset.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);
        }
    }

    function isValidLetter($char) {
        return (!( ($char == '#') or ($char >= 'a' and $char <= 'z') or ($char >= 'A' and $char <= 'Z') or ($char >= 'а' and $char <= 'я') or ($char >= 'А' and $char <= 'Я') ));
    }

    function validText($text) {
        $text = str_replace(array("\n", "\r", ",","(", ")", ".", "?", "!", "#", "–", "—", "»", "«","…","_","\"", "-", ":", "\\", "©", "❤", "🤫", "😂", "💔", "✨", "🤦‍♀️", "🔗","📚", "🇰🇿", "😉","😂","👠"), ' ', $text);
        $text = trim($text);
        return $text;
    }



    //TWITTER



