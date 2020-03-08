<?php
// run this command before create ssl and apache virtual host

// sudo /bin/bash /var/www/storecreator.io/domaindns create example.com

$outPut = shell_exec("echo 'New@Store5000New' | sudo -S /usr/bin/bash /var/www/storecreator.io/virtualhost create Newstoressss.storecreator.io");
$outPut2 = shell_exec("echo 'New@Store5000New' | sudo -S ls /usr/bin/certbot -d Newstoressss.storecreator.io --no-redirect");
echo "<pre>$outPut</pre>";
echo "<pre>$outPut2</pre>";
?>
