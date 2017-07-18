<?php
// Routes

/*** Web Routea ***/
$app->get(
    '/',
    'Aivo\WebController:IndexAction'
);

/*** Profile Routes  ***/
$app->get(
    '/profile/facebook/{facebookId}',
    'Aivo\ProfileController:getFacebookUserByIdAction'
);
