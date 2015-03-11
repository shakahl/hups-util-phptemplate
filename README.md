# Introduction

This package is a part of the Hups Framework. It is an extremely lightweight template class based on native PHP.


# Installation

https://packagist.org/packages/shakahl/hups-php-template

# Examples

Example for utilizing
--

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

Example template file

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



