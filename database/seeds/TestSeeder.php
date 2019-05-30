<?php

use Carbon\Carbon;
use Deviate\Activities\Models\Eloquent\Activity;
use Deviate\Activities\Models\Eloquent\ActivityCollection;
use Deviate\Organisations\Models\Eloquent\Organisation;
use Deviate\Usergroups\Models\Eloquent\Permission;
use Deviate\Usergroups\Models\Eloquent\PermissionSection;
use Deviate\Usergroups\Models\Eloquent\Usergroup;
use Deviate\Users\Models\Eloquent\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->isInvalidEnvironment()) {
            throw new RuntimeException('Cannot run TestSeeder in non local environment');
        }

        $this->createOrganisations();
        $this->createUsers();
        $this->createUsergroups();
        $this->addUsersToUsergroups();
        $this->createPermissions();
        $this->createActivityCollections();
        $this->createActivities();
    }

    private function isInvalidEnvironment()
    {
        $config = app('config');

        return !in_array($config['app']['env'], ['local', 'testing']);
    }

    private function createOrganisations()
    {
        factory(Organisation::class)->create([
            'id'   => 1,
            'name' => 'Deviate',
            'slug' => 'deviate',
        ]);

        factory(Organisation::class)->create([
            'id'   => 2,
            'name' => 'Citrium',
            'slug' => 'citrium',
        ]);
    }

    private function createUsers()
    {
        factory(User::class)->create([
            'id'              => 1,
            'organisation_id' => 1,
            'forename'        => 'Brody',
            'surname'         => 'Cross',
            'email'           => 'brody@deviate.test',
            'password'        => bcrypt('testpassword'),
        ]);

        factory(User::class)->create([
            'id'              => 2,
            'organisation_id' => 1,
            'forename'        => 'Phil',
            'surname'         => 'Cross',
            'email'           => 'phil@deviate.test',
            'password'        => bcrypt('testpassword'),
        ]);

        factory(User::class)->create([
            'id'              => 3,
            'organisation_id' => 1,
            'forename'        => 'Lisa',
            'surname'         => 'Cross',
            'email'           => 'lisa@deviate.test',
            'password'        => bcrypt('testpassword'),
        ]);

        factory(User::class)->create([
            'id'              => 4,
            'organisation_id' => 2,
            'forename'        => 'Neil',
            'surname'         => 'Andrew',
            'email'           => 'neil@citrium.test',
            'password'        => bcrypt('testpassword'),
        ]);

        factory(User::class)->create([
            'id'              => 5,
            'organisation_id' => 2,
            'forename'        => 'Jayne',
            'surname'         => 'Andrew',
            'email'           => 'jayne@citrium.test',
            'password'        => bcrypt('testpassword'),
        ]);

        factory(User::class)->create([
            'id'              => 6,
            'organisation_id' => 2,
            'forename'        => 'Neve',
            'surname'         => 'Andrew',
            'email'           => 'neve@citrium.test',
            'password'        => bcrypt('testpassword'),
        ]);

        factory(User::class)->create([
            'id'              => 7,
            'organisation_id' => 2,
            'forename'        => 'Alfie',
            'surname'         => 'Andrew',
            'email'           => 'alfie@citrium.test',
            'password'        => bcrypt('testpassword'),
        ]);
    }

    private function createUsergroups()
    {
        factory(Usergroup::class)->state('supergroup')->create([
            'id'              => 1,
            'organisation_id' => 1,
            'name'            => 'Network Administrators',
        ]);

        factory(Usergroup::class)->create([
            'id'              => 2,
            'organisation_id' => 1,
            'name'            => 'Standard Usergroup',
        ]);

        factory(Usergroup::class)->state('supergroup')->create([
            'id'              => 3,
            'organisation_id' => 2,
            'name'            => 'Network Administrators',
        ]);

        factory(Usergroup::class)->create([
            'id'              => 4,
            'organisation_id' => 2,
            'name'            => 'Standard Usergroup',
        ]);
    }

    private function addUsersToUsergroups()
    {
        DB::table('user_usergroup')->insert([
            [
                'user_id'      => 1,
                'usergroup_id' => 2,
            ],
            [
                'user_id'      => 2,
                'usergroup_id' => 1,
            ],
            [
                'user_id'      => 4,
                'usergroup_id' => 3,
            ],
            [
                'user_id'      => 5,
                'usergroup_id' => 3,
            ],
            [
                'user_id'      => 6,
                'usergroup_id' => 4,
            ],
        ]);
    }

    private function createPermissions()
    {
        $section = factory(PermissionSection::class)->create([
            'id'          => 1,
            'name'        => 'Test Section',
            'description' => 'This is a test section',
        ]);

        factory(Permission::class)->create([
            'id'                    => 1,
            'permission_section_id' => $section->id,
            'permission_key'        => 'test.permission',
            'name'                  => 'Test permission',
            'description'           => 'This is a test permission',
            'is_ownable'            => true,
        ]);

        factory(Permission::class)->create([
            'id'                    => 2,
            'permission_section_id' => $section->id,
            'permission_key'        => 'test.permission.unownable',
            'name'                  => 'Test unownable permission',
            'description'           => 'This is a test unownable permission',
            'is_ownable'            => false,
        ]);
    }

    private function createActivityCollections()
    {
        $nextYear = Carbon::now()->addYear()->startOfYear();
        $yearAfter = Carbon::now()->addYears(2)->startOfYear();

        factory(ActivityCollection::class)->create([
            'id'                => 1,
            'organisation_id'   => 1,
            'name'              => 'Summer Activities ' . $nextYear->format('Y'),
            'description'       => 'A collection of activities for summer ' . $nextYear->format('Y'),
            'booking_starts_at' => $nextYear->format('Y-m-d 00:00:00'),
        ]);

        factory(ActivityCollection::class)->create([
            'id'                => 2,
            'organisation_id'   => 1,
            'name'              => 'Summer Activities ' . $yearAfter->format('Y'),
            'description'       => 'A collection of activities for summer ' . $yearAfter->format('Y'),
            'booking_starts_at' => $yearAfter->format('Y-m-d 00:00:00'),
        ]);
    }

    private function createActivities()
    {
        /** @var ActivityCollection $collection */
        $collection = ActivityCollection::find(1);

        factory(Activity::class)->create([
            'id'                     => 1,
            'organisation_id'        => 1,
            'activity_collection_id' => 1,
            'name'                   => 'Paintballing',
            'description'            => 'This is a test paintballing activity',
            'starts_at'              => $collection->activities_start_at->format('Y-m-d 00:00:00'),
            'ends_at'                => $collection->activities_start_at->format('Y-m-d 23:59:59'),
            'places'                 => 30,
            'cost'                   => 2000,
        ]);

        factory(Activity::class)->create([
            'id'                     => 2,
            'organisation_id'        => 1,
            'activity_collection_id' => 1,
            'name'                   => 'Ice Skating',
            'description'            => 'This is a test ice skating activity',
            'starts_at'              => $collection->activities_start_at->format('Y-m-d 00:00:00'),
            'ends_at'                => $collection->activities_start_at->format('Y-m-d 23:59:59'),
            'places'                 => 30,
            'cost'                   => 2000,
        ]);

        factory(Activity::class)->create([
            'id'                     => 3,
            'organisation_id'        => 1,
            'activity_collection_id' => 1,
            'name'                   => 'Paignton Zoo',
            'description'            => 'This is a test zoo activity',
            'starts_at'              => $collection->activities_start_at->format('Y-m-d 00:00:00'),
            'ends_at'                => $collection->activities_start_at->format('Y-m-d 23:59:59'),
            'places'                 => 30,
            'cost'                   => 2000,
        ]);
    }
}
