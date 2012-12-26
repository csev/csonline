<?php

function isAdmin() {
   return isset($_SESSION['admin']);
}

function loggedIn() {
   return isset($_SESSION['id']);
}

