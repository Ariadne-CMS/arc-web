arc\route
=========

This component provides very basic URL routing. You could use it like this:

    $config = [
        '/blog/' => function($remainder) {
                if ( preg_match( '/(?<id>\d+)(?<format>\..+)?/', $remainder, $params ) ) {
                    switch ( $params['format'] ) {
                        case '.json':
                            return json_encode( blog::get($params['id']) );
                        break;
                        case '.html':
                            ...
                        break;
                    }
                    return 'Error: unknown format '.$params['format'];
                } else {
                    return 'main';
                }
            },
        '/' => function($remainder) {
                if ( $remainder ) {
                    return 'notfound';
                } else {
                    return 'home';
                }
            }
    ];
    $result = \arc\route::match('/blog/42.html', $config);
     
URL routing is a good way to implement a REST api, but in this form less usefull for a CMS system. Mostly because routes
are defined in code instead of user editable data. So use it with care.

`arc/route` doesn't implement parameter matching. The example above shows a very simple syntax using regular expressions
which is easy to learn and much more powerfull than anything we could build. The most basic use works like this:
 
    if ( preg_match( '|(?<name>[^/]+)/|', $path, $params ) ) {
        echo $params['name'];
    }
    
The syntax `(?<name>` means that the expression following it, untill the next matching `)` will store its matching value
in $params['name']. You can use any regular expression inside it. In this case the actual regular expression used is 
`[^/]+` which will match any character except '/'.
    