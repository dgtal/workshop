<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;

class ScrapSegurosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:seguros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    protected $car_makes = [
        260 => 'ACTIVA MOTORS',
        127 => 'AEOLUS',
        10 => 'ALEKO',
        11 => 'ALFA ROMEO',
        194 => 'ANCHI',
        175 => 'APRILIA',
        219 => 'ASAKI',
        259 => 'ASHIDA',
        13 => 'ASIA MOTORS',
        143 => 'ATALA',
        14 => 'AUDI',
        20 => 'B.M.W.',
        136 => 'BACCIO',
        294 => 'BAIC',
        173 => 'BAJAJ',
        227 => 'BAOTIAN',
        229 => 'BENELLI',
        240 => 'BETA MOTOS',
        193 => 'BRILLIANCE',
        250 => 'BUELL MOTORCYCLES',
        190 => 'BYD AUTO',
        291 => 'BYQ MOTOS',
        233 => 'CAN-AM',
        255 => 'CFMOTO',
        130 => 'CHANA',
        192 => 'CHANGHE',
        171 => 'CHERY',
        22 => 'CHEVROLET',
        95 => 'CHRYSLER',
        242 => 'CIAO',
        212 => 'CIMAX',
        23 => 'CITROEN',
        309 => 'COOUGAR MOTOS',
        156 => 'D.F.M. (DONGFENG MOTOR)',
        159 => 'D.F.S.K.',
        248 => 'DAELIM MOTOS',
        26 => 'DAEWOO',
        27 => 'DAIHATSU',
        247 => 'DIRTY MOTOS',
        29 => 'DODGE',
        142 => 'DUCATI',
        155 => 'EFFA',
        237 => 'EFPG',
        33 => 'F.S.O. - DAEWOO',
        166 => 'FAW',
        226 => 'FDMCO',
        31 => 'FIAT',
        32 => 'FORD',
        261 => 'FORLAND',
        172 => 'FOTON',
        188 => 'FUQI',
        161 => 'G.W.M.',
        185 => 'GEELY',
        176 => 'GONOW',
        207 => 'HAFEI',
        217 => 'HAIMA',
        245 => 'HAMAZAKI',
        88 => 'HARLEY DAVIDSON',
        340 => 'HEMEI',
        108 => 'HERO',
        36 => 'HONDA',
        186 => 'HUAYANG',
        221 => 'HYOSUNG',
        37 => 'HYUNDAI',
        246 => 'IMSA MOTOS',
        238 => 'INTERPARTES',
        38 => 'ISUZU',
        147 => 'J.M.C.',
        165 => 'JAC',
        40 => 'JEEP',
        141 => 'JIALING',
        249 => 'JINCHENG',
        131 => 'K.T.M.',
        89 => 'KAWASAKI',
        201 => 'KEEWAY',
        77 => 'KIA',
        198 => 'KIN',
        137 => 'KINETIC',
        208 => 'KINGSTAR',
        252 => 'KORENY MOTOS',
        230 => 'KYMCO',
        41 => 'LADA',
        222 => 'LAND FORCE',
        43 => 'LAND ROVER',
        257 => 'LEOPARD',
        138 => 'LIFAN',
        236 => 'LONCIN',
        66 => 'MAHINDRA',
        46 => 'MAZDA',
        228 => 'MEGELLI',
        47 => 'MERCEDES BENZ',
        94 => 'MG',
        195 => 'MINI',
        49 => 'MITSUBISHI',
        205 => 'MONDIAL',
        51 => 'MORRIS',
        209 => 'MOTO GUZZI',
        284 => 'MOTOMEL',
        232 => 'MTR',
        169 => 'MUDAN',
        210 => 'MV AGUSTA',
        52 => 'NISSAN',
        301 => 'OCEAN MOTOS',
        55 => 'OLTCIT',
        197 => 'ORIENT',
        56 => 'PEUGEOT',
        223 => 'POLARIS',
        251 => 'RAM',
        231 => 'REGAL RAPTOR',
        61 => 'RENAULT',
        199 => 'ROCKET',
        62 => 'ROVER',
        244 => 'ROYAL ENFIELD',
        182 => 'S.M.A.',
        308 => 'SCION',
        65 => 'SEAT',
        253 => 'SENDA MOTOS',
        202 => 'SHINERAY',
        254 => 'SONIC MOTOS',
        9 => 'SSANGYONG',
        243 => 'STAR MOTOS',
        68 => 'SUBARU',
        69 => 'SUZUKI',
        86 => 'TATA',
        213 => 'TGB',
        274 => 'T-KING',
        158 => 'TONGBAO',
        72 => 'TOYOTA',
        178 => 'TRIUMPH',
        218 => 'TULA',
        225 => 'TVS',
        241 => 'TXM MOTOS',
        170 => 'UFO',
        258 => 'UM',
        224 => 'VERADO MOTOS',
        239 => 'VESPA',
        307 => 'VICTORY AUTO',
        149 => 'VINCE',
        211 => 'VITAL',
        74 => 'VOLKSWAGEN',
        96 => 'VOLVO',
        153 => 'WINNER',
        146 => 'WULING',
        289 => 'XMOTOS',
        104 => 'YAMAHA',
        145 => 'YASUKI',
        134 => 'YUMBO',
        92 => 'ZANELLA',
        315 => 'ZERO MOTORCYCLES',
        191 => 'ZOTYE',
        164 => 'ZX AUTO',
    ];

    protected $url = 'http://www.segurosonline.com.uy/seguros.aspx';

    protected $headers = [
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        'Accept-Encoding' => 'gzip, deflate, sdch',
        'Accept-Language' => 'en-US,en;q=0.8,es;q=0.6',
        'Cache-Control' => 'max-age=0',
        'Connection' => 'keep-alive',
        'Host' => 'www.segurosonline.com.uy',
        'Upgrade-Insecure-Requests' => '1',
        'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36',
    ];

    /**
     * Create a new command instance.
     *
     * @param  DripEmailer  $drip
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $driver = new \Behat\Mink\Driver\GoutteDriver();
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit($this->url);

        $page = $session->getPage();
        
        $selectMarcas = $page->find('named_exact', ['id_or_name', 'ctl00_ContentPlaceHolder1_DropDownMarcas']);
        $selectMarcas->selectOption(260);

        $inputEventTargetValue = $page->find('named_exact', ['id_or_name', '__LASTFOCUS']);

        if (null === $inputEventTargetValue) {
            throw new \Exception('The element is not found');
        }

        dd($inputEventTargetValue->getValue());
        // $selectElement = $page->find('xpath', '//select[@id = "ctl00_ContentPlaceHolder1_DropDownMarcas"]');
        // $selectElement->selectOption(260);

        // $input_value = $page->find('xpath', '//input[@id = "__EVENTTARGET"');
        // dd($input_value);
        // $content = $session->getPage()->getContent();

        exit();
 
        $client = new Client();

        foreach ($this->headers as $name => $value) {
            $client->setHeader($name, $value);
        }

        $crawler = $client->request('GET', $this->url);

        $hiddenInputs = [
            '__VIEWSTATE' => '',
            '__VIEWSTATEGENERATOR' => '',
            '__EVENTVALIDATION' => '',
            '__EVENTTARGET' => '',
            '__EVENTARGUMENT' => '',
            'ctl00_ContentPlaceHolder1_ToolkitScriptManager1_HiddenField' => '',
            '__LASTFOCUS' => '',
        ];

        foreach ($hiddenInputs as $input_id => &$input_value) {
            $input_value = $crawler->filterXPath("//*[contains(./@id, '$input_id')]/@value")->text();
        }

        $hiddenInputs['__EVENTTARGET'] = 'ctl00$ContentPlaceHolder1$DropDownMarcas';

        $postData = [
            'ctl00$ContentPlaceHolder1$RadioButtonListPersonal' => 'Personal',
            'ctl00$ContentPlaceHolder1$DropDownMarcas' => '260',
            'ctl00$ContentPlaceHolder1$DropDownAnnos' => '-1',
            'ctl00$ContentPlaceHolder1$DropDownModelos' => '-1',
            'ctl00$ContentPlaceHolder1$DropDownAreasManejo' => '1',
            'ctl00$ContentPlaceHolder1$TextBoxEdad' => '',
            '__ASYNCPOST' => 'true',
        ];

        $crawler = $client->request('POST', $this->url, array_merge($hiddenInputs, $postData));
        echo $client->getBody();
    }
}