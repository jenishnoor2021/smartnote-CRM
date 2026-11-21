<?php

namespace Tests\Feature;

use App\Models\Party;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FlowTest extends TestCase
{
    public function test_database_tables_are_clean()
    {
        $tables = array_map(function ($t) {
            return array_values((array)$t)[0];
        }, \Illuminate\Support\Facades\DB::select('SHOW TABLES'));

        sort($tables);
        $expected = [
            'failed_jobs',
            'migrations',
            'parties',
            'password_resets',
            'personal_access_tokens',
            'users'
        ];
        sort($expected);

        $this->assertEquals($expected, $tables);
    }

    public function test_login_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Login To Your Account');
    }

    public function test_login_and_dashboard_flow()
    {
        $tempPassword = 'TestPassword123!';
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'testflow@example.com',
            'username' => 'testflowuser',
            'password' => Hash::make($tempPassword),
        ]);

        $response = $this->post('/login', [
            'username' => 'testflowuser',
            'password' => $tempPassword,
        ]);

        $response->assertRedirect('/admin/dashboard');

        // Test dashboard loads with session
        $dashResponse = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->get('/admin/dashboard');

        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Dashboard');

        // Test party CRUD operations
        // 1. Index
        $partyIndex = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->get('/admin/party');
        $partyIndex->assertStatus(200);

        // 2. Create page
        $partyCreate = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->get('/admin/party/create');
        $partyCreate->assertStatus(200);

        // 3. Store
        $partyStore = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->post('/admin/party/store', [
                'fname' => 'TestFirst',
                'lname' => 'TestLast',
                'party_code' => 'TP001',
                'address' => '123 Test St',
                'mobile' => '9876543210',
                'gst_no' => 'GST12345',
            ]);
        $partyStore->assertRedirect('admin/party');

        $createdParty = Party::where('party_code', 'TP001')->first();
        $this->assertNotNull($createdParty);
        $this->assertEquals('TestFirst', $createdParty->fname);

        // 4. Edit page
        $partyEdit = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->get('/admin/party/edit/' . $createdParty->id);
        $partyEdit->assertStatus(200);

        // 5. Update
        $partyUpdate = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->patch('/admin/party/update/' . $createdParty->id, [
                'fname' => 'UpdatedFirst',
                'lname' => 'TestLast',
                'party_code' => 'TP001',
                'is_active' => '1',
            ]);
        $partyUpdate->assertRedirect('admin/party');
        $this->assertEquals('UpdatedFirst', $createdParty->fresh()->fname);

        // 6. Update Status AJAX
        $statusUpdate = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->postJson('/admin/party/update_status', [
                'party_id' => $createdParty->id,
                'is_active' => false,
            ]);
        $statusUpdate->assertStatus(200);
        $statusUpdate->assertJson(['status' => true]);
        $this->assertEquals(0, (int)$createdParty->fresh()->is_active);

        // 7. Change Password Page
        $profilePage = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->get('/profile/' . $testUser->id);
        $profilePage->assertStatus(200);
        $profilePage->assertSee('Change Password');

        // 8. Change Password Update
        $profileUpdate = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->patch('/profile/update', [
                'current_password' => $tempPassword,
                'new_password' => 'NewPassword123!',
                'new_password_confirmation' => 'NewPassword123!',
            ]);
        $profileUpdate->assertSessionHas('success');

        // Verify updated password
        $updatedUser = User::find($testUser->id);
        $this->assertTrue(Hash::check('NewPassword123!', $updatedUser->password));

        // 9. Delete Selected AJAX
        $party2 = Party::create([
            'fname' => 'PartyTwo',
            'lname' => 'PartyTwoL',
            'party_code' => 'TP002',
        ]);
        $deleteMultiple = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->postJson('/admin/party/delete_selected', [
                'ids' => [$party2->id],
            ]);
        $deleteMultiple->assertStatus(200);
        $this->assertNull(Party::find($party2->id));

        // 10. Destroy AJAX
        $destroyParty = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->deleteJson('/admin/party/destroy/' . $createdParty->id);
        $destroyParty->assertStatus(200);
        $this->assertNull(Party::find($createdParty->id));

        // 11. Logout
        $logoutResponse = $this->withSession(['user' => $testUser])
            ->actingAs($testUser)
            ->get('/logout');
        $logoutResponse->assertRedirect('/');

        // Cleanup test user
        $testUser->delete();
    }
}
