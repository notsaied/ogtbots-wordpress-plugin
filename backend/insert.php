<?php
/**
*
* [script name] => Fetch Data From Ogtbots API
*
* [Author] => Ahmed Saied Aka Saiedoz
*
* [facebook] => Fb.com/notsaied
*
* [telegram] => t.me/notsaied
*
*/
require_once('../../../../wp-load.php' );
require_once ABSPATH . "wp-admin/includes/image.php";
/**
*
* Get Data From Request
*
*/
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        die(json_encode(['error'=>'We only accept POST request !']));
    }

    $hook = file_get_contents('php://input');

    // Converts it into a PHP object
    $data = json_decode($hook,true);
    
    $categoryID = [];

    foreach($data["category"] as $singleCategory):
        $tagID = wp_insert_term(
            $singleCategory,
            'category' ,
            [
            'slug' => $singleCategory
            ]
        );

        $categoryID[] = (is_wp_error($tagID)) ? $tagID->error_data['term_exists'] : $tagID["term_id"];

    endforeach;

/**
*
* Insert Post In DB
*
* @function(string,string,string,string,int,int)
*
*/
    $postID = wp_insert_post([
        'post_title'    => $data["title"],
        'post_content'  => $data["description"],
        'post_type'     => 'post',
        'post_status'   => 'publish', // type of post [draft - publish]
        'post_author'   => 1, // 1 = admin
        'post_category' => $categoryID

    ]); //end wp_insert function
 

/**
*
* Updata Post With Links
*
*/
    wp_set_object_terms($postID, $categoryID, "category");
    update_post_meta($postID, "watch", $data["watch"] );
    update_post_meta($postID, "downloads", $data["downloads"] );

    if(!empty($data["number"]) && $data["number"] != ""){
        update_post_meta($postID, "number", $data["number"]);
    }

/**
*
* Set Post Terms
*
*/

    $castRaws = array_keys($data['cast']);

    foreach($castRaws as $raw)
    {
        if(!empty($data['cast'][$raw])) {
            wp_set_post_terms($postID, array_values($data['cast'][$raw]), $raw);
        }
    }

/**
*
* data[poster]@<string>
*
* check if poster exists and fetch it
*
*/

    if(!empty($data['poster'])):

      $uploadDir = wp_upload_dir();

      $image = wp_remote_fopen($data['poster']);

      $fileName = basename($data['poster']);

      $fileExtention = substr($fileName,strripos($fileName, '.'));

      $fileName = str_replace(

        $fileExtention,

        "-" . $postID . $fileExtention,

        $fileName

       );

      $file = (wp_mkdir_p($uploadDir["path"])) ? $uploadDir["path"] . "/" . $fileName : $uploadDir["basedir"] . "/" . $fileName;

      file_put_contents($file,$image);

      $wpFileType = wp_check_filetype($fileName, NULL);

      $attachment = [
        'post_mime_type' => $wpFileType["type"],
        'post_title' => sanitize_file_name($fileName),
        'post_content' => '',
        'post_status' => 'inherit'
      ];

      $attachID = wp_insert_attachment($attachment,$file,$postID);

      $attachData = wp_generate_attachment_metadata($attachID,$file);

      wp_update_attachment_metadata($attachID, $attachData);

      set_post_thumbnail($postID,$attachID);

    endif;

/**
*
* $data[selary] = @array[]
*
* check if selary is exists and fetch it
*
*/
    if(isset($data["selary"]) and count($data["selary"]) > 0):

        $tagID = wp_insert_term(

            $data["selary"],

            'selary',

            [
                'slug' =>$data["selary"]
            ]

        );

        $catID = (is_wp_error($tagID)) ? $tagID->error_data['term_exists'] : $tagID["term_id"];

        wp_set_post_terms($postID, array_values([$catID]), "selary");

    endif;

    if(is_int($postID)):
        $result = ['result'=>true,'description'=>'successfull post inserted !'];
    else:
        $result = ['result'=>false,'description'=>'try again , or contact to developer'];
    endif;

/**
*
* Response With JSON
*
* @header,json_encode
*
*/
    header('content-type: application/json');
    echo json_encode($result);