<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        $sanitizedInput = $this->sanitizeInput($input);
        $request->replace($sanitizedInput);

        return $next($request);
    }

    private function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }

        return htmlspecialchars($input, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

