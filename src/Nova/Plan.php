<?php

namespace GeneaLabs\CashierPaypal\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use App\Nova\Resource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use GeneaLabs\CashierPaypal\Plan as PaypalPlan;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Panel;

class Plan extends Resource
{
    public static $group = 'Admin';
    public static $model = PaypalPlan::class;
    public static $title = 'name';
    public static $search = [
        "id",
        "name",
    ];

    public function fields(Request $request) : array
    {
        return [
            ID::make()
                ->hideFromDetail()
                ->sortable(),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:128'),
            Textarea::make("Description")
                ->rules("required", "max:127"),
            Select::make("Type")
                ->options([
                    "fixed" => "Fixed",
                    "infinite" => "Infinite",
                ])
                ->withMeta([
                    "value" => "infinite",
                ])
                ->displayUsingLabels(),
            Select::make("Status")
                ->options([
                    "created" => "Created",
                    "active" => "Active",
                    "inactive" => "Inactive",
                ])
                ->withMeta([
                    "value" => "active",
                ])
                ->displayUsingLabels(),
            DateTime::make("Created At")
                ->onlyOnDetail(),
            DateTime::make("Updated At")
                ->onlyOnDetail(),

            new Panel("Trial Options", [
                Boolean::make("Enable Trial", "has_trial"),
                NovaDependencyContainer::make([
                    Number::make("Trial Interval"),
                    Select::make("Trial Frequency")
                        ->options([
                            "day" => "Day",
                            "week" => "Week",
                            "month" => "Month",
                            "year" => "Year",
                        ])
                        ->rules("required"),
                    Number::make("Trial Cycles")
                        ->rules("required", "min:0"),
                    Number::make("Trial Amount")
                        ->rules("required"),
                    Select::make("Trial Currency")
                        ->options([
                            "usd" => "USD",
                        ])
                        ->rules("required"),
                    Number::make("Trial Tax"),
                    Number::make("Trial Shipping"),
                ])
                ->dependsOn("has_trial", true),
            ]),

            new Panel("Plan Options", [
                Number::make("Interval")
                    ->withMeta([
                        "value" => 1,
                    ]),
                Select::make("Frequency")
                    ->options([
                        "day" => "Day",
                        "week" => "Week",
                        "month" => "Month",
                        "year" => "Year",
                    ])
                    ->withMeta([
                        "value" => "year",
                    ])
                    ->displayUsingLabels()
                    ->rules("required"),
                Number::make("Cycles")
                    ->withMeta([
                        "value" => 1,
                    ])
                    ->rules("required", "min:0"),
                Number::make("Amount")
                    ->rules("required"),
                Select::make("Currency")
                    ->options([
                        "usd" => "USD",
                    ])
                    ->withMeta([
                        "value" => "usd",
                    ])
                    ->displayUsingLabels()
                    ->rules("required"),
                Number::make("Tax"),
                Number::make("Shipping"),
            ]),

            new Panel("Merchant Preferences", [
                Number::make("Setup Fee"),
                Text::make("Cancel URL"),
                Text::make("Return URL"),
                Text::make("Notify URL"),
                Number::make("Max Fail Attempts"),
                Boolean::make("Auto Bill Amount"),
                Select::make("Initial Fail Amount Action")
                    ->options([
                        "continue" => "Continue",
                        "cancel" => "Cancel",
                    ]),
            ]),

        ];
    }
}
