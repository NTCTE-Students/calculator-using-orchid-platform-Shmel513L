<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use App\Models\CalculationHistory;

class CalculatorScreen extends Screen
{
    public $name = 'Calculator';

    public function query(): array
    {
        return [
            'history' => CalculationHistory::all()
        ];
    }

    public function commandBar(): array
    {
        return [];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('expression')
                    ->title('Expression')
                    ->placeholder('Enter your expression'),
                Button::make('Calculate')
                    ->method('calculate'),
                Label::make('result')
                    ->title('Result'),
            ]),
            Layout::table('history', [
                'Expression' => 'expression',
                'Result' => 'result',
                'Timestamp' => 'created_at',
            ]),
        ];
    }

    public function calculate(Request $request)
    {
        $expression = $request->input('expression');
        $result = $this->evaluateExpression($expression);

        CalculationHistory::create([
            'expression' => $expression,
            'result' => $result,
        ]);

        return back()->with('result', $result);
    }

    private function evaluateExpression($expression)
    {
        // Обработка выражения и вычисление результата
        // Для безопасности используйте парсеры выражений или математические библиотеки
        try {
            $result = eval("return $expression;");
        } catch (\Exception $e) {
            $result = 'Error';
        }

        return $result;
    }
}
