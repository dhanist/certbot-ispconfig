<?php
include('conf.php');

$client = new SoapClient(
    NULL,
    array(
        'location'   => SOAP_LOCATION,
        'uri'        => SOAP_URI,
        'trace'      => 1,
        'exceptions' => 1
    )
);

function login()
{
    global $client;
    $sid = NULL;
    try {
        $sid = $client->login(USERNAME, PASSWORD);
    } catch (SoapFault $e) {
        fwrite(STDERR, 'SOAP Error: '.$e->getMessage() . "\n");
        return false;
    }

    return $sid;
}

function logout($sid)
{
    global $client;
    try {
        $client->logout($sid);
        if (!$sid) exit("Logout error");

    } catch (SoapFault $e) {
        exit('SOAP Error: '.$e->getMessage());
    }

    return true;
}

function get_server_id($sid, $name)
{
    global $client;
    try {
        return $client->server_get_serverid_by_name($sid, $name);
    } catch(SoapFault $e) {
        exit('SOAP Error: '.$e.getMessage());
    }
}

?>
