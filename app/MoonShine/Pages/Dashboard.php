<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;

class Dashboard extends Page
{
    protected string $title = 'Админка';
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Админ панель';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
	{
		return [];
	}
}
