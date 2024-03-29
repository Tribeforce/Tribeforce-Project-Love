<?php

class UserSeeder extends Seeder {

  public function run() {
    $this->command->info('Deleting tables...');
    DB::table('users')->delete();
    DB::table('groups')->delete();
    DB::table('users_groups')->delete();
    DB::table('agrees')->delete();
    DB::table('circles')->delete();
    DB::table('circle_user')->delete();
    DB::table('endorsements')->delete();
    DB::table('feedbackables')->delete();
    DB::table('personals')->delete();
    DB::table('feedbacks')->delete();
    DB::table('goals')->delete();
    DB::table('rights')->delete();


    // Create the admin group
    $this->command->info('Creating admin group...');
    $group = Sentry::getGroupProvider()->create(array(
        'name'        => 'admin',
        'permissions' => array(
            'admin' => 1,
            'users' => 1,
        ),
    ));

    // Create users
    $this->command->info('Creating users...');
    $femi = User::create(array(
      'first_name' => 'Femi',
      'last_name' => 'Veys',
      'email' => 'femiveys@gmail.com',
      'password' => '1234',
      'activated' => true,
    ));

    $stijn = User::create(array(
      'first_name' => 'Stijn',
      'last_name' => 'De Winter',
      'email' => 'stijn@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $bruno = User::create(array(
      'first_name' => 'Bruno',
      'last_name' => 'Delepierre',
      'email' => 'bruno@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user1 = User::create(array(
      'first_name' => 'User1',
      'last_name' => 'Lastname',
      'email' => 'user1@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user2 = User::create(array(
      'first_name' => 'User2',
      'last_name' => 'Lastname',
      'email' => 'user2@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user3 = User::create(array(
      'first_name' => 'User3',
      'last_name' => 'Lastname',
      'email' => 'user3@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user4 = User::create(array(
      'first_name' => 'User4',
      'last_name' => 'Lastname',
      'email' => 'user4@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user5 = User::create(array(
      'first_name' => 'User5',
      'last_name' => 'Lastname',
      'email' => 'user5@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user6 = User::create(array(
      'first_name' => 'User6',
      'last_name' => 'Lastname',
      'email' => 'user6@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user7 = User::create(array(
      'first_name' => 'User7',
      'last_name' => 'Lastname',
      'email' => 'user7@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user8 = User::create(array(
      'first_name' => 'User8',
      'last_name' => 'Lastname',
      'email' => 'user8@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    $user9 = User::create(array(
      'first_name' => 'User9',
      'last_name' => 'Lastname',
      'email' => 'user9@tribeforce.com',
      'password' => '1234',
      'activated' => true,
    ));

    // Handle the avatars
    $this->command->info('Handling the avatars...');
    $users = array(
      $femi,
      $stijn,
      $bruno,
      $user1,
      $user2,
      $user3,
      $user4,
      $user5,
      $user6,
      $user7,
      $user8,
      $user9,
    );

    $avatar_dir = storage_path() . '/files/avatar';

    $avatars = scandir($avatar_dir);
    // We only need the 12 first users and we omit the . and .. folders
    $avatars = array_slice($avatars, 2, 12);

    for($i = 0; $i < count($avatars); $i++) {
      // Rename the files
      $full_oldname = "$avatar_dir/" . $avatars[$i];
      $newname = "avatar." . $users[$i]->id . ".jpeg";
      $full_newname = "$avatar_dir/$newname";
      rename($full_oldname, $full_newname);

      // Store the new filename in the db
      $users[$i]->avatar = $newname;
      $users[$i]->save();
    }


    // Add femi to the admin group
    $this->command->info('Adding Femi to the admin group...');
    $femi->addGroup($group);


    // Create circles for users
    $this->command->info('Creating circles for users...');
    // FEMI
    $circle1_f = Circle::create(array(
      'name' => 'Family',
      'owner_id' => $femi->id,
      'owner_type' => 'User',
    ));

    $circle2_f = Circle::create(array(
      'name' => 'Good friends',
      'owner_id' => $femi->id,
      'owner_type' => 'User',
    ));

    $circle3_f = Circle::create(array(
      'name' => 'Best friends',
      'owner_id' => $femi->id,
      'owner_type' => 'User',
    ));

    // STIJN
    $circle1_s = Circle::create(array(
      'name' => 'Family',
      'owner_id' => $stijn->id,
      'owner_type' => 'User',
    ));

    $circle2_s = Circle::create(array(
      'name' => 'Good friends',
      'owner_id' => $stijn->id,
      'owner_type' => 'User',
    ));

    $circle3_s = Circle::create(array(
      'name' => 'Intimate friends',
      'owner_id' => $stijn->id,
      'owner_type' => 'User',
    ));

    // BRUNO
    $circle1_b = Circle::create(array(
      'name' => 'Family',
      'owner_id' => $bruno->id,
      'owner_type' => 'User',
    ));

    $circle2_b = Circle::create(array(
      'name' => 'Good friends',
      'owner_id' => $bruno->id,
      'owner_type' => 'User',
    ));

    $circle3_b = Circle::create(array(
      'name' => 'Best friends',
      'owner_id' => $bruno->id,
      'owner_type' => 'User',
    ));


    // Subscribe users to circles
    $this->command->info('Subscribing users to circles...');
    $femi->subscribedCircles()->attach($circle1_s->id);
    $femi->subscribedCircles()->attach($circle1_f->id);
    $femi->subscribedCircles()->attach($circle2_f->id);
    $femi->subscribedCircles()->attach($circle3_f->id);
    $stijn->subscribedCircles()->attach($circle1_b->id);
    $stijn->subscribedCircles()->attach($circle1_s->id);
    $stijn->subscribedCircles()->attach($circle2_s->id);
    $stijn->subscribedCircles()->attach($circle3_s->id);
    $bruno->subscribedCircles()->attach($circle1_f->id);
    $bruno->subscribedCircles()->attach($circle1_b->id);
    $bruno->subscribedCircles()->attach($circle2_b->id);
    $bruno->subscribedCircles()->attach($circle3_b->id);


    // Add users to circles
    $this->command->info('Adding users to circles...');
    // FEMI
    $circle1_f->users()->attach($user2->id);
    $circle1_f->users()->attach($user3->id);
    $circle1_f->users()->attach($user4->id);
    $circle2_f->users()->attach($stijn->id);
    $circle2_f->users()->attach($bruno->id);
    $circle2_f->users()->attach($user1->id);
    $circle3_f->users()->attach($user5->id);
    $circle3_f->users()->attach($user6->id);
    $circle3_f->users()->attach($user7->id);
    // Stijn
    $circle1_s->users()->attach($user8->id);
    $circle1_s->users()->attach($user7->id);
    $circle1_s->users()->attach($user6->id);
    $circle2_s->users()->attach($femi->id);
    $circle2_s->users()->attach($bruno->id);
    $circle2_s->users()->attach($user9->id);
    $circle3_s->users()->attach($user5->id);
    $circle3_s->users()->attach($user4->id);
    $circle3_s->users()->attach($user3->id);
    // Bruno
    $circle1_b->users()->attach($user4->id);
    $circle1_b->users()->attach($user5->id);
    $circle1_b->users()->attach($user6->id);
    $circle2_b->users()->attach($stijn->id);
    $circle2_b->users()->attach($femi->id);
    $circle2_b->users()->attach($user7->id);
    $circle3_b->users()->attach($user8->id);
    $circle3_b->users()->attach($user9->id);
    $circle3_b->users()->attach($user3->id);


    // Create Goals for femi, stijn and bruno
    $this->command->info('Creating goals...');
    // FEMI
    $goal_1_f = Goal::create(array(
      'name' => 'Get fitter',
      'user_id' => $femi->id,
    ));
    $goal_2_f = Goal::create(array(
      'name' => 'Get better',
      'user_id' => $femi->id,
    ));
    $goal_3_f = Goal::create(array(
      'name' => 'Get more real',
      'user_id' => $femi->id,
    ));
    $goal_4_f = Goal::create(array(
      'name' => 'Get cool',
      'user_id' => $femi->id,
    ));
    $goal_1_1_f = Goal::create(array(
      'name' => 'Get much fitter',
      'user_id' => $femi->id,
      'child_id' => $goal_1_f->id,
    ));
    $goal_1_1_1_f = Goal::create(array(
      'name' => 'Get totally fit',
      'user_id' => $femi->id,
      'child_id' => $goal_1_1_f->id,
    ));
    $goal_2_2_f = Goal::create(array(
      'name' => 'Get much better',
      'user_id' => $femi->id,
      'child_id' => $goal_2_f->id,
    ));
    // STIJN
    $goal_1_s = Goal::create(array(
      'name' => 'Get fitter',
      'user_id' => $stijn->id,
    ));
    $goal_2_s = Goal::create(array(
      'name' => 'Get better',
      'user_id' => $stijn->id,
    ));
    $goal_3_s = Goal::create(array(
      'name' => 'Get more real',
      'user_id' => $stijn->id,
    ));
    $goal_4_s = Goal::create(array(
      'name' => 'Get cool',
      'user_id' => $stijn->id,
    ));
    $goal_1_1_s = Goal::create(array(
      'name' => 'Get much fitter',
      'user_id' => $stijn->id,
      'child_id' => $goal_1_s->id,
    ));
    $goal_1_1_1_s = Goal::create(array(
      'name' => 'Get totally fit',
      'user_id' => $stijn->id,
      'child_id' => $goal_1_1_s->id,
    ));
    $goal_2_2_s = Goal::create(array(
      'name' => 'Get much better',
      'user_id' => $stijn->id,
      'child_id' => $goal_2_s->id,
    ));
    // BRUNO
    $goal_1_b = Goal::create(array(
      'name' => 'Get fitter',
      'user_id' => $bruno->id,
    ));
    $goal_2_b = Goal::create(array(
      'name' => 'Get better',
      'user_id' => $bruno->id,
    ));
    $goal_3_b = Goal::create(array(
      'name' => 'Get more real',
      'user_id' => $bruno->id,
    ));
    $goal_4_b = Goal::create(array(
      'name' => 'Get cool',
      'user_id' => $bruno->id,
    ));
    $goal_1_1_b = Goal::create(array(
      'name' => 'Get much fitter',
      'user_id' => $bruno->id,
      'child_id' => $goal_1_b->id,
    ));
    $goal_1_1_1_b = Goal::create(array(
      'name' => 'Get totally fit',
      'user_id' => $bruno->id,
      'child_id' => $goal_1_1_b->id,
    ));
    $goal_2_2_b = Goal::create(array(
      'name' => 'Get much better',
      'user_id' => $bruno->id,
      'child_id' => $goal_2_b->id,
    ));



    // Create Personals for femi, stijn and bruno5
    $this->command->info('Creating personals...');
    // FEMI
    $fb_1_f = Personal::create(array(
      'type' => 1, // character
      'name' => 'A character name',
      'user_id' => $femi->id,
    ));
    $fb_1_1_f = Personal::create(array(
      'type' => 1, // character
      'name' => 'A new character name',
      'user_id' => $femi->id,
      'child_id' => $fb_1_f->id,
    ));
    $fb_1_1_1_f = Personal::create(array(
      'type' => 1, // character
      'name' => 'Newest character name',
      'user_id' => $femi->id,
      'child_id' => $fb_1_1_f->id,
    ));
    $fb_2_f = Personal::create(array(
      'type' => 2, // destiny
      'name' => 'A destiny name',
      'user_id' => $femi->id,
    ));
    $fb_2_2_f = Personal::create(array(
      'type' => 2, // destiny
      'name' => 'Newest destiny name',
      'user_id' => $femi->id,
      'child_id' => $fb_2_f->id,
    ));
    $fb_3_f = Personal::create(array(
      'type' => 3, // vision
      'name' => 'A vision name',
      'user_id' => $femi->id,
    ));
    // STIJN
    $fb_1_s = Personal::create(array(
      'type' => 1, // character
      'name' => 'A character name',
      'user_id' => $stijn->id,
    ));
    $fb_1_1_s = Personal::create(array(
      'type' => 1, // character
      'name' => 'A new character name',
      'user_id' => $stijn->id,
      'child_id' => $fb_1_s->id,
    ));
    $fb_1_1_1_s = Personal::create(array(
      'type' => 1, // character
      'name' => 'Newest character name',
      'user_id' => $stijn->id,
      'child_id' => $fb_1_1_s->id,
    ));
    $fb_2_s = Personal::create(array(
      'type' => 2, // destiny
      'name' => 'A destiny name',
      'user_id' => $stijn->id,
    ));
    $fb_2_2_s = Personal::create(array(
      'type' => 2, // destiny
      'name' => 'Newest destiny name',
      'user_id' => $stijn->id,
      'child_id' => $fb_2_s->id,
    ));
    $fb_3_s = Personal::create(array(
      'type' => 3, // vision
      'name' => 'A vision name',
      'user_id' => $stijn->id,
    ));
    // BRUNO
    $fb_1_b = Personal::create(array(
      'type' => 1, // character
      'name' => 'A character name',
      'user_id' => $bruno->id,
    ));
    $fb_1_1_b = Personal::create(array(
      'type' => 1, // character
      'name' => 'A new character name',
      'user_id' => $bruno->id,
      'child_id' => $fb_1_b->id,
    ));
    $fb_1_1_1_b = Personal::create(array(
      'type' => 1, // character
      'name' => 'Newest character name',
      'user_id' => $bruno->id,
      'child_id' => $fb_1_1_b->id,
    ));
    $fb_2_b = Personal::create(array(
      'type' => 2, // destiny
      'name' => 'A destiny name',
      'user_id' => $bruno->id,
    ));
    $fb_2_2_b = Personal::create(array(
      'type' => 2, // destiny
      'name' => 'Newest destiny name',
      'user_id' => $bruno->id,
      'child_id' => $fb_2_b->id,
    ));
    $fb_3_b = Personal::create(array(
      'type' => 3, // vision
      'name' => 'A vision name',
      'user_id' => $bruno->id,
    ));


    // Create endorsements between users
    $this->command->info('Creating endorsements...');
    // FEMI
    $en_1_f = Endorsement::create(array(
      'name' => 'Endorsement 1',
      'created_for' => $femi->id,
      'user_id' => $user1->id,
    ));
    $en_2_f = Endorsement::create(array(
      'name' => 'Endorsement 2',
      'created_for' => $femi->id,
      'user_id' => $stijn->id,
    ));
    $en_3_f = Endorsement::create(array(
      'name' => 'Endorsement 3',
      'created_for' => $femi->id,
      'user_id' => $user5->id,
    ));
    $en_4_f = Endorsement::create(array(
      'name' => 'Endorsement 4',
      'created_for' => $femi->id,
      'user_id' => $user3->id,
    ));
    // STIJN
    $en_1_s = Endorsement::create(array(
      'name' => 'Endorsement 1',
      'created_for' => $stijn->id,
      'user_id' => $user8->id,
    ));
    $en_2_s = Endorsement::create(array(
      'name' => 'Endorsement 2',
      'created_for' => $stijn->id,
      'user_id' => $bruno->id,
    ));
    $en_3_s = Endorsement::create(array(
      'name' => 'Endorsement 3',
      'created_for' => $stijn->id,
      'user_id' => $user5->id,
    ));
    $en_4_s = Endorsement::create(array(
      'name' => 'Endorsement 4',
      'created_for' => $stijn->id,
      'user_id' => $user3->id,
    ));
    // BRUNO
    $en_1_b = Endorsement::create(array(
      'name' => 'Endorsement 1',
      'created_for' => $bruno->id,
      'user_id' => $user7->id,
    ));
    $en_2_b = Endorsement::create(array(
      'name' => 'Endorsement 2',
      'created_for' => $bruno->id,
      'user_id' => $stijn->id,
    ));
    $en_3_b = Endorsement::create(array(
      'name' => 'Endorsement 3',
      'created_for' => $bruno->id,
      'user_id' => $user5->id,
    ));
    $en_4_b = Endorsement::create(array(
      'name' => 'Endorsement 4',
      'created_for' => $bruno->id,
      'user_id' => $user3->id,
    ));


    // Set permissions on goals
    $this->command->info('Setting permissions on goals...');
    // FEMI
    Right::create(array(
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_2_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle2_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_3_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_4_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $bruno->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_4_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_1_1_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_1_1_1_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_2_2_f->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle2_f->id,
      'permission_type' => 'Circle',
    ));
    // STIJN
    Right::create(array(
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_2_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle2_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_3_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_4_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $bruno->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_4_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_1_1_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_1_1_1_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_2_2_s->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle2_s->id,
      'permission_type' => 'Circle',
    ));
    // BRUNO
    Right::create(array(
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_2_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle2_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_3_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_4_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_4_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $goal_1_1_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_1_1_1_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle1_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $goal_2_2_b->id,
      'obj_type' => 'Goal',
      'permission_id' => $circle2_b->id,
      'permission_type' => 'Circle',
    ));

    // Set permissions on feedbackables
    $this->command->info('Setting permissions on feedbackables...');
    // FEMI
    Right::create(array(
      'obj_id' => $fb_1_f->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_1_1_f->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_1_1_1_f->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_2_f->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_2_2_f->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_3_f->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_3_f->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $bruno->id,
      'permission_type' => 'User',
    ));
    // STIJN
    Right::create(array(
      'obj_id' => $fb_1_s->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_1_1_s->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_1_1_1_s->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_2_s->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_2_2_s->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_3_s->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_3_s->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $bruno->id,
      'permission_type' => 'User',
    ));
    // BRUNO
    Right::create(array(
      'obj_id' => $fb_1_b->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_1_1_b->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_1_1_1_b->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $circle1_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $fb_2_b->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_2_2_b->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_3_b->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $fb_3_b->id,
      'obj_type' => 'Feedbackable',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));

    // Set permissions on endorsements
    $this->command->info('Setting permissions on endorsements...');
    // FEMI
    Right::create(array(
      'obj_id' => $en_1_f->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $circle2_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $en_2_f->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $circle3_f->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $en_3_f->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $bruno->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $en_4_f->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $en_4_f->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $user4->id,
      'permission_type' => 'User',
    ));
    // STIJN
    Right::create(array(
      'obj_id' => $en_1_s->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $circle2_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $en_2_s->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $circle3_s->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $en_3_s->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $bruno->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $en_4_s->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $en_4_s->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $user8->id,
      'permission_type' => 'User',
    ));
    // BRUNO
    Right::create(array(
      'obj_id' => $en_1_b->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $circle2_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $en_2_b->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $circle3_b->id,
      'permission_type' => 'Circle',
    ));
    Right::create(array(
      'obj_id' => $en_3_b->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $stijn->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $en_4_b->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $femi->id,
      'permission_type' => 'User',
    ));
    Right::create(array(
      'obj_id' => $en_4_b->id,
      'obj_type' => 'Endorsement',
      'permission_id' => $user6->id,
      'permission_type' => 'User',
    ));

    // Set feedback on goals
    $this->command->info('Setting feedback on goals...');
    // FEMI
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user2->id,
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some other feedback text 1',
      'user_id' => $user3->id,
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some great feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user1->id,
      'obj_id' => $goal_2_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $goal_2_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $goal_2_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $goal_3_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $goal_4_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user2->id,
      'obj_id' => $goal_1_1_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user2->id,
      'obj_id' => $goal_1_1_f->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $goal_1_1_f->id,
      'obj_type' => 'Goal',
    ));
    // STIJN
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user6->id,
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some other feedback text 1',
      'user_id' => $user7->id,
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some great feedback text 1',
      'user_id' => $user8->id,
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user9->id,
      'obj_id' => $goal_2_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $goal_2_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $goal_2_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $goal_3_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $goal_4_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user7->id,
      'obj_id' => $goal_1_1_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user8->id,
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user8->id,
      'obj_id' => $goal_1_1_s->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user6->id,
      'obj_id' => $goal_1_1_s->id,
      'obj_type' => 'Goal',
    ));
    // BRUNO
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user6->id,
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some other feedback text 1',
      'user_id' => $user5->id,
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some great feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user7->id,
      'obj_id' => $goal_2_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $goal_2_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $goal_2_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $goal_3_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $goal_4_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $goal_1_1_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user5->id,
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user6->id,
      'obj_id' => $goal_1_1_b->id,
      'obj_type' => 'Goal',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user5->id,
      'obj_id' => $goal_1_1_b->id,
      'obj_type' => 'Goal',
    ));


    // Set feedback on feedbackables
    $this->command->info('Setting feedback on feedbackables...');
    // FEMI
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user3->id,
      'obj_id' => $fb_1_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $fb_1_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user2->id,
      'obj_id' => $fb_1_1_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user3->id,
      'obj_id' => $fb_1_1_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user2->id,
      'obj_id' => $fb_1_1_1_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $fb_1_1_1_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $fb_2_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $fb_2_2_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $fb_3_f->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $fb_3_f->id,
      'obj_type' => 'Feedbackable',
    ));
    // STIJN
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user7->id,
      'obj_id' => $fb_1_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user8->id,
      'obj_id' => $fb_1_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user7->id,
      'obj_id' => $fb_1_1_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user6->id,
      'obj_id' => $fb_1_1_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user7->id,
      'obj_id' => $fb_1_1_1_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user8->id,
      'obj_id' => $fb_1_1_1_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $fb_2_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $fb_2_2_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $fb_3_s->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $fb_3_s->id,
      'obj_type' => 'Feedbackable',
    ));
    // BRUNO
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $fb_1_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user5->id,
      'obj_id' => $fb_1_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user6->id,
      'obj_id' => $fb_1_1_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user5->id,
      'obj_id' => $fb_1_1_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $fb_1_1_1_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user5->id,
      'obj_id' => $fb_1_1_1_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $fb_2_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $fb_2_2_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $fb_3_b->id,
      'obj_type' => 'Feedbackable',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $fb_3_b->id,
      'obj_type' => 'Feedbackable',
    ));

    // Set feedback on endorsements
    $this->command->info('Setting feedback on endorsements...');
    // FEMI
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user1->id,
      'obj_id' => $en_1_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $en_1_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $en_1_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user5->id,
      'obj_id' => $en_2_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user6->id,
      'obj_id' => $en_2_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $en_3_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 2',
      'user_id' => $bruno->id,
      'obj_id' => $en_3_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $en_4_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $en_4_f->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $en_4_f->id,
      'obj_type' => 'Endorsement',
    ));
    // STIJN
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user9->id,
      'obj_id' => $en_1_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $en_1_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $en_1_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user3->id,
      'obj_id' => $en_2_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user4->id,
      'obj_id' => $en_2_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $en_3_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 2',
      'user_id' => $bruno->id,
      'obj_id' => $en_3_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $en_4_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user8->id,
      'obj_id' => $en_4_s->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $bruno->id,
      'obj_id' => $en_4_s->id,
      'obj_type' => 'Endorsement',
    ));
    // BRUNO
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user7->id,
      'obj_id' => $en_1_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $en_1_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $en_1_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user3->id,
      'obj_id' => $en_2_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user8->id,
      'obj_id' => $en_2_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $stijn->id,
      'obj_id' => $en_3_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 2',
      'user_id' => $stijn->id,
      'obj_id' => $en_3_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $en_4_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $user6->id,
      'obj_id' => $en_4_b->id,
      'obj_type' => 'Endorsement',
    ));
    Feedback::create(array(
      'feedback' => 'Some feedback text 1',
      'user_id' => $femi->id,
      'obj_id' => $en_4_b->id,
      'obj_type' => 'Endorsement',
    ));

    // Set agree on goals
    $this->command->info('Setting agrees on goals...');
    // FEMI
    Agree::create(array(
      'user_id' => $user2->id,
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user3->id,
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user4->id,
      'obj_id' => $goal_1_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user2->id,
      'obj_id' => $goal_1_1_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user3->id,
      'obj_id' => $goal_1_1_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user4->id,
      'obj_id' => $goal_1_1_1_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user1->id,
      'obj_id' => $goal_2_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $bruno->id,
      'obj_id' => $goal_2_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $bruno->id,
      'obj_id' => $goal_2_2_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $stijn->id,
      'obj_id' => $goal_3_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $stijn->id,
      'obj_id' => $goal_4_f->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $bruno->id,
      'obj_id' => $goal_4_f->id,
      'obj_type' => 'Goal',
    ));
    // STIJN
    Agree::create(array(
      'user_id' => $user6->id,
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user7->id,
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user8->id,
      'obj_id' => $goal_1_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user7->id,
      'obj_id' => $goal_1_1_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user6->id,
      'obj_id' => $goal_1_1_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user7->id,
      'obj_id' => $goal_1_1_1_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user9->id,
      'obj_id' => $goal_2_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $bruno->id,
      'obj_id' => $goal_2_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $bruno->id,
      'obj_id' => $goal_2_2_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $femi->id,
      'obj_id' => $goal_3_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $femi->id,
      'obj_id' => $goal_4_s->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $bruno->id,
      'obj_id' => $goal_4_s->id,
      'obj_type' => 'Goal',
    ));
    // BRUNO
    Agree::create(array(
      'user_id' => $user4->id,
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user5->id,
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user6->id,
      'obj_id' => $goal_1_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user5->id,
      'obj_id' => $goal_1_1_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user4->id,
      'obj_id' => $goal_1_1_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user5->id,
      'obj_id' => $goal_1_1_1_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $user7->id,
      'obj_id' => $goal_2_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $femi->id,
      'obj_id' => $goal_2_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $femi->id,
      'obj_id' => $goal_2_2_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $stijn->id,
      'obj_id' => $goal_3_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $stijn->id,
      'obj_id' => $goal_4_b->id,
      'obj_type' => 'Goal',
    ));
    Agree::create(array(
      'user_id' => $femi->id,
      'obj_id' => $goal_4_b->id,
      'obj_type' => 'Goal',
    ));


    // Set agree on feedbackables
    // Set agree on endorsements
    // Set agree on feedback


  }
}
