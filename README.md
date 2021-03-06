PHPTemplate
===========

Introduction
------------

This package is a part of the Hups Framework. It is an extremely lightweight
template class based on native PHP.

This library is forked from: https://github.com/lsolesen/php-template/

 

Installation
------------

https://packagist.org/packages/shakahl/hups-util-phptemplate

Add `shakahl/hups-util-phptemplate` as a requirement to `composer.json`:

```javascript
{
    "require": {
        "shakahl/hups-util-phptemplate": "dev-master"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

You can also add the package using `composer require shakahl/hups-util-phptemplate` and later specifying the version you want (for now, `dev-master` is your best bet).
 

Usage example
-------------
 

### Example for usage

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<?php  
$path = './templates/';  

$tpl = new \Hups\Util\PHPTemplate('/path/to/template_file.php');
$tpl->some_title = 'User list';
$tpl->userArray = array(
    array(
        "id" =>  1,
        "name" => "John Doe1"
    ),
    array(
        "id" =>  2,
        "name" => "John Doe2"
    ),
    array(
        "id" =>  3,
        "name" => "John Doe3"
    )
);
$tpl->set('another_variable', 'some value');
$tpl->assign('another_variable2', 'some value');
$renderedOutput = $tpl->fetch('template-tpl.php');
$tpl->display('template-tpl.php');
?>
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

### Example template file

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<!-- test_template.tpl.php -->
<h1><?php echo $some_title; ?></h1>
<table>  
    <tr>  
        <th>Id</th>  
        <th>Name</th>  
        <th>Email</th>  
        <th>Banned</th>  
    </tr>  
    <?php foreach($userArray as $usr): ?>  
    <tr>  
        <td><?php echo $usr['id']; ?></td>  
        <td><?php echo $usr['name']; ?></td>  
    </tr>  
    <?php endforeach; ?>  
</table>
<p>
<?php echo $this->another_variable; // Can be used like this ?>
</p>
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

 

Unit testing
------------
 

### Under Windows

```
$ composer update
$ vendor/bin/phpunit​.bat
```
 

### Under Linux

```
$ composer update
$ vendor/bin/phpunit​
```
