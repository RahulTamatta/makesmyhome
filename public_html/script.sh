#!/bin/bash
(crontab -l | grep -v "/usr/bin/php /home/housecraft/public_html/artisan email:send-renewal-reminder") | crontab -
(crontab -l; echo "0 0 * * * /usr/bin/php /home/housecraft/public_html/artisan email:send-renewal-reminder") | crontab -
