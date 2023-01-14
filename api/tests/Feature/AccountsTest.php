<?php

namespace Tests\Feature;

use App\Enums\TransactionTypeEnum;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountsTest extends TestCase
{
    use WithoutMiddleware;

    private $base_route;
    private $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->base_route = 'api/accounts/';

        $this->user = app(UserRepository::class)->create([
            'name' => Hash::make('test'),
            'password' => '1111',
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBalanceZeroShouldPass()
    {
        $token = $this->getToken();

        $response =  $this->get($this->base_route . 'balance/' . $this->user->id, [], ['Authorization' => "Bearer $token"])->decodeResponseJson();

        $this->assertEquals('0.0', $response['balance']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAccountHistoricShouldBeEmpty()
    {
        $token = $this->getToken();

        $response =  $this->get($this->base_route . 'historic/' . $this->user->id, [], ['Authorization' => "Bearer $token"])->decodeResponseJson();
        
        $this->assertEquals([], $response['data']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateNewTranscationShouldPass()
    {
        $token = $this->getToken();

        $data = [
            'type' => TransactionTypeEnum::DEPOSIT,
            'amount' => 400,
            'check' => UploadedFile::fake()->image('test.jpg'),
        ];
        $response =  $this->post($this->base_route . $this->user->id .'/transaction', $data, ['Authorization' => "Bearer $token"])->decodeResponseJson();
        
        $this->assertEquals($data['amount'], $response['data']['amount']);
        $this->assertEquals($data['type'], $response['data']['type']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testApprovedTranscationShouldPass()
    {
        $token = $this->getToken();
        $adm_token = $this->getAdminToken();

        $data_deposit = [
            'type' => TransactionTypeEnum::DEPOSIT,
            'amount' => 400,
            'check' => UploadedFile::fake()->image('test.jpg'),
        ];

        $response =  $this->post($this->base_route . $this->user->id .'/transaction', $data_deposit, ['Authorization' => "Bearer $token"])->decodeResponseJson();
        
        $transaction_id = $response['data']['id'];

        $this->assertEquals($data_deposit['amount'], $response['data']['amount']);
        $this->assertEquals($data_deposit['type'], $response['data']['type']);

        $data_approved = [
            'type' => TransactionTypeEnum::APPROVED,
            'transaction_id' => $transaction_id,
        ];
        
        $response =  $this->post('api/admin/transactions', $data_approved, ['Authorization' => "Bearer $adm_token"])->decodeResponseJson();


        $this->assertEquals($data_approved['type'], $response['status']);
        $this->assertEquals($data_deposit['amount'], $response['amount']);
        $this->assertEquals($data_deposit['type'], $response['type']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testBalanceUpdateShouldPass()
    {
        $token = $this->getToken();
        $adm_token = $this->getAdminToken();

        $data_deposit = [
            'type' => TransactionTypeEnum::DEPOSIT,
            'amount' => 400,
            'check' => UploadedFile::fake()->image('test.jpg'),
        ];

        $response =  $this->post($this->base_route . $this->user->id .'/transaction', $data_deposit, ['Authorization' => "Bearer $token"])->decodeResponseJson();
        
        $transaction_id = $response['data']['id'];

        $this->assertEquals($data_deposit['amount'], $response['data']['amount']);
        $this->assertEquals($data_deposit['type'], $response['data']['type']);

        $data_approved = [
            'type' => TransactionTypeEnum::APPROVED,
            'transaction_id' => $transaction_id,
        ];
        
        $response =  $this->post('api/admin/transactions', $data_approved, ['Authorization' => "Bearer $adm_token"])->decodeResponseJson();


        $this->assertEquals($data_approved['type'], $response['status']);
        $this->assertEquals($data_deposit['amount'], $response['amount']);
        $this->assertEquals($data_deposit['type'], $response['type']);

        $response =  $this->get($this->base_route . 'balance/' . $this->user->id, [], ['Authorization' => "Bearer $token"])->decodeResponseJson();
        $this->assertEquals($data_deposit['amount'], $response['balance']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testHistoricUpdateShouldPass()
    {
        $token = $this->getToken();
        $adm_token = $this->getAdminToken();

        $response =  $this->get($this->base_route . 'historic/' . $this->user->id, [], ['Authorization' => "Bearer $token"])->decodeResponseJson();
        $this->assertEquals([], $response['data']);

        $data_deposit = [
            'type' => TransactionTypeEnum::DEPOSIT,
            'amount' => 400,
            'check' => UploadedFile::fake()->image('test.jpg'),
        ];

        $response =  $this->post($this->base_route . $this->user->id .'/transaction', $data_deposit, ['Authorization' => "Bearer $token"])->decodeResponseJson();
        
        $transaction_id = $response['data']['id'];

        $this->assertEquals($data_deposit['amount'], $response['data']['amount']);
        $this->assertEquals($data_deposit['type'], $response['data']['type']);

        $data_approved = [
            'type' => TransactionTypeEnum::APPROVED,
            'transaction_id' => $transaction_id,
        ];
        
        $response =  $this->post('api/admin/transactions', $data_approved, ['Authorization' => "Bearer $adm_token"])->decodeResponseJson();


        $this->assertEquals($data_approved['type'], $response['status']);
        $this->assertEquals($data_deposit['amount'], $response['amount']);
        $this->assertEquals($data_deposit['type'], $response['type']);

        $response =  $this->get($this->base_route . 'historic/' . $this->user->id, [], ['Authorization' => "Bearer $token"])->decodeResponseJson();
        
        $this->assertEquals(
            [
                "id" => 1,
                "amount" => "400.0",
                "description" => null,
                "type" => "DEPOSIT",
                "status" => "APPROVED",
                "date_time" => now()
            ], $response['data'][0]);
    }

    private function getToken()
    {

        $payload = [
            'name' => $this->user->name,
            'password' => '1111'
        ];
        $response =  $this->post('api/auth/login', $payload)->decodeResponseJson();

        return $response['access_token'];
    }

    private function getAdminToken()
    {
        $payload = [
            'name' => 'adm',
            'password' => 'pass'
        ];

        $response =  $this->post('api/auth/login', $payload)->decodeResponseJson();

        return $response['access_token'];
    }
}
