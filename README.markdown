About this tool
---------------

This Zend Controller Action Helper allows to pass some variables from controller javscript.

Instalation Steps:
-------

 - Create the path *Cf/Controller/Acttion/Helper/* in the standard library folder on you Zend Framework installation directory.
 - Add a autoloader namespace on your application configuration file (*autoloaderNamespaces[] = "Cf"*).
 - Drop the file *Jcf.php* in the folder *Cf/Controller/Acttion/Helper/* that you have just created.
 - On your bootstrap class, execute the following command: *Zend_Controller_Action_HelperBroker::addPrefix('Cf_Controller_Action_Helper')*
 - On your view script, add a call to headScript ("*echo $this->headScript()*").

Usage:
-------

Just call (on your controller):

    $this->_helper->jcf->name = "Eduardo";
    $this->_helper->jcf->age = 25;

Automatically, these values will be present on your view (inside the variable jcf)

    // Will alert "Eduardo"
    <?php echo $this->headScript()->appendScript('alert(jcf.name)') ?>

You can also call jcf helper as a function

    // Equivalent to ...->jcf->name = "Eduardo"
    $this->_helper->jcf("name","Eduardo");

If you do not want to allow values to change, you can call the following method:

    $this->_helper->jcf->setAllowOverwrite(false);
