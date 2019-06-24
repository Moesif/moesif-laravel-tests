<?php

/**
 * mask request headers by removing fields
 *
 * @return headers
 */
$maskRequestHeaders = function($headers) {
    $headers['header3'] = 'adding rather the removing, but should work the same.';
    return $headers;
};

/**
 * Remove any fields from body that you don't want to send to Moesif.
 *
 * @return body
 */
$maskRequestBody = function($body) {
    return $body;
};

/**
 * mask request headers by removing fields
 *
 * @return headers
 */
$maskResponseHeaders = function($headers) {
    $headers['header2'] = '';
    return $headers;
};

/**
 * Remove any fields from body that you don't want to send to Moesif.
 *
 * @return body
 */
$maskResponseBody = function($body) {
    return $body;
};

/**
 * users the userId. If your app differs from standard lararvel for identify users.
 *
 * @return string
 */

$identifyUserId = function($request, $response) {
    if (is_null($request->user())) {
        return null;
    } else {
        $user = $request->user();
        return $user['id'];
    }
};

/**
 * Use this function to find tokenId . If your app differs from standard lararvel for tokenIds.
 *
 * @return string
 */
$identifySessionId = function($request, $response) {
    if ($request->hasSession()) {
        return $request->session()->getId();
    } else {
        return null;
    }
};

/**
 * Use this function to set companyId.
 *
 * @return string
 */

$identifyCompanyId = function($request, $response) {
    return "12345";
};

/**
 * If you want to add any other tags to this event. Please comma separate them,
 *
 * @return string
 */
$addTags = function($request, $response) {
    return 'nada, profile';
};

return [
    'applicationId' => 'Your Application Id',
    'maskRequestHeaders' => $maskRequestHeaders,
    'maksRequestBody' => $maskRequestBody,
    'maskResponseHeaders' => $maskResponseHeaders,
    'maskResponseBody' => $maskResponseBody,
    'identifyUserId' => $identifyUserId,
    'identifyCompanyId' => $identifyCompanyId,
    'identifySessionId' => $identifySessionId,
    'apiVersion' => '1.2.2',
    'debug' => false,
    'addTags' => $addTags
];
