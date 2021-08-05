<?php

function gravatar_url ($email)
{
    $email = md5($email);
    return "https://gravatar.com/avatar/{$email}?" . http_build_query([
            'size' => 60,
            'default' => 'https://s3.amazonaws.com/laracasts/images/default-square-avatar.jpg',
        ]);
}
