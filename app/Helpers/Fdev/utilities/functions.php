<?php

function is_production () {
  return env("APP_ENV", "development") === "production";
}


function crypto_status_up ($str) {
  return $str === "icon-Caret-up" ? "up" : "down";
}