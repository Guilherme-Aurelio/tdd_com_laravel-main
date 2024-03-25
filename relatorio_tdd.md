### Relatório Textual de Teste de Software: Desenvolvimento de Projeto com TDD

#### Discentes: Andriéria Dantas, Bruno Pithon, Guilherme Aurélio, João Paulo e Kelvin Marques.

[Repositório no Github](https://github.com/brunopithon/tdd_com_laravel/tree/main) 

---
#### 1. Visão Geral do Projeto	
A proposta do projeto foi o desenvolvimento de um aplicativo de lista de compras que permita aos usuários criar e gerenciar listas de compras, adicionar itens, definir quantidades e marcar itens como comprados, o projeto foi desenvolvido utilizando conceitos de Test Driven Development (TDD) com ênfase na criação de testes automatizados.

#### 2. Funcionalidades principais 
- Criação de Listas de Compras;
- Adição de Itens;
- Visualização de Listas de Compras;
- Adição de Quantidade de Itens;
- Marcação de Itens como Comprados;
- Exclusão de Itens;
- Exclusão de Listas de Compras.

#### 3. Tecnologias
O projeto será desenvolvido utilizando as seguintes tecnologias:
- PHP: Linguagem de programação principal do projeto, utilizada em conjunto com o framework Laravel para o desenvolvimento da aplicação. 
- Laravel: Framework PHP utilizado para facilitar o desenvolvimento ágil e eficiente da aplicação, fornecendo boa estrutura e um conjunto de ferramentas úteis para o desenvolvimento e testes. 
- MySQL: Banco de dados relacional utilizado para armazenar os dados das listas de compras e dos usuários.
- SQLite: Banco de dados em memória.
- Angular: Framework TypeScript utilizado para o front-end de aplicações web. 

#### 4. Lista Preliminar de Casos de Teste
`test_get_shopping_lists_endpoint`: Este método testa a funcionalidade de obtenção de todas as listas de compras. 
`test_get_single_shopping_list_endpoint`: Este método testa a funcionalidade de obtenção de uma lista de compras específica. 
`test_post_shopping_list_endpoint`: Este método testa a funcionalidade de adicionar uma nova lista de compras. 
`test_put_shopping_list_endpoint`: Este método testa a funcionalidade de atualizar uma lista de compras existente. 
`test_delete_shopping_list_endpoint`: Este método testa a funcionalidade de excluir uma lista de compras existente. 

Esses casos de teste abrangem as principais funcionalidades do aplicativo e garantirão que todas as partes do sistema estejam devidamente testadas e funcionando corretamente. 

#### 5. Estrutura Básica dos Testes
A estrutura básica dos testes segue o padrão de testes fornecido pelo Laravel. Cada método de teste corresponde a uma funcionalidade específica da API de gerenciamento de listas de compras. Os testes são escritos de forma a garantir que cada aspecto da API seja testado individualmente, desde a obtenção da lista de compras até a exclusão delas. A estrutura dos testes segue uma abordagem unitária, onde cada teste é independente e focado em uma única operação da API. 

#### 6. Implementação do Projeto
O projeto foi implementado seguindo as práticas recomendadas do Laravel, com estrutura MVC (Model-View-Controller) para garantir uma separação clara de responsabilidades. A funcionalidade principal de gerenciamento de listas de compras foi implementada no controlador “ShoppingListController”, que é responsável por lidar com requisições HTTP relacionadas às listas de compras. Além disso, foram criados modelos para representar os dados das listas de compras (“ShoppingList”) e dos usuários (“User”). 

A implementação do projeto foi realizada de forma interativa, seguindo a abordagem de Test Driven Development (TDD). Primeiro, os casos de teste foram escritos para as funcionalidades desejadas. Em seguida, o código foi desenvolvido para fazer os testes passarem. Esse ciclo foi repetido até que todas as funcionalidade estivessem implementadas e os testes passassem com sucesso. 

#### 7.  Desafios e Lições Aprendidas
Durante o desenvolvimento do projeto, alguns desafios foram enfrentados, principalmente relacionados à configuração inicial do ambiente de desenvolvimento e à familiarização com o framework Laravel. No entanto, esses desafios foram superados com pesquisa e experimentação da tecnologia PHP e framework Laravel. 

Além disso, utilizou-se a abordagem Test Driven Development (TDD), onde, primeiramente, criaram-se testes, e posteriormente, o código principal. Isso ajudou a manter o projeto organizado e a garantir que tudo funcionasse corretamente. Portanto, notou-se que é importante manter o código limpo e fazer melhorias constantes. 
No final, foi criado um aplicativo sólido e adquiriu-se experiência em desenvolvimento ágil e TDD, proporcionando uma maior confiança na qualidade do código.



