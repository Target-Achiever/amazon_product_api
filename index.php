<?php

// Your Access Key ID, as taken from the Your Account page
$access_key_id = "AKIAISEFW6RGJWKJJCFQ";

// Your Secret Key corresponding to the above ID, as taken from the Your Account page
$secret_key = "CVq3UGnnpNeU0ysTMkM/EZoErpHJGZTpSmTDC23+";

// The region you are interested in
$endpoint = "webservices.amazon.co.uk";

$uri = "/onca/xml";

$params = array(
    "Service" => "AWSECommerceService",
    "Operation" => "ItemSearch",
    "AWSAccessKeyId" => "AKIAISEFW6RGJWKJJCFQ",
    "AssociateTag" => "heartfaceuk-21",
    "SearchIndex" => "Beauty",
    "Keywords" => "aroma",
    "ResponseGroup" => "Images,ItemAttributes,Offers"
);

// Set current timestamp if not set
if (!isset($params["Timestamp"])) {
    $params["Timestamp"] = gmdate('Y-m-d\TH:i:s\Z');
}

// Sort the parameters by key
ksort($params);

$pairs = array();

foreach ($params as $key => $value) {
    array_push($pairs, rawurlencode($key)."=".rawurlencode($value));
}

// Generate the canonical query
$canonical_query_string = join("&", $pairs);

// Generate the string to be signed
$string_to_sign = "GET\n".$endpoint."\n".$uri."\n".$canonical_query_string;

// Generate the signature required by the Product Advertising API
$signature = base64_encode(hash_hmac("sha256", $string_to_sign, $secret_key, true));

// Generate the signed URL
$request_url = 'https://'.$endpoint.$uri.'?'.$canonical_query_string.'&Signature='.rawurlencode($signature);

$response = file_get_contents($request_url);

$pxml = @simplexml_load_string($response,true);

print_r($pxml);

?>