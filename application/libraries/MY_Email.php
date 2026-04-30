<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Email — extends CI3's Email library
 * Overrides _smtp_connect() to use stream_socket_client() with an SSL context
 * that disables certificate peer verification — required for shared hosting
 * mail servers (e.g. LWS) where the certificate CN doesn't match the SMTP host.
 */
class MY_Email extends CI_Email {

    protected function _smtp_connect() {
        if (is_resource($this->_smtp_connect)) {
            return TRUE;
        }

        $ssl_opts = [
            'verify_peer'       => FALSE,
            'verify_peer_name'  => FALSE,
            'allow_self_signed' => TRUE,
        ];

        $scheme = ($this->smtp_crypto === 'ssl') ? 'ssl://' : '';
        $addr   = $scheme . $this->smtp_host . ':' . $this->smtp_port;
        $ctx    = stream_context_create(['ssl' => $ssl_opts]);

        $this->_smtp_connect = stream_socket_client(
            $addr,
            $errno,
            $errstr,
            $this->smtp_timeout,
            STREAM_CLIENT_CONNECT,
            $ctx
        );

        if (! is_resource($this->_smtp_connect)) {
            $this->_set_error_message('lang:email_smtp_error', $errno . ' ' . $errstr);
            return FALSE;
        }

        stream_set_timeout($this->_smtp_connect, $this->smtp_timeout);
        $this->_set_error_message($this->_get_smtp_data());

        if ($this->smtp_crypto === 'tls') {
            $this->_send_command('hello');
            $this->_send_command('starttls');

            // Apply SSL options to the stream before upgrading to TLS
            stream_context_set_option($this->_smtp_connect, 'ssl', 'verify_peer',       FALSE);
            stream_context_set_option($this->_smtp_connect, 'ssl', 'verify_peer_name',  FALSE);
            stream_context_set_option($this->_smtp_connect, 'ssl', 'allow_self_signed',  TRUE);

            $crypto = stream_socket_enable_crypto(
                $this->_smtp_connect,
                TRUE,
                STREAM_CRYPTO_METHOD_TLS_CLIENT
            );

            if ($crypto !== TRUE) {
                $this->_set_error_message('lang:email_smtp_error', $this->_get_smtp_data());
                return FALSE;
            }
        }

        return $this->_send_command('hello');
    }
}
