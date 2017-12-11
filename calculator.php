<?php

function calculateRPN($input) {
    $k = 0;
    $pointer = 0;
    $stack = [];
    $output = [
        'input' => $input,
        'steps' => [],
        'result' => 0
    ];
    for($i=0;$i<strlen($input);$i++) {
        $char = $input[$i];

        if($char == ' '){

        } else if(is_numeric($char)){
            //read until space
            $stack[$pointer]='';
            while(is_numeric($input[$i])){
                $stack[$pointer] .= $input[$i];
                $i++;
            }
            $i--;

            $pointer++;
        } else if ($char == '^') {
            $stack[$pointer-2] = $stack[$pointer-2] ** $stack[$pointer-1];
            $stack[$pointer-1] = 0;
            $pointer--;
        } else if ($char == '*') {
            $stack[$pointer-2] = $stack[$pointer-2] * $stack[$pointer-1];
            $stack[$pointer-1] = 0;
            $pointer--;
        } else if ($char == '/') {
            $stack[$pointer-2] = $stack[$pointer-2] / $stack[$pointer-1];
            $stack[$pointer-1] = 0;
            $pointer--;
        } else if ($char == '+') {
            $stack[$pointer-2] = $stack[$pointer-2] + $stack[$pointer-1];
            $stack[$pointer-1] = 0;
            $pointer--;
        } else if ($char == '-') {
            $stack[$pointer-2] = $stack[$pointer-2] - $stack[$pointer-1];
            $stack[$pointer-1] = 0;
            $pointer--;
        }
        $output['steps'][] = [
            'step' => $k,
            'element' => $char,
            'stack' => $stack
        ];
        $k++;

    }
    $output['result']=$stack[0];
    return $output;
}

$inputs=[
    '12 3-3/2 ^',
    '5 5*',
    '2 30-',
    '2 30 -',
    '5 1 2 + 4 * 3 - +',
    '4 2 5 * + 1 3 2 * + /'
];

foreach ($inputs as $input) {
    $out = calculateRPN($input);
    echo $out['input'].'<br>';
    foreach ($out['steps'] as $step){
        echo 'Krok: '.$step['step'].' Element:'.$step['element'].' Stos: '.implode(' ',($step['stack'])).'<br>';
    }
    echo $out['result'];

    echo '<br><br>';
}