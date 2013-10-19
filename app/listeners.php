<?php
/**
 * Event Listeners File
 * @author Andrei Boar <andrey.boar@gmail.com>
 */

/**
 * Save total_expenses on Tablet upon expense.create.success
 */
Event::listen('expense.create.success', function($expense) {
            $predictionId = $expense->prediction_id;
            $prediction = Prediction::find($predictionId);

            if ($prediction->id) {
                $tablet = $prediction->tablet;
                $tablet->total_expenses = $tablet->total_expenses + $expense->value;
                $tablet->save();
            }
        }
);

/**
 * Save current_sum on Tablet upon expense.create.success
 */
Event::listen('expense.create.success', function($expense) {
            $predictionId = $expense->prediction_id;
            $prediction = Prediction::find($predictionId);

            if ($prediction->id) {
                $tablet = $prediction->tablet;
                $tablet->current_sum = $tablet->current_sum - $expense->value;
                $tablet->save();
            }
        }
);

/**
 * Update Prediction value upon expense.create.success
 */
Event::listen('expense.create.success', function($expense) {
            $predictionId = $expense->prediction_id;
            $prediction = Prediction::find($predictionId);

            if ($prediction->id) {
                $currentValue = (float) $prediction->value;
                $expenseValue = (float) $expense->value;
                
                $prediction->value = $currentValue - $expenseValue;
                $prediction->save();
            }
        }
);

/**
 * Update current_sum on Tablet upon income.create.success
 */
Event::listen('income.create.success', function($incomeValue, $tabletId) {
            $tablet = Tablet::find($tabletId);

            if ($tablet->id) {
                $oldCurrentSum = $tablet->current_sum;
                $newCurrentSum = $oldCurrentSum + $incomeValue;
                $tablet->current_sum = $newCurrentSum;
                $tablet->save();
            }
        }
);