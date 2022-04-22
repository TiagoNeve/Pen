# Informações sobre o que eu fiz

1. Connect to Starting Point VPN before starting the machine:
Para se conectar primeiro é necessário ter um arquivo .ovpn, para utilizar com o 
> sudo openvpn file.ovpn
Sempre verifique se é possível pingar o ip do tun0

2. Click to Spawn the machine
Clique no botão para iniciar a máquina

Ip da máquina: 10.129.179.137
Não veio mais informações, então isso é um Black-box


3. What does the acronym VM stand for?

Primeira coisa que devemos realizar é uma enumeração nesse ip, utilizando nmap
> nmap -sV --open 10.129.179.137

PORT   STATE SERVICE VERSION
23/tcp open  telnet  Linux telnetd
Service Info: OS: Linux; CPE: cpe:/o:linux:linux_kernel

Vamos ver se conseguimos algum banner
> nc -nv 10.129.179.137 23
## Virtual Machine

4. What tool do we use to interact with the operating system in order to start our VPN connection

## terminal

5. What service do we use to form our VPN connection?

## openvpn

6. What is the abreviated name for a tunnel interface in the output of your VPN boot-up sequence output?

## tun

7. What tool do we use to test our connection to the target?

## ping

8. What is the name of the tool we use to scan the target's ports?

## nmap

9. What service do we identify on port 23/tcp during our scans?

## telnet

10. What username ultimately works with the remote management login prompt for the target?

## root

11. Submit root flag

## b40abdfe23665f766f9c61ecba8a4c19