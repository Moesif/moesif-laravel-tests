<?php

use Moesif\Middleware\MoesifLaravel;
use Illuminate\Http\Request;

class MoesifMiddlewareTest extends TestCase
{
    /**
     * Send Event to Moesif.
     *
     * @return void
     */
    public function testSendEvent()
    {
        $request = Request::create('https://acmeinc.com/items/42752/reviews', 'GET', ['key'=>'value']);
        $request->headers->set('Content-Type', 'application/json');

        $middleware = new MoesifLaravel();

        $middleware->handle($request, function () {
            return response("{ \"key\": \"value\"}", 200)
                  ->header('Content-Type', 'application/json');
        });
    }

    /**
     * Update User.
     *
     * @return void
     */
    public function testUpdateUser() 
    {
        $user = array(
            "user_id" => "phpapiuser",
            "metadata" => array(
                "email" => "johndoe@acmeinc.com",
                "string_field" => "value_1",
                "number_field" => 0,
                "object_field" => array(
                    "field_a" => "value_a",
                    "field_b" => "value_b"
                )
            ),
        );
        $middleware = new MoesifLaravel();
        $middleware->updateUser($user);
    }

    /**
     * Update Users Batch.
     *
     * @return void
     */
    public function testUpdateUsersBatch()
    {
        $metadata = array(
            "email" => "johndoe@acmeinc.com",
            "string_field" => "value_1",
            "number_field" => 0,
            "object_field" => array(
                "field_a" => "value_a",
                "field_b" => "value_b"
            )
            );

        $userA = array(
            "user_id" => "phpapiuser",
            "metadata" => $metadata,
        );

        $userB = array(
            "user_id" => "phpapiuser1",
            "metadata" => $metadata,
        );

        $users = array();
        $users[] = $userA;
        $users[] = $userB;

        $middleware = new MoesifLaravel();
        $middleware->updateUsersBatch($users);
    }
}