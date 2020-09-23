<?php
    /*
     * You may need to secure this file with chmod 600
     *
     * Remote CP account. This remote account needs access to these modules
     * - server function
     * - client function
     * - dns zone function
     * - dns txt function
     *
     * You need to enable access to the above functions from the
     * ISPConfig web interface
     */
    define('USERNAME', 'certbot');
    define('PASSWORD', 'password');
    define('SOAP_LOCATION', 'https://localhost/remote/index.php');
    define('SOAP_URI', 'https://localhost/remote/');

    /*
     * How long should we wait (in seconds) for the changes
     * to propagate accross servers and reload the service.
     */
    define('SERVER_WAIT', 120);

    /* DNS record time to live value for _acme-challenge TXT record. */
    define('DNS_TTL', "300");
?>
