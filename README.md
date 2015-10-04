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
   

## Contribuindo

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

TODO: Write history

## Credits

Renato Tavares ([Github][3], [Twitter][4])

## License

MIT License




[1]: http://php.net/curl                                            "Manual PHP cURL"
[2]: https://github.com/renatotavares/curl/archive/master.zip       "Download classe cURL"
[3]: https://github.com/renatotavares                               "Github"
[4]: http://twitter.com/renatotavares                               "Twitter"