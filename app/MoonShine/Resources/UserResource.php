<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\FieldsGroup;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Field;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Text;

/**
 * @extends ModelResource<User>
 */
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Пользователи';

    protected string $column = 'name';

    protected int $itemsPerPage = 20;
    
    /**
     * @return list<FieldContract>
     */
    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('ФИО', 'full_name'),
            Email::make('Почта', 'email'),
            Date::make('Создан', 'created_at')->format('d.m.Y-H:i'),
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
                Text::make('Фамилия', 'lastname'),
                Text::make('Имя', 'name'),
                Text::make('Отчество', 'surname'),
                Email::make('Почта', 'email'),
            ]),
            Box::make([
                Password::make('Пароль', 'password')->eye(),
                PasswordRepeat::make('Повторите пароль', 'password_repeat')->eye(),
            ]),
        ];
    }

    /**
     * @return list<FieldContract>
     */
    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Фамилия', 'lastname'),
            Text::make('Имя', 'name'),
            Text::make('Отчество', 'surname'),
            Email::make('Почта', 'email'),
        ];
    }

    /**
     * @param User $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    protected function rules(mixed $item): array
    {
        return [
            'email' => [
                'sometimes',
                'required',
                'email',
            ],
            'password' => $item->exists
                ? 'sometimes|nullable|required_with:password_repeat|same:password_repeat'
                : 'required|required_with:password_repeat|same:password_repeat',
        ];
    }

    protected function search(): array
    {
        return [
            'name',
            'email',
        ];
    }
}
