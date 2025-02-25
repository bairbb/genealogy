<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
use MoonShine\Core\Resources\Resource;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\Laravel\Fields\Relationships\RelationRepeater;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Div;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<Person>
 */
class PersonResource extends ModelResource
{
    protected string $model = Person::class;

    protected string $title = 'Потомки';

    protected string $column = 'name';

    protected array $with = [
        'spouses',
    ];

    protected int $itemsPerPage = 20;

    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Image::make('Фото', 'image_path'),
            Text::make('ФИО', 'full_name'),
            Date::make('Год рождения', 'birth_year')->format('Y'),
//            Date::make('Год смерти', 'death_year')->format('Y'),
            BelongsTo::make('Родитель', 'parent', formatted: '?name', resource: PersonResource::class),
            HasMany::make('Супруг(а)', 'spouses')
            ->relatedLink()
        ];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make(),
                Select::make('Родитель', 'parent_id')->options(Person::all()->pluck('full_name', 'id')->toArray())->nullable(),
                Text::make('Фамилия', 'lastname'),
                Text::make('Имя', 'name'),
                Text::make('Отчество', 'surname'),
                Number::make('Год рождения', 'birth_year')->min(1700)->max(2100),
                Number::make('Год смерти', 'death_year')->min(1700)->max(2100),
                Text::make('Описание', 'description'),
                Image::make('Изображение', 'image_path')->dir('images')->removable()->nullable(),
                HasMany::make('Супруг(а)', 'spouses')->searchable(false),
//                RelationRepeater::make('Супруг(а)', 'spouses')->vertical()->removable()->nullable(),
            ])
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            BelongsTo::make('Родитель', 'parent', formatted: '?name', resource: PersonResource::class),
            Text::make('Фамилия', 'lastname'),
            Text::make('Имя', 'name'),
            Text::make('Отчество', 'surname'),
            Date::make('Год рождения', 'birth_year')->format('Y'),
            Date::make('Год смерти', 'death_year')->format('Y'),
            Text::make('Описание', 'description'),
            Image::make('Изображение', 'image_path')
                ->itemAttributes(fn(string $filename, int $index = 0) => [
                    'style' => 'width: 300px; height: 300px;'
                ]),
            HasMany::make('Супруг(а)', 'spouses')->previewMode()
        ];
    }

    /**
     * @param Person $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [];
    }

    protected function search(): array
    {
        return [
            'name',
            'lastname',
            'surname',
        ];
    }
}
