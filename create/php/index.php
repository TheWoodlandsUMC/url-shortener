<?php
require_once 'db.php';

$shortened = '';

class shortener {

	private $used;
	
	function __construct() {

        $stmt = db::connect()->prepare('SELECT rewrite FROM urls');
        
		$stmt->execute();//store mysql result in object
		
		$result = $stmt->fetchAll();
		
		if (count($result)) { 	

			foreach($result as $row) {
				
				$this->used[] = $row['rewrite'];//get array of already used urls
			}
			
		}
		
	}
	
	private function generateURL() {//recursive function to make sure unique url is used
	
		$ext = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 3)), 0, 3);//get random 3 char string
	
		if (!in_array($ext, $this->used)) {
			return $ext;
		}
		
		return $this->generateURL();//if random string exists then run again
		
	}
	
	public function setRewrite($url, $rw) {
		
		if (filter_var($url, FILTER_VALIDATE_URL) === false) {//is it a valid url?
			
			return '<div class="row"><div class="large-12 columns "><div class="panel">Not a valid URL!</div></div></div>';
			
		} else if ($rw == '') {//generate random url
			
			$rw = $this->generateURL();
			
		} else if (!in_array($rw, $this->used)) {//custom utl not used
			
			$rw = $rw;
			
		} else {//custom url is already used!
			
			return '<div class="row"><div class="large-12 columns "><div class="panel">Shortened URL is already being used!</div></div></div>';
		}
		
		$stmt = db::connect()->prepare('INSERT INTO urls (rewrite, url) VALUES (:rw, :url)');        
		$stmt->execute(array(
			':rw' => $rw,
			':url' => $url			
		));
		
		$this->generateHtaccess();
		
		return '<div class="row"><div class="large-12 columns "><div class="panel">Your shortened URL: http://twum.ch/' . $rw . '</div></div></div>';
	}
	
	public function generateHtaccess() {
		
		$stmt = db::connect()->prepare('SELECT * FROM urls');
        
		$stmt->execute();
		
		$result = $stmt->fetchAll();

		$myFile = '../.htaccess';
		
		unlink($myFile);//remove old htaccess
		
		file_put_contents($myFile, 
		'DirectoryIndex index.php
	
<IfModule mod_rewrite.c>
  RewriteEngine on
	
  RewriteCond %{HTTP_HOST} ^www\.twum\.ch [NC]
  RewriteRule ^(.*)$ http://twum.ch/$1 [L,R=301]
	
  RewriteBase /' . "\n", FILE_APPEND);
		
		if (count($result)) { 	

			foreach($result as $row) {
				
				file_put_contents($myFile, '  RewriteRule ^' . $row['rewrite'] . '$ ' . $row['url'] . ' [R=301,L]' . "\n", FILE_APPEND);
				
			}
		}
		
		file_put_contents($myFile, '</IfModule>', FILE_APPEND);
				
	}
	
}
$shortener = new shortener;

if(isset($_POST['submit'])) {
	
	$shortened = $shortener->setRewrite($_POST['url'], $_POST['rw']);
	
}
?>
