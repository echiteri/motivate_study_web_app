<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//namespace google\appengine\api\cloud_storage;
//require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
//use google\appengine\api\cloud_storage\CloudStorageTools;

$options = [ 'gs_bucket_name' => 'motivatestudy-967.appspot.com' ];
$upload_url = CloudStorageTools::createUploadUrl('/import_data.php', $options);

?>
<form action="<?php echo $upload_url?>" enctype="multipart/form-data" method="post">
    Files to upload: <br>
   <input type="file" name="uploaded_files" size="40">
   <input type="submit" value="Send">
</form>