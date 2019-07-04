<?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";
//require_once 'WindowsAzure\WindowsAzure.php';
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=herwinstorage;AccountKey=hGfaejSJBdu2TQ7q9ZG/PZGEMf1OyoTKSmAel9OW8gYwj+CfcI5r7eveS8s/22z8DEVZtv6wODLgek8/q0vy6g==;EndpointSuffix=core.windows.net";
 // Create blob REST proxy.
 $blobClient = BlobRestProxy::createBlobService($connectionString);

 //$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);

 //$content = fopen("c:\myfile.txt", "r"); //this works when hard coded like this
 //$blob_name = "myblob.txt";
 //get posts
 //$fpath = $_POST["resFile"];//tried this too - no go
  $fpath = $_FILES["resFile"];
  $fname = $_FILES["resFile"];

  $content = fopen($fpath, "r"); //I know this isn't right, but trying
  $blob_name = $fname;

 try {
     //Upload blob
     $blobClient->createBlockBlob("saskcontainer", $blob_name, $content);
 }
 catch(ServiceException $e){
// Handle exception based on error codes and messages.
// Error codes and messages are here: 
// http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
$code = $e->getCode();
$error_message = $e->getMessage();
echo $code.": ".$error_message."<br />";
 }
 //and I need to return the url here on success
 ?>
