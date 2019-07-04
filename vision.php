    <!DOCTYPE html>
    <html>
    <head>
        <title>Analyze Sample</title>
        <script src="jquery.min.js"></script>
    </head>
    <body>
<style>
	  
	  
	  
	  
</style>

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
    
     
    <h1>Analyze image:</h1>
    Enter the URL to an image, then click the <strong>Analyze image</strong> button.
    <br><br>
    Image to analyze:
    <input type="text"  name="inputImage" id="inputImage"
        value="http://upload.wikimedia.org/wikipedia/commons/3/3c/Shaki_waterfall.jpg" />
    <button onclick="processImage()">Analyze image</button>
    <br><br>
    <div id="wrapper" style="width:1020px; display:table;">
        <div id="jsonOutput" style="width:600px; display:table-cell;">
            Response:
            <br><br>
            <textarea id="responseTextArea" class="UIInput"
                      style="width:580px; height:300px;"></textarea>
        </div>
        <div id="imageDiv" style="width:420px; display:table-cell;">
            Source image:
            <br><br>
            <img id="sourceImage" width="400" />
        </div>

    </div>

    </body>
    <p id="demo"></p></br>
     <p id="demo2"></p>
  

    </html>
