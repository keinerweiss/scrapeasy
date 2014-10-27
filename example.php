<?php
include("scrapeasy.php");

$html = <<<END
<html>
  <head>
    <title>Mein Titel</title>
  </head>
  <body>
    <div id="content">
      <p>Paragraph 1</p>
      <p>Paragraph 
      2</p>
    </div>
    <div id="footer">
      Footer
    </div>
  </body>
</html>
END;

$results = scrapeasy($html, array(
	"title" => function($content) {
		if(preg_match('/<title>([\s\S]*?)<\/title>/', $content, $match)) {
			return $match[1];
		}
	},
	"content" => function($content) {
		if(preg_match('/<div id="content">([\s\S]*?)<\/div>[\s]*?<div id="footer">/i', $content, $match)) {
			return $match[1];
		}
	},
	"content:after" => function($content, $context) {
		$paragraphs = array();
		if(preg_match_all('/<p.*?>([\s\S]*?)<\/p>/i', $content, $match)) {
			foreach($match[1] as $p) {
				$paragraphs[] = $p;
			}
		}
		return $paragraphs;
	}
));
print_r($results);
