<?php

namespace App\View\Components\UI;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * The modal ID.
     *
     * @var string
     */
    public $id;

    /**
     * The modal size (modal-sm, modal-lg, modal-xl).
     *
     * @var string
     */
    public $size;

    /**
     * Whether the modal should be centered.
     *
     * @var bool
     */
    public $centered;

    /**
     * Whether the modal should be scrollable.
     *
     * @var bool
     */
    public $scrollable;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $id,
        string $size = '',
        bool $centered = false,
        bool $scrollable = false
    ) {
        $this->id = $id;
        $this->size = $size;
        $this->centered = $centered;
        $this->scrollable = $scrollable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.u-i.modal');
    }
}
