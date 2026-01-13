<?php

namespace App\View\Components\Layouts;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Component;

class Alerts extends Component
{
	private $alerts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->alerts = collect([]);
		
		$errors = session()->get('errors', app(ViewErrorBag::class));
		$status = session()->get('status');

		if ($errors->any()) {
			foreach ($errors->all() as $error) {
				$this->alerts->push(['message' => $error, 'type' => 'danger']);
			}
		}
		
		if (is_array($status)) {
			foreach ($status as $item) {
				$this->alerts->push(['message' => $item, 'type' => 'info']);
			}
		} elseif (is_string($status) || is_numeric($status)) {
			$this->alerts->push(['message' => $status, 'type' => 'info']);
		}
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layouts.alerts')->withAlerts($this->alerts);
    }
}
