<?php
class FormProcess {
	//Form Processing class; Evtl. noch nicht in der richtigen Reiehnfolge
	
	public $errors = [];
	
	static function expect(...$items) {
		$result = [];
		$numItems = count($items);
		for($i = 0; $i < $numItems; $i++)
			$result[] = $_POST[$items[$i]];
		return $result;
	}
	
	function vStr($value, $item) {
		$err = [];
		$rules = $item['attr'] ?? $item['prop'] ?? [];
		foreach($rules as $ruleKey => $ruleVal) {
			if($ruleKey === 'required' && empty($value)) { #Im obigen Array nachsehen, ob das jeweilige Feld gegeben sein muss, und prüfen, ob es gegeben ist
				$err[] = 'is required';
			} else if(!empty($value)) {
				switch($ruleKey) {
					case 'minlength':
						if(mb_strlen($value) < $ruleVal) {
							$err[] = "must contain a minimum of $ruleVal characters";
						}
					break;
					case 'maxlength':
						if(mb_strlen($value) > $ruleVal) {
							$err[] = "must contain a maximum of $ruleVal characters";
						}
					break;
					case 'pattern':
						if(!preg_match("/^$ruleVal$/", $value)) {
							$err[] = "may consist of {$rules['title']} only";
						}
					break;
				}
			}
		}
		if(!empty($err)) {
			#Entstandene Fehler in einem Satz aufzählen und im Objekt speichern, um diesen später ausgeben zu können
			$this->errors[] = implode(' and ', array_filter([implode(', ', array_slice($err, 0, -1)), end($err)], 'strlen'));
			return false;
		}
		return true;
	}
	
	private static function email($email) {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return 'is invalid';
		}
		return false;
	}
	
	function addError($message) {
		$this->errors[] = $message;
	}
	
	function listErrors() {
		#Liste mit Fehlern ausgeben
		echo '<div class="alert"><b>We had a problem processing your request:</b><ul>';
			foreach($this->errors as $error) {
				echo "<li>$error!</li>";
			}
		echo '</ul></div>';
	}
}