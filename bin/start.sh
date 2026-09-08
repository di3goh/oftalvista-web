#!/bin/sh
set -eu
php /var/www/html/bin/setup.php
exec apache2-foreground
