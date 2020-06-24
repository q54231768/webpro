<?php

namespace Tests\Unit;

use App\Dao\UserDao;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{

//    public $userDao;
//
//    /**
//     * ExampleTest constructor.
//     */
//    public function __construct(UserDao $userDao)
//    {
//        $this->userDao=$userDao;
//        parent::__construct();
//    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function testDataBase()
    {
//        echo 'test';
        $result=DB::insert('insert into user(id,userName,email,password) values(?,?,?,?)', array('awdawd', 'awdawdafa', 'awfwafawfa', 'wafwafwafaw'));
//        $result=$this->userDao->addNewUser(null);
        var_dump($result);
    }
}
