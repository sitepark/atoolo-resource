<?php

/* Bootstrap */
if (!isset($context)) {
        $context = include(
            __DIR__ .
            '/./WEB-IES/sitekit-module/php/bootstrapper.php'
        );
}
if (!isset($lifecycle)) {
        $lifecycle = $context->getAttribute('lifecycle');
}

$resource = $context->redirectToTranslation($lifecycle, '/index.php');
if ($resource !== null) {
        return $resource;
}

/* Lifecylce-Process */
$resource = $lifecycle->init([
        "id" => 1118,
        "version" => "1694758793440",
        "encoding" => "UTF-8",
        "locale" => "en_US",
        "objectType" => "home",
        "url" => "/index.php",
        "name" => "Homepage",
        "anchor" => "internetwebsite.home",
]);
if ($lifecycle->finish($resource)) {
    return $resource;
}

if ($lifecycle->process("base", $resource)) {
    $resource->process("base", [
        "date" => 1571988240
    ]);
}

if ($lifecycle->finish($resource)) {
    return $resource;
}

if ($lifecycle->process("metadata", $resource)) {
    $resource->process("metadata", [
        "description" => "The new website with up-to-date information."
    ]);
}

if ($lifecycle->finish($resource)) {
    return $resource;
}

if ($lifecycle->process("searchindexdata", $resource)) {
    $resource->process("searchindexdata", [
        "content" => "The new website with up-to-date information."
    ]);
}

if ($lifecycle->finish($resource)) {
    return $resource;
}

if ($lifecycle->process("content", $resource)) {
    $resource->process("content", [
        "type" => "ROOT",
        "id" => "ROOT",
        "items" => [[
                "type" => "main",
                "id" => "main",
                "items" => [[
                ]]
        ]]
    ]);
}
if ($lifecycle->finish($resource)) {
    return $resource;
}

return $lifecycle->service($resource);
