<?php 
    require_once 'vendor/autoload.php';
        
    use MicrosoftAzure\Storage\Blob\BlobRestProxy;
    use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
    use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
    use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
    use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
        
    $connectionString = "DefaultEndpointsProtocol=https;AccountName=meirusfandiwev;AccountKey=vwhIwbU1kaFKEZMFWTd5ng21ux0PA8P8XRgUgo6atp8xbKPYFStk5vz+7/lTIG8SyZ/37LGfYqQxqbsX/EIwCQ==;EndpointSuffix=core.windows.net";
        
    // Create blob client.
    $blobClient = BlobRestProxy::createBlobService($connectionString);
                  
    $containerName = "blockblobs";

    if (isset($_POST['upload'])){
        try {
            // Getting local file so that we can upload it to Azure
            $filename = strtolower($_FILES['file']['name']);
            $filecontent = fopen($_FILES['file']['tmp_name'], "r");
            
            # Upload file as a block blob
            echo "Uploading File: ".PHP_EOL;
            echo $filename;
            echo " Successfully<br />";
            echo '<a href="index.php"><button>Back To Main</button></a>';

            //Upload blob
            $blobClient->createBlockBlob($containerName, $filename, $filecontent);
        } catch(ServiceException $e){
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message."<br />";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Upload</title>
</head>
<body>
    <h2>Upload new Photo</h2>
    <form action="upload.php">
        <input type="file" name="file" id="file">
        <input type="submit" value="Upload" name="upload">
    </form>
</body>
</html>