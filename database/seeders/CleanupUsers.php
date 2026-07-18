<?php
$users = \App\Models\User::all();
foreach ($users as $u) {
    echo $u->id . ' | ' . $u->email . ' | ' . $u->role . PHP_EOL;
}

// Delete all except admin (id 1)
$deleted = \App\Models\User::where('id', '!=', 1)->delete();
echo PHP_EOL . "Deleted $deleted users. Remaining: " . \App\Models\User::count() . PHP_EOL;
