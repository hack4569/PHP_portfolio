<?php
    $upload_max_filesize = 1024*1024*300;
    $SavePath = $_SERVER["DOCUMENT_ROOT"] . "/wine/data/file/";		// 첨부파일 저장경로

    $wine_cate = array(
        'snack' => array('All','snack'),
        'cs' => array('All','Sparkling','Champagne'),
        'sw'=> array('All','Tokaji','Auslese','Porto','Sauternes', 'Moscato'),
        'ww'=> array('All','Alsace','Bordeaux','Bourgogne','Loire','Germany','Italy','Austria','Chile','Australia','Napa','Oregon','New Zealand', 'Languedoc Roussillon', 'Rhone', 'Campania', 'Toscana', 'Valle dAosta', 'Piedmonte', 'Vienna', 'Marlborough', 'California','Alto Adige','Piedmonte','Mosel','Mariborough','Clare Valley','Rapel Valley'),
        'rw'=> array('All','Bourgogne','Bordeaux','Saint Emilion','Rhone','Piemonte','Toscana','Spain','Chile','Australia','Napa','Oregon', 'Rioja', 'Ribera del Duero', 'Penedes', 'Marche', 'Abruzzo', 'Veneto', 'Sicily', 'California', 'Washington', 'Coonawarra', 'Barossan Valley', 'Central Otago', 'Colchagua', 'Maipo Valley', 'Aconcagua', 'Casablanca Valley', 'Mendoza', 'Santa Cruz', 'Languedoc Roussillon', 'Sardegna', 'Campania', 'Cholchagua')
    );
    $wine_name = array(
        'snack'=>"과자",
        'cs'=>'Champagne & Sparkling',
        'sw'=>'Sweet Wines',
        'ww'=>'Whilte Wine',
        'rw'=>'Red Wine'
    );
?>