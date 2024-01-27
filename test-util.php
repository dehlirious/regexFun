<?php
//$scientificNotation = "2.3e5";
$scientificNotation = "1e154";
$wholeNumber = number_format((float)$scientificNotation, 0, '.', ''); // Remove decimal points
echo $wholeNumber . " \\ "; // Output will be '230000'

$wholeNumber = $wholeNumber;
if ($wholeNumber == 0) {
    $scientificNotation = '0e+0';
} else {
    $sign = ($wholeNumber > 0) ? '' : '-'; // Handle negative numbers
    $exponent = (int)floor(log(abs($wholeNumber), 10)); // Get the exponent part
    $mantissa = $wholeNumber / pow(10, $exponent); // Get the mantissa part
    $scientificNotation = sprintf('%s%.1fe%d', $sign, $mantissa, $exponent); // Construct the scientific notation
}
echo $scientificNotation . "\n\n\n\n<br/>\n"; // Output will be '2.3e+5'


function generateNestedRegex($additionalLayers) {
    // Base pattern for one layer of nesting
	// {aa} <  layers 
    //$basePattern = "{(?:[^{}]|{[^{}]*})*}";
    $basePattern = "{[^{}]*}";

    // Pattern for the recursive part
	//two, so adding it again would be four I believe, but I'm not going to correct it. 50 = 100 , but I'm still saying its 50 layers deep
    $recursivePart = "{(?:[^{}]|{[^{}]*})*}";


    // Add additional layers of nesting
    for ($i = 0; $i < $additionalLayers; $i++) {
        // Replace the innermost '{}' with the recursive part
        $basePattern = str_replace("{[^{}]*}", $recursivePart, $basePattern);
    }

    return $basePattern;
}

// Usage:
$numberOfAdditionalLayers = 15; // Change this number to add more layers
$regexPattern = generateNestedRegex($numberOfAdditionalLayers);
echo $regexPattern. "\n\n\n\n\n\n\n<br/>\n";
//Designed for usage in this regex (async\s+)?function\s+(\w+)\s*\(([^)]*)\)\s*{((?:[^{}]|{(?:[^{}]|{[^{}]*})*})*?)}


function measureRegexPerformance($testString, $maxLayers, $iterationsPerLayer) {
    $timings = [];

    for ($layers = 1; $layers <= $maxLayers; $layers++) {
        $regexPattern = generateNestedRegex($layers - 1); // generate pattern with the current number of layers
        $times = [];
		$totalTimeForLayer = 0;
		$totalMatchesForLayer = 0;

        for ($i = 0; $i < $iterationsPerLayer; $i++) {
            $startTime = microtime(true);
            preg_match_all($regexPattern, $testString, $matches);
            $endTime = microtime(true);
			$iterationTime = $endTime - $startTime;
            $times[] = $iterationTime;
			$totalTimeForLayer += $iterationTime;
			$totalMatchesForLayer += count($matches[0]);
			
            if (!isset($totalTimeForLayerx[$i])) {
                $totalTimeForLayerx[$i] = 0;
                $totalMatchesForLayerx[$i] = 0;
            }

            $totalTimeForLayerx[$i] += $iterationTime;
            $totalMatchesForLayerx[$i] += count($matches[0]);
        }

        // Calculate fastest, slowest, and average time
        $fastestTime = min($times);
        $slowestTime = max($times);
        $averageTime = array_sum($times) / count($times);

        $timings[$layers] = [
            'fastest' => $fastestTime,
            'slowest' => $slowestTime,
            'average' => $averageTime,
			'total'   => $totalTimeForLayer,
			'totalx'   => $totalTimeForLayerx,
			'matches' => $totalMatchesForLayer,
			'matchesx' => $totalMatchesForLayerx
        ];
    }

    return $timings;
}

function generateNestedJS($depth) {
    $code = "function deeplyNestedFunction() {\n";
    $indentation = "    ";

    for ($i = 0; $i < $depth; $i++) {
        $structure = mt_rand(0, 3); // Randomly choose a structure

        switch ($structure) {
            case 0: // if
                $code .= $indentation . "if (1) {\n";
                break;
            case 1: // for
                $code .= $indentation . "for (let i = 0; i < 10; i++) {\n";
                break;
            case 2: // while
                $code .= $indentation . "while (0) {\n";
                break;
            case 3: // do...while
                $code .= $indentation . "do {\n";
                break;
            case 4: // switch
                $code .= $indentation . "switch (variable) {\n";
                $code .= $indentation . "    case 1:\n";
                $indentation .= "    ";
               break;
            // You can add more structures here
        }

        $indentation .= "    ";
    }

    // Close the structures
    for ($i = 0; $i < $depth; $i++) {
        $indentation = substr($indentation, 0, -4);
        $structure = mt_rand(0, 4); // Randomly choose a structure for closing
        if ($structure == 3) {
            $code .= $indentation . "} while (condition);\n";
        } else {
            $code .= $indentation . "}\n";
        }
    }

    $code .= "}\n";
    return $code;
}

// Usage
$startTime = microtime(true);
$testString = generateNestedJS(100); // Generate 30 layers of nesting
$endTime = microtime(true);
$totalTime = ($endTime - $startTime);
echo "Time: {$totalTime}s \n <br/> \n";
//echo "<pre>" . htmlspecialchars($nestedCode) . "</pre>"; // Display the code

$maxLayers = 50; // Maximum number of layers to test
$iterationsPerLayer = 50; // Number of times to test each layer

$startTime = microtime(true);
// Measure the performance
$performanceTimings = measureRegexPerformance($testString, $maxLayers, $iterationsPerLayer);
$endTime = microtime(true);
$totalTime = ($endTime - $startTime);
echo "Total Time: {$totalTime}s \n <br/> \n";
// Display the results
foreach ($performanceTimings as $layers => $timing) {
	$total = intval($timing['total']*1000);
	$fastest = intval($timing['fastest']*1000);
	$slowest = intval($timing['slowest']*1000);
	$average = intval($timing['average']*1000);
	
	//test utils
	//{$timing['matches']}
    $totalTimes = $timing['totalx'];
    $totalMatches = $timing['matchesx'];

	$totalx = intval((array_sum($totalTimes))*1000);
	$averagex = array_sum($totalMatches) / count($totalMatches);
	
	echo "Layers: $layers, Total Time: {$total}ms, Fastest Time: {$fastest}ms, Slowest Time: {$slowest}ms, Average Time: {$average}ms, Matches: $averagex / {$timing['matches']} <br/>\n";
}

