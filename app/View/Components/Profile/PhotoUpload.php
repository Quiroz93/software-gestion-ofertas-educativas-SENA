<?php

namespace App\View\Components\Profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class PhotoUpload extends Component
{
    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new component instance.
     */
    public function __construct(User $user = null)
    {
        $this->user = $user ?? auth()->user();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.photo-upload');
    }
}
