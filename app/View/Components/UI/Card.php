<?php

namespace App\View\Components\UI;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Additional CSS classes for the card.
     *
     * @var string
     */
    public $class;

    /**
     * CSS classes for the header.
     *
     * @var string
     */
    public $headerClass;

    /**
     * CSS classes for the body.
     *
     * @var string
     */
    public $bodyClass;

    /**
     * CSS classes for the footer.
     *
     * @var string
     */
    public $footerClass;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $class = '',
        string $headerClass = '',
        string $bodyClass = '',
        string $footerClass = ''
    ) {
        $this->class = $class;
        $this->headerClass = $headerClass;
        $this->bodyClass = $bodyClass;
        $this->footerClass = $footerClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.u-i.card');
    }
}
