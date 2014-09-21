<?php


	/*

		Writer : Alperen Türköz
		twitter : 0088FF
		e-mail: alperentrkz[at]gmail[dot]com
		version : v1.0
		github:0088FF
		repository:open-search-generator



	 */
	$version = "v1.0";
	function reload(){
		$uri = $_SERVER["REQUEST_URI"];
		$uri = strtok($uri,"?");
		header('Location:'.$uri);
	}
	if(isset($_GET)){
		if(isset($_GET["crtxml"]) && empty($_GET["crtxml"])){
			/* change or create */ 
			if(isset($_GET["change"]) && $_GET["change"] == true){

				/* change */

			}else{

				if(empty($_GET["shortname"]) || empty($_GET["searchaddr"]) || empty($_GET["attr"]) || !filter_var($_GET["searchaddr"],FILTER_VALIDATE_URL)){

					echo "<script> alert('fail :(') </script>";
						reload();
				}else{
					@unlink("opensearch.xml");
					touch("opensearch.xml");
					$datas = array(
						"shortname" => $_GET["shortname"],
						"searchaddr"=> $_GET["searchaddr"],
						"query"		=> $_GET["attr"],
						"favicon"   => $_GET["favicon"],
					);
					$xmlcontent = array();
						$xmlcontent[0] = '<!-- open-search-generator // github: 0088FF/open-search-generator // writer: twitter.com/0088FF // simply do your own opensearch.xml  -->';
						$xmlcontent[1] = '<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">';
						$xmlcontent[2] = '<ShortName>'.$datas["shortname"].'</ShortName>';
						$xmlcontent[3] = '<Image width="16" height="16">'.$datas["favicon"].'</Image>';
							$xyz = $datas["searchaddr"]."?".$datas["query"]."={searchTerms}";
						$xmlcontent[4] = '<Url type="text/html" template="'.$xyz.'" />';
						$xmlcontent[5] = '</OpenSearchDescription>';
						$xmlcontent[6] = '<!-- open-search-generator // github: 0088FF/open-search-generator // writer: twitter.com/0088FF // simply do your own opensearch.xml  -->';
						$content = "";
						for($i= 0;$i < count($xmlcontent);$i++){
							$content = $content.$xmlcontent[$i];
						}		
						$file = fopen("opensearch.xml", "w");
						fwrite($file, $content);
						echo "<script> alert('OK,Ready') </script>";
						fclose($file);
						reload();
				}


			}
		}else{

			$gets = strtolower(trim(@$_GET["make"]));
			if($gets == "delete" && isset($_GET["nobackup"]) && empty($_GET["nobackup"]) && file_exists("opensearch.xml")){
				/* delete,nobackup,re-create */	
				unlink("opensearch.xml");
				reload();
			}else if($gets == "delete" && isset($_GET["backup"]) && empty($_GET["backup"]) && file_exists("opensearch.xml")){
				/* delete,backup,re-create */
				$file = fopen("opensearch.xml","r");
				if(!$file){
					echo "opensearch.xml failed";
					exit;
				}else{
					$fileread = fread($file, filesize("opensearch.xml"));
						/* backup */
						touch("open-search-generator.backup.txt");
						$backupread = fopen("open-search-generator.backup.txt", "w");
						fwrite($backupread, $fileread);
						echo "<script> alert('Backup name: open-search-generator.backup.txt') </script>";
					fclose($file);
						unlink("opensearch.xml");
						reload();
				}

			}else if($gets == "change"){
				/* change settings */
				$degisim = true;
				@$change = true;
			}
		}
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Opensearch.xml Yükleyici <?php echo $version ?></title>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<meta name="google-translate-customization" content="200eef9273fa8982-4bd71e912149ce1f-g19e083b615608056-9"></meta>
	<script type="text/javascript">
		function googleTranslateElementInit() {
		  new google.translate.TranslateElement({pageLanguage: 'tr'}, 'google_translate_element');
		}
	</script>
	<script>

	function confirmf(){
		var cnf = confirm("Emin misiniz?");
		if(cnf == true){
			window.location = "?make=delete&nobackup";
		}else{
			return false;
		}
	}

	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
     <style type="text/css">

     p{
     	font-size: 15px !important;
     }
     .ntbr{
     	margin-top:20px !important;
     }
     #google_translate_element{
     	margin-top:20px;
     }
     .skiptranslate .goog-te-gadget{
     	display: none;
     }
     .exm{
     	width: 60%;
     	margin:15px auto;
     }
     .exm h3,.exm p{
     	text-align: center;
     }
     </style> 
</head>
<body>

  		<div class="jumbotron">
  			<div class="container">
   				 <h1>Opensearch.xml Yükleyici <small>versiyon <?php echo $version ?></small> </h1>
 		 			<p>Sisteminize basitçe OpenSearch.xml kurar.</p>
 		 			<iframe src="http://ghbtns.com/github-btn.html?user=0088FF&repo=open-search-generator&type=fork&count=true"
  allowtransparency="true" frameborder="0" scrolling="0" width="95" height="20"></iframe><iframe src="http://ghbtns.com/github-btn.html?user=0088FF&type=follow"
  allowtransparency="true" frameborder="0" scrolling="0" width="132" height="20"></iframe><iframe src="http://ghbtns.com/github-btn.html?user=0088FF&repo=open-search-generator&type=watch&count=true"
  allowtransparency="true" frameborder="0" scrolling="0" width="110" height="20"></iframe><div id="google_translate_element"></div>
 		 			<div class="ntbr">
	 		 			<?php
	 		 				if(file_exists("opensearch.xml") && @$degisim == false){
	 		 					

	 		 			?>
	 		 					
	 		 				<p class="text-danger">Opensearch.xml <strong> zaten kurulmuş </strong></p>
	 		 				<a href="?make=delete&nobackup" onclick="confirmf();return false" class="btn btn-danger">Sil ve yenile</a>	
	 		 				<a href="?make=delete&backup" class="btn btn-success">Sil, yedekle, yeniden oluştur.</a>
	 		 				<a href="?make=change" class="btn btn-default">Şimdikinin ayarını değiştir</a>
	 		 			<?php
								return false;
	 		 				}else{
	 		 					$degisim = true;
	 		 				}
	 		 			?>
	 		 			<?php
	 		 				if(@$degisim == true){
	 		 			?>

	 		 				<form class="form-horizontal" name="setOSG">
	 		 						<?php 
	 		 							if(@$change == true)
	 		 								echo '<input type="hidden"  name="change" value="true" />';
	 		 						?>
	 		 					<div class="form-group">
    								<label for="shortname" class="col-sm-2 control-label">Kısa Ad</label>
	   								 <div class="col-sm-4">
	     								 <input type="text" class="form-control" required id="shortname" name="shortname" placeholder="ex: yoursite">
	    								<small></small>
	    							</div>
 								 </div>
 								 <div class="form-group">
    								<label for="searchaddr" required class="col-sm-2 control-label">Arama sayfası</label>
	   								 <div class="col-sm-4">
	     								 <input type="url" class="form-control" required id="searchaddr" name="searchaddr" placeholder="ex: http://yoursite.com/search" />
	    								<small></small>
	    							</div>
 								 </div>
 								  <div class="form-group">
    								<label for="attr" class="col-sm-2 control-label">Paramatre</label>
	   								 <div class="col-sm-4">
	     								 <input type="text" class="form-control" required id="attr" name="attr" placeholder="ex: query">
	     								 <small>yoursite.com/search?<strong>q</strong>=</small>
	    							</div>
 								 </div>
 								 <div class="form-gruop">
 								 	<label for="favicon" class="col-sm-2 control-label" style="width: 179px !important;">Favicon</label>
 								 	<div class="col-sm-4">
	    									<input type="text"  style="width: 361px;" class="form-control"  id="favicon" name="favicon" placeholder="ex: yoursite.com/favicon.ico">
	    							</div>	
 								 </div>	
 								 <button type="submit" name="crtxml" class="btn btn-default">Opensearch.xml oluştur/değiştir</button>		 
	 		 				</form>
	 		 				 
	 		 			<?php } ?>
	 		 			
	 		 		</div>
 		 	</div>
		</div>


</body>
</html>
