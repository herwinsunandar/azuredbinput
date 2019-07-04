<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
</style>
</head>
        <script src="jquery.min.js"></script>

<body>
    <script type="text/javascript">
        function processImage() {
            // **********************************************
            // *** Update or verify the following values. ***
            // **********************************************
     
            // Replace <Subscription Key> with your valid subscription key.
            var subscriptionKey = "48cb7cf83084412e867b3321d8321b3b";
     
            // You must use the same Azure region in your REST API method as you used to
            // get your subscription keys. For example, if you got your subscription keys
            // from the West US region, replace "westcentralus" in the URL
            // below with "westus".
            //
            // Free trial subscription keys are generated in the "westus" region.
            // If you use a free trial subscription key, you shouldn't need to change
            // this region.
            var uriBase =
                "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
     
            // Request parameters.
            var params = {
				 "visualFeatures": "Categories,Description,Color",

                //"visualFeatures": "Description",
                "details": "",
                "language": "en",
         
            };
            
            //var obj = {JSON.parse(params)
			//document.getElementById("demo").innerHTML = obj.Categories + ", " + obj.Description}; 
     
            // Display the image.
            var sourceImageUrl = document.getElementById("inputImage").value;
            document.querySelector("#sourceImage").src = sourceImageUrl;
     
            // Make the REST API call.
            $.ajax({
                url: uriBase + "?" + $.param(params),
     
                // Request headers.
                beforeSend: function(xhrObj){
                    xhrObj.setRequestHeader("Content-Type","application/json");
                    xhrObj.setRequestHeader(
                        "Ocp-Apim-Subscription-Key", subscriptionKey);
                },
     
                type: "POST",
     
                // Request body.
                data: '{"url": ' + '"' + sourceImageUrl + '"}',
            })
     
            .done(function(data) {
                // Show formatted JSON on webpage.
               //$("#responseTextArea").val(JSON.stringify(data, null, 2));

                //$("#responseTextArea").val(JSON.stringify(data, ['categories','name', 'score']));
                $("#responseTextArea").val(JSON.stringify(data, ['description','captions','text']));


                
                var myObj, myJSON, text, obj;

                myJSON = JSON.stringify(data, null, 2);
				//document.getElementById("demo").innerHTML = myJSON; 
				
				localStorage.setItem("testJSON", myJSON);
				//Retrieving data:
				text = localStorage.getItem("testJSON");
				obj = JSON.stringify(data, ['description','captions','text']);
				document.getElementById("demo2").innerHTML = obj;
				
				 })
     
            .fail(function(jqXHR, textStatus, errorThrown) {
                // Display error message.
                var errorString = (errorThrown === "") ? "Error. " :
                    errorThrown + " (" + jqXHR.status + "): ";
                errorString += (jqXHR.responseText === "") ? "" :
                    jQuery.parseJSON(jqXHR.responseText).message;
                alert(errorString);
            });
            
			
			
        };
    </script>
    
<?php
/**----------------------------------------------------------------------------------
* Microsoft Developer & Platform Evangelism
*
* Copyright (c) Microsoft Corporation. All rights reserved.
*
* THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY KIND, 
* EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE IMPLIED WARRANTIES 
* OF MERCHANTABILITY AND/OR FITNESS FOR A PARTICULAR PURPOSE.
*----------------------------------------------------------------------------------
* The example companies, organizations, products, domain names,
* e-mail addresses, logos, people, places, and events depicted
* herein are fictitious.  No association with any real company,
* organization, product, domain name, email address, logo, person,
* places, or events is intended or should be inferred.
*----------------------------------------------------------------------------------
**/

/** -------------------------------------------------------------
# Azure Storage Blob Sample - Demonstrate how to use the Blob Storage service. 
# Blob storage stores unstructured data such as text, binary data, documents or media files. 
# Blobs can be accessed from anywhere in the world via HTTP or HTTPS. 
#
# Documentation References: 
#  - Associated Article - https://docs.microsoft.com/en-us/azure/storage/blobs/storage-quickstart-blobs-php 
#  - What is a Storage Account - http://azure.microsoft.com/en-us/documentation/articles/storage-whatis-account/ 
#  - Getting Started with Blobs - https://azure.microsoft.com/en-us/documentation/articles/storage-php-how-to-use-blobs/
#  - Blob Service Concepts - http://msdn.microsoft.com/en-us/library/dd179376.aspx 
#  - Blob Service REST API - http://msdn.microsoft.com/en-us/library/dd135733.aspx 
#  - Blob Service PHP API - https://github.com/Azure/azure-storage-php
#  - Storage Emulator - http://azure.microsoft.com/en-us/documentation/articles/storage-use-emulator/ 
#
**/
require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

//$connectionString = "DefaultEndpointsProtocol=https;AccountName=".getenv('ACCOUNT_NAME').";AccountKey=".getenv('ACCOUNT_KEY');
$connectionString = "DefaultEndpointsProtocol=https;AccountName=herwinstorage;AccountKey=hGfaejSJBdu2TQ7q9ZG/PZGEMf1OyoTKSmAel9OW8gYwj+CfcI5r7eveS8s/22z8DEVZtv6wODLgek8/q0vy6g==;EndpointSuffix=core.windows.net";

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);


// ambil data file yang akan di upload

//$fileToUpload = "HelloWorld.txt";
$namaFile = $_FILES['berkas']['name'];
$namaSementara = $_FILES['berkas']['tmp_name'];

// tentukan lokasi file akan dipindahkan
//$dirUpload = "terupload/";

// pindahkan file
//$terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

//if ($terupload) {
  //  echo "Upload berhasil!<br/>";
   // echo "Link: <a href='".$dirUpload.$namaFile."'>".$namaFile."</a>";
//} else {
//    echo "Upload Gagal!";
//}

if (!isset($_GET["Cleanup"])) {
    // Create container options object.
    $createContainerOptions = new CreateContainerOptions();

    // Set public access policy. Possible values are
    // PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
    // CONTAINER_AND_BLOBS:
    // Specifies full public read access for container and blob data.
    // proxys can enumerate blobs within the container via anonymous
    // request, but cannot enumerate containers within the storage account.
    //
    // BLOBS_ONLY:
    // Specifies public read access for blobs. Blob data within this
    // container can be read via anonymous request, but container data is not
    // available. proxys cannot enumerate blobs within the container via
    // anonymous request.
    // If this value is not specified in the request, container data is
    // private to the account owner.
    $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

    // Set container metadata.
    $createContainerOptions->addMetaData("key1", "value1");
    $createContainerOptions->addMetaData("key2", "value2");

      //$containerName = "herwin-".generateRandomString();
            $containerName = "herwin-".generateRandomString();


    try {
        // Create container.
        $blobClient->createContainer($containerName, $createContainerOptions);

        // Getting local file so that we can upload it to Azure
       // $myfile = fopen($fileToUpload, "w") or die("Unable to open file!");
                //$myfile = fopen("HelloWorld.txt", "r") or die("Unable to open file!");
                $myfile = fopen($namaSementara, "r") or die("Unable to open file!");


        fclose($myfile);
        
        # Upload file as a block blob
        //echo "Uploading BlockBlob: ".PHP_EOL;
        //echo $namaSementara;
       // echo "<br />";
        
        //$content = fopen($namaSementara, "r");
         $content = file_get_contents($namaSementara, "r");
        

        //Upload blob
        $blobClient->createBlockBlob($containerName, $namaSementara, $content);

        // List blobs.
        $listBlobsOptions = new ListBlobsOptions();
        //$listBlobsOptions->setPrefix("HelloWorld");
         $listBlobsOptions->setPrefix("");

        echo "These are the blobs present in the container: ";

        do{
            $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
            foreach ($result->getBlobs() as $blob)
            {
               // echo $blob->getName().": ".$blob->getUrl()."<br />";
            
           echo
            
             "<input type='hidden'  name='inputImage' id='inputImage'  value=".$blob->getUrl()." />";
        
         echo 
            "<table>
  <tr>
    <th>No</th>
    <th>URL</th>
    <th>Analyze image</th>
  </tr>
  <tr>
    <td>1</td>
    <td><a href=".$blob->getUrl().">Download Link</a> or URL =".$blob->getUrl()."</td>
    <td><button type='button' onclick='processImage()' >Click to Analyze</button> </td>
  </tr>
        </table>" ;   
     "</br>" ;
     echo "<td><a href='input.php'>Upload Lagi</a></td>";
     
     echo     "<br><br>";
     echo     "<img id='sourceImage' class='center'style='width:580px; height:300px;'>";
     echo "<p id='demo2'class='center'></p>";
            
            
            }
        
            $listBlobsOptions->setContinuationToken($result->getContinuationToken());
        } while($result->getContinuationToken());
        //echo "<br />";

        // Get blob.
        //echo "This is the content of the blob uploaded: ";
       // $blob = $blobClient->getBlob($containerName, $namaSementara);
       // fpassthru($blob->getContentStream());
       // echo "<br />";
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
    catch(InvalidArgumentTypeException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
} 
else 
{

    try{
        // Delete container.
        echo "Deleting Container".PHP_EOL;
        echo $_GET["containerName"].PHP_EOL;
        echo "<br />";
        $blobClient->deleteContainer($_GET["containerName"]);
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
}
?>
    
  

    </body>
   
 
  

    </html>



