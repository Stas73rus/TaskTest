<?php

$html_c = array('<html>','<head>','</head>','<body>',
    '<div>','<p>','<h1>','</h1>','</p>','<a>','</a>','</div>','</body>','</html>');

$html_ic = array('<html>','<head>','</head>','<body>',
    '<div>','</h1>','<dic>','<h>','</div>','</div>','</body>','</html>');


function correctHtml($html){
    $znak = ['/','<','>',' '];
    $mas = array();

    foreach ($html as $el) {
        if (strpos($el, "/") == false) {
            $el = str_replace($znak, '', $el);
            array_push($mas, $el);
        } else {
            $el = str_replace($znak, '', $el);
            if ($el != array_pop($mas))
                return false;
        }
    }

    if (count($mas) != 0)
        return false;

    return true;
}

echo var_dump(correctHtml($html_c));
