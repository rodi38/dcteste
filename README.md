<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Sistema de Venda

Este é um teste feito com intuito de implementar um simples sistema de venda.

# Manual de instalação

Para rodar o projeto, inicialmente, é necessário ter o php 8.2+ e composer 2.7.9 bem como alguma versão do mysql. Uma boa opção é instalar o XAMP pois vem com o php e o mysql junto.

Primeiro de tudo é necessário clonar o projeto, no terminal digite o seguinte comando <code>git clone https://github.com/rodi38/dcteste.git</code>
Outra opção é baixar o projeto em formato zip clicando no botão <b><> Code</b> e escolhendo a opção <b>Download ZIP</b>

Com o clone feito terás alterar o nome da variável <code>.env.example</code> e parte de seu conteudo.

dessa forma:

ANTES:

```
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

DEPOIS:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=NomeDoSeuBanco
DB_USERNAME=SeuNomeDeUsuario
DB_PASSWORD=SuaSenha
```

Fique atento na hora de preencher estes campos, se tiver alguma informação errada o projeto não vai rodar!

após isso, rode os seguintes comandos no terminal, respectivamente:

<code>composer install</code>
<code>php artisan key:generate</code>
<code>php artisan migrate</code>

terminando essa leva de comandos pode rodar a aplicação com o seguinte comando no terminal: <code>php artisan serve</code>

# Explicação detalhada do projeto
