<?php
/*
	This code is licensed under the MIT license.
	See the LICENSE file for more information.
*/

namespace App\Classes;

class IPFS {
	private $gatewayIP;
	private $gatewayPort;
	private $gatewayApiPort;

	function __construct($ip, $port, $apiPort) {
		$this->gatewayIP      = $ip;
		$this->gatewayPort    = $port;
		$this->gatewayApiPort = $apiPort;
	}

	public function cat ($hash) {
		$ip = $this->gatewayIP;
		$port = $this->gatewayPort;

		return $this->curl("$ip/ipfs/$hash");
	}

	public function add ($content) {
		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;

		$req = $this->curl("$ip:$port/api/v0/add", $content);
		
		//$req = json_decode($req, TRUE);
		$req = explode("\n", $req);
		
		$cnt = count($req);
		// dd($req1);
		for ($i = 0; $i < $cnt; $i++) {
			
			$requestHash = json_decode($req[$i]);
			if (!is_null($requestHash)) {

				if (str_contains($requestHash->Name, 'tmp/')) {
					// dd($reqq->Hash);
					return $requestHash->Hash;
				}
			}
		}
        // return substr(explode("\",\"Size", explode("\"Hash\":", $req)[2])[0], 1);

	}

	public function ls ($hash) {
		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;

		$response = $this->curl("http://$ip:$port/api/v0/ls/$hash");

		$data = json_decode($response, TRUE);

		return $data['Objects'][0]['Links'];
	}

	public function size ($hash) {
		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;

		$response = $this->curl("http://$ip:$port/api/v0/object/stat/$hash");
		$data = json_decode($response, TRUE);

		return $data['CumulativeSize'];
	}

	public function pinAdd ($hash) {
		
		$ip = $this->gatewayIP;
		$port = $this->gatewayApiPort;

		$response = $this->curl("http://$ip:$port/api/v0/pin/add/$hash");
		$data = json_decode($response, TRUE);

		return $data;
	}

    public function pinRm ($hash)
    {
        $ip = $this->gatewayIP;
        $port = $this->gatewayApiPort;

        $response = $this->curl("$ip:$port/api/v0/pin/rm/$hash");
        $data = json_decode($response, TRUE);

        return $data;
    }

    public function version () {
        
        $ip = $this->gatewayIP;
        $port = $this->gatewayApiPort;
        $response = $this->curl("http://$ip:$port/api/v0/version");
        $data = json_decode($response, TRUE);
        return $data["Version"];
    }

	private function curl ($url, $data = "") {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if ($data != "") {
            $cFile = curl_file_create($data);
            $file = array(
                "key" => "prova.txt",
                "file" => $cFile,
            );
			curl_setopt($ch, CURLOPT_HEADER, 0);
			// curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $file);
            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: multipart/form-data"
            ));
		}
		else
        {
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        }

		$output = curl_exec($ch);

		if ($output == FALSE) {
			//todo: when ipfs doesn't answer
		}		 
		curl_close($ch);
 

		return $output;
	}
}


