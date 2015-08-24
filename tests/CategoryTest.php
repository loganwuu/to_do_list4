<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Work stuff";
            $test_Category = new Category($name);

            //Act
            $result = $test_Category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "Kitchen chores";
            $test_category = new Category($name);

            //Act
            $test_category->setName("Home chores");
            $result = $test_category->getName();

            //Assert
            $this->assertEquals("Home chores", $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);

            //Act
            $result = $test_Category->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);
            $test_Category->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_Category, $result[0]);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $new_name = "Home stuff";

            //Act
            $test_category->update($new_name);

            //Assert
            $this->assertEquals("Home stuff", $test_category->getName());
        }

        function testDeleteCategory()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Home stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            //Act
            $test_category->delete();

            //Assert
            $this->assertEquals([$test_category2], Category::getAll());
        }

        function testGetAll()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name, $id2);
            $test_Category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name, $id2);
            $test_Category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name, $id2);
            $test_Category2->save();

            //Act
            $result = Category::find($test_Category->getId());

            //Assert
            $this->assertEquals($test_Category, $result);
        }
    }
?>
