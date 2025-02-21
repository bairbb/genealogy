<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Spouse;
use MoonShine\Core\Resources\Resource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Laravel\Traits\Resource\ResourceWithParent;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class SpouseResource extends ModelResource
{
    protected string $model = Spouse::class;

    protected string $title = 'Супруг(а)';

    protected string $column = 'name';

    protected array $with = [
        'person'
    ];

    protected int $itemsPerPage = 20;

    /**
     * @return list<PageContract>
     */

    use ResourceWithParent;

    protected function getParentResourceClassName(): string
    {
        return PersonResource::class;
    }

    protected function getParentRelationName(): string
    {
        return 'person';
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Фото', 'image_path'),
            Text::make('Пол', 'gender'),
            Text::make('Имя', 'name'),
//            Text::make('Фамилия', 'lastname'),
//            Text::make('Отчество', 'surname'),
            Date::make('Год рождения', 'birth_year')->format('Y'),
            Date::make('Год смерти', 'death_year')->format('Y'),
//            Textarea::make('Описание', 'description'),
            BelongsTo::make('Супруг(а)', 'person'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                BelongsTo::make('Супруг(а)', 'person'),
                Select::make('Пол', 'gender')->options([
                    'male' => 'Муж',
                    'female' => 'Жена',
                ]),
                Text::make('Фамилия', 'lastname'),
                Text::make('Имя', 'name'),
                Text::make('Отчество', 'surname'),
                Number::make('Год рождения', 'birth_year')->min(1700)->max(2100),
                Number::make('Год смерти', 'death_year')->min(1700)->max(2100),
                Textarea::make('Описание', 'description'),
                Image::make('Фото', 'image_path')->dir('images')->removable()->nullable(),
            ])
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            BelongsTo::make('Супруг(а)', 'person'),
            Text::make('Пол', 'gender'),
            Text::make('Фамилия', 'lastname'),
            Text::make('Имя', 'name'),
            Text::make('Отчество', 'surname'),
            Date::make('Год рождения', 'birth_year')->format('Y'),
            Date::make('Год смерти', 'death_year')->format('Y'),
            Textarea::make('Описание', 'description'),
            Image::make('Фото', 'image_path')
            ->itemAttributes(fn(string $filename, int $index = 0) => [
                'style' => 'width: 300px; height: 300px;'
            ]),
        ];
    }

    protected function rules(mixed $item): array
    {
        return [];
    }
}
