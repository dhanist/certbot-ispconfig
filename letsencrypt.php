<?php
    include('soap.php');

    function usage()
    {
        global $argv;
        echo("Usage : " . $argv[0] . " domain text\n");
        exit(1);
    }

    if (count($argv) != 3)
        usage();

    $domain = $argv[1] . '.';
    $txt    = $argv[2];

    define('RECORD', '_acme-challenge.' . $domain);

    $sid = login();
    if (!$sid) exit("Login Error\n");

    $zone = $client->dns_zone_get($sid, array('origin' => $domain));
    if (count($zone) == 0) {
        fwrite(STDERR, "Error: Domain name " .$argv[1]." does not exist\n");
        logout($sid);
        exit(1);
    }
    $uid = $client->client_get_id($sid, $zone[0]['sys_userid']);

    $params = array(
      'sys_userid' => $zone[0]['sys_userid'],
      'sys_groupid'=> $zone[0]['sys_groupid'],
      'server_id'  => $zone[0]['server_id'],
      'zone'       => $zone[0]['id'],
      'type'       => 'TXT',
      'name'       => RECORD,
      'active'     => 'y'
    );

    $rec = $client->dns_txt_get($sid, $params);
    $params['data'] = $txt;
    $params['ttl']  = DNS_TTL;

    if (count($rec) != 1) {
        for ($i = 0; $i < count($rec); $i++)
            $client->dns_txt_delete($sid, $rec[$i]["id"]);

        $client->dns_txt_add($sid, $uid, $params);
    } else {
        $client->dns_txt_update($sid, $uid, $rec[0]["id"], $params);
    }

    logout($sid);
    sleep(SERVER_WAIT);
?>
