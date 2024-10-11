<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Project extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Project>
     */
    public static $model = \App\Models\Project::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
        'description',
        'author.name',
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount('flags');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Image::make('Cover')
                ->thumbnail(function () {
                    return $this->cover;
                })
                ->indexWidth('100')
                ->onlyOnIndex(),
            Boolean::make('Censored', 'censored')
                ->sortable()
                ->filterable()
                ->rules('boolean'),
            Number::make('Flag Count', 'flags_count')
                ->sortable()
                ->textAlign('center')
                ->onlyOnIndex(),
            Text::make('Title')
                ->sortable()
                ->rules('required', 'max:255'),
            BelongsTo::make('Author', 'author', User::class)
                ->sortable(),
            Number::make('Goal')
                ->sortable()
                ->rules('required', 'integer'),
            Text::make('Goal Type')
                ->sortable()
                ->displayUsing(function ($value) {
                    return $value ? 'Words' : 'Days';
                })
                ->onlyOnIndex(),
            Boolean::make('Word Goal? (If not, it is a day goal)', 'goal_type')
                ->onlyOnForms()
                ->rules('boolean'),
            Text::make('Description')
                ->hideFromIndex(),
            Text::make('Status')
                ->sortable()
                ->filterable()
                ->rules('required', 'in:pending,in progress,shelved,abandoned,complete'),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new Filters\Flagged,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            new Actions\CensorImage,
            new Actions\ClearFlags,
        ];
    }
}
