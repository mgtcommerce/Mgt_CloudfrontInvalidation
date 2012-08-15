#!/bin/sh

# find and deletes dead symlinks
#cd /var/www/magento1510/htdocs && find -L . -type l -delete

lns -afFr /var/www/Mgt_CloudfrontInvalidation/htdocs/app/ /var/www/magento1510/htdocs/app/