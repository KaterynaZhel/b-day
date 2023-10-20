<?php

namespace App\Services;

use App\Models\Celebrant;
use App\Models\Hobby;


class AddHobbiesToCelebrantService
{
    public function addHobbiesToCelebtant(Celebrant $celebrant, array $hobbies)
    {
        if (empty($hobbies)) {
            return;
        }

        $hobby_names = array_unique($hobbies);

        $hobby_existed = Hobby::whereIn('name', $hobby_names)
            ->select('name')
            ->pluck('name')->toArray();

        $new_hobby_names = array_diff($hobby_names, $hobby_existed);

        foreach ($new_hobby_names as $name) {
            $newHobby       = new Hobby();
            $newHobby->name = $name;
            $newHobby->save();
        }
        $hobby_ids = Hobby::whereIn('name', $hobby_names)
            ->select('id')
            ->pluck('id')->toArray();

        $celebrant->hobbies()->sync($hobby_ids);
    }
}