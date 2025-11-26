<?php
session_start();
function isAuth()
{
    return isset($_SESSION["id"]) && isset($_SESSION["role"]);
}

function isAdmin()
{
    return isset($_SESSION["role"]) && $_SESSION["role"] === "ADMIN";
}

function requireAdmin()
{
    if (!isAdmin()) {
        header("Location: /blog");
        exit();
    }
}
