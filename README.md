A symfony2 bundle for creating a short link service (e.g. bit.ly, tiny.cc, t.co, goo.gl).


Configuration
-------------

The following are the defaults (`./app/console config:dump dpb_shortcode`):

    Default configuration for extension with alias: "dpb_shortlink"
    dpb_shortlink:
    
        # Redirection URL when accessing / (or null to return a 404)
        root:                 ~
    
        # Options for generating short links
        link:
    
            # Character set to use for auto-generated short codes
            characters:           ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789
    
            # Length of auto-generated short codes
            default_length:       6


**Database** - currently only using Doctrine ORM (e.g. MySQL)...

    GRANT USAGE ON *.* TO app_shortlink@localhost IDENTIFIED BY 'test1234';
    GRANT ALL PRIVILEGES ON app_shortlink.* TO app_shortlink@localhost;
    CREATE DATABASE app_shortlink CHARSET = utf8 COLLATE = utf8_general_ci;


**Security Roles** - the following are used...

 * `ROLE_DPB_SHORTLINK_CREATE` - permission to create new links

**QR Codes** - separate library to install from [phpqrcode.sourceforge.net](http://phpqrcode.sourceforge.net/) (LGPL),
if necessary...

    wget 'http://downloads.sourceforge.net/project/phpqrcode/releases/phpqrcode-2010100721_1.1.4.zip'
    unzip phpqrcode-2010100721_1.1.4.zip
    rm phpqrcode-2010100721_1.1.4.zip


Examples
--------

**Links**

 * `http://localhost/uKWRY9` - standard clickthru link
 * `http://localhost/uKWRY9/url.txt` - simple response of the destination URL
 * `http://localhost/uKWRY9/qrcode.png` - generate QR image - accepts `ec` (correction level; **`l`**, `m`, `q`, `h`) and `s` (size; **3**)

**Security Configuration** (`app/config/security.yml`)

    providers:
        in_memory:
            memory:
                users:
                    myuser:
                        password: "mypass"
                        roles:
                            - "ROLE_DPB_SHORTLINK_CREATE"
                    anon:
                        password: "anon"
                        roles: []
    firewalls:
        api:
            pattern: "^/\+/"
            http_basic:
                realm: "API Endpoint"


**API**

    curl -si --user myuser:mypass -d url='http://www.example.com/hello-world.html' 'http://localhost/+/link/create-unique' | grep -iE '(location|http/)'


License
-------

[MIT License](./LICENSE)

