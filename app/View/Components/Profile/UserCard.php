<?php

namespace App\View\Components\Profile;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class UserCard extends Component
{
    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * Additional CSS classes.
     *
     * @var string
     */
    public $class;

    /**
     * Create a new component instance.
     */
    public function __construct(User $user = null, string $class = '')
    {
        $this->user = $user ?? auth()->user();
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.user-card');
    }
}
