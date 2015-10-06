# cURL

Classe cURL simples e leve, objetivada para facilitar integração com API's. Para outras informações sobre o cURL visite [documentação do PHP][1]

## Instalação

Clique no botão de [download][2] ou clone esse repositório usando o comando `git clone https://github.com/renatotavares/curl.git`

## Uso

### Inicialização

Simplismente inclua e inicialize a classe Curl:
    
    require_once 'src/Curl.php';
    $curl = new Curl;

### Fazendo uma requisição

O objeto Curl suporta 2 tipos de requisições: `POST` e `GET`. Você deve informar a url a ser requisitada e, opcionalmente, um array associativo de variáveis a serem enviadas junto com a requisição. Além disso, você pode informar opcionalmente, uma função de callback que será executada logo após a requisição ser finalizada.

    $response = $curl->post($url, $vars = array(), 'callback');
    $response = $curl->get($url, $vars = array(), 'callback');

Para todos os exemplos de uso, consulte a pasta **examples**.   

## Contribuindo

1. Faça um fork!
2. Crie sua melhoria em um branch: `git checkout -b my-new-feature`
3. Commit suas mudanças: `git commit -am 'Adicionando nova funcionalidade'`
4. Envie ao branch: `git push origin my-new-feature`
5. Envie um pull request :D

## Changelog

#### Versão 1.0.0 *(2015-10-03)*

- Versão inicial.

## Créditos

Renato Tavares ([Github][3], [Twitter][4])

## Licença

[MIT License][5]

[1]: http://php.net/curl                                            "Manual PHP cURL"
[2]: https://github.com/renatotavares/curl/archive/master.zip       "Download classe cURL"
[3]: https://github.com/renatotavares                               "Github"
[4]: http://twitter.com/renatotavares                               "Twitter"
[5]: https://github.com/renatotavares/curl/blob/master/LICENSE      "Licença MIT"