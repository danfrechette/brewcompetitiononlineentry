<?php 
    require_once CLASSES.'twig/vendor/autoload.php';

    include (DB.'sponsors.db.php');

    define('PATH_SCRSHT_IMAGES' , realpath(ADMIN . "_scoresheets/_ScoreSheet_Images/" ) . "\\");
    define('URL_SCRSHT_IMAGES'  , $base_url . "admin/_scoresheets/_ScoreSheet_Images/");

    function _jpkImages($var){ return preg_match('/^jpk-image-[hd|lh|rh|cn]/', $var); }

    $packetImages = [
        'jpk-image-hd'     => URL_SCRSHT_IMAGES . '_Uploaded/sheet_header.png',
        'jpk-image-hd-txt' => URL_SCRSHT_IMAGES . '_Uploaded/jpk-image-hd-txt.png',
        'jpk-image-lh'     => URL_SCRSHT_IMAGES . '_Uploaded/cs_lh_col.png',
        'jpk-image-rh'     => URL_SCRSHT_IMAGES . '_Uploaded/cs_rh_col.png',
        'jpk-image-cn'     => URL_SCRSHT_IMAGES . '_Uploaded/cs_mn_bdy.png'
    ];

    foreach(array_filter( directory_contents_dropdown(USER_IMAGES , "none" , "2") , "_jpkImages") as $f){
        $path_parts = pathinfo($f);
        $packetImages[$path_parts['filename']] = $base_url . "user_images/" . $f;
    }

    function db_process_enum_data($connection, $db_table ){
        $sql = "SELECT * FROM `" . $db_table . "` WHERE `id`= 1;";
        
        $prefs = mysqli_query($connection, $sql) or die (mysqli_error($connection));
        $values = mysqli_fetch_assoc( $prefs );

        $sql = "SHOW COLUMNS FROM `" . $db_table . "` where `type` like 'enum%';";
        $prefs = mysqli_query($connection, $sql) or die (mysqli_error($connection));
        $collection = array();

        while ($row = mysqli_fetch_assoc( $prefs )) {
            $val = 1;
            $field_name = $row['Field'];
            $elems = explode("','" , preg_replace("/(enum|set)\('(.+?)'\)/" , "\\2" , $row['Type']));

            foreach($elems as &$el) {
                $el = array('label'  => $el , 'index'=> $val);
                if($el['label'] === $values[$field_name]){ $el['active'] = True; }
                $val++;                
            }

            $collection += [$field_name => $elems];
        }
        return $collection;
    }
    
    $loader = new \Twig\Loader\FilesystemLoader(ADMIN.'_scoresheets/views');
    $twig   = new \Twig\Environment($loader);

    $boolLambda = function($value) { return  "`" . $value . "`+0 AS `" . $value . "`"; };

    $fields = [
        "inc_flight_sheet", 
        "inc_specialty_sheet",
        "inc_cover_sheet",         
        "inc_page_header",
        "inc_scoresheets", 
        "inc_cat_sponsors", 
        "inc_qrcodes", 
        "inc_tracking_numbers", 
        "assigned_tracking_numbers"
    ];
   
    ### DRF should lock in to comp with where statement
    $query_prefs = sprintf("SELECT ". implode(" , " , array_map($boolLambda , $fields) ) . " FROM `%s` ", $prefix."judging_packet_preferences"); 
    $prefs = mysqli_query($connection,$query_prefs) or die (mysqli_error($connection));
 
    $packet_options = mysqli_fetch_assoc($prefs);
    $controls = db_process_enum_data($connection, "judging_packet_preferences");

    echo "<br>".$twig->render('index.ScoreSheetCreation.twig', array(
        'base_url'=> $base_url,
        'url_ScrShtImages'=>URL_SCRSHT_IMAGES,
        'packetImages' => $packetImages, 
        'packet_options'=>$packet_options,        
        'controls'=>$controls,
        'url_action' => sprintf( '%1$s' . "includes/ajax_functions.inc.php?action=toggle", $base_url),
    ));
?>

