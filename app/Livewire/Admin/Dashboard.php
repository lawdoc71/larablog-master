<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Post;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard',[
            // 'myposts'=>Post::where('author_id', auth)
        ]);
    }
}
