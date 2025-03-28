<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// استبدال الدالة القديمة بالـ package
function randomPassword() {
    return generateSecurePassword();
}