<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;

class PhysicalCalculatorScreen extends Screen
{
    public $name = 'Physical Calculator';

    public function query(): array
    {
        return [];
    }

    public function commandBar(): array
    {
        return [];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Select::make('unit_from')
                    ->title('From Unit')
                    ->options([
                        'meter' => 'Meter',
                        'kilometer' => 'Kilometer',
                        'centimeter' => 'Centimeter',
                        // Добавьте больше единиц измерения
                    ]),
                Input::make('value')
                    ->title('Value')
                    ->placeholder('Enter the value'),
                Select::make('unit_to')
                    ->title('To Unit')
                    ->options([
                        'meter' => 'Meter',
                        'kilometer' => 'Kilometer',
                        'centimeter' => 'Centimeter',
                        // Добавьте больше единиц измерения
                    ]),
                Button::make('Convert')
                    ->method('convert'),
                Label::make('result')
                    ->title('Result'),
            ]),
        ];
    }

    public function convert(Request $request)
    {
        $unitFrom = $request->input('unit_from');
        $value = $request->input('value');
        $unitTo = $request->input('unit_to');
        $result = $this->convertUnits($unitFrom, $value, $unitTo);

        return back()->with('result', $result);
    }

    private function convertUnits($unitFrom, $value, $unitTo)
    {
        // Пример конвертации длины
        $conversionRates = [
            'meter' => 1,
            'kilometer' => 1000,
            'centimeter' => 0.01,
            // Добавьте больше конвертаций
        ];

        if (isset($conversionRates[$unitFrom]) && isset($conversionRates[$unitTo])) {
            $valueInMeters = $value * $conversionRates[$unitFrom];
            $result = $valueInMeters / $conversionRates[$unitTo];
        } else {
            $result = 'Invalid unit';
        }

        return $result;
    }
}