fuel-orientdb
=============

fuel-orientdb is a library for using OrientDB in FuelPHP.

This library is still *experimental*. You should not use for production.

Features
========

TODO: implement

Installation
============

* Create [FuelPHP](http://fuelphp.com/) project in new directory. (any installation method you can use. ex:use git-clone, download and extract tarball manually)
* Install [composer](http://getcomposer.org).
* In project dir, create `composer.json` file. *Strongly recommended:* set `vendor-dir` value to `fuel/app/vendor`. ex:

```
{
	"config" : {
		"vendor-dir" : "fuel/app/vendor"
	},
	"require" : {
		"sakuraiyuta/fuel-orientdb" : "dev-master"
	}
}
```

* Execute `composer install`. This command downloads the library and dependencies.
* Change permissions `"project-dir"/fuel/app/vendor/sakuraiyuta/fuel-orientdb/tmp` writable by HTTP Server. ex: `chmod 777 "project-dir"/fuel/app/vendor/sakuraiyuta/fuel-orientdb/tmp`
* Modify your application bootstrap. Target file is `"project-dir"/fuel/app/bootstrap.php`. Add some classes to Autoloader in line `Autoloader::add_classes()`. ex:

```
Autoloader::add_classes(array(
	// Add classes you want to override here
	// Example: 'View' => APPPATH.'classes/view.php',
	"Fuel\\Core\\OrientDB" => APPPATH . "vendor/sakuraiyuta/fuel-orientdb/src/Fuel/Core/OrientDB.php",
	"Fuel\\Core\\Database_Orientdb_Connection" => APPPATH . "vendor/sakuraiyuta/fuel-orientdb/src/Fuel/Core/Database_Orientdb_Connection.php",
));
```

* *Optionally*, you can create entity classes for mapping records to objects.
* Finally, you must configure database connection settings.

Configuration
=============

You can configure database connection settings using FuelPHP common config file, and also can use `dsn` notation.

Target file is `"project-dir"/fuel/app/{development,test,production}/db.php`. ex:

```
return array(
	'default' => array(
		'type'       => 'orientdb',
		'connection'  => array(
			'dsn'        => 'orientdb:host=localhost;dbname=school-manager;port=2480',
			'username'   => 'admin',
			'password'   => 'admin',
		),
	),
);
```

* `$config["default"]["type"]` is regular value `orientdb`. Do not change.
* `$config["default"]["connection"]["dsn"]` can splits some sections. Expression is `"dbtype":host="yourdbhostname";dbname="yourdbname";port="yourdbport"`.
	* `dbtype` is regular value `orientdb`. Do not change.
	* `host` is your hostname (or IPaddress) working OrientDB.
	* `dbname` is database name you want to use.
	* `port` is a port to connect OrientDB you want to use.
* `$config["default"]["connection"]["username"]` is username you want to use for connecting the database.
* `$config["default"]["connection"]["password"]` is password you want to use for connecting the database.

How to use
==========

Use raw SQL+ query
--------------------

You can use SQL+ query provided by OrientDB, in FuelPHP controllers.

*Notice: You can only use SELECT statement. Executing INSERT, UPDATE, and DELETE statement feature is not implemented yet.*

```
// ex: Using FuelPHP DB class.
// In DB class, creates instance Database_Orientdb_Connection and execute query.
// This returns array contains stdClass object. These object contains properties.
$result = DB::query("SELECT * FROM User");
var_dump($result);

// ex: Using raw OrientDB class.
// The class extends FuelPHP DB class (but many methods are not implemented yet).
$result = OrientDB::get_manager
```

Use FuelPHP-like query builder
------------------------------

```
$result = OrientDB::insert("User")
	->set(
		array(
			"username" => "testuser",
			"password" => "hashedpassword",
		)
	)->execute();
var_dump($result);
```

Use raw orientdb-odm Manager
------------------------------

If you want to use a feature, mapping records to object, write as below:

```
// ex: Using raw OrientDB class.
// The class extends FuelPHP DB class (but many methods are not implemented yet).
// This returns array contains User object. These objects is mapped to records.
$result = OrientDB::get_manager
	->getRepository("User")
	->findAll();
var_dump($result);
```

You *need to create User class* for mapping entities. Instruction is below:

* Create directory `Entity` in `"project-dir"/fuel/app/classes/`.
* Create Entity file in the directory. ex: `User.php`
* Write details in the Entity file. This needs to include annotations. ex:

```
// Need definition of namespace "Entity" for autoloading.
namespace Entity;

use Doctrine\ODM\OrientDB\Mapper\Annotations as ODM;

/**
* @ODM\Document(class="User")
*/
class User
{
    /**
     * @ODM\Property(name="@rid", type="string")
     */
    protected $rid;

    /**
     * @ODM\Property(type="string", notnull="true")
     */
    protected $username;

    /**
     * @ODM\Property(type="string", notnull="true")
     */
    protected $password;

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRid()
    {
        return $this->rid;
    }

    public function setRid($rid)
    {
        $this->rid = $rid;
    }
}
```

Entity directory can't change now. But in the future, implement configuration feature.

See also
========

* [FuelPHP](http://fuelphp.com) is a simple, flexible, community driven PHP 5.3+ framework.
* [Composer](http://getcomposer.org) is a tool for dependency management in PHP. Look document and understand auto-loading mechanism in Composer.
* [Doctrine Project](http://www.doctrine-project.org/), for learning a concept ORM and ODM.
* [orientdb-odm](https://github.com/doctrine/orientdb-odm), using in this library.
* [Starting to play with the Doctrine OrientDB ODM](http://odino.org/starting-to-play-with-the-doctrine-orientdb-odm/), written by Alessandro Nadalin, is a good article for learning to use the library. (Create project using Smarty framework and raw orientdb-odm library is a precondition, but some paragraph is useful even if using FuelPHP)
