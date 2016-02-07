; Example configuration for a local development installation.
; See rox_default.ini for a more complete list of configuration options.

[db]
dsn = "mysqli:host=localhost;dbname=bewelcome"
user = "bewelcome"
password = "bewelcome"

[env]
; set override to https://bewelcome to force ssl, or http://bewelcome to disable it
force_ssl_sensitive = true
;if true, forces ssl for login, signup, verification, pwd change regardless of what other settings might suggest.

[map]
; OSM tiles provider URL
osm_tiles_provider_base_url = http://otile2.mqcdn.com/tiles/1.0.0/map//{z}/{x}/{y}.jpg
; OSM tiles provider API key (currently not required by MapQuest)
osm_tiles_provider_api_key =

[development]
