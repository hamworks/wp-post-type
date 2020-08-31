# wp-post-type

```php
$builder = new HAMWORKS\WP\Post_Type\Builder( 'slug', 'name' );
$builder->set_options( 
    [
        'public'      => true,
        'description' => '',
        'has_archive' => true,
    ]
);
$builder->create();
```
