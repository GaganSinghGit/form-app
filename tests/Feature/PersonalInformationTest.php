<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\PersonalInformation;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PersonalInformationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itReturnsPersonalInformation()
    {
        $personalInformation = PersonalInformation::factory()->create();

        $response = $this->get(route('records.get-personal-information', $personalInformation->id));

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('first_name', $personalInformation->first_name)
            ->etc()
        );
    }

    /**
     * @test
     */
    public function canCreatePersonalInformation()
    {
        $response = $this->post(route('records.create-personal-information'), [
            'first_name' => 'abc',
            'last_name' => 'def',
            'date_of_birth' => Carbon::yesterday(),
        ]);

        $this->assertDatabaseHas('personal_information', [
            'first_name' => 'abc',
            'last_name' => 'def',
        ]);
    }

    /**
     * @test
     */
    public function cannotCreatePersonalInformationWithDateOfBirthInFuture()
    {
        $response = $this->post(route('records.create-personal-information'), [
            'first_name' => 'abc',
            'last_name' => 'def',
            'date_of_birth' => Carbon::tomorrow(),
        ]);

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function canUpdatePersonalInformation()
    {
        $personalInformation = PersonalInformation::factory()->create();

        $response = $this->post(route('records.update-personal-information', [
            'personalInformation' => $personalInformation->id,
        ]), [
            'first_name' => 'abc',
            'last_name' => 'def',
            'date_of_birth' => Carbon::yesterday(),
        ]);

        $this->assertDatabaseHas('personal_information', [
            'first_name' => 'abc',
            'last_name' => 'def',
        ]);
    }
}
