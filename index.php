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
        
    // // Create container options object.
    // $createContainerOptions = new CreateContainerOptions();
        
    // $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
        
    // // Set container metadata.
    // $createContainerOptions->addMetaData("key1", "value1");
    // $createContainerOptions->addMetaData("key2", "value2");
            
    $containerName = "blockblobs";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Blob Storage</title>
    <style type="text/css">
        .table {
            font-family: sans-serif;
            color: #444;
            border-collapse: collapse;
            width: 50%;
            border: 1px solid #f2f5f7;
        }
        
        .table tr th{
            background: #35A9DB;
            color: #fff;
            font-weight: normal;
        }
        
        .table, th, td {
            padding: 8px 20px;
            text-align: center;
        }
        
        .table tr:hover {
            background-color: #f5f5f5;
        }
        
        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Daftar Gambar dan file dari Azure Blob Storage</h2>
    <button></button>
    <table class="table">
        <thead>
            <th>No. </th>
            <th>Nama File</th>
            <th>Link Url</th>
            <th>Gambar</th>
            <th colspan="2">Aksi</th>
        </thead>
        <tbody>
        <?php 
            // if (isset($_POST['delete'])) {

            // }
            // List blobs.
            $listBlobsOptions = new ListBlobsOptions();
            $listBlobsOptions->setPrefix("");

            $i = 0;
            do {
                $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
                
                foreach ($result->getBlobs() as $blob) {
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $blob->getName(); ?></td>
                <td><?php echo $blob->getUrl(); ?></td>
                <td><img src="<?php echo $blob->getUrl(); ?>"></td>
                <td><?php echo "Analyze"; ?></td>
                <td><?php echo "Delete"; ?></td>
            </tr>
        <?php 
                }
                $listBlobsOptions->setContinuationToken($result->getContinuationToken());
            } while($result->getContinuationToken());
        ?>
        </tbody>
    </table>
</body>
</html>