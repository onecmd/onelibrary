http://www.yiiframework.com/extension/ehttpclient

============================================================

Requirements 

Working from Yii v1.1.5 till v1.1.9

TODO 

Add streaming support

Usage 

Unpack compressed files and place them on your protected/extensions directory.

You can refer to the Zend_Http_Client documentation (remember to exchange the names from Zend to those in the extension).

Here two easy samples (Send me your tests, I would love to see more in action)

Example 1 - Getting my twitter statuses

Yii::import('ext.httpclient.*');
 
// get my twitter status
$client = new EHttpClient('http://twitter.com/statuses/user_timeline/tonydspaniard.xml', array(
    'maxredirects' => 0,
    'timeout'      => 30));
 
$response = $client->request();
 
if($response->isSuccessful())
    echo '<pre>' . htmlentities($response->getBody()) .'</pre>';
else
    echo $response->getRawBody();
Example 2 - Performing a Full Page Google Search Now, using EHttpClientAdapterCurl

Yii::import('ext.httpclient.*');
 
$client = new EHttpClient('http://www.google.es/search', array(
    'maxredirects' => 3,
    'timeout'      => 30,
    'adapter'      => 'EHttpClientAdapterCurl'));
 
$client->setParameterGet(array('hl'=>'es', 'q'=>'manolo'));
 
$response = $client->request();
 
if($response->isSuccessful())
   echo $response->getBody();
else
   $response->getRawBody();
Example 3 - Downloading using stream

Yii::import('ext.httpclient.*');
 
$uri = EUri::factory('http://www.ip2nation.com/ip2nation/Download/');
 
$temp_dir = realpath(sys_get_temp_dir()). DIRECTORY_SEPARATOR;
 
$temp_file = tempnam($temp_dir, 'TEST');
 
$config = array('adapter'=>'EHttpClientAdapterCurl', 'timeout'=>'60');
 
$client = new EHttpClient($uri, $config);
$client->setStream();
 
$response = $client->request('GET');
 
if($response->isSuccessful()){
   // copy stream to temporary file... 
   copy( $response->getStreamName(), $temp_dir . $temp_file );
   // other work with temporary file (ie decompress, decrypt, etc...)
}
else
   $response->getRawBody();
ChangeLog 

version 1.0.2 Fixed really silly reference bug
version 1.0.1 Added streaming support
version 1.0.0 Initial public release