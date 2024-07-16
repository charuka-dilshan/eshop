<?php

session_start();

if ($_SESSION["u"]) {

    $_SESSION["u"] = null;
    session_reset();
    session_destroy();
    echo("success");
}
