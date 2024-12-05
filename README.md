# Customer Registration
Aplicação web que pode ser evoluída de forma simples e que permite o gerenciamento de clientes, utilizando a stack `PHP` com `Laravel` para o backend, e `jQuery` e `Bootstrap` para o frontend, através do template `AdminLTE`, com o banco de dados `MySQL`.

## Requisitos necessários excução do  projeto 

 > Docker  
 >

 ## Como executar o projeto 

  1. Primeiro realize a clonagem para sua máquina do repositório [customerRegistration](https://github.com/themarcosramos/customerRegistration).

  2. Após isso ainda diretório raiz do projeto execute : 

```bash
docker-compose up --build -d
```
  3. Ainda no diretório raiz do projeto execute : 

```bash
sudo chmod -R 775 storage bootstrap/cache
```

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
```
  Dando as permissões necessárias para esta pasta.

 4. Em seguinda execute : 

```bash
docker-compose ps 
```
  Para lista o status dos contêineres para verificar se está tudo em execução.

 5. Agora execute :

```bash
docker exec -it laravel_app bash
```
  Para acessar terminal  do contêiner da app

 6. no terminal do contêiner execute  o composer atraves do comando :

```bash
composer install
```
 
 7. gere uma nova chave de aplicação e configurá-la com  o comando : 

```bash
php artisan key:generate
```
 8. Agora execute as migrations do laravel: 

```bash
php artisan migrate
```
 9. Inicie o servidor laravel :

```bash
php artisan serve --host=0.0.0.0 --port=8080
```
Quando você terminar de usar o servidor laravel, pressione `Ctrl + C` no terminal onde o servidor está em execução para encerrá-lo. E para sair do contêiner, basta digitar `exit` no terminal.

## Para usar o pprojheto apos a configuração 

É só roda o comando comando 

```bash
docker-compose up -d  
```

Iniciar o servidor laravel :

```bash
php artisan serve --host=0.0.0.0 --port=8080
```

Quando você terminar de usar o servidor laravel, pressione `Ctrl + C` no terminal onde o servidor está em execução para encerrá-lo. E para sair do contêiner, basta digitar `exit` no terminal.

 ### Demostração de uso  

![Demonstração de Uso da aplicação ](/gif/gravacao_de_teste.gif)

![Demonstração de Uso da aplicação ](/gif/gravacao.gif)
