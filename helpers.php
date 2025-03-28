<?php
use ParagonIE\HiddenString\HiddenString;

function generateSecurePassword() {
    return (new HiddenString(random_bytes(25)))->getString();
}