<?php

namespace Yuzderece\Netgsm;

use GuzzleHttp\Client;
use Yuzderece\Netgsm\Exception\AuthException;
use Yuzcerece\Netgsm\Exception\HeaderException;
use Yuzderece\Netgsm\Exception\MessageException;
use Yuzderece\Netgsm\Exception\ParameterException;

class Netgsm
{
    protected $url;
    protected $username;
    protected $password;
    protected $header;
    protected $lang;
    protected $http;

    public function __construct($config)
    {
        $this->url = config('netgsm.url');
        $this->username = config('netgsm.username');
        $this->password = config('netgsm.password');
        $this->header = config('netgsm.header');
        $this->lang = config('netgsm.language');
        $this->http = new Client([
            "base_uri" => $this->url,
            "timeout" => 10
        ]);
    }

    public function sendSms($number, $message, $header = null, $startDate = null, $endDate = null, $lang = null)
    {
        $numbers = [];
        if (is_array($number))
            foreach ($number as $num)
                $numbers[] = $num;
        else
            $numbers[] = $number;

        if (is_null($header))
            $header = $this->header;
        if (is_null($lang))
            $lang = $this->lang;

        $query = [
            'usercode' => $this->username,
            'password' => $this->password,
            'gsmno' => implode(',', $numbers),
            'message' => $message,
            'msgheader' => $header,
            'startdate' => $startDate,
            'stopdate' => $endDate,
            'dil' =>$lang
        ];

        $response = $this->http->request('GET', 'bulkhttppost.asp', [
            'query' => $query
        ]);

        if($response->getStatusCode() == 200){
            $content = $response->getBody()->getContents();

            if($content == '20')
                throw new MessageException('Mesaj metniniz hatalı veya standart maximum karakter sayısını geçiyor');
            elseif($content=='30')
                throw new AuthException('Geçersiz kullanıcı adı veya şifre yada Api erişiniz bulunmamakta');
            elseif($content=='40')
                throw new HeaderException('Mesaj başlığınız sistemde tanımlı değil');
            elseif($content=='70')
                throw new ParameterException('Gönderim parametreleri hatalı');

            $exp=explode(' ',$content);

            return $exp[1];
        } else {
            throw new ResponseException($response->getReasonPhrase());
        }

    }
}
