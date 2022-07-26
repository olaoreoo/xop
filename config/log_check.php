<?php
//if (!isset($_SESSION)) { session_start(); }
if ((function_exists('session_status')
    && session_status() !== PHP_SESSION_ACTIVE) || !session_id()) {
    session_start();
}
