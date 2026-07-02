<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sync_manager stub — prevents "Unable to load the requested class" errors.
 * The real implementation does not exist yet; this placeholder keeps CI3 happy
 * wherever the library is loaded (hooks, controllers, etc.).
 */
class Sync_manager {

    public function run()     { return TRUE; }
    public function enqueue() { return TRUE; }
    public function tick()    { return TRUE; }
}
