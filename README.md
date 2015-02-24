# AWS SDK for PHP - Simple Storage Service Demo

A simple PHP application illustrating how to use simple storage service of the AWS SDK for PHP.

## Requirements

A `composer.json` file declaring the dependency on the AWS SDK is provided. To
install Composer and the SDK, run:

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install

## Basic Configuration

You need to set up your AWS security credentials before the sample code is able to connect to AWS. Then open up sample.php and add your **AWS access key and secret**.

    $credentials = new Credentials('YOUR_AWS_ACCESS_KEY_ID', 'YOUR_AWS_SECRET_KEY');

Then add bucket name if not created. Script will automatically create bucket with that name for you.

    $bucket='your name of bucket';

See the [Security Credentials](http://aws.amazon.com/security-credentials) page for more information on getting your keys. You can also set your credentials in a couple of other ways. See the [AWS SDK for PHP documentation](http://docs.aws.amazon.com/aws-sdk-php-2/guide/latest/configuration.html) for more information.

## Running the S3 sample

Just run `index.php` from your localhost and upload file! Thats it!

The S3 documentation has a good overview of the [restrictions for bucket names](http://docs.aws.amazon.com/AmazonS3/latest/dev/BucketRestrictions.html) for when you start making your own buckets.

## License

This sample application is distributed under the
[Apache License, Version 2.0](http://www.apache.org/licenses/LICENSE-2.0).
