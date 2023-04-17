<?php

function is_production () {
  return env("APP_ENV", "development") === "production";
}

