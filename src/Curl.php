<?php 

/**
 * Biblioteca cURL simples e leve, objetivada para facilitar integração com API's
 *
 * @package     Curl
 * @version     1.0.0
 * @author      Renato Tavares
 * @license     MIT License
 * @copyright   2015 Renato Tavares
 * @link        http://github.com/renatotavares/curl
 */
class Curl
{
    /**
     * Armazena o manipulador cURL 
     * 
     * @var resource
     */
    private $handle;
    
    /**
     * Armazena o motivo do erro caso a requisição falhe
     * 
     * @var string
     */
    private $error;
    
    /**
     * Corpo da resposta sem os cabeçalhos HTTP
     * 
     * @var sring
     */
    public $responseBody;
    
    /**
     * Array associativo contendo o cabeçalho HTTP da resposta
     * 
     * @var array
     */
    public $responseHeader = array();

    /**
     * Inicializa a classe Curl, armazena o handle global e inicializa as opções básicas
     *
     * @return void
     */
    public function __construct()
    {
        $this->handle = curl_init();
        curl_setopt($this->handle, CURLOPT_HEADER, true);
        curl_setopt($this->handle, CURLOPT_ENCODING, "");
        curl_setopt($this->handle, CURLOPT_MAXREDIRS, 10);
        curl_setopt($this->handle, CURLOPT_AUTOREFERER, true);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->handle, CURLOPT_SSL_VERIFYHOST, false);
    }

    /**
     * Destrói a classe Curl e finaliza o handle cURL
     *
     * @return void
     */
    public function __destruct()
    {
       curl_close($this->handle);
    }
    
    /**
     * Realiza uma requisição HTTP GET
     * 
     * @param  string $url      URL de destino do HTTP GET
     * @param  array  $data     Array (chave e valor) dos parâmetros a serem enviados
     * @param  string $callback Nome da função a ser invocada imediatamente no fim da requisição
     * @return string Copo da resposta encontrada na URL de destino
     */
    public function get($url, $data = null, $callback = null)
    {
        curl_setopt($this->handle, CURLOPT_HTTPGET, true);
        
        if($data)
            $url = $url.'?'.http_build_query($data);

        return $this->request($url, null, $callback);
    }

    /**
     * Realiza uma requisição HTTP POST
     * 
     * @param  string $url      URL de destino do HTTP POST
     * @param  array  $data     Array (chave e valor) dos parâmetros a serem enviados
     * @param  string $callback Nome da função a ser invocada imediatamente no fim da requisição
     * @return string Copo da resposta encontrada na URL de destino
     */
    public function post($url, $data = null, $callback = null)
    {
        curl_setopt($this->handle, CURLOPT_POST, true);

        if ($data) 
            curl_setopt($this->handle, CURLOPT_POSTFIELDS, $data);

        return $this->request($url, $data, $callback);
    }

    /**
     * Faz uma requisição cURL a uma URL específica
     * 
     * @param  string $url      URL de destino da requisição
     * @param  array  $data     Array (chave e valor) dos parâmetros a serem enviados
     * @param  string $callback Nome da função a ser invocada imediatamente no fim da requisição
     * @return string|false Copo da resposta encontrada na URL de destino ou false em caso de falha
     */
    public function request($url, $data, $callback)
    {
        curl_setopt($this->handle, CURLOPT_URL, $url);
        
        $rawResponse = curl_exec($this->handle);
        
        if(curl_errno($this->handle))
        {
            $this->error = curl_errno($this->handle).' - '.curl_error($this->handle);
            return false;
        }

        $this->responseParser($rawResponse);
        
        if($callback)
            call_user_func($callback, $this->responseHeader, $this->responseBody);

        return $this->responseBody;
    }

    /**
     * Define as opções a serem utilizadas durante a requisição
     * 
     * @param array $options Array (chave e valor) das opções a serem definidas no curl_setopt()
     * @throws InvalidArgumentException Lança uma exceção caso parametro $options não seja um array
     * @return Curl
     */
    public function setOptions($options = array())
    {
        $temp = array();

        if (!is_array($options))
            throw new Exception('Parâmetro $options deve ser um Array.');
        
        foreach ($options as $option => $value) 
        {
            $option = 'CURLOPT_'.str_replace('CURLOPT_', '', strtoupper($option));
            $temp[constant($option)] = $value; 
        }

        curl_setopt_array($this->handle, $temp);
        return $this;
    }

    /**
     * Define os headers a serem enviados durante a requisição
     * 
     * @param array $headers Array com os cabeçalhos a serem enviados na requisição
     * @throws InvalidArgumentException Lança uma exceção caso parametro $headers não seja um array
     */
    public function setHeaders($headers = array())
    {
        if (!is_array($headers))
            throw new Exception('Parâmetro $headers deve ser um Array.');

        curl_setopt($this->handle, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    /**
     * Define as credenciais utilizadas para a autenticação do usuário
     * 
     * @param string $user Nome de usuário
     * @param string $pass Senha do usuário
     * @throws Exception Lança uma exceção caso parametro $user ou $pass não sejam definidos
     * @return Curl
     */
    public function setBasicAuth($user, $pass)
    {
        if(!$user || !$pass)
            throw new Exception('Parâmetro $user e $pass devem ser definidos.');

        curl_setopt($this->handle, CURLOPT_USERPWD, $user.':'.$pass);  
        return $this;
    }

    /**
     * Define e configura o arquivo para armazenar os cookies de sessão
     * 
     * @param string $file Caminho para o arquivo de cookies
     * @return Curl
     */
    public function setCookieFile($file = 'curl_cookie.txt')
    {
        if (! file_exists($file))
        {
            $handle = fopen($file, 'w+');
            
            if(!$handle)
                throw new Exception('O arquivo de cookie não pôde ser aberto. Certifique-se este diretório tem as permissões corretas');
            
            fclose($handle);
        }

        curl_setopt($this->handle, CURLOPT_COOKIESESSION, true);
        curl_setopt($this->handle, CURLOPT_COOKIEJAR, $file);
        curl_setopt($this->handle, CURLOPT_COOKIEFILE, $file);
        return $this;
    }

    /**
     * Define o valor do cabeçalho "Cookie: " 
     * 
     * @param  array  $cookie Array (chave e valor) do cookie que deseja enviar 
     * @return Curl
     */
    public function sendCookieData($cookie = array())
    {
        if (!is_array($cookie))
            throw new Exception('Parâmetro $cookie deve ser um Array.');
        
        $str = '';

        foreach ($cookie as $key => $value)
            $str .= $key .'='.$value.'; ';
        
        $str = rtrim($str, ' ;');

        curl_setopt($this->handle, CURLOPT_COOKIE, $str);
        return $this;
    }

    /**
     * Define o tempo limite da requisição
     * 
     * @param integer $conn O tempo máximo em segundos de espera ao tentar se conectar
     * @param integer $exec O tempo máximo em segundos que o cURL pode executar
     * @return Curl
     */
    public function setTimeout($conn = 0, $exec = 0)
    {
        curl_setopt($this->handle, CURLOPT_CONNECTTIMEOUT, $conn);
        curl_setopt($this->handle, CURLOPT_TIMEOUT, $exec);
        return $this;
    }

    /**
     * Configura o servidor de proxy
     * 
     * @param string $proxy Endereço de IP do servidor de proxy, ou string IP:Porta
     * @param string $port  Porta do servidor de proxy
     * @return Curl
     */
    public function setProxy($proxy, $port = null)
    {
        
        if ($port) 
            curl_setopt($this->handle, CURLOPT_PROXY, $proxy.':'.$port);
        else
            curl_setopt($this->handle, CURLOPT_PROXY, $proxy);
        
        return $this;    
    }
    
    /**
     * Configura a autenticação no servidor de proxy
     * 
     * @param string $user Nome de usuário do servidor proxy
     * @param string $pass Senha do usuário do servidor proxy
     * @return Curl
     */
    public function setProxyAuth($user, $pass)
    {
        curl_setopt($this->handle, CURLOPT_PROXYUSERPWD, $user.':'.$pass);
        return $this;
    }

    /**
     * Define um arquivo para receber a transferência remota
     * 
     * @param [type] &$fp Arquivo onde a transferência será escrita
     * @return Curl
     */
    public function setFileDownload(&$fp)
    {
        curl_setopt($this->handle, CURLOPT_HEADER , false);
        curl_setopt($this->handle, CURLOPT_FILE, $fp);
        return $this;
    }

    /**
     * Define o user-agent da requisição
     * 
     * @param string $userAgent String de user-agent
     * @return Curl
     */
    public function setUserAgent($userAgent= 'Curl/PHP 1.0 (https://github.com/renatotavares/curl)')
    {
        curl_setopt($this->handle, CURLOPT_USERAGENT, $userAgent);
        return $this;
    }

    /**
     * Define o conteudo do cabeçalho "Referer: " para ser usado na requisição
     * 
     * @param string $referer Valor a ser usado no cabeçalho "Referer: " 
     * @return Curl
     */
    public function setReferer($referer)
    {
        curl_setopt($this->handle, CURLOPT_REFERER, $referer);
        return $this;
    }

    /**
     * Devolve o último erro ocorrido
     * 
     * @return string Erro da requisção
     */
    public function getError()
    {
        return $this->error;
    } 

    /**
     * Interpreta a resposta de uma requisição cURL separando o cabeçalho do corpo
     * 
     * @param  string $rawResponse Resposta do curl_exec()
     * @return string Corpo da resposta sem o cabeçalho
     * @author Sean Huber <shuber@huberry.com>
     */
    public function responseParser($rawResponse)
    {
        $pattern = '#HTTP/\d\.\d.*?$.*?\r\n\r\n#ims';
      
        preg_match_all($pattern, $rawResponse, $matches);
        $headers_string = array_pop($matches[0]);
        $headers = explode("\r\n", str_replace("\r\n\r\n", '', $headers_string));
        
        $this->responseBody = str_replace($headers_string, '', $rawResponse);
        array_shift($headers);
     
        foreach ($headers as $header) {
            preg_match('#(.*?)\:\s(.*)#', $header, $matches);
            $this->responseHeader[$matches[1]] = $matches[2];
        }
    }

    /**
     * Recupera informações da requisição
     * 
     * @return array|false Retorna um array com informações da requisição
     */
    public function getInfo()
    {
        return curl_getinfo($this->handle);
    }

    /**
     * Faz o cURL falhar caso receba um código HTTP maior que 400
     * 
     * @return Curl
     */
    public function setFailOnError()
    {
        curl_setopt($this->handle, CURLOPT_FAILONERROR, true);
        return $this;
    }

}