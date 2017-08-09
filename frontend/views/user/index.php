<?php

/** @var \frontend\models\Users $user */

echo '<pre>';
print_r($user->name);
echo '</pre>';

echo '<pre>';
print_r($user->phone);
echo '</pre>';

echo '<pre>';
print_r($user->email);
echo '</pre>';

echo '<pre>';
print_r($user->registration_type);
echo '</pre>';

echo '<pre>';
print_r($user->coupons);
echo '</pre>';

// ajax
// POST /coupons/add [name]