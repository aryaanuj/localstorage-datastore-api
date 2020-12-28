<?php
	class DataStore{
		var $filepath = '';
		function __construct($path=''){
			$this->filepath = !empty($path)?$path:'result.json';
		}

		function printMsg($msg,$code,$status="true"){
			if($status=='true'){
				echo json_encode(["success"=> array("msg"=>$msg,"status"=>$status)]);
			}else{
				echo json_encode(["error"=> array("msg"=>$msg,"status"=>$status)]);
			}
			http_response_code($code);
			exit;
		}

		function create($key='', $value=''){
			if(empty($key)){
				$this->printMsg("Can't add data. Key parameter is empty",404,"false");
			}
			if(empty($value)){
				$this->printMsg("Value parameter is empty",404,"false");
			}
			$content = array($key=>$value);
			if(!file_exists($this->filepath) || filesize($this->filepath) == 0){
				$tempArray = array();
			}else{
				$inp = file_get_contents($this->filepath);
				$tempArray = json_decode($inp,true);
				foreach ($tempArray as $keys) {
					if(array_key_exists($key,$keys))
					{
						$this->printMsg("Key already exists!",400,"false");
					}
				}
			}
			array_push($tempArray, $content);
			$jsonData = json_encode($tempArray);
			if(file_put_contents($this->filepath, $jsonData)){
				echo json_encode(["success"=> array("msg"=>"Data added successfuly!","status"=>"true")]);
				http_response_code(200);
			}
		}


		function read($key=''){
			if(filesize($this->filepath) == 0){
				$this->printMsg("File is empty",200);
			}else{
				$inp = file_get_contents($this->filepath);
				$tempArray = json_decode($inp,true);
				if(empty($key)){
					echo $inp;
					exit;
				}else{
					foreach ($tempArray as $keys) {
						foreach ($keys as $keyd => $value) {
							if($keyd==$key){
								echo json_encode(array($keyd=>$value));
								exit;
							}
						}
					}
				}
				$this->printMsg("Key not found!",400,"false");
			}
		}

		function delete($key){
			if(filesize($this->filepath) == 0){
				$this->printMsg("File is empty",200);
			}else{
				$inp = file_get_contents($this->filepath);
				$tempArray = json_decode($inp, true);
				if(empty($key)){
					$this->printMsg("Key missing",404,"false");
				}else{
					$i = 0;
					foreach ($tempArray as $keys) {
						foreach ($keys as $keyd => $value) {
							if($keyd==$key){
							 	unset($tempArray[$i]);
								$json_arr = array_values($tempArray);
								file_put_contents($this->filepath,json_encode($json_arr));
								$this->printMsg("Data deleted successfuly!", 200);
							}
						}
						$i++;
					}
				}
				$this->printMsg("Key not found!",400,"false");
			}
		}
	}
?>
