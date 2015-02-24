<?php
/*
 * Copyright 2013. Amazon Web Services, Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
**/


// Include the SDK using the Composer autoloader
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Common\Credentials\Credentials;

/*
 If you instantiate a new client for Amazon Simple Storage Service (S3) with
 no parameters or configuration, the AWS SDK for PHP will look for access keys
 in the AWS_ACCESS_KEY_ID and AWS_SECRET_KEY environment variables.

 For more information about this interface to Amazon S3, see:
 http://docs.aws.amazon.com/aws-sdk-php-2/guide/latest/service-s3.html#creating-a-client
*/
 
 $credentials = new Credentials('YOUR_AWS_ACCESS_KEY_ID', 'YOUR_AWS_SECRET_KEY');
 $client = S3Client::factory(array(
    'credentials' => $credentials
));

/*
 Everything uploaded to Amazon S3 must belong to a bucket. These buckets are
 in the global namespace, and must have a unique name.

 For more information about bucket name restrictions, see:
 http://docs.aws.amazon.com/AmazonS3/latest/dev/BucketRestrictions.html
*/

//uniqid("php-sdk-sample-", true);
          $bucket='your name of bucket'; 
          //$bucket = 'icloud-images'; 
          echo "Creating bucket named : {$bucket}";
          echo '<br>';
          $result = $client->createBucket(array('Bucket' => $bucket));

// Wait until the bucket is created
// $client->waitUntilBucketExists(array('Bucket' => $bucket));

/*
 Files in Amazon S3 are called "objects" and are stored in buckets. A specific
 object is referred to by its key (i.e., name) and holds data. Here, we create
 a new object with the key "uploaded file name",SourceFile "temporary path of the file",
 ContentType "type of the file".

 For a detailed list of putObject's parameters, see:
 http://docs.aws.amazon.com/aws-sdk-php-2/latest/class-Aws.S3.S3Client.html#_putObject
*/
         
         $key = $_FILES["fileToUpload"]["name"];
         $path = $_FILES["fileToUpload"]["tmp_name"];
         $type = $_FILES["fileToUpload"]["type"];

         echo "Creating a new object with key {$key}";
         echo "<br>";
         $result = $client->putObject(array(
                  'Bucket' => $bucket,
                  'Key'    => $key,
                  'SourceFile' => $path,
                  'ACL'        => 'public-read',
                  'ContentType' => $type,
                                         ));

            // We can poll the object until it is accessible
             $client->waitUntil('ObjectExists', array(
             'Bucket' => $bucket,
             'Key'    => $key
));
  
       echo "Link of uploaded file:";
       echo "<br>";
       print_r($result['ObjectURL']);
       echo "<br>";
    

/*
 Download the object and read the body directly.

 For more examples of downloading objects, see the developer guide:
 http://docs.aws.amazon.com/aws-sdk-php-2/guide/latest/service-s3.html#downloading-objects

 Or the API documentation:
 http://docs.aws.amazon.com/aws-sdk-php-2/latest/class-Aws.S3.S3Client.html#_getObject
*/
      echo "Downloading that same object:";
      echo "<br>";
            $result = $client->getObject(array(
                      'Bucket' => $bucket,
                      'Key'    => $key,
                      'SaveAs' => 'tmp/'.$key
                        ));


                      echo "\n---BEGIN---\n";
                      echo "<br>";
                      print_r($result);
                      echo "<br>";
                      echo "\n---END---\n\n";
                      echo "<br>";


/*
 Buckets cannot be deleted unless they're empty. With the AWS SDK for PHP, you
 have two options:

  - Use the clearBucket helper:
      http://docs.aws.amazon.com/aws-sdk-php-2/latest/class-Aws.S3.S3Client.html#_clearBucket
  - Or individually delete all objects.

 Since this sample created a new unique bucket and uploaded a single object,
 we'll just delete that object.
*/
 echo "Deleting object with key {$key}";
 echo "<br>";
$result = $client->deleteObject(array(
    'Bucket' => $bucket,
    'Key'    => $key
));

/*
 Now that the bucket is empty, it can be deleted.

 See the API documentation for more information on deleteBucket:
 http://docs.aws.amazon.com/aws-sdk-php-2/latest/class-Aws.S3.S3Client.html#_deleteBucket
*/
// echo "Deleting bucket {$bucket}\n";
// $result = $client->deleteBucket(array(
//     'Bucket' => $bucket
// ));

//listing  your bucket
echo "Bucket listing";
echo "<br>";
$result = $client->listBuckets();
foreach ($result['Buckets'] as $bucketlist)
 {
    // Each Bucket value will contain a Name and CreationDate
    echo "{$bucketlist['Name']} - {$bucketlist['CreationDate']}";
 }