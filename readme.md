### Desafio Dextra

#### Justificativa de design de código

##### Backend - PHP
Eu poderia ter optado em utilizar um framework de mercado como o Laravel (o qual domino plenamente), mas como a ideia do 
desafio é mostrar um pouco do meu código, decidi seguir com uma abordagem mais framework-agnostic, sendo assim fiz apenas uso de
bibliotecas como ReactPHP, League/Fractal, League/Container, League/Router etc.

Além dessa abordagem, segui um modelo de implementação baseado no DDD (Domain Driven Design - Eric Evans), a ideia
é tentar expressar ao máximo os elementos de domínio (no caso o próprio desafio) em código, isso se reflete em nomes de 
classes, métodos e a separação da camada de domínio das demais camadas (Application e Infrastructure).
No mais, toda a implementação foi feita do zero, seguindo boas práticas de Clean Code e princípios SOLID.


##### Frontend - React.JS
Para o front optei por utilizar o React.JS, mas poderia ter feito o mesmo em Angular ou Vue.js, foi mais uma escolha por gosto,
confesso que gostaria de ter implementado uma store com Redux e RxJS, mas o tempo não me permitiu, acabei dando foco maior no backend


##### Infra - Docker compose

Para a infra, optei pelo docker compose por ser ser uma solução simples e rápida (dado o nível do problema). Basicamente
criei 3 conteineres, sendo um para o backend com PHP 7.3 (optei pelo CLI já que estou utilizando o ReactPHP como server HTTP), 
outro para para o frontend com NodeJS 10.15, e por fim o container do nginx que é responsável por fazer o proxying tanto
das requests do front como do back, em ambos os casos encaminhando as requisições para a porta interna 3000 das 
respectivas aplicações.

#### Requisitos

Para execução do projeto é necessário ter os seguintes softwares instalados:

 - Docker
 - Docker compose
 
 **Importante*** 
 
 O container do nginx vai fazer listen na porta 80, logo certificar que não há nenhum outro serviço rodando nessa porta.
 
#### Instruções para execução
 
Clonar esse repositório, e na raiz do projeto (onde se encontra o docker-compose.yml), executar o comando:
 
```
docker-compose up
```

Por fim, em um navegador web acessar a aplicação em http://127.0.0.1/

#### Testes

Para a execução dos testes, rodar o script run-tests.sh que se encontra na raiz da app.
Também por questão de tempo não pude configurar o circle-ci para integração dos testes.

```
./run-tests.sh
```
