<?php
// Routes

$app->get('/profile/facebook/{facebook-id}', function ($request, $response, $args) {

    return json_encode(['name' => 'Jorge Nuñez']);
});
