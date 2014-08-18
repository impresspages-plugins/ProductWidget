<?php
function ipReplacePlaceholders($content, $context = 'Ip', $customValues = array())
{
    $userData = ipUser()->data();
    $userEmail = !empty($userData['email']) ? $userData['email'] : '';
    $userName = !empty($userData['name']) ? $userData['name'] : '';

    $values = array(
        '{websiteTitle}' => ipGetOptionLang('Config.websiteTitle'),
        '{websiteEmail}' => ipGetOptionLang('Config.websiteEmail'),
        '{websiteUrl}' => ipConfig()->baseUrl(),
        '{userId}' => ipUser()->userId(),
        '{userEmail}' => $userEmail,
        '{userName}' => $userName
    );

    foreach ($customValues as $key => $value) {
        $values['{' . $key . '}'] = $value;
    }

    $answer = strtr($content, $values);
    return $answer;

}
