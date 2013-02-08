<?php

namespace Entity;

use Doctrine\ODM\OrientDB\Mapper\Annotations as ODM;

/**
* @ODM\Document(class="TestClass")
*/
class TestClass
{
    /**
     * @ODM\Property(name="@rid", type="string")
     */
    protected $rid;

    /**
     * @ODM\Property(type="string", notnull="true")
     */
    protected $testcolumn1;

    /**
     * @ODM\Property(type="string", notnull="true")
     */
    protected $testcolumn2;

    /**
     * @ODM\Property(type="datetime", notnull="true")
     */
    protected $testcolumn3;

    /**
     * Returns the nickname of the user, or his email if he has no nick set.
     * 
     * @return string
     */
    public function getTestcolumn1()
    {
        return $this->testcolumn1;
    }

    public function setTestcolumn1($testcolumn1)
    {
        $this->testcolumn1 = $testcolumn1;
    }

    public function getTestColumn2()
    {
        return $this->testcolumn2;
    }

    public function setTestColumn2($testcolumn2)
    {
        $this->testcolumn2 = $testcolumn2;
    }

    public function getTestColumn3()
    {
        return $this->testcolumn3;
    }

    public function setTestColumn3($testcolumn3)
    {
        $this->testcolumn3 = $testcolumn3;
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
