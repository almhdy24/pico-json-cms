<?php
/**
 * Pico JSON CMS - Admin Configuration
 *
 * Author: Elmahdi
 * GitHub: https://github.com/almhdy24/pico-json-cms
 * Description:
 *   Admin credentials configuration file with security protection.
 *
 * License: MIT
 */

if (
  php_sapi_name() !== "cli" &&
  basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])
) {
  die("Access denied");
}

return [
  "admin_user" => "admin", // change to a strong username
  "admin_pass" => password_hash("secret123", PASSWORD_DEFAULT), // strong password hash
];