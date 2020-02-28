<?php 
require_once("SimpleRest.php");
require_once("Site.php");

class SiteRestHandler extends SimpleRest{

	function getAllSites(){

		$site = new Site();
		$rawData = $site->getAllSite();

		if(empty($rawData)){
			$statusCode = 404;
			$rawData = array('error'=>'No sites found');
		}else{
			$statusCode = 200;
		}

		$requestContentType = $_SERVER['HTTP_ACCEPT'];
		$result = $this->setHttpHeaders($requestContentType, $statusCode);

		// echo '<pre>';
		// var_dump($requestContentType);
		// exit;


		// 处理请求类型
		if(strpos($requestContentType, 'application/json') !== false){

			$response = $this->encodeJson($rawData);
			echo $response;
		}else if(strpos($requestContentType, 'text/html') !== false){

			$response = $this->encodeHtml($rawData);
			echo $response;
		}else if(strpos($requestContentType,'text/xml') !==false){

			$response = $this->encodeXml($rawData);
			echo $response;
		}
	}

	public function encodeHtml($responseData){

		$htmlResponse = "<table border='1'>";

		foreach($responseData as $key=>$value){

			$htmlResponse .="<tr>";

			$htmlResponse .="<td>".$key."</td>";
			$htmlResponse .="<td>".$value."</td>";

			$htmlResponse .="</tr>";
		}	

		$htmlResponse .="</table>";

		return $htmlResponse;
	}

	/**
	 * 返回Json格式数据
	 * @param  [type] $responesData [description]
	 * @return [type]               [description]
	 */
	public function encodeJson($responseData){

		$jsonResponse = json_encode($responseData);
		return $jsonResponse;
	}

	/**
	 * 返回Xml格式数据
	 * @param  [type] $responseData [description]
	 * @return [type]               [description]
	 */
	public function encodeXml($responseData){

		// 创建 SimpleXMLElement对象
		$xml = new SimpleXMLElement('<?xml version="1.0"?><site></site>');
		foreach ($responseData as $key => $value) {
			
			$xml->addChild($key, $value);
		}

		return $xml->asXML();
	}	

	/**
	 * 通过id获取
	 * @param  int $id 网站id
	 * @return html/json/xml 返回相对应的数据
	 */
	public function getSite($id){

		$site = new Site();
		$rawData = $site->getSite($id);

		if(empty($rawData)){

			$statusCode = 404;
			$rawData = array('error'=> 'No sites found!');
		}else{
			$statusCode = 200;
		}

		$requestContentType = $_SERVER['HTTP_ACCEPT'];



		$this->setHttpHeaders($requestContentType,$statusCode);

		$response = '';

		if(strpos($requestContentType,'application/json') !== false){

			$response = $this->encodeJson($rawData);
			// echo $response;
		}else if(strpos($requestContentType,'text/html') !== false){
		
			$response = $this->encodeHtml($rawData);
			// echo $response;
		}else if(strpos($requestContentType, 'application/xml') !== false){

			$response = $this->encodeXml($rawData);
			// echo $response;
		}
			// $response = $this->encodeXml($rawData);
			
		echo $response;
		exit;
	}	
}
?>