<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FibonacciController extends Controller
{
    public function sumFibonacci(Request $request)
    {
        $n1 = $request->input('n1');
        $n2 = $request->input('n2');

        $fibN1 = $this->fibonacci($n1);
        $fibN2 = $this->fibonacci($n2);

        $sum = $fibN1 + $fibN2;

        return view('sum-fibonacci', compact('n1', 'n2', 'sum'));
    }

    private function fibonacci($n)
    {
        if ($n <= 0) {
            return 0;
        } elseif ($n == 1) {
            return 1;
        } else {
            return $this->fibonacci($n - 1) + $this->fibonacci($n - 2);
        }
    }
}
